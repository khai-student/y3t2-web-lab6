<?php

class SignUpView extends Object implements IView
{
    function Render()
    { 
        require_once 'include/header.php';

        echo '
        <div class="signin">
            <form method="POST" action="/router.php">
                <input name="r" type="hidden" value="auth/signup">
                <div class="form-group">
                    <label for="login">Login</label>
                    <input class="form-control" id="login" type="text" placeholder="Enter login" name="login" value="'.$this->login.'" required>
                    <label for="password">Password</label>
                    <input class="form-control" id="password" type="password" placeholder="Enter password" name="password" value="'.$this->password.'" required>
                    <label for="first_name">First name</label>
                    <input class="form-control" id="first_name" type="text" placeholder="Enter first name" name="first_name" value="'.$this->first_name.'" required>
                    <label for="second_name">Second name</label>
                    <input class="form-control" id="second_name" type="text" placeholder="Enter second name" name="second_name" value="'.$this->second_name.'" required>
                    <label for="email">E-mail</label>
                    <input class="form-control" id="email" type="email" placeholder="Enter e-mail" name="email" value="'.$this->email.'"required>
                </div>
                <div class="form-group">
                    <button class="btn btn-default" type="submit">Sign Up</button>';
                    if (isset($this->msg))
                    {
                        echo '<span class="label label-default info-msg">'.$this->msg.'</span>';
                    }      
        echo '
                </div>
            </form>
        </div>
        ';

        require_once 'include/footer.php';
    }
}
