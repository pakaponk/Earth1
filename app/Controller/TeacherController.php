<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bun suwanparsert
 * Date: 3/11/13 AD
 * Time: 5:24 PM
 * To change this template use File | Settings | File Templates.
 */

class TeacherController extends AppController{

    public $uses = array('Lesson','Course','Topic','ProblemSet','CoursesLesson','Teacher','TeacherCourse'
                        ,'Problem','ProblemLevel','ProblemDataSet','ProblemsetsProblem'
                        ,'Classroom','Assignment','AssignmentScore','User');
    public $components = array('RequestHandler');
    public $layout = 'teacher';

    private function getTopClassList($all){
        $teacher_id = $this->Auth->user('id');

        $db = $this->AssignmentScore->getDataSource();
        $result = $db->fetchAll('SELECT TeachersClassroom.classroom_id , Classroom.grade , Classroom.room
                        FROM teachers_classrooms AS TeachersClassroom , classrooms AS Classroom
                        WHERE Classroom.id = TeachersClassroom.classroom_id
                        AND TeachersClassroom.teacher_id = ?
                        ',
            array($teacher_id));

        $i=0;
        foreach ($result AS $classroom){
            $classroom_id = $classroom['TeachersClassroom']['classroom_id'];
            if (!$all)
            {
                $result2 = $db->fetchAll(
                    'SELECT User.id AS student_id , SUM(AssignmentScore.score)*AVG(AssignmentScore.average_level) AS total_score , AVG(AssignmentScore.average_level) AS average_level , COUNT(AssignmentScore.assignment_score_id) AS total_do_assignment , COUNT(Assignment.id) AS total_assignment , SUM(AssignmentScore.question) AS total_question , User.title , User.first_name , User.last_name , User.classroom_id
                    FROM (user AS User INNER JOIN assignment AS Assignment ON (User.classroom_id = Assignment.classroom_id)) LEFT JOIN assignment_score AS AssignmentScore ON
                                        (Assignment.id = AssignmentScore.assignment_id
                                AND User.id = AssignmentScore.student_id)
                                WHERE User.role = "student"
                        AND User.classroom_id = ?
                        GROUP BY User.id
                    ORDER BY total_score DESC , User.id ASC
                    LIMIT 3',
                    array($classroom_id)
                );
            }
            else
            {
                $result2 = $db->fetchAll(
                    'SELECT User.id AS student_id , SUM(AssignmentScore.score)*AVG(AssignmentScore.average_level) AS total_score , AVG(AssignmentScore.average_level) AS average_level , COUNT(AssignmentScore.assignment_score_id) AS total_do_assignment , COUNT(Assignment.id) AS total_assignment , SUM(AssignmentScore.question) AS total_question , User.title , User.first_name , User.last_name , User.classroom_id
                    FROM (user AS User INNER JOIN assignment AS Assignment ON (User.classroom_id = Assignment.classroom_id)) LEFT JOIN assignment_score AS AssignmentScore ON
                                        (Assignment.id = AssignmentScore.assignment_id
                                AND User.id = AssignmentScore.student_id)
                                WHERE User.role = "student"
                        AND User.classroom_id = ?
                        GROUP BY User.id
                    ORDER BY total_score DESC , User.id ASC',
                    array($classroom_id)
                );
            }
            $return[$i++] = $result2;
        }

        $return['Classroom'] = $result;
        return $return;
    }

