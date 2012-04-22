<?php

class DB
{

    private static $objInstance;

    /*
     * Class Constructor - Create a new database connection if one doesn't exist 
     * Set to private so no-one can create a new instance via ' = new DB();' 
     */

    private function __construct()
    {
        
    }

    /*
     * Like the constructor, we make __clone private so nobody can clone the instance 
     */

    private function __clone()
    {
        
    }

    /*
     * Returns DB instance or create initial connection 
     * @param 
     * @return $objInstance; 
     */

    public static function getInstance()
    {

        if (!self::$objInstance)
        {
            #FIXME pegar do arquivo de configs, utilizando globals ?
            $mgDB_DSN = 'mysql:host=localhost;dbname=default_project;';
            $mgDB_USER = 'user';
            $mgDB_PASS = 'user';

            self::$objInstance = new PDO($mgDB_DSN, $mgDB_USER, $mgDB_PASS);
            self::$objInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$objInstance;
    }

# end method 

    /*
     * Passes on any static calls to this class onto the singleton PDO instance 
     * @param $chrMethod, $arrArguments 
     * @return $mix 
     */

    final public static function __callStatic($chrMethod, $arrArguments)
    {

        $objInstance = self::getInstance();

        return call_user_func_array(array($objInstance, $chrMethod), $arrArguments);
    }

# end method 

    public static function rec($obj, $table)
    {
        
        $primaryKey = DB::getPrimaryKey($table);
        
        if (!$obj->{$primaryKey})
        {
            $sql = 'INSERT INTO ' . $table;
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

            if (DB::exec($sql . $sql_fields . $sql_values))
            {
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
            $this->update($obj, $table, $primaryKey);
        }
    }
    
    public static function getPrimaryKey($table)
    {
        $sql = 'SHOW COLUMNS FROM '.$table;
        $objs = DB::getObjects($sql);
        
        foreach ($objs as $obj)
        {
            if($obj->Key == 'PRI')
            {
                $field = $obj->Field;
                break;
            }
        }
        
        return $field;
    }

    public static function update($obj, $table, $primaryKey = 'id')
    {
        $sql = 'UPDATE '.$table.' SET' ;

        foreach (get_object_vars($obj) as $key => $value)
        {
            $sql.= "{$key} = '{$value}' AND";
        }

        $sql = substr($sql, 0, -3);
        $sql.= "WHERE {$primaryKey} = {$obj->{$primaryKey}}";

        if (DB::exec($sql))
        {
            return true;
        }
        else
        {
            #FIXME retornar obj de erros com nome de erros do banco ?!?!
            return false;
        }
        
    }

    public static function delete($id,$table)
    {
        
        $primaryKey = DB::getPrimaryKey($table);
        
        if(DB::exec("DELETE FROM {$table} WHERE {$primaryKey} = {$id}"))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public static function getObjects($sql)
    {
        $st = DB::query($sql);
        while($obj = $st->fetchObject())
        {
            $objects[] = $obj;
        }
        
        return $objects;
    }
    
    public static function getObject($sql)
    {
        $st = DB::query($sql);
       
        return $st->fetchObject();
    }

}

?>
