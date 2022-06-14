<?php
    include_once 'header.php';
    require_once "models/User.php";
    require_once "models/Task.php";

    $userModel = new User;
    $taskModel = new Task;

    if(!isset($_POST['editId']))
    {
        $taskid = $_SESSION['editId'];
    }
    else
    {
        $taskid = $_POST['editId'];
    }

    $userlist = $userModel->findAllUsers();
    $taskdetails = $taskModel->findTasksByTaskId($taskid);
    $assignments = $taskModel->findAssignmentsByTaskId($taskid);
    unset($userModel);
    unset($taskModel);

    if ($_SESSION['userRole'] !== "Admin")
    {
        header("location: index.php");
    }
?>

<section class="taskupdater">
    <h3>Edit Task</h3>
    <form action="controllers/Tasks.ctrl.php" method="post">
        <input type="hidden" name="formtype" value="updatetask">
        <input type="hidden" name="editId" value="<?php echo "$taskid";?>">
        <?php
        echo "<label for='taskname'>Task Name (*): </label>";
        echo "<input type='text' name='taskname' placeholder='Task Name' value='$taskdetails->taskName'>";
        echo "<br/>";

        echo "<label for='taskdescription'>Task Description: </label> <br/>";
        echo "<textarea name='taskdescription' placeholder='Task Description' rows='4' cols='50'>$taskdetails->taskDescription</textarea>";
        echo "<br/>";

        echo "<label for='taskdeadline'>Deadline (*): </label>";
        echo "<input type='datetime-local' name='taskdeadline' placeholder='Date And Time' value='$taskdetails->taskDeadline'>";
        echo "<br/>";
        ?>
        <br/>

        <label for="assignments">Assign Task To.. (*) (Hold Ctrl/Command To Select Multiple Users)</label> 
        <br/>
        <select name="assignments[]" id="assignments" multiple="multiple">
            <?php 
                foreach($userlist as $user) 
                {
                    $userFullName = $user->userFName . " " . $user->userLName;
                    $userFullNameandUid = $userFullName . " (" . $user->userUid . ")";
                    foreach($assignments as $assigneduser)
                    {
                        if($user->userId === $assigneduser->userId)
                        {
                            $flag = 1;
                            echo '<option value="'.$user->userId.'" selected>'.$userFullNameandUid.'</option>';
                            break;
                        }
                        $flag = 0;
                    }
                    if($flag == 0)
                    {
                        echo '<option value="'.$user->userId.'">'.$userFullNameandUid.'</option>';
                    }
                }          
            ?>
        </select>
        <br/><br/>

        <button class='btn btn-primary' type="submit" name="submit">Update Task</button> 
        <a class='btn btn-danger' href="index.php">Cancel</a>  
    </form>
    <br/>
    <?php
        include_once 'includes/errorhandler.inc.php'
    ?>
</section>

<?php
    include_once 'footer.php';
?>