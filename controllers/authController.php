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

        if ($session->isAuthorized())
        {
            $utilities->headerLocation('/router.php', ['r' => 'section/index', 'section' => 'strings']);
        }

        if ($this->login == null && $this->password == null) {
            $view = new SignInView();
            $view->data = $this->data;
            $view->Render();
            die();
        }
        // if authorization is queried
        try
        {
            $session->start($this->login, $this->password);
        }
        catch (Exception $e)
        {
            $utilities->headerLocation('/router.php', ['r' => 'auth/signin', 'error_message' => $e->GetMessage()]);
        }

        $utilities->headerLocation('/router.php', ['r' => 'section/index', 'section' => 'strings']);
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

        $utilities->headerLocation('/router.php', ['r' => 'section/index', 'section' => 'strings']);
    }

    public function actionSignUp() // registration
    {
        global $db;
        global $session;
        global $utilities;

        $to_check = ['login', 'password', 'first_name', 'second_name', 'email'];
        foreach ($to_check as $var) {
            if ($this->$var == null || $this->$var == '')
            {
                $this->msg = 'You did not set '.ucfirst(str_replace('_', ' ', $var));
                $view = new SignUpView();
                $view->data = $this->data;
                $view->Render();
                die();
            }
        }
        $password_encrypted = password_hash($this->password, PASSWORD_DEFAULT);
        $sql = "
            INSERT INTO public.user (login, password, first_name, second_name, email, is_admin) VALUES
            ('".$db->RealEscapeString($this->login)."',
            '".$db->RealEscapeString($password_encrypted)."',
            '".$db->RealEscapeString($this->first_name)."',
            '".$db->RealEscapeString($this->second_name)."',
            '".$db->RealEscapeString($this->email)."',
            false);
            ";

        if ($db->Insert($sql) != TRUE) {
            $this->msg = 'Cannot register user with such credentials. Either login or e-mail is not unique.';
            $view = new SignUpView();
            $view->data = $this->data;
            $view->Render();
            die();
        }
        //
        try
        {
            $session->start($this->login, $this->password);
        }
        catch (Exception $e)
        {
            $utilities->error($e->GetMessage());
        }
        // 
        $utilities->headerLocation('/router.php', ['r' => 'section/index', 'section' => 'strings']);
    }
}
