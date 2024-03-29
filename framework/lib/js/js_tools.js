
function showHighLight(message, state)
{

    var image_src = '';
    var classMessage = '';
    if (state == 'INFO'){
        image_src = 'info.png' ;
        classMessage = 'info_message';
    }else if(state == 'SUCCESS'){
        image_src = 'success.png';
        classMessage = 'success_message';
    }else if(state == 'ERROR'){
        image_src = 'error.png';
        classMessage = 'error_message';
    }else if(state == 'WARNING'){
        image_src = 'warning.png';
        classMessage = 'warning_message';
    }
    message = (image_src) ? '<img class="img_message" src="framework/images/'+image_src+'"/><label>'+message+'</label>' : '<label>'+message+'</label>';

    // add message to highlight_messages class
    //var message_obj = $('<div class="message '+classMessage+'">'+message+'</div>');
    var message_obj = $('<div>').addClass('message '+classMessage).html(message);

    $('.highlight_messages').html(message_obj);
    message_obj.slideDown();

    // hide and remove message when click
    message_obj.click(function(){
        $(this).slideUp(300,function(){$(this).remove()});
    });

}


(function( $ ){
    $.fn.serializeJSON=function() {
        var json = {};
        jQuery.map($(this).serializeArray(), function(n, i){
            json[n['name']] = n['value'];
        });
        return json;
    };
})( jQuery );

(function( $ )
{
    $.fn.checkFields=function() 
    {
        var valid = true;
        this.find('input,select,textarea').each(function()  
        {
            if($(this).prop('required') && ($(this).val() == '' || $(this).val() == 0))
            {
                valid  = false;
                return false;
            }
        });
        if(!valid)
            this.find('.validate-tips').slideDown();

        return valid;                
    };
})( jQuery );
