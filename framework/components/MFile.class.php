<?php


class MFile extends MInput
{
    private $MCore;
    private $frameWorkDir;
    private $objFile;
    
    public function __construct($name=null, $id=null,$maxlength=null)
    {
        parent::__construct();
        $this->maxlength = $maxlength;
        $this->name = $name;
        $this->id = $id;
        $this->MCore = MCore::getInstance();
        $this->frameWorkDir = $this->MCore->getFrameworkDir();
    }
    
    /*
     * $objFile->location
     * $objFile->name
     */
    public function setValue($objFile)
    {
        $this->objFile = $objFile;
    }
    
    public function show()
    {
        parent::show();
        if (count($this->properties) > 0)
        {
            foreach ($this->properties as $key => $value)
            {
                $add .= " $key='$value' ";
            }
        }
        if($this->getObligatory())
        {
            $required = "obligatory='1'";            
        }
        
        $edit = '';
        $get_edit = '';
        $style_div_new_file = '';
        $jq_button = '';
        if($this->objFile)
        {
            $obj->edit = true;
            $json_objFile = json_encode($obj);
            
            $edit = 
            "<div id='edit_file'>   
                <a href='{$this->objFile->location}' target='_blank'> {$this->objFile->name} </a>
                <div class='jq_button' onclick=\"$('#edit_file').hide(); $('#div_new_file').show();$('#{$this->name}_file').val(json_file_edit);\"> Novo Arquivo ?</div>
            </div>";
            $jq_button = '$(".jq_button").button(); json_file_edit = \''.$json_objFile.'\' ';
            $style_div_new_file = 'display:none';
            $get_edit = '?edit=1';
        }
        
        $script = 
        "   <script>
            $(document).ready(function() 
            {  
                var bar = $('.bar');
                var percent = $('.percent');
                var status = $('#status');   
                $('#formFile').ajaxForm(
                {    
                    beforeSend: function() 
                    {   
                        status.empty(); 
                        var percentVal = '0%';        
                        bar.width(percentVal)  
                        percent.html(percentVal);    
                    },  uploadProgress: 
                    function(event, position, total, percentComplete) 
                    {
                        var percentVal = percentComplete + '%';
                        bar.width(percentVal)
                        percent.html(percentVal);    
                    },	complete:
                        function(xhr) 
                        {	
                            status.html(xhr.responseText);	
                        }
                }); 
            });
              </script>     
        ";
        return 
        "
        <script>
        $(document).ready(function() 
        {
            $('#div_form_file').append(\"<form id='formFile' action='upload.php{$get_edit}' enctype='multipart/form-data' method='post'> <input name='{$this->name}' id='{$this->id}' {$add} type='file' $required /> <button id='b_file_sub'style='display:none'> Enviar Arquivo </button></form>\");
            $('#{$this->id}').change(function(){ $('#b_file_sub').click(); });
            {$jq_button}
        });
	</script>
        <style>
            .progress { position:relative; width:150px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
            .bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
            .percent { position:absolute; display:inline-block; top:3px; left:48%; }
        </style>
    
        <script src='{$this->frameWorkDir}/lib/js/jquery-form.js'> </script> 
        {$edit}
        <div style='float:left;font-size:12px;$style_div_new_file' {$style_div_new_file} id='div_new_file'>
            <div id='div_form_file'> </div>

            <div class='progress'>
                <div class='bar'></div>
                <div class='percent'>0%</div>
            </div>
            <div id='status'> </div>
            <input type='hidden' id='{$this->name}_file' name='{$this->name}_file'  />
        </div>
            {$script}
            
            ";
       
    }
}

?>