    private function setStatus(){

        //Get List of Classrooms which this teacher teachs
        $teacher_id = $this->Auth->user('id');
        $db = $this->Classroom->getDataSource();
        $results = $db->fetchAll('SELECT classroom_id
                        FROM teachers_classrooms AS TeachersClassroom , classrooms AS Classroom
                        WHERE Classroom.id = TeachersClassroom.classroom_id
                        AND TeachersClassroom.teacher_id = ?
                        ',
            array($teacher_id));
        $classrooms = array();
        $size = 0;
        foreach ($results as $result)
        {
            $classrooms[$size] = $result['TeachersClassroom']['classroom_id'];
            $size++;
        }

        date_default_timezone_set("Asia/Bangkok");
        $assignments = $this->Assignment->find('all',array(
            'conditions' => array(
                'classroom_id' => $classrooms,
                'status' => (array('assigned','released'))
            )));
        foreach($assignments as $assignment)
        {
            $isEnd = substr(CakeTime::timeAgoInWords($assignment['Assignment']['end_date']),-3);
            switch($assignment['Assignment']['status'])
            {
                case('released') :
                    if ($isEnd == 'ago' || $isEnd == 'now')
                    {
                        $this->Assignment->id = $assignment['Assignment']['id'];
                        $this->Assignment->saveField('status','ended');
                    }
                    break;
                case ('assigned') :
                    $isRelease = substr(CakeTime::timeAgoInWords($assignment['Assignment']['release_date']),-3);
                    if ($isRelease== 'ago' || $isRelease == 'now')
                    {
                        $this->Assignment->id = $assignment['Assignment']['id'];
                        if ($isEnd == 'ago' || $isEnd == 'now')
                            $this->Assignment->saveField('status','ended');
                        else
                            $this->Assignment->saveField('status','released');
                    }
                    break;
                default : break;
            }
        }
    }

    public function beforeFilter(){
        parent::beforeFilter();
        if($this->Auth->user('role') === 'school_admin'){
            $this->Auth->allow('add');
            $this->layout = 'school_admin';
        }
        $this->setStatus();
    }

    public function isAuthorized($user) {
        if (isset($user['role']) && $user['role'] === 'teacher' ) {
            return true;
        }else{
            $this->Session->setFlash('You have no authoritative here','flash_notification');
        }
        return false;
    }

    public function index(){
        //pr($this->Teacher->find('all'));
        //only view here
        $courses = $this->TeacherCourse->find('all',array(
            'conditions' => array(
                'teacher_id' => $this->Auth->user('id')
            ),
            'recursive' => 2,
            'fields' => array('TeacherCourse.course_id','Course.course_name','Course.course_id')
        ));
        //pr($courses);
        $courses_num = count($courses);
        for ($i = 0; $i< $courses_num;$i++)
        {
            $lessons = $courses[$i]['Course']['Lesson'];
            $last = array();
            $now = array();
            $next = array();
            $last_monday = strtotime('Monday last week');
            $last_sunday = strtotime('Sunday last week');
            $this_monday = strtotime('Monday this week');
            $this_sunday = strtotime('Sunday this week');
            $next_monday = strtotime('Monday next week');
            $next_sunday = strtotime('Sunday next week');
            foreach ($lessons as $lesson)
            {
                $lesson_start_date = strtotime($lesson['start_date']);
                $lesson_end_date = strtotime($lesson['end_date']);
                if (($lesson_start_date<$last_monday&&$lesson_end_date>=$last_monday)||($lesson_start_date>=$last_monday&&$lesson_start_date<=$last_sunday))
                {
                    $last[count($last)] = $lesson['lesson_name'];
                    if ($lesson_end_date>=$this_monday)
                        $now[count($now)] = $lesson['lesson_name'];
                    if ($lesson_end_date>=$next_monday)
                        $next[count($next)] = $lesson['lesson_name'];
                }
                else if ($lesson_start_date>=$this_monday&&$lesson_start_date<=$this_sunday)
                {
                    $now[count($now)] = $lesson['lesson_name'];
                    if ($lesson_end_date>=$next_monday)
                        $next[count($next)] = $lesson['lesson_name'];
                }
                else if ($lesson_start_date>=$next_monday&&$lesson_start_date<=$next_sunday)
                {
                    $next[count($next)] = $lesson['lesson_name'];
                }
            }
            $courses[$i]['LessonPlan']['This'] = $now;
            $courses[$i]['LessonPlan']['Next'] = $next;
            $courses[$i]['LessonPlan']['Last'] = $last;
        }
        $this->set('courses',$courses);

        $leaderboards = $this->getTopClassList(false);
        //pr($leaderboards);
        $this->set("leaderboards",$leaderboards);
    }

