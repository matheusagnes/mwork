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
    private $MCore;

    const EDIT = 'framework/images/edit.png';
    const DELETE = 'framework/images/delete.png';
    const VIEW = 'framework/images/view.png';

    public function __construct()
    {
        $this->MCore = MCore::getInstance();
    }

    // Action seria passar a url para o request
    // array parameter
    //  - size, align,     
    public function addColumn($column_table_name, $label, $parameters = null, $relation = null, $function = null)
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
        $objColumn->relation = $relation;
        $objColumn->parameters = $parameters;
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
        if (!preg_match('/::/', $action))
        {
            $action = $this->getListControlName() . '::' . $action;
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
        $operators['='] = '=';
        $operators['like'] = 'like';
        $operators['>='] = '>=';
        $operators['<='] = '<=';

        $select = 'SELECT ';
        foreach ($this->columns as $key => $value)
        {
            $key = str_replace('::', '.', $key);
            $select.= " {$key},";
            $table = explode('.', $key);
            $from[$table[0]] = $table[0];

            if ($value->relation)
            {
                $where.= ' ' . $value->relation . ' AND';
            }
        }

        if ($this->filter)
        {
            foreach ($this->filter as $key_filter => $filter)
            {
                if ($filter)
                {
                    $key_filter = explode('::', $key_filter);
                    $operator = $key_filter[2];
                    $key_filter = $this->model->getTable() . '.' . $key_filter[1];
                    //$key_filter = $this->model->getTable() .'.'.$key_filter[1];
                    if ($operator)
                    {
                        if ($operator == 'like')
                        {
                            $where.= " {$key_filter} like '%{$filter}%' AND";
                        }
                        elseif ($operators[$operator])
                        {
                            $where.= " {$key_filter} {$operators[$operator]} '{$filter}' AND";
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
        
        return $select . ' from ' . $from . $where . ' limit 20';
    }

    public function setGridId($gridId)
    {
        $this->gridId = $gridId;
    }

    public function showGrid($fast_search=false)
    {

        //pegar a tabela de forma automatica
        //fazer paginação, tenho a classe no mwork/lib
        //$objects = DB::getObjects("SELECT {$this->sqlColumns} FROM usuarios");
        $table = $this->model->getTable();
        
        if (!$this->actions)
        {
            $this->addAction('Ver', MGrid::VIEW, 'info');          // js func     // parameter 
            $this->addAction('Editar', MGrid::EDIT, 'edit', array($this->model->getPrimaryKey()), 'showContent', array('conteudo'));
            $this->addAction('Deletar', MGrid::DELETE, 'delete');
        }
        
        $objects = new stdClass();
        
        $objects = DB::getObjects($this->getSql());
        
        if(!$fast_search)
        {
            $grid = '<div id ="' . $this->gridId . '" > <table width="100%">';
            
        }
        if ($objects)
        {
            if(!$fast_search)
            {   
                $grid.='<thead>';
                $gridLabels = '';
                $gridInputs = '';
                foreach ($this->columns as $columnTable => $column)
                {
                    $align = $column->parameters[1] ? $column->parameters[1] : 'center';
                    $width = $column->parameters[0] ? $column->parameters[0].'%' : '';

                    if($column->relation)                    
                    {   
                        $ref_column = explode('=', $column->relation);
                        
                        foreach($ref_column as $ref)
                        {
                            if(preg_match(".$table.", $ref))
                            {
                                $ref_column = explode('.',$ref);
                                $ref_column = $ref_column[1];
                                break;
                            }                                
                        }
                        
                        $newColumnTable = '';        
                        $newColumnTable = str_replace('::','.', $columnTable);
                                            
                        $tableColumn = explode('.', $newColumnTable);
                        $tableColumn = $tableColumn[0];
                        $tableColumn = trim($tableColumn);
                        $ref_column = trim($ref_column);
                        
                        unset($modelTable);
                        $modelTable = $this->MCore->getModelFromTable($tableColumn);
                        unset($combo);
                        $combo = new MCombo($modelTable->getArray());   
                        $combo->setName($tableColumn.'::'.$ref_column.'::'.'=');
                        $combo->setId($tableColumn.'::'.$ref_column.'::'.'=');                    
                        $gridInputs .= "<td align='{$align}' width='{$width}'> ".$combo->show()." </td>";
                    }
                    else
                    {
                        unset($input);
                        $input = new MText();
                        $input->setName($columnTable.'::'.'like');
                        $gridInputs .= "<td align='$align' width='{$width}'> ".$input->show()." </td>";
                    }
                    $gridLabels.="<td align='{$align}' width='{$width}'> {$column->label} </td>";
                }
                
                $grid.="<tr> {$gridLabels} </tr>";
                $grid.="<tr class='filters-grid'>  {$gridInputs}  </tr> ";
                $grid.='</thead> <tbody id="tbody_'.$this->gridId.'">';
            }
            
            foreach ($objects as $object)
            {
                $grid.= '<tr>';
                
                foreach ($this->columns as $key => $value)
                {
                    $objKey = '';
                    if(count(explode(' as ', $key)) > 1)
                    {         
                        $key = explode(' as ', $key);
                        $objKey = trim($key[1]);
                    }
                    else
                    {
                        $key = explode('::', $key);   
                        $objKey = trim($key[1]);
                    }
                    
                    $grid.='<td align="center">' . $object->{$objKey} . '</td>';
                }
                
                foreach ($this->actions as $objAction)
                {
                    $params= null;
                    if ($objAction->params)
                    {
                        $params= null;
                        foreach ($objAction->params as $actionParam)
                        {
                            if ($object->{$actionParam})
                            {
                                $params.= $object->{$actionParam} . ',';
                            }
                            else
                            {
                                $params.= $actionParam . ',';
                            }
                            
                        }
                        $params = substr($params, 0, -1);
                        $params = '(' . $params . ')';
                    }
                    else
                    {
                        $params = '()';
                    }
                    $action = null;    
                    $action = $objAction->action . $params;
                    $jsParams = null;
                    if ($objAction->jsParams)
                    {                        
                        $jsParams = "'{$action}',";

                        foreach ($objAction->jsParams as $actionJsParam)
                        {
                            $jsParams .= "'{$actionJsParam}',";
                        }
                        $jsParams = substr($jsParams, 0, -1);
                        $jsParams = "({$jsParams})";
                    }
                    else
                    {
                        $jsParams = "('{$action}')";
                    }
                    
                    $grid.="<td align='center'> <img class='grid_img_action' src='{$objAction->icon}' title='{$objAction->title}' onclick = \"{$objAction->jsFunction}{$jsParams}\"/> </td>";
                }

                $grid.= '</tr>';
            }
        }
        else
        {
            $grid.='<tr> <td> Nothing found </td> </tr>';
        }
        
        if(!$fast_search)
        {
            $grid.='</tbody> </table></div>';        
            echo " <script>
            $('#{$this->gridId}').keyup(function(e)
            { 
                if(e.keyCode == 13) 
                {
                    var objsFilter = $('.filters-grid').find('input,select'); 
                    ajaxSubmitObjs('{$this->listControlName}::search(1)','tbody_{$this->gridId}',objsFilter);
                    return true;
                }
            });

            $('#{$this->gridId}').find('select').change(function(e)
            { 
                var objsFilter = $('.filters-grid').find('input,select'); 
                ajaxSubmitObjs('{$this->listControlName}::search(1)','tbody_{$this->gridId}',objsFilter);
                return true;
            });

            </script>";
        }
        echo $grid;
        
        
    }
}

?>
