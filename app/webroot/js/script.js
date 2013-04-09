setInterval(function(){
    var today = $('#date').html();
    if (today == '00:00:00')
    {
        $('#submit').trigger('click');
    }
    else
    {
        var hours = today.substr(0,2);
        var minutes = today.substr(3,2);
        var seconds = today.substr(6,2);
        if (seconds>0)
        {
            seconds = seconds-1;
        }
        else if (minutes>0)
        {
            minutes = minutes-1;
            seconds = 59;
        }
        else
        {
            hours = hours-1;
            minutes = 59;
            seconds = 59;
        }
        hours = addZero(parseInt(hours));
        minutes = addZero(parseInt(minutes));
        seconds = addZero(seconds);
        $('#date').html(hours+":"+minutes+":"+seconds);
    }
} , 1000);

function addZero(time){
    if (time<10)
    {
        time = "0"+time;
    }
    return time;
}
