/**
 * Created with JetBrains PhpStorm.
 * User: Apple
 * Date: 3/20/13 AD
 * Time: 11:51 AM
 * To change this template use File | Settings | File Templates.
 */

var problemCount = 0 ;
var problemId = new Array();
var problemStatus = new Array();

function getProblemIndex(id){
    for(var i =0 ;i<problemCount;i++){
        if(problemId[i] == id) return i ;
    }
    return -1;
}

function save_problemset(pid){
    var idArr = $('#problemset_problem_id').html() ;
    var id ='';
    var status = '';
    //alert(idArr);
    idArr = idArr.split(",");
    //var len = idArr.length - 2 ;
    for(var i=0;i< problemCount;i++){
        //alert(idArr[i]+' '+$('#status'+idArr[i]).html() );
        /*id += idArr[i];
        status += $('#status'+idArr[i]).html();*/
        id +=problemId[i];
        status +=problemStatus[i];
        if(i != problemCount){
            id +=';';
            status +=';';
        }
    }
    var callUrl = '/mathblink/teacher/save_problemset/'+pid+'/'+id +'/'+ status ;
    //alert(callUrl);

    //alert(problemId.join('\n'));
    //alert(problemStatus.join('\n'));
    $.ajax({
        url: callUrl,
        cache: false,
        type: 'GET',
        dataType: 'HTML',
        success: function (data) {
            $('#finish_create_problemset').show();
            //$('#debug_save').html(data);
            /*$('#TopicDiv').html(data);
            $('html, body').animate({
                scrollTop: $("#TopicDiv").offset().top - 33
            },1000);*/
        }
    });
}

function problemsetGetTopic(urlStr,id){
    var lesson_id = $('#'+id).val();
    //alert(lesson_id);
    if( lesson_id.length == 0 ){
        //alert("now");
        $('#ProblemDiv').empty();
    }
    $('#ProblemDiv').empty;
    $.ajax({
        url: urlStr+'/'+lesson_id ,
        cache: false,
        type: 'GET',
        dataType: 'HTML',
        success: function (data) {
            $('#ProblemDiv').empty();
            $('#TopicDiv').html(data);
            $('html, body').animate({
                scrollTop: $("#TopicDiv").offset().top - 50
            },1000);
        }
    });
}


function problemsetGetProblem(urlStr,id){
    var topic = $('#'+id).val();
    if(topic.length == 0){
        $('#ProblemDiv').empty();
    }else{
        $.ajax({
            url: urlStr+'/'+topic ,
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            success: function (data) {
                $('#ProblemDiv').html(data);
                $('html, body').animate({
                    scrollTop: $("#problem_header").offset().top - 33
                },1000);
               //alert(data);
            }
        });
    }
}

function addProblem(latex,id){
    var str = '<div style="font-size: 13px;margin-bottom: -5px;border-bottom: 1px solid #b3b3b3" id="'+id+'">';
    str += '<span style="width:50px">'+latex+'</span><a href="javascript:removeProblem(\''+latex+'\','+id+')" class="btn btn-mini">remove</a></div>';
    $('#problemset_queue').append(str);
    $('#problemset_problem_id').append(id+',');


    if( $('#status'+id).is("div,ul,blockquote") ){
        //alert("hey");
        var index = getProblemIndex(id);
        problemStatus[index] ="add";
        $('#status'+id).html("add");
    }else{
        problemId[problemCount] = id;
        problemStatus[problemCount++] = "add" ;
        var str2 = '<div id="status'+id+'">add</div>';
        $('#problemset_problem_status').append(str2);
    }
    $('#button'+id).html('<a class="btn" href="javascript:removeProblem(\''+latex+'\','+id+')">Remove</a>');
    MathJax.Hub.Typeset();
    // alert("heyy");
}

function changeStatus(latex,id){
    $('#button'+id).html('<a class="btn" href="javascript:removeProblem(\''+latex+'\','+id+')">Remove</a>');
    MathJax.Hub.Typeset();
}

function removeProblem(latex,id){
    var index = getProblemIndex(id);
    problemStatus[index] = "remove";
    $('#button'+id).html('<a class="btn" href="javascript:addProblem(\''+latex+'\','+id+')">Add</a>');
    $('#status'+id).html("remove");
    $('#'+id).remove();
}



