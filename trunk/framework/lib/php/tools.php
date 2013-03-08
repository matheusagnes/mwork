<?php

function arrayToObject($array)
{
    foreach($array as $key=>$value)
    {
        if($value)
        {
            if(!is_array($value))
            {
                if(json_decode(stripslashes($value)))
                {
                    $array[$key] = json_decode(stripslashes($value));
                }
            }
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

function changeCombo($array, $id_field)
{
    $script = "<script>";
    $script.="clearCombo('{$id_field}');";
    if($array)
    foreach ($array as $key=>$value)
    {
        $script.="addSelectOption(document.getElementById('{$id_field}'),'{$value}','{$key}'); \n";
    }
    $script .= "</script>";
    echo $script;
}

function strip_html_tags( $text )
{    
    $text = preg_replace(
        array(
          // Remove invisible content
            '@<head[^>]*?>.*?</head>@siu',
            '@<style[^>]*?>.*?</style>@siu',
            '@<script[^>]*?.*?</script>@siu',
            '@<object[^>]*?.*?</object>@siu',
            '@<embed[^>]*?.*?</embed>@siu',
            '@<applet[^>]*?.*?</applet>@siu',
            '@<noframes[^>]*?.*?</noframes>@siu',
            '@<noscript[^>]*?.*?</noscript>@siu',
            '@<noembed[^>]*?.*?</noembed>@siu',
          // Add line breaks before and after blocks
            '@</?((address)|(blockquote)|(center)|(del))@iu',
            '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
            '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
            '@</?((table)|(th)|(td)|(caption))@iu',
            '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
            '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
            '@</?((frameset)|(frame)|(iframe))@iu',
        ),
        array(
            ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
            "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
            "\n\$0", "\n\$0",
        ),
        $text );
    return strip_tags( $text );
}

function getBrowserClientInfo() 
{ 
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
    
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Internet Explorer'; 
        $ub = "MSIE"; 
    } 
    elseif(preg_match('/Firefox/i',$u_agent)) 
    { 
        $bname = 'Mozilla Firefox'; 
        $ub = "Firefox"; 
    } 
    elseif(preg_match('/Chrome/i',$u_agent)) 
    { 
        $bname = 'Google Chrome'; 
        $ub = "Chrome"; 
    } 
    elseif(preg_match('/Safari/i',$u_agent)) 
    { 
        $bname = 'Apple Safari'; 
        $ub = "Safari"; 
    } 
    elseif(preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Opera'; 
        $ub = "Opera"; 
    } 
    elseif(preg_match('/Netscape/i',$u_agent)) 
    { 
        $bname = 'Netscape'; 
        $ub = "Netscape"; 
    } 
    
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
    
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
    
    // check if we have a number
    if ($version==null || $version=="") {$version="?";}
    
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
} 

function updateBrowser()
{
	$browser = getBrowserClientInfo();

	$version = explode('.',$browser['version']);
	$version = $version[0];
	
	if(preg_match('/Internet Explorer/i',$browser['name'])) 
    { 
        if($version < 9)
        	echo "<script> location.href = 'atualize';  </script>";
    } 
    elseif(preg_match('/Mozilla Firefox/i',$browser['name'])) 
    { 
        if($version < 8)        	
        	echo "<script> location.href = 'atualize';  </script>";
    } 	
}

function dateFormat($datahora, $formato = 'd/m/Y H:i')
{
    if (!$datahora)
    {
        return $datahora;
    }
    return date($formato, strtotime($datahora));
}

?>
