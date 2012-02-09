$(function() {

    var $getitems   = $('#getitems'),
        $msg        = $('#msg')
        $messages   = $('#messages'),
        xhr         = null;

    $getitems.bind('click', function() {
//        $.post(
//            '/async/getitems',
//            { 'msg' :  msg },
//            function(resp) {
//                alert(resp);
//            }, 'json'
//        );

        xhr = $.ajax('/async/getitems',
            {
                dataType: 'json',
                type: 'post',
                data: { 'msg' : $msg.val() }
            }
        );

        xhr.always(function(data){
//            console.log(data);
            var $resp = $(data);
            $messages
                .append($resp)
                .hide()
                .fadeToggle('500');

            setTimeout(function(obj) {
//                console.log('timeout');
                obj.fadeOut('500', function() {
                    $(this).remove();
                });
            }, 2500, $resp);
        });
        return false;
    });
});

















