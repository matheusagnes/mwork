// jQuery Alert Dialogs Plugin
//
// Version 1.0
//
// Cory S.N. LaViska
// A Beautiful Site (http://abeautifulsite.net/)
// 29 December 2008
//
// Visit http://abeautifulsite.net/notebook/87 for more information
//
// Usage:
//		jAlert( message, [title, callback] )
//		jConfirm( message, [title, callback] )
//		jPrompt( message, [value, title, callback] )
//
// History:
//
//		1.00 - Released (29 December 2008)
//
// License:
//
//		This plugin is licensed under the GNU General Public License: http://www.gnu.org/licenses/gpl.html
//

var script = "<script> $(function(){ $('.ui-state-default').hover( "+
"function(){ $(this).addClass('ui-state-hover'); },"+
"function(){ $(this).removeClass('ui-state-hover'); }"+
");}); </script>";


(function($) {

    $.alerts = {

        // These properties can be read/written by accessing $.alerts.propertyName from your scripts at any time

        verticalOffset: -75,                // vertical offset of the dialog from center screen, in pixels
        horizontalOffset: 0,                // horizontal offset of the dialog from center screen, in pixels/
        repositionOnResize: true,           // re-centers the dialog on window resize
        overlayOpacity: 0.7,                // transparency level of overlay
        overlayColor: '#000000',               // base color of overlay
        draggable: true,                    // make the dialogs draggable (requires UI Draggables plugin)
        okButton: '&nbsp;OK&nbsp;',         // text for the OK button
        cancelButton: '&nbsp;Cancelar&nbsp;', // text for the Cancel button
        dialogClass: null,                  // if specified, this class will be applied to all dialogs

        // Public methods

        alertR: function(message, title, url, div, callback) {
            if( title == null ) title = 'AlertR';
            $.alerts._showR(title, url, div, message, null, 'alertR', function(result) {
                if( callback ) callback(result);
            });
        },

        alertMail: function(msg,title, callback) {
            $.alerts.showMail(title,'', msg, null, 'alertMail', function(result) {
                if( callback ) callback(result);
            });
        },

        alert: function(message, title, callback) {
            if( title == null ) title = 'Alert';
            $.alerts._show(title,'', message, null, 'alert', function(result) {
                if( callback ) callback(result);
            });
        },

        confirm: function(message, title, callback) {
            if( title == null ) title = 'Confirm';
            $.alerts._show(title,'', message, null, 'confirm', function(result) {
                if( callback ) callback(result);
            });
        },

        prompt: function(message, value, title, callback) {
            if( title == null ) title = 'Prompt';
            $.alerts._show(title,'', message, value, 'prompt', function(result) {
                if( callback ) callback(result);
            });
        },

        // Private methods
        
        showMail: function(title,url, msg, value, type, callback) {

            $.alerts._hideMail();
            $.alerts._overlay('showMail');

            $("BODY").append(
                '<div id="popup_email">' +
                '<div class="ui-state-default ui-corner-all" id="exit"> </div>' +
                '<h1 id="popup_title_mail"></h1>' +
                '<div id="popup_content_mail">' +
                '<div id="popup_message_mail"></div>' +
                '</div>' +
                '</div>');

            if( $.alerts.dialogClass ) $("#popup_email").addClass($.alerts.dialogClass);

            // IE6 Fix
            var pos = ($.browser.msie && parseInt($.browser.version) <= 6 ) ? 'absolute' : 'fixed';
            pos = 'fixed',
            $("#popup_email").css({
                position: pos,
                zIndex: 99999,
                padding: 0,
                margin: 0
            });
                        

            $("#exit_mail").text('<span style="margin:auto; margin-top:2px;"class="ui-icon ui-icon-circle-close"> </span>'+script);
            $("#exit_mail").html( $("#exit").text().replace(/\n/g, '<br />') );
            $("#popup_title_mail").text(title);
            $("#popup_title_mail").html( $("#popup_title_mail").text().replace(/\n/g, '<br />') );
            $("#popup_content_mail").addClass(type);
            $("#popup_message_mail").text(msg);
            $("#popup_message_mail").html( $("#popup_message_mail").text().replace(/\n/g, '<br />') );
                       

            $("#popup_email").css({
                minWidth: $("#popup_email").outerWidth(),
                maxWidth: $("#popup_email").outerWidth()
            });

            $.alerts._repositionMail();
            $.alerts._maintainPosition(true);

            switch( type ) {
                case 'alertMail':
                    $("#exit_mail").click( function() {
                        $.alerts._hide();
                        callback(true);
                    });
                    $("#exit_mail").focus().keypress( function(e) {
                        if( e.keyCode == 13 || e.keyCode == 27 ) $("#popup_ok_mail").trigger('click');
                    });
					
                    $("#popup_ok_mail").click( function() {
                        $.alerts._hide();
                        callback(true);
                    });
                    $("#popup_ok_mail").focus().keypress( function(e) {
                        if( e.keyCode == 13 || e.keyCode == 27 ) $("#popup_ok_mail").trigger('click');
                    });
                    break;
            }
            
            if( $.alerts.draggable ) {
                try {
                    $("#popup_mail").draggable({
                        handle: $("#popup_title_mail")
                        });
                    $("#popup_title_mail").css({
                        cursor: 'move'
                    });
                } catch(e) { /* requires jQuery UI draggables */ }
            }
        },

                

        _show: function(title,url, msg, value, type, callback) {

            $.alerts._hide();
            $.alerts._overlay('show');

            $("BODY").append(
                '<div id="popup_container">' +
                '<div class="ui-state-default ui-corner-all" id="exit" > <span  style="margin:auto; margin-top:2px;"class="ui-icon ui-icon-circle-close"> </span>'+script+' </div>' +
                '<h1 id="popup_title"></h1>' +
                '<div id="popup_content">' +
                '<div id="popup_message"></div>' +
                '</div>' +
                '</div>');

            if( $.alerts.dialogClass ) $("#popup_container").addClass($.alerts.dialogClass);

            // IE6 Fix
            var pos = ($.browser.msie && parseInt($.browser.version) <= 6 ) ? 'absolute' : 'fixed';
            pos = 'fixed',
            $("#popup_container").css({
                position: pos,
                zIndex: 99999,
                padding: 0,
                margin: 0
            });
                        

            //$("#exit").text('<span style="margin:auto; margin-top:2px;"class="ui-icon ui-icon-circle-close"> </span>'+script);
            //$("#exit").html( $("#exit").text().replace(/\n/g, '<br />') );
            $("#popup_title").text(title);
            $("#popup_title").html( $("#popup_title").text().replace(/\n/g, '<br />') );
            $("#popup_content").addClass(type);
            $("#popup_message").text(msg);
            $("#popup_message").html( $("#popup_message").text().replace(/\n/g, '<br />') );
                       

            $("#popup_container").css({
                minWidth: $("#popup_container").outerWidth(),
                maxWidth: $("#popup_container").outerWidth()
            });

            $.alerts._reposition();
            $.alerts._maintainPosition(true);

            switch( type ) {
                case 'alertM':
                    $("#exit").click( function() {
                        alert('aaa');
                        $.alerts._hide();
                        callback(true);
                    });
                    $("#exit").focus().keypress( function(e) {
                        if( e.keyCode == 13 || e.keyCode == 27 ) $("#popup_ok").trigger('click');
                    });
					
                    $("#popup_ok").click( function() {
                        $.alerts._hide();
                        callback(true);
                    });
                    $("#popup_ok").focus().keypress( function(e) {
                        if( e.keyCode == 13 || e.keyCode == 27 ) $("#popup_ok").trigger('click');
                    });
                    break;
                case 'alertR':
                    $("#exit").click( function() {
                        $.alerts._hide();
                        callback(true);
                    });
                    $("#exit").focus().keypress( function(e) {
                        if( e.keyCode == 13 || e.keyCode == 27 ) $("#popup_ok").trigger('click');
                    });
                    $("#popup_message").after('<div id="popup_panel"><input type="button" value="' + $.alerts.okButton + '" id="popup_ok" style="cursor:pointer;" /></div>');
                    $("#popup_ok").click( function() {
                        $.alerts._hide();
                        requestPage(url,'conteudo','get','','');
                        callback(true);
                    });
                    $("#popup_ok").focus().keypress( function(e) {
                        if( e.keyCode == 13 || e.keyCode == 27 ) $("#popup_ok").trigger('click');
                    });
                    break;
                case 'alert':
                    
                    $("#exit").click( function() {
                        $.alerts._hide();
                        callback(true);
                    });
                    $("#exit").focus().keypress( function(e) {
                        if( e.keyCode == 13 || e.keyCode == 27 ) $("#popup_ok").trigger('click');
                    });
                    $("#popup_message").after('<div id="popup_panel"><input type="button" value="' + $.alerts.okButton + '" id="popup_ok" style="cursor:pointer;" /></div>');
                    $("#popup_ok").click( function() {
                        $.alerts._hide();
                        callback(true);
                    });
                    $("#popup_ok").focus().keypress( function(e) {
                        if( e.keyCode == 13 || e.keyCode == 27 ) $("#popup_ok").trigger('click');
                    });
                    break;
                case 'confirm':
                    $("#popup_message").after('<div id="popup_panel"><input type="button" value="' + $.alerts.okButton + '" id="popup_ok" style="cursor:pointer;" /> <input type="button" value="' + $.alerts.cancelButton + '" id="popup_cancel" style="cursor:pointer;" /></div>');
                    $("#popup_ok").click( function() {
                        $.alerts._hide();
                        if( callback ) callback(true);
                    });
                    $("#popup_cancel").click( function() {
                        $.alerts._hide();
                        if( callback ) callback(false);
                    });
                    $("#popup_ok").focus();
                    $("#popup_ok, #popup_cancel").keypress( function(e) {
                        if( e.keyCode == 13 ) $("#popup_ok").trigger('click');
                        if( e.keyCode == 27 ) $("#popup_cancel").trigger('click');
                    });
                    break;
                case 'prompt':
                    $("#popup_message").append('<br /><input type="text" size="30" id="popup_prompt" />').after('<div id="popup_panel"><input type="button" value="' + $.alerts.okButton + '" id="popup_ok" style="cursor:pointer;" /> <input type="button" value="' + $.alerts.cancelButton + '" id="popup_cancel" style="cursor:pointer;" /></div>');
                    $("#popup_prompt").width( $("#popup_message").width() );
                    $("#popup_ok").click( function() {
                        var val = $("#popup_prompt").val();
                        $.alerts._hide();
                        if( callback ) callback( val );
                    });
                    $("#popup_cancel").click( function() {
                        $.alerts._hide();
                        if( callback ) callback( null );
                    });
                    $("#popup_prompt, #popup_ok, #popup_cancel").keypress( function(e) {
                        if( e.keyCode == 13 ) $("#popup_ok").trigger('click');
                        if( e.keyCode == 27 ) $("#popup_cancel").trigger('click');
                    });
                    if( value ) $("#popup_prompt").val(value);
                    $("#popup_prompt").focus().select();
                    break;
            }

            // Make draggable
            if( $.alerts.draggable ) {
                try {
                    $("#popup_container").draggable({
                        handle: $("#popup_title")
                        });
                    $("#popup_title").css({
                        cursor: 'move'
                    });
                } catch(e) { /* requires jQuery UI draggables */ }
            }
        },
        _showR: function(title,url,div, msg, value, type, callback) {

            $.alerts._hide();
            $.alerts._overlay('show');

            $("BODY").append(
                '<div id="popup_container">' +
                '<h1 id="popup_title"></h1>' +
                '<div id="popup_content">' +
                '<div id="popup_message"></div>' +
                '</div>' +
                '</div>');

            if( $.alerts.dialogClass ) $("#popup_container").addClass($.alerts.dialogClass);

            // IE6 Fix
            var pos = ($.browser.msie && parseInt($.browser.version) <= 6 ) ? 'absolute' : 'fixed';
            pos = 'fixed',
            $("#popup_container").css({
                position: pos,
                zIndex: 99999,
                padding: 0,
                margin: 0
            });

            $("#popup_title").text(title);
            $("#popup_content").addClass(type);
            $("#popup_message").text(msg);
            $("#popup_message").html( $("#popup_message").text().replace(/\n/g, '<br />') );

            $("#popup_container").css({
                minWidth: $("#popup_container").outerWidth(),
                maxWidth: $("#popup_container").outerWidth()
            });

            $.alerts._reposition();
            $.alerts._maintainPosition(true);

            switch( type ) {
                case 'alertR':
                    $("#popup_message").after('<div id="popup_panel"><input type="button" value="' + $.alerts.okButton + '" id="popup_ok" style="cursor:pointer;" /></div>');
                    $("#popup_ok").click( function() {
                        $.alerts._hide();
                        requestPage(url,div,'get','','');
                        callback(true);
                    });
                    $("#popup_ok").focus().keypress( function(e) {
                        if( e.keyCode == 13 || e.keyCode == 27 ) $("#popup_ok").trigger('click');
                    });
                    break;
            }

            // Make draggable
            if( $.alerts.draggable ) {
                try {
                    $("#popup_container").draggable({
                        handle: $("#popup_title")
                        });
                    $("#popup_title").css({
                        cursor: 'move'
                    });
                } catch(e) { /* requires jQuery UI draggables */ }
            }
        },

        _hide: function() {
            $("#popup_container").remove();
            $.alerts._overlay('hide');
            $.alerts._maintainPosition(false);
        },
        
        _hideMail: function() {
            $("#popup_container_mail").remove();
            $.alerts._overlay('hide_mail');
            $.alerts._maintainPosition(false);
        },

        _overlay: function(status) {
            switch( status ) {
                case 'show':
                    $.alerts._overlay('hide');
                    $("BODY").append('<div id="popup_overlay"></div>');
                    $("#popup_overlay").css({
                        position: 'absolute',
                        zIndex: 99998,
                        top: '0px',
                        left: '0px',
                        width: '100%',
                        height: $(document).height(),
                        background: $.alerts.overlayColor,
                        opacity: $.alerts.overlayOpacity
                    });
                    break;
                case 'hide':
                    $("#popup_overlay").remove();
                    break;
            }
            switch( status ) {
                case 'showMail':
                    $.alerts._overlay('hide');
                    $("BODY").append('<div id="popup_overlay_mail"></div>');
                    $("#popup_overlay_mail").css({
                        position: 'absolute',
                        zIndex: 99998,
                        top: '0px',
                        left: '0px',
                        width: '100%',
                        height: $(document).height(),
                        background: $.alerts.overlayColor,
                        opacity: $.alerts.overlayOpacity
                    });
                    break;
                case 'hide':
                    $("#popup_overlay").remove();
                    break;
                case 'hide_mail':
                    $("#popup_overlay_mail").remove();
                    break;    
            }
        },

        _reposition: function() {
            var top = (($(window).height() / 2) - ($("#popup_container").outerHeight() / 2)) + $.alerts.verticalOffset;
            var left = (($(window).width() / 2) - ($("#popup_container").outerWidth() / 2)) + $.alerts.horizontalOffset;
            if( top < 0 ) top = 0;
            if( left < 0 ) left = 0;

            // IE6 fix
            if( $.browser.msie && parseInt($.browser.version) <= 6 ) top = top + $(window).scrollTop();

            $("#popup_container").css({
                top: top + 'px',
                left: left + 'px'
            });
            $("#popup_overlay").height( $(document).height() );
        },
        
        _repositionMail: function() {
            var top = (($(window).height() / 2) - ($("#popup_mail").outerHeight() / 2)) + $.alerts.verticalOffset;
            var left = (($(window).width() / 2) - ($("#popup_mail").outerWidth() / 2)) + $.alerts.horizontalOffset;
            if( top < 0 ) top = 0;
            if( left < 0 ) left = 0;

            // IE6 fix
            if( $.browser.msie && parseInt($.browser.version) <= 6 ) top = top + $(window).scrollTop();

            $("#popup_mail").css({
                top: top + 'px',
                left: left + 'px'
            });
            $("#popup_overlay_mail").height( $(document).height() );
        },

        _maintainPosition: function(status) {
            if( $.alerts.repositionOnResize ) {
                switch(status) {
                    case true:
                        $(window).bind('resize', function() {
                            $.alerts._reposition();
                        });
                        break;
                    case false:
                        $(window).unbind('resize');
                        break;
                }
            }
        }

    }

    // Shortuct functions
    jAlert = function(message, title, callback) {
        $.alerts.alert(message, title, callback);
    }
    jAlertM = function(message, title, callback) {
        $.alerts.alertMail(message, title, callback);
    }

    jAlertR = function(message,  title, url, div, callback) {
        $.alerts.alertR(message,  title, url, div, callback);
    }

    jConfirm = function(message, title, callback) {
        $.alerts.confirm(message, title, callback);
    };

    jPrompt = function(message, value, title, callback) {
        $.alerts.prompt(message, value, title, callback);
    };

})(jQuery);