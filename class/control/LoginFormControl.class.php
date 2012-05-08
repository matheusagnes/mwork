<?php

class LoginFormControl extends MControl
{
    public function save()
    {
        if (parent::validatePost())
        {
            $post = parent::getPost();                        
            $senha = md5($post->senha);
            
            if(DB::getObjects("SELECT * FROM usuarios where email = '{$post->email}' and senha = '{$senha}' "))
            {
                $MCore = MCore::getInstance();
                
                $MCore->setSession('loged',true);
                
                echo '<script> location.href="index.php"</script>';                
            }
            else
            {
                new Message('E-mail ou senha incorretos!', Message::ERROR, Message::DIALOG);
            }    
            
        }
    }
    
    public function logout()
    {
        $MCore = MCore::getInstance();
        $MCore->sessionDestroy();
        echo '<script> location.href="index.php"</script>';
    }
}

?>
