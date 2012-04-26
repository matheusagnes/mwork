<?php

class MGrid
{

	private $columns;
	private $actions;
	private $sqlColumns;
	private $controlName;

	public function __construct()
    {
        
    }

	// Action seria passar a url para o request
	public function addColumn($column_db_name, $label, $mask = null)
	{
		if(!$this->sqlColumns)
		{
			$this->sqlColumns = "{$column_db_name} ";		
		}
		else
		{
			$this->sqlColumns.= " ,{$column_db_name} ";		
		}

		$objColumn->label = $label;
		$objColumn->mask = $mask;
	
		$this->columns[$column_db_name] = $objColumn;
	}

	public function addAction($action, $title, $iconPath)
	{
		$objAction->icon   = $iconPath;
		$objAction->title  = $title;
		$objAction->action = $action;				

		$this->actions[] = $objAction;
	}

	public function SetDBTable()
	{
	
	}

	public function setControlName($controlName)
	{
		$this->controlName = $controlName;
	}

	public function getGrid()
	{
		//pegar a tabela de forma automatica
		//fazer paginação, tenho a classe no mwork/lib
		$objects = DB::getObjects("SELECT {$this->sqlColumns} FROM usuarios");

		$grid = '<table> <thead>';

		foreach($this->columns as $column)
		{
			$grid.="<td> {$column->label} </td>";		
		}
	    $grid.='</thead> <tbody>';
		foreach ($objects as $object)
		{
			$grid.= '<tr>';
			foreach($this->columns as $key => $value)
			{
				$grid.='<td>'.$object->{$key}.'</td>';		
			}	
			$grid.= '</tr>';
		}
		$grid.='</tbody> </table>';
		echo $grid;
	}

}

?>