function get_problem_to_topic(inp_id){
    //alert(inp_id);
    var type ;
    var id ;
    if(inp_id =="TopicConceptId"){
        type = 1 ;
        id = $('#TopicConceptId').val() ;
        $('#TopicTechniqueId').val("");
        $('#problem').html("");
    }else if(inp_id == "TopicTechniqueId"){
        type = 0 ;
        id = $('#TopicTechniqueId').val();
        $('#TopicConceptId').val("");
        $('#problem').html("");
    }


   // alert(id);
    /*
     TODO
     URL in get_problem_to_topic should be replace
     */
    $.ajax({
        url: '/mathblink/topic/get_problem_to_topic/'+type+'/'+id ,
        cache: false,
        type: 'GET',
        dataType: 'HTML',
        success: function (data) {
            $('#problem').html(data);
            $('html, body').animate({
                scrollTop: $("#problem").offset().top - 50
            },1000);
        }
    });


}

function remove_problem_topic(latex,id){
    var index = getProblemIndex(id);
    problemStatus[index] = "remove";
    $('#problem'+id).remove();
    $('#button'+id).html('<a class="btn" href="javascript:add_problem_to_topic(\''+latex+'\',\''+id+'\');">Add</a>');
}

function add_problem_to_topic(latex,id){
    //alert(id);
     var str = "<div id=\"problem"+id+"\" style=\"padding: 5px;font-size: 15px;width: 400px;margin-bottom: 5px\" class=\"hero-unit\">";
     str += "<span style=\"font-weight: bold\" class=\"muted\">";
     str += "#"+id ;
     str += "</span>";
     str += latex ;
     str += "<a href=\"\" class=\"btn\">remove</a></div>";

    var index = getProblemIndex(id) ;
    if(index == -1){
        problemId[problemCount] = id ;
        problemStatus[problemCount] = "add";
        problemCount++;
    }else{
        problemStatus[index] = "add";
    }

    $('#button'+id).html('<a class="btn" href="javascript:remove_problem_topic(\''+latex+'\','+id+')">Remove</a>');
    $('#problem_queue').append(str);
    MathJax.Hub.Typeset();
}

function changeStatus2(latex,id){
    $('#button'+id).html('<a class="btn" href="javascript:remove_problem_topic(\''+latex+'\','+id+')">Remove</a>');
    MathJax.Hub.Typeset();
}

function save_problem_to_topic(tid){
    var id ='';
    var status = '';

    for(var i=0;i< problemCount;i++){
        id +=problemId[i];
        status +=problemStatus[i];
        if(i != problemCount){
            id +=';';
            status +=';';
        }
    }
    //alert("enter");



    /*
    TODO: Please change callUrl
     */
    var callUrl = '/mathblink/topic/save_problem_to_topic/'+tid+'/'+id +'/'+ status ;

    $.ajax({
        url: callUrl,
        cache: false,
        type: 'GET',
        dataType: 'HTML',
        success: function (data) {
            //alert(data);
            //$('#finish_add_problem').show();
            //$('#debug_save').html(data);
            /*$('#TopicDiv').html(data);
             $('html, body').animate({
             scrollTop: $("#TopicDiv").offset().top - 33
             },1000);*/
        }
    });
}


function close_bg(){
    $('#bg').hide();
    $('#selectCourseDiv').hide();
}

function get_class(id){
    /*
    * TODO:Change url here !!
    * */
    var callUrl = '/mathblink/teacher/get_class/'+id ;
    $('.btn').removeClass(" btn-primary");
    $('#bt'+id).addClass(" btn-primary");
    $.ajax({
        url: callUrl,
        cache: false,
        type: 'GET',
        dataType: 'HTML',
        success: function (data) {
            //alert(data);
            $('#selectClassDiv').hide();
            $('#selectClassDiv').fadeIn("slow");
            $('#selectClassDiv').html(data);
            //$('#debug_save').html(data);
            /*$('#TopicDiv').html(data);
             $('html, body').animate({
             scrollTop: $("#TopicDiv").offset().top - 33
             },1000);*/
        }
    });
}