    public function create_problemset(){
        $teacher_arr = $this->Teacher->findById($this->Auth->user('id'));
        $course_arr = $teacher_arr["Course"];
        $num = count($course_arr);
        $course_list_temp = array();
        for($i=0;$i<$num;$i++){
            $course_list_temp[$course_arr[$i]["course_id"]] = $course_arr[$i]["course_name"];
        }
        //pr($course_list_temp);

        $this->set('course_list',$course_list_temp);

        if($this->request->is('post')){
            //pr($this->request->data);
            $this->request->data['ProblemSet']['user_id'] = $this->Auth->user('id');
            if($this->ProblemSet->save($this->request->data)){
                $this->redirect(array(
                    'controller' => 'Teacher',
                    'action' => 'problemset',
                    $this->ProblemSet->getLastInsertID()
                    /*,$this->request->data['ProblemSet']['course_id']*/
                ));
            }
        }
    }

    public function problemset($id,$courseId = -1){
        $allProblem = $this->ProblemsetsProblem->findAllByProblemsetId($id);
        $problemset_arr =  $this->ProblemSet->findByProblemsetId($id) ;
        $course_arr = $this->Course->findByCourseId($problemset_arr["ProblemSet"]["course_id"]) ;
        $lesson_list = $course_arr["Lesson"];
        $num = count($lesson_list);
        $lesson_list_temp = array();
        for($i=0;$i<$num;$i++){
            $lesson_list_temp[$lesson_list[$i]["lesson_id"]] = $lesson_list[$i]["lesson_name"];
        }

        $this->set('added_problem',$allProblem);
        $this->set('problemset_arr',$problemset_arr);
        $this->set('course_arr',$course_arr);
        $this->set('lesson_list',$lesson_list_temp);
    }

    public function problemset_main(){
        $creatorID = $this->Auth->user('id');
        //$this->ProblemSet->recursive = 2 ;
        $problemsetArr = $this->Teacher->findById($creatorID);
        $course_list = $this->Course->find('list');
        //$temp = $this->ProblemSet->find('all');
        //pr($course_list);
        $this->set('course_list',$course_list);
        $this->set('problemset_arr',$problemsetArr);
    }

    public function add($classroomid){
        if ($this->request->is('post')){
            $uses = array('User');
            $this->loadModel('User');
            $sadmin = $this->Auth->user();
            $this->User->set('school_id',$sadmin['school_id']);
            $this->User->set('classroom_id',$classroomid);
            $this->User->set('role','teacher');
            if($this->User->save($this->request->data)){
                $this->redirect(array(
                    'controller' => 'classrooms',
                    'action' => 'index'
                ));
            }
        }
    }

    public function problemsetGetLesson($course_id = -1){
        if($course_id == -1){
            $this->autoRender = false ;
        }else{
            $lesson_list = $this->Lesson->Course->findByCourseId($course_id);
            pr("ddd");
        }
    }

    public function problemsetGetTopic($lesson_id = -1){
        if($lesson_id == -1){
            $this->autoRender=false;
        }else{
            $topic_list = $this->Topic->Lesson->findByLessonId($lesson_id);
            $topic_list = $topic_list["Topic"];
            //pr($topic_list);
            $num = count($topic_list);
            $topic_list_temp = array();
            for($i=0;$i<$num;$i++){
                $topic_list_temp[$topic_list[$i]["topic_id"]] = $topic_list[$i]["topic_name"];
                //$topic_list[$topic_list[$i]["topic_id"]] = $topic_list[$i]["topic_name"];
                //unset($topic_list[$i]);
            }
            //pr($topic_list);
            $this->set('topic_list',$topic_list_temp);
        }
    }

