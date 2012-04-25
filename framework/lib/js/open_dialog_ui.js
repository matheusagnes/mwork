//Carregar imagens para nao precisar carregar no momento em que chama o ajax // testei isso com o debug - e funciona
var path_carregando = 'imgs/loading.gif';
imgLoad = new Image();
imgLoad.src = path_carregando;


// mostra um dialog com o conteudo que retornar a url
function openDialog(message, url, title, width, height)
{

    // valores padrao caso nao seja passado por parametro
    message = (message == 'undefined' || message == null) ? '' : message;
    width = (width == 'undefined' || width == null) ? '300' : width;
    height = (height == 'undefined' || height == null) ? '200' : height;
    title = (title == 'undefined' || title == null) ? '' : title;

    // insere a div do dialog apenas a primeira vez que chama o openDialog
    if (!document.getElementById('ui-dialog'))
    {
            $("BODY").append('<div id="ui-dialog" title="'+title+'" style="display:none;" ><center><img src="'+path_carregando+'" style="display:none;padding-top:20px;" class="loading_dialog_ui" /></center> <div id="popup"> '+message+' </div></div>');
    }

    // chama a funcao dialog do jQuery-ui para transformar a div em um dialog
    $(function()
    {
        $( "#ui-dialog" ).dialog({ modal: true , height: height, width: width });
    });

    if (url != null && url != 'undefined')
    {
        // mostra loading dentro do dialog e oculta o conteudo do dialog
        $('.loading_dialog_ui').show();
        $('#popup').hide();

        $("#ui-dialog").ready(function() {
          // Handler for .ready() called.
                // chama um ajax para colocar o resultado dentro do dialog
            $.ajax({
                url: url,
                success: function(data)
                {
                    $('#popup').html(data);
                },
                error: function(erro)
                {
                    $('#popup').html(erro.responseText);
                },
                complete: function()
                {
                    $('.loading_dialog_ui').hide();
                    $('#popup').show();
                }
            });
        });
    }

    // remover dialog apos ser fechado
    $( "#ui-dialog" ).bind( "dialogbeforeclose", function(event, ui) 
    {
        $(this).remove();
    });
}

function closeDialog()
{
    $( "#ui-dialog" ).dialog("close");
}


