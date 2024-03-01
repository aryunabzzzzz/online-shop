<!DOCTYPE html>
<html>
<body>

<form action="post_login.php" method="POST">

    <input id="signin" name="action" type="radio" value="signin">
    <label>Sign in</label>

    <div id="wrapper">
        <div id="arrow"></div>
        <input id="email" placeholder="Email" type="text" name="email">
        <p><?php echo $errors['email'] ?? ''; ?></p>
        <input id="psw" placeholder="Password" type="password" name="psw">
        <p><?php echo $errors['psw'] ?? ''; ?></p>
    </div>
    <button type="submit">
    <span>
      Sign in
    </span>
    </button>
</form>

</body>
</html>

<?php
require_once ('./style.php');