    public function problemsetGetProblem($topic_id = -1){
        if($topic_id == -1){
            $this->autoRender=false;
            echo" ";
        }else{

            $this->Problem->recursive = 2 ;
            $problemArr = $this->Problem->find('all');

            $problemIdArr = $this->Topic->findByTopicId($topic_id);
            $problemIdArr = $problemIdArr["Problem"];
            //pr($problemArr);
            if($problemArr !== array() && $problemIdArr !== array()){
                $problemArr_temp = array();
                for($i=0;$i<count($problemArr);$i++){
                    $problemArr_temp[ $problemArr[$i]["Problem"]["problem_id"] ] = $problemArr[$i]["ProblemLevel"];
                    //$problemArr[ $problemArr[$i]["Problem"]["problem_id"] ] = $problemArr[$i]["ProblemLevel"];
                    //unset($problemArr[$i]);
                }

                for($i=0;$i<count($problemIdArr);$i++){
                    $problemIdArr[$i] = $problemIdArr[$i]["problem_id"];
                    //unset($problemIdArr[$i]);
                }

                //debug($problemArr);

                for($i=0;$i<count($problemIdArr);$i++){
                    if( array_key_exists($problemIdArr[$i],$problemArr_temp) ){
                        $problemIdArr[$i] = $problemArr_temp[ $problemIdArr[$i] ] ;
                    }
                }
            }

            //debug($problemIdArr);
            $this->set('problemArr',$problemIdArr);
        }
    }

    public function class_report(){
        $teacher = $this->Teacher->findById($this->Auth->user('id')) ;
        //pr($teacher["Classroom"]);
        $classroom_id = array();
        $classroom_problemset_id = array();
        for($i=0;$i < count($teacher["Classroom"]) - 7;$i++){
            $classroom_id[$i] = $teacher["Classroom"][$i]["id"];
        }

        for($i=0;$i<count($classroom_id);$i++){
            $arr =  $this->Assignment->find('all',array("conditions"=>array("Assignment.classroom_id" => $classroom_id[$i])));
            for($j=0;$j<count($arr);$j++){
                $problemset_data[$classroom_id[$i]][$j] = $arr[$j]["ProblemSet"]["problemset_id"] ;
                $problemset_name[$classroom_id[$i]][$j] = $arr[$j]["ProblemSet"]["problemset_name"];

                $highest_score[$classroom_id[$i]][$j] = $this->requestAction(
                         array('controller'=>'problem_set','action'=>'get_class_highest_score')
                        ,array('pass' => array($classroom_id[$i],$arr[$j]["ProblemSet"]["problemset_id"])));

            }
            //pr($arr);
        }
//class_highest_score($classroom_id,$problemset_id)


        //$ProblemSet = new ProblemSet();
        //$ProblemSet->constructClasses();
        $data = array();
        for($i=0;$i<count($problemset_data);$i++){
            for($j=0;$j<count($problemset_data[$classroom_id[$i]]);$j++){
                $data[$classroom_id[$i]][$j] = $this->requestAction(array('controller'=>'problem_set','action'=>'get_class_progress')
                                                ,array('pass' => array($classroom_id[$i],$problemset_data[$classroom_id[$i]][$j])));
                $data[$classroom_id[$i]][$j]["assignment_complete"] = $data[$classroom_id[$i]][$j][0][0][0]["assignment_complete"];
                $data[$classroom_id[$i]][$j]["total_assignment"] = $data[$classroom_id[$i]][$j][1][0][0]["total_assignment"];
                unset($data[$classroom_id[$i]][$j][0]);
                unset($data[$classroom_id[$i]][$j][1]);
            }
        }
        //pr($highest_score);
        //pr($data);
        //pr($problemset_name);
        $this->set('highest_score',$highest_score);
        $this->set('data',$data);
        $this->set('problemset_id',$problemset_data);
        $this->set('problemset_name',$problemset_name);
        $this->set('teacher_class',$teacher["Classroom"]);
        $this->set('teacher_course',$teacher["Course"]);
    }

    public function save_problemset($problemset_id,$problem_level_id,$problem_status){
        $this->autoRender = false ;

        $problem_level_id_array = explode(";",$problem_level_id);
        $problem_status_array = explode(";",$problem_status);

        $conditions = array (
            "ProblemsetsProblem.problemset_id" => $problemset_id,
        );
        $this->ProblemsetsProblem->deleteAll($conditions);

        $len = count($problem_level_id_array);
        for($i=0;$i<$len;$i++){
            if($problem_status_array[$i] == "add"){
                echo "X";
                $data = $this->ProblemLevel->findByProblemLevelId( $problem_level_id_array[$i]) ;
                $problem_id = $data["Problem"]["problem_id"];
                $saveData = array(
                    'problemset_problem_id' =>'',
                    'problemset_id'     => $problemset_id ,
                    'problem_id'        => $problem_id,
                    'problem_level_id'  => $problem_level_id_array[$i]
                );
                $this->ProblemsetsProblem->save($saveData);
            }
        }
        //debug($problem_level_id);
        //debug($problem_status);

    }


