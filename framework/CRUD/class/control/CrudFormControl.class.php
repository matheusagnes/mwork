<?php

class CrudFormControl extends MControl
{

    public function save()
    {
       
        foreach ($this->post as $table)
        {
            $modelFile = file_get_contents(dirname(__FILE__).'/../../generic_model');
            
            
            $primary_key = DB::getPrimaryKey($table);
            
            unset($className);
            $words = explode('_',$table);
            foreach ($words as $word )
            {
                $className.= ucfirst($word);
            }
            $modelFile = str_replace('$className', $className, $modelFile);
            $modelFile = str_replace('$table', $table, $modelFile);            
            $modelFile = str_replace('$primary_key', $primary_key, $modelFile);
            
            
            file_put_contents(dirname(__FILE__).'/../../new_class/model/'.$className.'.class.php', $modelFile);
        }
      
        //new Message(, Message::SUCCESS, Message::DIALOG);
    }

}

?>
