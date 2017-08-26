<?php
define('login_options', false);
$html .= '<div class="cma-login-form"><form id="login" action="login.php" method="post">
    <h1>Log In</h1>
    <fieldset id="inputs">
        <input id="username" type="text" placeholder="Username" name="username" autofocus required>   
        <input id="password" type="password" name="password" placeholder="Password" required>
    </fieldset>
    <fieldset id="actions">
        <input type="submit" id="submit" value="Log in">
       <iv class="link-holder"><a href="">Register</a> <a href="">Forgot your password?</a></div>
    </fieldset>
</form></div>';

?>