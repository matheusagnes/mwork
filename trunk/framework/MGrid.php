<?php

class MGrid
{

    private $columns;
    private $actions;
    private $sqlColumns;
    private $controlName;
    private $gridId;
    private $filter;

    const EDIT = 'framework/lib/images/edit.png';
    const DELETE = 'framework/lib/images/delete.png';
    const VIEW = 'framework/lib/images/view.png';

    public function __construct()
    {
        
    }

    // Action seria passar a url para o request
    public function addColumn($column_table_name, $column_type, $label, $relation = null, $mask = null)
    {
        if (!$this->sqlColumns)
        {
            $this->sqlColumns = "{$column_table_name} ";
        }
        else
        {
            $this->sqlColumns.= " ,{$column_table_name} ";
        }

        $objColumn->label = $label;
        $objColumn->mask = $mask;
        $objColumn->column_type = $column_type;
        $objColumn->relation = $relation;

        $this->columns[$column_table_name] = $objColumn;
    }

    public function addAction($action, $title, $iconPath)
    {
        $objAction->icon = $iconPath;
        $objAction->title = $title;
        $objAction->action = $action;

        $this->actions[] = $objAction;
    }

    public function setControlName($controlName)
    {
        $this->controlName = $controlName;
    }

    public function setFilter($filter)
    {
        $this->filter = $filter;
    }

    public function setSql($sql)
    {
        $this->sql = $sql;
    }

	// #FIXME Colocar o getSql no class DB, passando por parametro $this->filter, $this->columns
    public function getSql()
    {
        $select = 'SELECT ';
        foreach ($this->columns as $key => $value)
        {
            $key = str_replace('::', '.', $key);
            $select.= " {$key},";
            $table = explode('.', $key);
            $from[$table[0]] = $table[0];
            
            if($value->relation)
            {
                $where.= $value->relation.' AND';
            }
        }

        if ($this->filter)
        {
            foreach ($this->filter as $key_filter => $filter)
            {
                if ($filter)
                {
                    $key_filter = str_replace('::', '.', $key_filter);
                    if ($this->columns[$key_filter]->column_type == 'varchar')
                    {
                        $where.= " {$key_filter} like '%{$filter}%' AND";
                    }
                    elseif ($this->columns[$key_filter]->column_type == 'primary')
                    {
                        $where.= " {$key_filter} = '{$filter}' AND";
                    }
                    elseif(is_string($filter))
                    {
                        $where.= " {$key_filter} like '%{$filter}%' AND";
                    }
                    elseif(is_int($key_filter))
                    {
                        $where.= " {$key_filter} = '{$filter}' AND";
                    }
                        
                }
            }
        }
        if ($where)
        {
            $where = ' WHERE ' . $where;
        }
        $where = substr($where, 0, -3);
        $select = substr($select, 0, -1);
        $from = implode(',', $from);
        
        return $select . ' from ' . $from . $where;
    }

    public function setGridId($gridId)
    {
        $this->gridId = $gridId;
    }

    public function showGrid()
    {
        //pegar a tabela de forma automatica
        //fazer paginação, tenho a classe no mwork/lib
        //$objects = DB::getObjects("SELECT {$this->sqlColumns} FROM usuarios");
        $objects = DB::getObjects($this->getSql());
        $grid = '<div id ="' . $this->gridId . '"> <table> <thead>';

        if ($objects)
        {
            foreach ($this->columns as $column)
            {
                $grid.="<td> {$column->label} </td>";
            }
            $grid.='</thead> <tbody>';

            foreach ($objects as $object)
            {
                $grid.= '<tr>';

                foreach ($this->columns as $key => $value)
                {
                    $key = explode('::', $key);
                    $grid.='<td>' . $object->{$key[1]} . '</td>';
                }

                foreach ($this->actions as $objAction)
                {
                    $grid.="<td> <img class='grid_img_action' src='{$objAction->icon}' title='{$objAction->title}' onclick = '{$objAction->action}'/> </td>";
                }

                $grid.= '</tr>';
            }
        }
        else
        {
            $grid.='<tr> <td> Nothing found </td> </tr>';
        }
        $grid.='</tbody> </table></div>';
        echo $grid;
    }

}

?>
