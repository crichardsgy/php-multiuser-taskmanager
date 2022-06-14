<?php
    include_once 'header.php';
    require_once "models/User.php";

    $userModel = new User;
    $userlist = $userModel->findAllUsers();
    unset($userModel);

    if ($_SESSION['userRole'] !== "Admin")
    {
        header("location: index.php");
    }
?>

<section class="taskcreator">
    <h3>Create Task</h3>
    <form action="controllers/Tasks.ctrl.php" method="post">
        <input type="hidden" name="formtype" value="createtask">

        <label for="taskname">Task Name (*) : </label>
        <input type="text" name="taskname" placeholder="Task Name">
        <br/>

        <label for="taskdescription">Task Description: </label>
        <br/>
        <textarea name="taskdescription" placeholder="Task Description" rows="4" cols="50"></textarea>
        <br/>

        <label for="taskdeadline">Deadline (*): </label>
        <input type="datetime-local" name="taskdeadline" placeholder="Date And Time">
        <br/><br/>

        <label for="assignments">Assign Task To.. (*) (Hold Ctrl/Command To Select Multiple Users)</label>   
        <br/> 
        <select name="assignments[]" id="assignments" multiple="multiple">
            <?php 
                foreach($userlist as $user) 
                {
                    $userFullName = $user->userFName . " " . $user->userLName;
                    $userFullNameandID = $userFullName . " (" . $user->userUid . ")";
                    echo '<option value="'.$user->userId.'">'.$userFullNameandID.'</option>';
                }          
            ?>
        </select>
        <br/><br/>
        <button class='btn btn-primary' type="submit" name="submit">Create Task</button>
        <a class='btn btn-danger' href="index.php">Cancel</a>  
    </form>
    <br/>
    <?php
        include_once 'includes/errorhandler.inc.php'
    ?>

    <?php
        include_once 'includes/errorhandler.inc.php'
    ?>
</section>

<?php
    include_once 'footer.php';
?>