<?php

class Session extends Object
{
    public function __construct()
    {
        session_name();
        session_start();

        if (isset($_SESSION['POST']))
        {
            foreach ($_SESSION['POST'] as $key => $value) {
                if (!isset($_POST[$key])) {
                    $_POST[$key] = $value;
                }
            }
        }
    }

    public function start($username, $password)
    {
        if ($this->isAuthorized())
        {
            throw new Exception("Already authorized.");
            return;
        }

        global $db;

        if ($username == '' || $password == '' || $username == null || $password == null) 
        {
            throw new Exception("Username and/or password is empty.");
            return;
        }

        $sql = "
            SELECT
            user.password
            FROM public.user
            WHERE 
            user.login = '".$db->RealEscapeString($username)."';
            ";
        $table_password = $db->Select($sql);
        if ($table_password == null || !password_verify($password, $table_password[0]['password']))
        {
            throw new Exception("Incorrect credentials.");
            return;
        }

        $sql = "
            SELECT
            user.id AS 'id'
            FROM public.user
            WHERE 
            user.login = '".$db->RealEscapeString($username)."';
            ";
        $user_id = $db->Select($sql);
        if ($user_id == null)
        {
            throw new Exception("Internal server error. Try again later...");
            return;
        }
        
        $_SESSION['user_id'] = $user_id[0]['id'];

        $is_session_saved = $db->Insert("
            INSERT INTO public.session (fk_user_id, start_date, session_id) VALUES
            ('".$db->RealEscapeString($user_id[0]['id'])."', 
            '".$db->RealEscapeString(date("Y-m-d H:i:s"))."', 
            '".$db->RealEscapeString(session_id())."');
        ");

        if ($is_session_saved == null)
        {
            throw new Exception("You cannot login now. Try again later.");
            return;
        }

        return $user_id;
    }

    public function end()
    {
        global $db;

        if (isset($_SESSION['user_id']))
        {
            $db->Insert(
                "DELETE FROM public.session
                WHERE fk_user_id = '".$db->RealEscapeString($_SESSION['user_id'])."';"
            );
        }

        foreach ($_SESSION as $key => $value) {
            unset($_SESSION[$key]);
        }
        unset($_SESSION);
    }

    public function isAuthorized()
    {
        if (!isset($_SESSION['user_id'])) {
            return false;
        }
        
        global $db;

        // session creation date
        $sql = "SELECT
            start_date
            FROM public.session
            WHERE
            fk_user_id = ".$db->RealEscapeString($_SESSION['user_id']).";";
        $mysql_date = $db->Select($sql);

        if ($mysql_date == null) {
            $this->end();
            return false;
        }
        $mysql_date = $mysql_date[0]['start_date'];
        // if session is exist in table
        $php_date = new DateTime();
        $php_date->setTimestamp(strtotime($mysql_date));
        date_add($php_date, date_interval_create_from_date_string('1 day'));

        if ($php_date < (new DateTime('now'))) {
            $this->end();
            return false;
        }
        return true;
    }

    public function isAdmin()
    {
        if (!$this->isAuthorized()) {
            return false;
        }
        
        global $db;

        $is_admin = $db->Select(
            "SELECT
            user.is_admin AS 'bool'
            FROM public.user
            WHERE
            user.id = ".$db->RealEscapeString($_SESSION['user_id']).";"
        );

        if ($is_admin == null) return false;
        
        return $is_admin[0]['bool'];
    }
}
