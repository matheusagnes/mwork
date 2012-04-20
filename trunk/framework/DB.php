<?php
class DB
{
	private static $objInstance; 
    
    /* 
     * Class Constructor - Create a new database connection if one doesn't exist 
     * Set to private so no-one can create a new instance via ' = new DB();' 
     */ 
    private function __construct() {} 
    
    /* 
     * Like the constructor, we make __clone private so nobody can clone the instance 
     */ 
    private function __clone() {} 
    
    /* 
     * Returns DB instance or create initial connection 
     * @param 
     * @return $objInstance; 
     */ 
    public static function getInstance() 
	{ 
            
        if(!self::$objInstance)
		{ 
			$mgDB_DSN = 'mysql:host=localhost;dbname=default_project;';
			$mgDB_USER = 'user';
			$mgDB_PASS = 'user';
			
            self::$objInstance = new PDO($mgDB_DSN, $mgDB_USER, $mgDB_PASS); 
            self::$objInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        } 
        
        return self::$objInstance; 
    
    } # end method 
    
    /* 
     * Passes on any static calls to this class onto the singleton PDO instance 
     * @param $chrMethod, $arrArguments 
     * @return $mix 
     */ 
    final public static function __callStatic( $chrMethod, $arrArguments ) 
	{ 
            
        $objInstance = self::getInstance(); 
        
        return call_user_func_array(array($objInstance, $chrMethod), $arrArguments); 
        
    } # end method 


	public static function rec($objs, $table, $primaryKey = 'id')
	{
		if(!$obj->{$primaryKey})
		{			
			$sql = 'INSERT INTO '.$table;
			$sql_fields = ' (';
			$sql_values = ' VALUES (';
			
			foreach(get_object_vars($objs) as $key =>$value)
			{
				$sql_fields.= "{$key},";
				$sql_values.= "'{$value}',";
			}		
		
			$sql_fields = substr($sql_fields,0,-1);
			$sql_values = substr($sql_values,0,-1);

			$sql_fields.=')';
			$sql_values.=')';

			if(DB::exec($sql.$sql_fields.$sql_values))
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
			$this->update($obj);
		}
	}

	public static function update()
	{
		
	}
    
    public static function delete()
    {

    }    

    public static function get()
    {

    }





}

?>
