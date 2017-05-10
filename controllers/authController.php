<?php

class AuthController extends Object
{
    public function actionIndex()
    {
        $this->actionLogin();
    }

    public function actionSignIn() // login
    {
        global $session;
        global $utilities;
        // 

        if ($this->login == null && $this->password == null) {
            $view = new SignInView();
            $view->Render();
            die();
        }
        // if authorization is queried
        try
        {
            $session->start($username, $password);
        }
        catch (Exception $e)
        {
            $utilities->error($e->GetMessage());
        }

        $utilities->headerLocation('Location: /router.php?r=section/index&section=strings');
    }

    public function actionSignOut() // logout
    {
        global $session;
        global $utilities;

        try
        {
            $session->end();
        }
        catch (Exception $e)
        {
            $utilities->error($e->GetMessage());
        }

        $utilities->headerLocation('Location: /router.php?r=section/index&section=strings');
    }

    public function actionSignUp() // registration
    {
        global $db;
        global $session;
        global $utilities;
        // todo 
        $to_check = ['login', 'password', 'first_name', 'second_name', 'email'];
        foreach ($to_check as $var) {
            if ($this->$var == null || $this->$var == '')
            {
                $view = new SignUpView();
                $view->data = $this->data;
                $view->Render();
                die();
            }
        }
        $sql = "
            INSERT INTO public.user (login, password, first_name, second_name, email, is_admin) VALUES
            ('".$db->RealEscapeString($this->login)."',
            '".$db->RealEscapeString($this->password)."',
            '".$db->RealEscapeString($this->first_name)."',
            '".$db->RealEscapeString($this->second_name)."',
            '".$db->RealEscapeString($this->email)."',
            false);
            ";

        if ($db->Insert($sql) != TRUE) {
            $utilities->error('','Cannot to add user to DB.');
        }
        //
        try
        {
            $session->start();
        }
        catch (Exception $e)
        {
            $utilities->error($e->GetMessage());
        }
        // 
        $utilities->headerLocation('Location: /router.php?r=section/index&section=strings');
    }
}

?>