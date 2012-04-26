<?php

class MListView extends MGrid
{

	public function __construct()
    {
        $listViewName = get_called_class();
		$listControlName = str_replace('View','Control',$listViewName);
    	$formViewName = str_replace('List','Form',$formControlName);		
		$formControlName = str_replace('View','Control',$formViewName);				
    }

	public function show()
	{

	}
    
}
?>
