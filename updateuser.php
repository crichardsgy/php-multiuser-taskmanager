<?php
    include_once 'header.php';
    require_once "models/User.php";

    $userModel = new User;

    if(!isset($_POST['editId']))
    {
        $userid = $_SESSION['editId'];
    }
    else
    {
        $userid = $_POST['editId'];
    }

    $userdetails = $userModel->findUserById($userid);

    unset($userModel);

    if ($_SESSION['userRole'] !== "Admin")
    {
        header("location: index.php");
    }
?>

<section class="taskupdater">
    <h3>Edit User</h3>
    <form action="controllers/Users.ctrl.php" method="post">
        <input type="hidden" name="formtype" value="updateuser">
        <input type="hidden" name="editId" value="<?php echo "$userid";?>">
        <?php
            echo "<input type='hidden' name='uid' placeholder='Username' value='$userdetails->userUid'>";

            echo "<label for='fname'>First Name (*): </label>";
            echo "<input type='text' name='fname' placeholder='First Name' value='$userdetails->userFName'>";
            echo "<br/>";

            echo "<label for='lname'>Last Name (*): </label>";
            echo "<input type='text' name='lname' placeholder='Last Name' value='$userdetails->userLName'>";
            echo "<br/>";

            echo "<label for='pwd'>Password (*): </label>";
            echo "<input type='password' name='pwd' placeholder='Password'>";
            echo "<br/>";

            echo "<label for='pwdconfirm'>Repeat Password (*): </label>";
            echo "<input type='password' name='pwdconfirm' placeholder='Repeat Password'>";
            echo "<br/>";
        ?>

        <label for="role">Role (*): </label>
        <select id="role" name="role">
            <option value='Normal' <?php if ($userdetails->userRole == "Normal"){echo "selected";}?>>Normal</option>
            <option value='Admin' <?php if ($userdetails->userRole == "Admin"){echo "selected";}?>>Admin/Project Manager</option>
        </select>
        <br/><br/>
        <button class='btn btn-primary' type="submit" name="submit">Update User</button>
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