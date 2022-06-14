<section class="loginform">
    <h3>Log In</h3>
    <form action="controllers/Users.ctrl.php" method="post">
        <input type="hidden" name="formtype" value="login">
        <input type="text" name="uid" placeholder="Username">
        <input type="password" name="pwd" placeholder="Password">
        <button class='btn btn-primary' type="submit" name="submit">Log In</button> 
    </form>
    <br/>
    <?php
        include_once 'includes/errorhandler.inc.php'
    ?>
</section>