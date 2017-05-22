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
                <label>Login</label>
                <input type="text" placeholder="Enter login" name="login" required>

                <label>Password</label>
                <input type="password" placeholder="Enter password" name="password" required>

                <button type="submit">Sign In</button>
                <a href="/router.php?r=auth/signup">New user? Sign Up.</a>';
                
                if (isset($this->error_message)) {
                    echo '<span class="error">'.$this->error_message.'</span>';
                }
        echo '
            </form>
        </div>
        ';

        require_once 'include/footer.php';
    }
}
