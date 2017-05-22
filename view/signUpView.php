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
                <label>Login</label>
                <input type="text" placeholder="Enter login" name="login" required>

                <label>Password</label>
                <input type="password" placeholder="Enter password" name="password" required>

                <label>First name</label>
                <input type="text" placeholder="Enter first name" name="first_name" required>

                <label>Second name</label>
                <input type="text" placeholder="Enter second name" name="second_name" required>

                <label>E-mail</label>
                <input type="text" placeholder="Enter e-mail" name="email" required>

                <button type="submit">Sign Up</button>';
        echo '
            </form>
        </div>
        ';

        require_once 'include/footer.php';
    }
}
