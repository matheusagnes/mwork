


var UploadFileCache = {};

function UploadFileObject(refInputFile) {

    this.setting = {};

    this.id     = refInputFile.id.length > 0 ? refInputFile.id : refInputFile.name;
    this.name   = refInputFile.name;
    this.objUploadFileTmp    = document.getElementById('UploadFileTmp');
    this.objBox              = null;
    this.objFormUpload       = null;
    this.objIFrameUpload     = null;
    this.objInputFile        = null;

    this.reset = function () {
        this.objUploadFileTmp    = document.getElementById('UploadFileTmp');
        this.objFormUpload       = document.getElementById('form_'+this.id);
        this.objIFrameUpload     = document.getElementById('iframe_'+this.id);
        this.objInputFile        = document.getElementById('file_'+this.id);
    }
    this.reset();

    this.ini = function (s) {
        
        this.setting = extend(this.setting, s);

        this.objBox = document.createElement('span');
        this.objBox.id = ''+this.id;
        this.objBox.style.display = refInputFile.style.display;
        this.objBox.innerHTML =
            '<input'+
            ' id="file_'+this.id+'"'+
            ' type="file"'+
            ' name="'+this.name+'"'+
            ' onchange="UploadFile(\'#'+this.id+'\').submit();"'+
            ' />'
        ;

        refInputFile.style.display = 'none';
        refInputFile.parentNode.insertBefore(this.objBox, refInputFile);

        this.reset();
        
        refInputFile.parentNode.removeChild(refInputFile);
    }

    this.submit = function () { var this1 = this, func = function () {

        this1.reset();

        this1.canceled = false;

        if (!this1.setting.action) {
            return;
        }

        var objTmp = document.createElement('div');
        objTmp.innerHTML =
            '<form'+
            ' id="form_'+this1.id+'"'+
            ' method="post"'+
            ' action="'+this1.setting.action+'"'+
            ' enctype="multipart/form-data"'+
            ' name="form_'+this1.id+'"'+
            ' target="iframe_'+this1.id+'"'+
            '>'+
            '</form>'+
            '<iframe'+
            ' id="iframe_'+this1.id+'"'+
            ' name="iframe_'+this1.id+'"'+
            ' src="#"'+
            ' onload="UploadFile(\'#'+this1.id+'\').load();"'+
            '>'+
            '</iframe>'+
            ''
        ;
        this1.objUploadFileTmp.appendChild(objTmp);

        this1.reset();

        this1.objFormUpload.appendChild(this1.objInputFile);

        this1.objFormUpload.submit();

        this1.objBox.innerHTML =
            //'<img src="lib/css/images/loading_file.gif" alt="enviando..." style="vertical-align: middle;" />'+
            '<input'+
            ' type="text"'+
            ' value=""'+
            ' readonly="readonly"'+
            ' style="background-image: url(lib/css/images/loading_file.gif); background-repeat: no-repeat; background-position: center center;"'+
            ' />'+
            ' '+
            '<span title="Cancelar Envio"'+
            ' style="cursor: pointer;"'+
            ' onclick="UploadFile(\'#'+this1.id+'\').cancel();"'+
            '>'+
            '<img src="imgs/stop.gif" alt="" title="Cancelar Envio"'+
            ' style="vertical-align: middle;"'+
            ' />'+
            ' '+
            'Cancelar'+
            '</span>'+
            ''+
            ''
        ;

        this1.objInputFile.style.display = 'none';
        this1.objBox.appendChild(this1.objInputFile);

        this1.reset();
    }; setTimeout(func, 0); }

    this.cancel = function () {//alert('cancel');

        this.reset();

        this.objBox.innerHTML =
            '<input'+
            ' id="file_'+this.id+'"'+
            ' type="file"'+
            ' name="'+this.name+'"'+
            ' onchange="UploadFile(\'#'+this.id+'\').submit();"'+
            ' />'
        ;

        this.canceled = true;
        this.objFormUpload.innerHTML = '';
        this.objFormUpload.action = '#';
        this.objFormUpload.submit();

        var obj = this.objIFrameUpload.parentNode;
        obj.removeChild(this.objIFrameUpload);
        obj.removeChild(this.objFormUpload);
        this.objUploadFileTmp.removeChild(obj);

        this.reset();
    }

    this.load = function () {//alert('load');

        this.reset();

        if (this.canceled) {
            this.objBox.innerHTML =
                '<input'+
                ' id="file_'+this.id+'"'+
                ' type="file"'+
                ' name="'+this.name+'"'+
                ' onchange="UploadFile(\'#'+this.id+'\').submit();"'+
                ' />'
            ;
            return;
        }
        if (!this.objIFrameUpload) {
            this.objBox.innerHTML =
                '<input'+
                ' id="file_'+this.id+'"'+
                ' type="file"'+
                ' name="'+this.name+'"'+
                ' onchange="UploadFile(\'#'+this.id+'\').submit();"'+
                ' />'
            ;
            return;
        }
        var result = this.objIFrameUpload.contentWindow.document.body.innerHTML;
        if (!result || result.length == 0 || result == '0') {
            this.objBox.innerHTML =
                '<input'+
                ' id="file_'+this.id+'"'+
                ' type="file"'+
                ' name="'+this.name+'"'+
                ' onchange="UploadFile(\'#'+this.id+'\').submit();"'+
                ' />'
            ;
            return;
        }
        
        
        
        var fileName = result;

        var usuarioId = document.getElementById('usuarioId').value;  
        var pasta = document.getElementById('pasta').value;
        //var formatos = fileName[1].split('.');
        //var formato = formatos[formatos.length-1];
        

//'<br><br><div class="fotoUp" style="width:120px;margin-top:10px;margin-bottom:10px;margin-left:25px;"> <img src="'+pasta+'/temp/'+usuarioId+'/'+this.id+'.'+formato+'"  width="120" > </div>'+

        this.objBox.innerHTML =
            '<input'+
            ' id="file_'+this.id+'"'+
            ' type="text"'+
            ' name="'+this.name+'"'+
            ' onchange="UploadFile(\'#'+this.id+'\').submit();"'+
            ' style="display: none;"'+
            ' />'+
            ' <input type="hidden" name="retorno" value="1"> '+        
            '<span style="float:left;" title="Remover Arquivo"'+
            ' style="cursor: pointer;"'+ 
            ' onclick=" UploadFile(\'#'+this.id+'\').remove();"'+
            '>'+
            '<img  src="lib/css/images/remove.gif" alt="" title="Remover Arquivo"'+
            ' style="cursor:pointer; width:25px;float:left;vertical-align: middle;"'+
            ' />'+
            ' '+
            '</span> </div>'+
            '<br><br><div class="fotoUp" style="width:120px;margin-top:10px;margin-bottom:10px;margin-left:25px;"> <img src="'+pasta+'/temp/'+usuarioId+'/'+fileName+'"  width="120" > </div>'+
            ''+
            ''
        ;

        this.reset();

        var obj = this;
        setTimeout(function () {
            obj.objUploadFileTmp.removeChild(obj.objIFrameUpload.parentNode);
            obj.reset();
        }, 0);
    }

    this.remove = function () {//alert('remove');

        this.reset();

        this.objBox.innerHTML =
            '<input'+
            ' id="file_'+this.id+'"'+
            ' type="file"'+
            ' name="'+this.name+'"'+
            ' onchange="UploadFile(\'#'+this.id+'\').submit();"'+
            ' />'
        ;

        this.reset();
    }

    function extend() {
        // copy reference to target object
        var target = arguments[0] || {}, i = 1, length = arguments.length, deep = false, options, name, src, copy;

        // Handle a deep copy situation
        if ( typeof target === "boolean" ) {
            deep = target;
            target = arguments[1] || {};
            // skip the boolean and the target
            i = 2;
        }

        // Handle case when target is a string or something (possible in deep copy)
        if ( typeof target !== "object" && typeof target !== "function") {
            target = {};
        }

        // extend jQuery itself if only one argument is passed
        if ( length === i ) {
            target = this;
            --i;
        }

        for ( ; i < length; i++ ) {
            // Only deal with non-null/undefined values
            if ( (options = arguments[ i ]) != null ) {
                // Extend the base object
                for ( name in options ) {
                    src = target[ name ];
                    copy = options[ name ];

                    // Prevent never-ending loop
                    if ( target === copy ) {
                        continue;
                    }

                    // Recurse if we're merging object literal values or arrays
                    if ( deep && copy && ( typeof copy === "object" || typeof copy === "array" ) ) {
                        var clone = src && ( typeof src === "object" || typeof src === "array" ) ? src
                        : typeof copy === "array" ? [] : {};

                        // Never move original objects, clone them
                        target[ name ] = extend( deep, clone, copy );

                    // Don't bring in undefined values
                    } else if ( copy !== undefined ) {
                        target[ name ] = copy;
                    }
                }
            }
        }

        // Return the modified object
        return target;
    }
    
}

function UploadFile(refInputFile) {
    
   
    if (typeof refInputFile == 'string') {
        if (refInputFile.substr(0, 1) == '#') {
            refInputFile = document.getElementById(refInputFile.substr(1));
        } else {
            refInputFile = document.getElementById(refInputFile);
        }
    }
    if (refInputFile.tagName == 'SPAN') {
        return UploadFileCache[refInputFile.id];
    }
    if (refInputFile.tagName != 'INPUT' || refInputFile.type != 'file') {
        return null;
    }
    //var name = refInputFile.name;
    var id = refInputFile.id.length > 0 ? refInputFile.id : refInputFile.name;
    
    var objUploadFileTmp = document.getElementById('UploadFileTmp');
    if (!objUploadFileTmp) {
        objUploadFileTmp = document.createElement('div');
        objUploadFileTmp.id = 'UploadFileTmp';
        objUploadFileTmp.style.display = 'none';
        if (document.readyState == 'complete') {
            document.body.appendChild(objUploadFileTmp);
        } else {
            window.onload = function () {
                document.body.appendChild(objUploadFileTmp);
            }
        }
    }

    
    var obj = new UploadFileObject(refInputFile);
    UploadFileCache[id] = obj;
    
    return UploadFileCache[id];

}
