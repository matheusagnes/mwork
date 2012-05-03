var $window = $( window ),
$html = $( "html" ),
$loader = $( "<div class='ui-loader ui-body-a ui-corner-all'><span class='ui-icon ui-icon-loading spin'></span><h1></h1></div>" );

// tempo de espera antes de apareces o loading message
var delay_before_loading = 50;

// tempo da mensagem de erro amarela do jquery mobile
var delay_error_message = 1200;

// mostrar mensagem padrao de erro. se false, mostra o erro retornado
var showDefaultError = true;

// mensagem de erro padrao
var stringDefaultError = 'Erro ao carregar página';

//Carregar imagens para nao precisar carregar no momento em que chama o ajax // testei isso com o debug - e funciona
imgLoad = new Image(); 
imgLoad.src = 'framework/lib/js/ajax/images/ajax-loader.png';


var cache = {
    // If url is '' (no fragment), display this div's content.
    '' : ''
};

// BBQ
$(document).ready(function() {

    $(window).bind(	'hashchange',function(e) {
        console.log('a');
        var param_fragment = $.param.fragment();
        var url = (param_fragment) ? param_fragment : 'ajax.php?class=UsuariosFormView::show()';

        // if the url cache exists
        if (cache[url]) {
		    
            // load html from cache
            $( '#conteudo' ).empty().append( cache[url] ).trigger('create');
					
        } else {
	
            if( url.substring(0, 1) == '!')
            {   
                
                requestPage(url.substring(1,url.strlen), 'conteudo', null, null,'post', true,false);
            }
            else
            {
                requestPage(url, 'conteudo', null, null,'post', true,true);				
            }
            			
        }
    })
    
    $(window).trigger('hashchange');

});

function showContent(url, div)
{
    if(div == 'conteudo')
    {
        location.href = '#!ajax.php?class='+url;    
    }    
    else
    {
        requestPage('ajax.php?class='+url, div,  null, null, 'post', true, false);
    }
}

function listAction(url)
{
    requestPage('ajax.php?class='+url, null,  null, null, 'post', true, false);
}

function openPage(url)
{
    if( url.substring(0, 1) == '#')
    {
        location.href = url;
    }
    else
    {    
        requestPage(url, 'conteudo',  null, null, 'post', true, true);
    }
}

function openLink(url)
{
    requestPage('ajax.php?class='+url, '',  null, null, 'post', true, true);
}

function loadCombo(url)
{
    requestPage(url, null,  null, null, 'post', true, null);
}


function requestPage(url,div,formId,campoId, tipo, loading, saveCache)
{        
    // remove dialogs na tela
    $('.ui-loader').remove(); 
	
    var elementos = null;

    elementos = (formId) ? formId : campoId;
    elementos = $('#'+elementos+'').serialize();
    
    if(loading)
    {
        // This configurable timeout allows cached pages a brief delay to load without showing a message
        var loadMsgDelay = setTimeout(function(){
			    
            // adiciona div para impedir que o usuario clique na tela
            //$.alerts._overlay('hide');
            $("BODY").append('<div id="block-ui"></div>');
            $("#block-ui").css({
                position: 'absolute',
                zIndex: 9,
                top: '0px',
                left: '0px',
                width: '100%',
                height: $(document).height(),
                background: '#555555',
                opacity: 0.2
            });
                
            $('#block-ui').show();
	        
            // mostra tela de loading
            showPageLoadingMsg();
				
        }, delay_before_loading ),
	
        // Shared logic for clearing timeout and removing message.
        hideMsg = function(){
	
            // Stop message show timer
            clearTimeout( loadMsgDelay );
	
            // Hide loading message
            hidePageLoadingMsg();
        };
    }
    
    $.ajax({
        type: tipo, //Tipo do envio das informacoes GET ou POST
        url: url, //url para onde sera enviada as informacoes digitadas
        data: elementos, /*parametros que serao carregados para a url selecionada (via POST). o 
                          *form serialize passa de uma so vez todas as informacoes que estao dentro do
                          * formulario. Facilita, mas pode atrapalhar quando nao for aplicado adequadamente a sua   aplicacao*/
        //async:false,
        //function(data) vide item 4 em $.get $.post
        success: function(data)
        {
            // Se nao foi definida a div
            if (!div)
            {
                $('html').append(data);//.trigger('create'); 
            }
            else
            {
                // Se foi definida uma div onde serah adicionado o retorno
                $( '#'+div+'' ).html( data ).trigger('create');
                 
                // Salvar a pagina no cache
                if(saveCache)
                    cache[url] = data;
            }
    		
            // remove loading message e div que bloqueia tela
            if(loading)
            {
                $('#block-ui').remove();
                hideMsg();
            }
    		
        },

        // Se acontecer algum erro e executada essa funcao
        error: function(erro)
        {
            
            if(loading)
            { 
                // remove loading message e div que bloqueia tela
                $('#block-ui').remove();
                hideMsg();
            }
            // mostra dialog de erro
            if (showDefaultError)
            {
                //showError(stringDefaultError);
                alert(stringDefaultError);

            }
            else
            {
                //showError(erro.responseText );
                alert(erro.responseText );
            }
        }        
    }); 

}

function ajaxSubmit(url,id,formId)
{
    requestPage('ajax.php?class='+url,id,formId,'', 'POST', true, false);
} 

function showPageLoadingMsg() {
    
    //var activeBtn = $( "." + $.mobile.activeBtnClass ).first();
    
    //#FIXME da altura
  
    $loader
    .find( "h1" )
    .text( "Carregando..." )
    .end()
    .appendTo( $html )
    // position at y center (if scrollTop supported), above the activeBtn (if defined), or just 100px from top
    .css({
        top: $.support.scrollTop && $window.scrollTop() + $window.height() / 2 || 200,
        position: 'fixed'
    });
    
    $html.addClass( "ui-loading" );

	

    


}

function hidePageLoadingMsg(){
    $html.removeClass( "ui-loading" );
}
