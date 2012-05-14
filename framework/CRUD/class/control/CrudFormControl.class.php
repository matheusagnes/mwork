<?php

class CrudFormControl extends MControl
{

    public function save()
    {
       
        foreach ($this->post as $table)
        {
            
            $primary_key = DB::getPrimaryKey($table);
            
            unset($className);
            $words = explode('_',$table);
            foreach ($words as $word )
            {
                $className.= ucfirst($word);
            }
            
            #Gera model
            $modelFile = file_get_contents(dirname(__FILE__).'/../../generic_model');    
            $modelFile = str_replace('$className', $className, $modelFile);
            $modelFile = str_replace('$table', $table, $modelFile);            
            $modelFile = str_replace('$primary_key', $primary_key, $modelFile);
            file_put_contents(dirname(__FILE__).'/../../new_class/model/'.$className.'.class.php', $modelFile);
            #---
                        
            #Gera formView
            $formViewFile = file_get_contents(dirname(__FILE__).'/../../generic_formView');
            $formViewFile = str_replace('$className', $className, $formViewFile);
            $formViewFile = str_replace('$table', $table, $formViewFile);
            $formViewFile = str_replace('$primary_key', $primary_key, $formViewFile);
            
            $objColumns = DB::getObjects('show columns from '.$table);
            $formViewFile = explode('#--', $formViewFile);   
         
            $search = array('$column_name','$label','$fieldType');            
    
            foreach($objColumns as $objColumn)
            {
                $replace = array($objColumn->Field, $objColumn->Field, MText);
                
                $formViewFile[0].= str_replace($search, $replace, $formViewFile[1]);
            }
            file_put_contents(dirname(__FILE__).'/../../new_class/view/'.$className.'FormView.class.php', $formViewFile[0].$formViewFile[2]);
            #---
            
            #Gera formControl
            $formControlFile = file_get_contents(dirname(__FILE__).'/../../generic_formControl');
            $formControlFile = str_replace('$className', $className, $formControlFile);
            file_put_contents(dirname(__FILE__).'/../../new_class/control/'.$className.'FormControl.class.php', $formControlFile);
            #--
            
                        

        }
      
    }

}

?>
