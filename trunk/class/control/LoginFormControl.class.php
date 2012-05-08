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
            }
            
        }
    }
}

?>
