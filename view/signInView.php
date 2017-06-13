<?php

class SignInView extends Object implements IView
{
    function Render()
    { 
        require_once 'include/header.php';

        echo '
        <div class="signin">
            <form method="POST" action="/router.php">
                <input name="r" type="hidden" value="auth/signin">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="login">Login</label>
                    <input class="form-control" type="text" placeholder="Enter login" name="login" id="login" required>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="password">Password</label>
                    <input class="form-control" type="password" placeholder="Enter password" name="password" id="password" required>
                </div>
                <div class="form-group">
                    <button class="btn btn-default" type="submit">Sign In</button>
                    <a href="/router.php?r=auth/signup">New user? Sign Up.</a>
                </div>';
                
                if (isset($this->error_message)) {
                    echo '<div class="form-group"><p>'.$this->error_message.'</p></div>';
                }
        echo '
            </form>
        </div>
        ';

        require_once 'include/footer.php';
    }
}
