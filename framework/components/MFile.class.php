<?php


class MFile extends MInput
{
    private $MCore;
    private $frameWorkDir;
    
    public function __construct($value=null, $disabled=false,$name=null, $id=null,$maxlength=null)
    {
        parent::__construct();
        $this->maxlength = $maxlength;
        $this->value = $value;
        $this->name = $name;
        $this->id = $id;
        $this->mask = null;
        $this->disabled = $disabled;
        $this->MCore = MCore::getInstance();
        
        $this->frameWorkDir = $this->MCore->getFrameworkDir();
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
            $required = "required=\"1\"";            
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
            $('#div_form_file').append(\"<form id='formFile' action='upload.php' enctype='multipart/form-data' method='post'> <input name='{$this->name}' id='{$this->id}' $add  value='{$this->value}' type='file' $required /> <button id='b_file_sub'style='display:none'> Enviar Arquivo </button></form>\");
            $('#{$this->id}').change(function(){ $('#b_file_sub').click(); });
        });
	</script>
        <style>
            .progress { position:relative; width:150px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
            .bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
            .percent { position:absolute; display:inline-block; top:3px; left:48%; }
        </style>
    
        <script src='{$this->frameWorkDir}/lib/js/jquery-form.js'> </script> 
        <div style='float:left;font-size:12px;'>
            <div id='div_form_file'> </div>

            <div class='progress'>
                <div class='bar'></div>
                <div class='percent'>0%</div>
            </div>
            <div id='status'> </div>
            <input type='hidden' id='{$this->name}_file' name='{$this->name}_file' />
        </div>
            {$script}
            
            ";
       
    }
}

?>
