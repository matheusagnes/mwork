<?php

function arrayToObject($array)
{
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

?>
