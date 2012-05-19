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
	#FIXME PQ ENTRA VARIAS VEZES ?
    public static function getInstance()
    {

        if (!self::$objInstance)
        {
            #FIXME pegar do arquivo de configs, utilizando globals ?
            $configs = MCore::getConfigs();
                
            $mgDB_TYPE = $configs['DB_TYPE'];
            $mgDB_HOST = $configs['DB_HOST'];
            $mgDB_NAME = $configs['DB_NAME'];
            $mgDB_USER = $configs['DB_USER'];
            $mgDB_PASS = $configs['DB_PASS'];

            $DSN = "$mgDB_TYPE:host=$mgDB_HOST;dbname=$mgDB_NAME;";

            self::$objInstance = new PDO($DSN, $mgDB_USER, $mgDB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
            self::$objInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$objInstance;
    }

# end method 

    public static function getDatabaseSystem()
    {
        $configs = MCore::getConfigs();
        return $configs['DB_TYPE'];
    }
    

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

    public static function getPrimaryKey($table)
    {
        if (self::getDatabaseSystem() == 'pgsql')
        {
            $sql = 
            'SELECT '.
            '    ci.relname AS "Index", '.
            '    a.attname AS "Key" '.
            'FROM '.
            '    pg_index i '.
            '        JOIN pg_class cr ON (cr.oid = i.indrelid) '.
            '        JOIN pg_attribute a ON (a.attrelid = cr.oid) '.
            '        JOIN pg_class ci ON (ci.oid = i.indexrelid) '.
            'WHERE '.
            '    i.indisprimary AND '.
            '    cr.relname = "'.$table.'" AND '.
            '    EXISTS (SELECT 1 FROM unnest(i.indkey) p(c) WHERE p.c = a.attnum) '.
            'ORDER BY '.
            '    a.attname ;';
        }
        elseif (self::getDatabaseSystem() == 'mysql')
        {
            $sql = 'SHOW COLUMNS FROM '.$table;
        }

        $objs = DB::getObjects($sql);
        #FIXME testar no postgres, mysql funciona
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

    public static function getObjects($sql)
    {        
        $st = DB::query($sql);
        while($obj = $st->fetchObject())
        {
            $objects[] = $obj;
        }
        
        return $objects;
    }

   
    
   

}

?>