    public function select(){
        //pr($this->Teacher->find('all'));
        $course_data = $this->Teacher->findById($this->Auth->user('id'));
        $course_data = $course_data["Course"];
        //pr($course_data);
        $course_list = array();
        foreach($course_data as $c){
            $course_list[ $c["course_id"] ]  = $c["course_name"] ;
        }
        //pr($course_list);
        $this->set("course_list",$course_list);
    }

    public function get_class($course_id){
        //$this->autoRender = false ;
        $class_data = $this->Course->findByCourseId($course_id);
        $class_data = $class_data["Classroom"];
        $class_list = array();
        foreach($class_data as $class){
            $class_list[ $class["id"] ] =  $class["full_classroom"];
        }
        $this->set("course_id",$course_id);
        $this->set("class_list",$class_list);
        //pr($class_list);
    }

    public function lesson_plan(){
        $teacher = $this->Teacher->findById($this->Auth->user('id'));
        $course_lesson = $this->Course->find('all');
        $courses = $teacher["Course"];
        //pr($courses);
        $course_id = array();
        $course_lesson_data =array();
        for($i=0;$i<count($courses);$i++){
            $course_id[$i] = $courses[$i]["course_id"];
        }
        for($i=0;$i<count($course_lesson);$i++){
            if( in_array($course_lesson[$i]["Course"]["course_id"],$course_id) )
                $course_lesson_data[ $course_lesson[$i]["Course"]["course_id"] ] = $course_lesson[$i]["Lesson"];
        }
        //pr($course_lesson_data);
        //pr($course_id);
        //pr($this->Course->find('all'));
        $this->set('data',$course_lesson_data);
        $this->set('courses',$courses);
    }

    public function view_lesson_plan($course_id){
        //$this->Lesson->recursive = 2 ;
        $all_topic = $this->Topic->Lesson->find('all');
        $data = $this->Topic->Lesson->Course->findByCourseId($course_id);

        $all_topic_temp = array();
        for($i=0;$i<count($all_topic);$i++){
            $all_topic_temp[$all_topic[$i]["Lesson"]["lesson_id"] ] = $all_topic[$i]["Topic"];
        }

        for($i=0;$i<count($data["Lesson"]);$i++){
            $data["Lesson"][$i]["Topic"] = $all_topic_temp[ $data["Lesson"][$i]["lesson_id"] ];
        }
        $this->set('data',$data);

        //pr($data);
    }

    public function full_lesson_plan($course_id){
        $all_topic = $this->Topic->Lesson->find('all');
        $data = $this->Topic->Lesson->Course->findByCourseId($course_id);

        $all_topic_temp = array();
        for($i=0;$i<count($all_topic);$i++){
            $all_topic_temp[$all_topic[$i]["Lesson"]["lesson_id"] ] = $all_topic[$i]["Topic"];
        }

        for($i=0;$i<count($data["Lesson"]);$i++){
            $data["Lesson"][$i]["Topic"] = $all_topic_temp[ $data["Lesson"][$i]["lesson_id"] ];
        }
        $this->set('data',$data);
    }

    public function full_calendar_lesson_plan($course_id){
        $all_topic = $this->Topic->Lesson->find('all');
        $data = $this->Topic->Lesson->Course->findByCourseId($course_id);

        $all_topic_temp = array();
        for($i=0;$i<count($all_topic);$i++){
            $all_topic_temp[$all_topic[$i]["Lesson"]["lesson_id"] ] = $all_topic[$i]["Topic"];
        }

        for($i=0;$i<count($data["Lesson"]);$i++){
            $data["Lesson"][$i]["Topic"] = $all_topic_temp[ $data["Lesson"][$i]["lesson_id"] ];
        }
        $this->set('data',$data);
    }

