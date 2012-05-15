<?php

class MGrid
{

    private $columns;
    private $actions;
    private $sqlColumns;
    private $listControlName;
    private $listViewName;
    private $formControlName;
    private $formViewName;
    private $gridId;
    private $filter;
    protected $model;
            
    const EDIT = 'framework/images/edit.png';
    const DELETE = 'framework/images/delete.png';
    const VIEW = 'framework/images/view.png';

    public function __construct()
    {

    }

    // Action seria passar a url para o request
    public function addColumn($column_table_name, $label, $operator = null, $relation = null, $mask = null)
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
        $objColumn->operator = $operator;
        $objColumn->relation = $relation;

        $this->columns[$column_table_name] = $objColumn;
    }
    
    /*
     * $title = 'deletar';
     * $iconPath = icones padroes ou o caminho
     * $action = UsuariosListControl::delete
     * $param = array(id) -> chave primaria da tabela
     * $jsFunction = listAction
     * $jsParam = array('conteudo')
     */
                    
    public function addAction($title, $iconPath, $action, $params = array('id'), $jsFunction = 'listAction', $jsParams = null)
    {
        if(!preg_match('/::/',$action))
        {
            $action = $this->getListControlName().'::'.$action;
        }
        
        $objAction->icon = $iconPath;
        $objAction->title = $title;
        $objAction->action = $action;       
        $objAction->params = $params;       
        $objAction->jsFunction = $jsFunction;
        $objAction->jsParams = $jsParams;

        $this->actions[] = $objAction;
    }

    public function setModel($model)
    {
        $this->model = $model;
    }
    
    public function setListControlName($listControlName)
    {
        $this->listControlName = $listControlName;
    }

    public function getListControlName()
    {
        return $this->listControlName;
    }

    public function setListViewName($listViewName)
    {
        $this->listViewName = $listViewName;
    }

    public function getListViewName()
    {
        return $this->listViewName;
    }

    public function setFormViewName($formViewName)
    {
        $this->formViewName = $formViewName;
    }

    public function getFormViewName()
    {
        return $this->formViewName;
    }
    
    public function setFormControlName($formControlName)
    {
        $this->formControlName = $formControlName;
    }

    public function getFormControlName()
    {
        return $this->formControlName;
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
                    if($this->columns[$key_filter]->operator)
                    {
                        if ($this->columns[$key_filter]->operator == 'like')
                        {
                            $where.= " {$key_filter} like '%{$filter}%' AND";
                        }
                        else
                        {
                            $where.= " {$key_filter} {$this->columns[$key_filter]->operator} '{$filter}' AND";
                        }
                    }
                    else
                    {
                        $where.= " {$key_filter} like '%{$filter}%' AND";
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
        if(!$this->actions)
        {
            $this->addAction('Ver', MGrid::VIEW, 'view');          // js func     // parameter 
            $this->addAction('Editar', MGrid::EDIT, 'edit',array($this->model->getPrimaryKey()),'showContent',array('conteudo'));
            $this->addAction('Deletar', MGrid::DELETE,'delete');
        }
        
        $objects = DB::getObjects($this->getSql());
        $grid = '<div class="list">';
        $grid .= '<div id ="' . $this->gridId . '"> <table> <thead>';

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
                    $params = null;
                    if($objAction->params)
                    {
                        foreach($objAction->params as $actionParam)
                        {
                            if($object->{$actionParam})
                            {
                                $params.= $object->{$actionParam}.',';  
                            }
                            else
                            {
                                $params.= $actionParam.',';
                            }
                        }
                        $params = substr($params, 0, -1);
                        $params = '('.$params.')';                        
                    }
                    else
                    {
                        $params ='()';
                    }
                    
                    $objAction->action = $objAction->action.$params;
                    
                    if($objAction->jsParams)
                    {
                        $jsParams = null;
                        $jsParams = "'{$objAction->action}',";
                        
                        foreach ($objAction->jsParams as $actionJsParam)
                        {
                            $jsParams .= "'{$actionJsParam}',";
                        }
                        $jsParams = substr($jsParams, 0, -1);
                    }
                    else
                    {                        
                        $jsParams = "('{$objAction->action}')";
                    }                                        
                    
                    $grid.="<td> <img class='grid_img_action' src='{$objAction->icon}' title='{$objAction->title}' onclick = \"{$objAction->jsFunction}({$jsParams})\"/> </td>";
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
