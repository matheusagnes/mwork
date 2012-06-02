<?php

class Model
{

    private $primary_key;
    private $table;

    public function __construct($primary_key , $table)
    {
        $this->primary_key = $primary_key;
        $this->table = $table;        
    }

    public function begin()
    {
        return DB::beginTransaction();
    }
    
    public function rollBack()
    {
        return DB::rollBack();
    }
    
    public function commit()
    {
        return DB::commit();
    }
    
    public function getLastInsertId()
    {
        return DB::lastInsertId();
    }
    
    public function getPrimaryKey()
    {
        return $this->primary_key;
    }
    
    public function getTable()
    {
        return $this->table;
    }
    
    public function setPrimaryKey($primary_key)
    {
        $this->primary_key = $primary_key;
    }

    public function setTable($table)
    {
        $this->table = $table;
    }

    public function rec($obj)
    {
        if (!isset($obj->{$this->primary_key}))
        {
            $sql = 'INSERT INTO ' . $this->table;
            $sql_fields = ' (';
            $sql_values = ' VALUES (';

            foreach (get_object_vars($obj) as $key => $value)
            {
                $sql_fields.= "{$key},";
                $sql_values.= "'{$value}',";
            }

            $sql_fields = substr($sql_fields, 0, -1);
            $sql_values = substr($sql_values, 0, -1);

            $sql_fields.=')';
            $sql_values.=')';
            $objStmt = DB::prepare($sql . $sql_fields . $sql_values);
            if ($objStmt->execute())
            {
                if($this->primary_key)
                    $obj->{$this->primary_key} = $this->getLastInsertId();
                 
                $MCore = MCore::getInstance();
                $MCore->getSession('ref_usuario');
                return true;
            }
            else
            {
                #FIXME retornar obj de erros com nome de erros do banco ?!?!
                return false;
            }
        }
        else
        {
            return $this->update($obj, $this->table, $this->primary_key);
        }
    }

    public function update($obj)
    {
        $sql = 'UPDATE ' . $this->table . ' SET';

        foreach (get_object_vars($obj) as $key => $value)
        {
            if ($key != $primaryKey)
                $sql.= " {$key} = '{$value}' ,";
        }

        $sql = substr($sql, 0, -1);
        $sql.= "WHERE {$this->primary_key} = {$obj->{$this->primary_key}}";

        try
        {
            //if (DB::exec($sql) >= 0)
            
            $objStmt = DB::prepare($sql);
            if ($objStmt->execute() >= 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        catch (Exception $e)
        {
            new Message($e->getMessage(), Message::ERROR, Message::DIALOG);
            return false;
        }
    }

    public function delete($id)
    {
        $objStmt = DB::prepare("DELETE FROM {$this->table} WHERE {$this->primary_key} = {$id}");
        if ($objStmt->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function deleteSql($sql)
    {
        $objStmt = DB::prepare($sql);
        if ($objStmt->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getObjects($sql = null)
    {
        if(!$sql)
        {
            $sql = "SELECT * FROM {$this->table}";
        }
        $st = DB::prepare($sql);
        $st->execute();
        while ($obj = $st->fetchObject())
        {
            $objects[] = $obj;
        }

        return $objects;
    }

    public function getObject($id)
    {
        $st = DB::prepare("SELECT * FROM {$this->table} where {$this->primary_key} = {$id}");
        $st->execute();
        $obj = $st->fetchObject();
        return $obj;
    }

}

?>