    public function compare($psid)
    {
        $assignments = $this->Assignment->findAllByProblemsetId($psid);
        $classroom_list = array();
        foreach ($assignments as $assignment)
        {
            $classroom_list[$assignment['Assignment']['id']] = $assignment['Classroom']['room'];
        }
        $this->set('classroom_list',$classroom_list);
        $this->set('result',false);

        if ($this->request->is('post'))
        {
            $compare_rooms = $this->request->data('CompareRoom');
            $question_num = $this->ProblemsetsProblem->find('count',array(
                'conditions' => array(
                    'ProblemsetsProblem.problemset_id' => $psid
                )
            ));
            $assignment1 = $this->Assignment->findById($compare_rooms[1]);
            $assignment2 = $this->Assignment->findById($compare_rooms[2]);
            $score1 = $this->AssignmentScore->findAllByAssignmentId($compare_rooms[1]);
            $score2 = $this->AssignmentScore->findAllByAssignmentId($compare_rooms[2]);

            //Calculate Average Score Room1
            if (count($score1)>0)
            {
                $score1_num = count($score1);
                $score1['Average'] = 0;
                for ($i = 0;$i< $score1_num ;$i++)
                {
                    $score1['Average'] += $score1[$i]['AssignmentScore']['score'];
                }
            }
            else
            {
                $score1_num = 0;
                $score1['Average'] = 0;
            }
            $num1 = $this->User->find('count',array(
                'conditions' => array(
                    'classroom_id' => $assignment1['Assignment']['classroom_id'],
                    'role' => 'student'
                )
            ));

            //Calcurate Average Score Room2
            if (count($score2)>0)
            {
                $score2_num = count($score2);
                $score2['Average'] = 0;
                for ($i = 0;$i< $score2_num ;$i++)
                {
                    $score2['Average'] += $score2[$i]['AssignmentScore']['score'];
                }
            }
            else
            {
                $score2_num = 0;
                $score2['Average'] = 0;
            }
            $num2 = $this->User->find('count',array(
                'conditions' => array(
                    'classroom_id' => $assignment2['Assignment']['classroom_id'],
                    'role' => 'student'
                )
            ));

            if ($assignment1['Assignment']['status']!="ended" && $score1_num != 0)
            {
                $score1['Average'] /= $score1_num;
            }
            else
            {
                $score1['Average'] /= $num1;
            }
            if ($assignment2['Assignment']['status']!="ended" && $score2_num != 0)
            {
                $score2['Average'] /= $score2_num;
            }
            else
            {
                $score2['Average'] /= $num2;
            }
            $this->set('question_num',$question_num);
            $this->set('assignment1',$assignment1);
            $this->set('assignment2',$assignment2);
            $this->set('score1',$score1);
            $this->set('score2',$score2);
            $this->set('score1_num',$score1_num);
            $this->set('score2_num',$score2_num);
            $this->set('num1',$num1);
            $this->set('num2',$num2);
            $this->set('result',true);
        }
    }

