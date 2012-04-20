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
			
            self::$objInstance = new PDO(DB_DSN, DB_USER, DB_PASS); 
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


	public static function rec($obj, $table, $primaryKey = 'id')
	{
		if(!$obj->{$primaryKey})
		{			
			// utilizar get_object_vars no obj para pegar o nome das colunas no foreach e ir concatenando com '', e tal..
			DB::exec();
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
