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
            $formViewFile = str_replace('$className', $className.'FormView', $formViewFile);
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
            
            #Gera FormControl
            $formControlFile = file_get_contents(dirname(__FILE__).'/../../generic_formControl');
            $formControlFile = str_replace('$className', $className.'FormControl', $formControlFile);
            file_put_contents(dirname(__FILE__).'/../../new_class/control/'.$className.'FormControl.class.php', $formControlFile);
            #--
            
            #Gera ListControl
            $listControlFile = file_get_contents(dirname(__FILE__).'/../../generic_listControl');
            $listControlFile = str_replace('$className', $className.'ListControl', $listControlFile);
            file_put_contents(dirname(__FILE__).'/../../new_class/control/'.$className.'ListControl.class.php', $formControlFile);
            #--
            
            #Gera ListView
            $listViewFile = file_get_contents(dirname(__FILE__).'/../../generic_listView');
            $listViewFile = str_replace('$className', $className, $listViewFile);
            $listViewFile = str_replace('$table', $table, $listViewFile);
            
            
            $objColumns = DB::getObjects('show columns from '.$table);
            $listViewFileForm = explode('#--form', $listViewFile);   
            $listViewFileGrid = explode('#--grid', $listViewFile);   
         
            $searchForm = array('$column_name','$label','$fieldType');            
            $searchGrid = array('$column_name','$label','$operator');            
    
            foreach($objColumns as $objColumn)
            {
                $columnType = preg_replace('~\(.*~', '', $objColumn->Type);
                if($columnType == 'int')
                {
                    $replaceGrid = array($objColumn->Field,  $objColumn->Field, '=');
                }
                else
                {
                    $replaceGrid = array($objColumn->Field,  $objColumn->Field, 'like');
                }
                
                $replaceForm = array($objColumn->Field,  $objColumn->Field, MText);
                
                
                $newListViewFileForm.= str_replace($searchForm, $replaceForm, $listViewFileForm[1]);
                $newListViewFileGrid.= str_replace($searchGrid, $replaceGrid, $listViewFileGrid[1]);
            }
            file_put_contents(dirname(__FILE__).'/../../new_class/view/'.$className.'ListView.class.php', $listViewFileForm[0].$newListViewFileForm.$newListViewFileGrid.$listViewFileGrid[2]);
            #---        

        }
      
    }

}

?>