    public function compare_with_course($psid)
    {
        $assignments = $this->Assignment->findAllByProblemsetId($psid);
        $classroom_list = array();
        $course_score['Average'] = 0;
        $course_score_num = 0;
        $course_num = 0;
        $question_num = $this->ProblemsetsProblem->find('count',array(
            'conditions' => array(
                'ProblemsetsProblem.problemset_id' => $psid
            )
        ));
        $course_end = true;
        foreach ($assignments as $assignment)
        {
            $classroom_list[$assignment['Assignment']['id']] = $assignment['Classroom']['room'];
            $score = $this->AssignmentScore->findAllByAssignmentId($assignment['Assignment']['id']);
            $score_num = count($score);
            $score['Average'] = 0;
            for ($i = 0;$i< $score_num ;$i++)
            {
                $score['Average'] += $score[$i]['AssignmentScore']['score'];
            }
            $num = $this->User->find('count',array(
                'conditions' => array(
                    'classroom_id' => $assignment['Assignment']['classroom_id'],
                    'role' => 'student'
                )
            ));
            $course_score['Average'] += $score['Average'];
            $course_score_num += $score_num;
            $course_num += $num;
            if ($assignment['Assignment']['status'] != 'ended')
            {
                $course_end = false;
            }
        }
        if ($course_end == true || $course_score_num == 0)
            $course_score['Average'] /= $course_num;
        else
            $course_score['Average'] /= $course_score_num;

        $this->set('course_end',$course_end);
        $this->set('classroom_list',$classroom_list);
        $this->set('result',false);

        if ($this->request->is('post'))
        {
            //Calculate Class Average Score
            $compare_room = $this->request->data('CompareRoom');
            $assignment = $this->Assignment->findById($compare_room[1]);
            $score = $this->AssignmentScore->findAllByAssignmentId($compare_room[1]);
            $score_num = count($score);
            $score['Average'] = 0;
            for ($i = 0;$i< $score_num ;$i++)
            {
                $score['Average'] += $score[$i]['AssignmentScore']['score'];
            }
            $num = $this->User->find('count',array(
                'conditions' => array(
                    'classroom_id' => $assignment['Assignment']['classroom_id'],
                    'role' => 'student'
                )
            ));
            if ($assignment['Assignment']['status']!="ended" && $score_num != 0)
            {
                $score['Average'] /= $score_num;
            }
            else
            {
                $score['Average'] /= $num;
            }

            $this->set('assignment',$assignment);
            $this->set('question_num',$question_num);

            $this->set('score',$score['Average']);
            $this->set('score_num',$score_num);
            $this->set('num',$num);

            $this->set('course_score',$course_score['Average']);
            $this->set('course_score_num',$course_score_num);
            $this->set('course_num',$course_num);

            $this->set('result',true);
        }
    }
    
    public function view_class_rank($lesson_id){
    	$teacher_id = $this->Auth->user('id');
    	$lesson = $this->Lesson->find('first',array(
    			'conditions' => array('Lesson.lesson_id' => $lesson_id),
    			'recursive' => -1));
    	$lesson_name = $lesson['Lesson']['lesson_name'];
    	 
    	$db = $this->AssignmentScore->getDataSource();
    	$result2 = $db->fetchAll(
    			'SELECT User.id AS student_id , SUM(AssignmentScore.score)*AVG(AssignmentScore.average_level) AS total_score , AVG(AssignmentScore.average_level) AS average_level , COUNT(AssignmentScore.assignment_score_id) AS total_do_assignment , COUNT(Assignment.id) AS total_assignment , User.title , User.first_name , User.middle_name , User.last_name 
					FROM (user AS User INNER JOIN assignment AS Assignment ON (User.classroom_id = Assignment.classroom_id)) LEFT JOIN assignment_score AS AssignmentScore ON
							(Assignment.id = AssignmentScore.assignment_id 
        					AND User.id = AssignmentScore.student_id)
					WHERE User.role = "student" 
					AND Assignment.problemset_id IN (SELECT Problemset.problemset_id
														FROM problemset AS Problemset INNER JOIN 
                                							courses_lessons AS CoursesLesson 
                                        					ON (Problemset.course_id = CoursesLesson.course_id)
                                						WHERE CoursesLesson.lesson_id = ?)
					AND User.classroom_id IN (SELECT TeachersClassroom.classroom_id 
    											FROM teachers_classrooms AS TeachersClassroom 
    											WHERE TeachersClassroom.teacher_id = ?)
					GROUP BY User.id
                    ORDER BY total_score DESC , User.id ASC 
                    LIMIT 10',
    			array($lesson_id,$teacher_id)
    	);
    	 
    	$this->set('lesson_name',$lesson_name);
    	$this->set('top10List',$result2);    	 
    	 
    	//     	echo '<br/><br/><br/><br/><br/><br/><br/>';
    	//     	pr($result2);
       
    }
    
