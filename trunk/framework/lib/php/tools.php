<?php

function arrayToObject($array)
{
    
    foreach($array as $key=>$value)
    {
        if(json_decode($value))
        {
            $array[$key] = json_decode($value);
        }
    }
    return (object) $array;

    if (!is_array($array))
    {
        return $array;
    }

    $object = new stdClass();
    if (is_array($array) && count($array) > 0)
    {
        foreach ($array as $name => $value)
        {
            $name = strtolower(trim($name));
            if (!empty($name))
            {
                $object->$name = arrayToObject($value);
            }
        }
        return $object;
    }
    else
    {
        return false;
    }
}

function dbug($obj)
{
    echo '<pre>';
    var_dump($obj);
    die;
}

function glue_upper($string,$glue) 
{        
    return strtolower(preg_replace( '/([a-z0-9])([A-Z])/', "$1$glue$2", $string ));
}

function glue_first_upper($string, $glue)
{
    $words = explode($glue, $string);
    
    foreach ($words as $word)
    {
        $new_string .= ucfirst($word);
    }
    
    return $new_string;
}



?>
