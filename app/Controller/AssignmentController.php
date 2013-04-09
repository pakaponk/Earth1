<?php

class AssignmentController extends AppController {

    public function extendEnddate($id,$psid){

        $redirect = '/problem_set/view/'.$psid;

        $assignmentData = $this->Assignment->findAllById($id);
        $this->set('data',$assignmentData);

        //////////////////////Check Assignment is over end date , isn't it?/////////////////
        $over = false;
        foreach ($assignmentData as $assignment){
            $end_date = $assignment['Assignment']['end_date'];
            $end_date = substr($end_date,0,10);
            $day = substr($end_date,8,2);
            $month = substr($end_date,5,2);
            $year = substr($end_date,0,4);
            $this->set('day',$day);
            $this->set('month',$month);
            $this->set('year',$year);
            if(date('Y-m-d H:i:s')>$assignment['Assignment']['end_date']){ // if over end date
                $over = true;
            }
        }

        if(!$over){ // if assignment isn't over end date , end date can be edited
            if($this->request->is('post') || $this->request->is('put')) {
                $this->Assignment->id = $id;
                if ($this->Assignment->save($this->request->data)) {
                    $this->Session->setFlash(__('The assignment set has been saved'),'flash_complete');
                    $this->redirect($redirect);
                } else {
                    $this->Session->setFlash(__('The assignment set could not be saved. Please, try again.'),'flash_notification');
                    $this->redirect($redirect);
                }
            }
        }else{
            $this->Session->setFlash(__('The assignment can\'t be edited, because it\'s over end date'),'flash_notification');
            $this->redirect($redirect);
        }
    }

}

?>