<?php

class Session extends Object
{
    public function start($username, $password)
    {
        if ($this->isAuthorized())
        {
            throw new Exception("Already authorized.");
            return;
        }

        global $db;

        if ($username == '' || $password = '') 
        {
            throw new Exception("Username and/or password is empty.");
            return;
        }

        $user_id = $db->Select("
            SELECT
            user.id
            FROM public.user
            WHERE 
            user.login = '".$db->RealEscapeString($username)."' AND
            user.password = '".$db->RealEscapeString($username)."';
        ");
        if ($user_id == null)
        {
            throw new Exception("Username and/or password is incorrect.");
            return;
        }
        
        session_start();

        $is_session_saved = $db->Insert("
            INSERT INTO public.session (fk_user_id, start_date, session_id) VALUES
            ('".$db->RealEscapeString($user_id)."', 
            '".$db->RealEscapeString(date("Y-m-d H:i:s"))."', 
            '".$db->RealEscapeString(session_id())."');
        ");

        if (!is_session_saved)
        {
            throw new Exception("You cannot login now. Try again later.");
            return;
        }

        return $user_id;
    }

    public function end()
    {
        if (!$this->isAuthorized())
        {
            throw new Exception("Session cannot be closed because you not signed in.");
            return;
        }

        $db->Insert(
            "DELETE FROM public.session
            WHERE session_id = '".$db->RealEscapeString(session_id())."';"
        );

        foreach ($_SESSION as $key => $value) {
            unset($_SESSION[$key]);
        }
    }

    public function isAuthorized()
    {
        if (!isset($_REQUEST[session_name()])) {
            return false;
        }
        
        global $db;

        // session creation date
        $mysql_date = $db->Select(
            "SELECT
            start_date
            FROM public.session
            WHERE
            session_id = '".session_id()."';"
        );

        if ($start_date == null) {
            return false;
        }
        // if session is exist in table
        $php_date = strtotime( $mysql_date );
        date_add($php_date, date_interval_create_from_date_string('1 day'));

        if ($php_date < (new DateTime('now'))) {
            end();
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
            FROM public.user, public.session
            WHERE
            session_name = '".$db->RealEscapeString(session_name())."' AND
            fk_user_id = user.id;"
        );

        if ($is_admin == null) return false;
        
        return $is_admin[0]['bool'];
    }
}

?>