    public function view_course_rank($lesson_id){
    	$teacher_id = $this->Auth->user('id');
    	
    	$lesson = $this->Lesson->find('first',array(
    			'conditions' => array('Lesson.lesson_id' => $lesson_id),
    			'recursive' => -1));
    	$lesson_name = $lesson['Lesson']['lesson_name'];
    
    	$db = $this->AssignmentScore->getDataSource();
    	$result2 = $db->fetchAll(
    			'SELECT User.id AS student_id , SUM(AssignmentScore.score)*AVG(AssignmentScore.average_level) AS total_score , AVG(AssignmentScore.average_level) AS average_level , COUNT(AssignmentScore.assignment_score_id) AS total_do_assignment , COUNT(Assignment.id) AS total_assignment , User.title , User.first_name , User.middle_name , User.last_name 
					FROM (user AS User INNER JOIN assignment AS Assignment ON (User.classroom_id = Assignment.classroom_id)) LEFT JOIN assignment_score AS AssignmentScore ON
							(Assignment.id = AssignmentScore.assignment_id 
        					AND User.id = AssignmentScore.student_id)
					WHERE User.role = "student" 
					AND Assignment.problemset_id IN (SELECT Problemset.problemset_id
														FROM problemset AS Problemset INNER JOIN 
                                							courses_lessons AS CoursesLesson 
                                        					ON (Problemset.course_id = CoursesLesson.course_id)
                                						WHERE CoursesLesson.lesson_id = ?)
					AND User.classroom_id IN (SELECT CoursesClassroom.classroom_id
			  									FROM courses_classrooms AS CoursesClassroom , 
                          							courses_classrooms AS CoursesClassroom2
                          						WHERE CoursesClassroom.course_id = CoursesClassroom2.course_id
                          						AND CoursesClassroom2.classroom_id IN (SELECT TeachersClassroom.classroom_id 
    																					FROM teachers_classrooms AS TeachersClassroom 
    																					WHERE TeachersClassroom.teacher_id = ?))
					GROUP BY User.id
                    ORDER BY total_score DESC , User.id ASC 
                    LIMIT 10',
    			array($lesson_id,$teacher_id)
    	);
    
    	$this->set('lesson_name',$lesson_name);
    	$this->set('top10List',$result2);
    
    	//     	echo '<br/><br/><br/><br/><br/><br/><br/>';
    	//     	pr($result2);
        
    }

    public function overview_student($psid)
    {
        $assignments = $this->Assignment->find('all',array(
            'conditions' => array(
                'Assignment.problemset_id' => $psid
            ),
        ));
        $asids = array();
        $classrooms = array();
        $course_num = 0;
        $course_end = true;
        foreach ($assignments as $assignment)
        {
            array_push($asids,$assignment['Assignment']['id']);
            array_push($classrooms,$assignment['Assignment']['classroom_id']);
            $num = $this->User->find('count',array(
                'conditions' => array(
                    'classroom_id' => $assignment['Assignment']['classroom_id'],
                    'role' => 'student'
                )
            ));
            if ($assignment['Assignment']['status']!='ended')
            {
                $course_end = false;
            }
            $course_num += $num;
        }
        $score = $this->AssignmentScore->find('all',array(
            'conditions' => array(
                'assignment_id' => $asids
            ),
            'order' => 'score DESC'
        ));
        $score_num = count($score);
        $course_students = $this->User->find('all',array(
            'conditions' => array(
                'User.classroom_id' => $classrooms,
                'role' => 'student'
            ),
        ));
        //pr($score);
        if ($course_end == true)
        {
            $q = floor($course_num/4);
            $assign = array();
            for ($i = 0; $i < $score_num ; $i++)
            {
                array_push($assign,$score[$i]['User']['id']);
            }
            for ($i = 0; $i < count($course_students) ;$i++)
            {
                if (!is_integer(array_search($course_students[$i]['User']['id'],$assign)))
                {
                    array_push($score,array());
                    $score[count($score)-1]['User'] = $course_students[$i]['User'];
                    $score[count($score)-1]['AssignmentScore']['score'] = 0;
                }
            }
        }
        else
        {
            $q = floor($score_num/4);
        }
        $this->set('course_students',$course_students);
        $this->set('score_num',$score_num);
        $this->set('score',$score);
        $this->set('course_num',$course_num);
        $this->set('course_end',$course_end);
        $this->set('q',$q);
    }

    public function leaderboard()
    {
        $leaderboards = $this->getTopClassList(true);
        $classrooms_num = count($leaderboards)-1;
        $this->set("leaderboards",$leaderboards);
        $this->set("classrooms_num",$classrooms_num);
        //pr($leaderboards);
    }

}

?>