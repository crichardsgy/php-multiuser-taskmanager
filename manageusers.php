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

<section class="usermanage">
    <h3>Manage Users</h3>
    <br/>
    <a class='btn btn-dark' href="createuser.php">Add User</a>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Username/Uid</th>
            <th>Role</th>
        </tr>
        </thead>
        <tbody>
            <?php
                foreach($userlist as $user) 
                {
                    echo "<tr>";
                    echo "<td>$user->userFName</td>";
                    echo "<td>$user->userLName</td>";
                    echo "<td>$user->userUid</td>";
                    echo "<td>$user->userRole</td>";
                    echo "<td>
                    <form action='updateuser.php' method='post'>
                    <button class='btn btn-light' type='submit' name='editId' value='$user->userId'>Edit</button>
                    </form>
                    </td>";
                    echo "<td>
                    <form action='controllers/Users.ctrl.php' method='post'>
                    <input type='hidden' name='formtype' value='deleteuser'>
                    <button class='btn btn-danger' type='submit' name='deleteId' value='$user->userId'>Delete</button>
                    </form>
                    </td>";
                    echo "</tr>";
                }  
            ?>
        </tbody>
    </table>
</section>

<?php
    include_once 'footer.php';
?>