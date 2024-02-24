<!DOCTYPE html>
<html>

<body>
<form action="post_registration.php" method="POST">

    <input id="signup" name="action" type="radio" value="signup">
    <label for="signup">Sign up</label>

    <div id="wrapper">
        <div id="arrow"></div>
        <input id="name" placeholder="Name" type="text" name="name">
        <p><?php echo $errors['name'] ?? ''; ?></p>
        <input id="email" placeholder="Email" type="text" name="email">
        <p><?php echo $errors['email'] ?? ''; ?></p>
        <input id="psw" placeholder="Password" type="password" name="psw">
        <p><?php echo $errors['psw'] ?? ''; ?></p>
        <input id="psw-repeat" placeholder="Repeat password" type="password" name="psw-repeat">
        <p><?php echo $errors['psw-repeat'] ?? ''; ?></p>
    </div>
    <button type="submit">
    <span>
      Sign up
    </span>
    </button>

</form>

<div id="hint">Already have an account? <a href="http://localhost:8080/singin.php">Sign in</div>

</body>
</html>

<?php
require_once ('./style.php');