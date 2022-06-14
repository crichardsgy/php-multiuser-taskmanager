<?php
    include_once 'header.php';
?>

<section class="createuserform">
    <h3>Create User</h3>
    <form action="controllers/Users.ctrl.php" method="post">
        <input type="hidden" name="formtype" value="register">

        <label for="uid">Username (*): </label>
        <input type="text" name="uid" placeholder="Username">
        <br/>

        <label for="fname">First Name (*): </label>
        <input type="text" name="fname" placeholder="First Name">
        <br/>

        <label for="lname">Last Name (*): </label>
        <input type="text" name="lname" placeholder="Last Name">
        <br/>

        <label for="pwd">Password (*): </label>
        <input type="password" name="pwd" placeholder="Password">
        <br/>

        <label for="pwdconfirm">Repeat Password (*): </label>
        <input type="password" name="pwdconfirm" placeholder="Repeat Password">
        <br/>

        <label for="role">Role (*): </label>
        <select id="role" name="role">
            <option value="Normal">Normal</option>
            <option value="Admin">Admin/Project Manager</option>
        </select>
        <br/><br/>

        <button class='btn btn-primary' type="submit" name="submit">Create User</button> 
        <a class='btn btn-danger' href="manageusers.php">Cancel</a>  
    </form>
    <br/>
    <?php
        include_once 'includes/errorhandler.inc.php'
    ?>
</section>

<?php
    include_once 'footer.php';
?>