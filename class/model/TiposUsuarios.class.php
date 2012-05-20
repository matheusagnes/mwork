<?php

class TiposUsuarios extends Model
{
    public function __construct()
    {
        parent::__construct('id','tipos_usuarios');
    }

    public function getArray()
    {
        $objs = $this->getObjects();

        if ($objs)
            foreach ($objs as $obj)
            {
                $array[$obj->id] = $obj->descricao;
            }

        return $array;
    }
}
?>
