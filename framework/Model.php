<?php

class Model
{
	public function rec($obj, $table, $primaryKey = 'id')
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

	public function update()
	{
		
	}
    
    public function delete()
    {

    }    

    public function get()
    {

    }

}

?>
