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

//Carregar imagens para nao precisar carregar no momento em que chama o ajax
imgLoad = new Image(); 
imgLoad.src = 'lib/ajax/images/ajax-loader.png';
//imgClose = new Image(); 
//imgClose.src = 'images/close.gif';



var cache = {
    // If url is '' (no fragment), display this div's content.
    '' : ''
};

// BBQ
$(document).ready(function() {

    $(window).bind(	'hashchange',function(e) {
        
        var param_fragment = $.param.fragment();
        var url = (param_fragment) ? param_fragment : 'ajax.php?class=UsuariosFormView::show()';
        if (cache[url]) {
					
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
    requestPage(url, '',  null, null, 'post', true, true);
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
            // Se retornou erro
            if (data.indexOf("showMessage") != -1 || data.indexOf("showError") != -1) // FIXME mudar identificador de erro
            {
                $( 'html' ).append( data );
            }
            // Se nao retornou erro
            else
            {
                // Se foi definida uma div onde serah adicionado o retorno
                if(div)      
                {
                    $( '#'+div+'' ).empty().append( data ).trigger('create');
		         	 
                    // Salvar a pagina no cache
                    if(saveCache)
                        cache[url] = data;
                }
                // se a div alvo nao foi definida, adiociona o retorno no final do html
                else
                {
                    $( 'html' ).append( data ).trigger('create');
                }
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
                console.log(erro.responseText);
            }
            else
            {
                console.log(erro.responseText);
                //showError(erro.responseText );
                alert(erro.responseText );
            }
        }        
    });   
    
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
