<?php
session_start();
require_once "../models/User.php";



class Users 
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User;
    }

    //(Qixotl LFC, 2021)
    //https://www.youtube.com/watch?v=lSVGLzGBEe0
    public function register()
    {
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

        $fields = [
            'uid' => trim($_POST["uid"]),
            'fname' => trim($_POST["fname"]),
            'lname' => trim($_POST["lname"]),
            'pwd' => trim($_POST["pwd"]),
            'pwdconfirm' => trim($_POST['pwdconfirm']),
            'role' => trim($_POST['role'])
        ];

        if(empty($fields['uid']) || empty($fields['fname']) || empty($fields['lname']) || empty($fields['pwd']) || empty($fields['pwdconfirm']))
        {
            header("location: ../createuser.php?error=emptyFields");
            exit();
        }

        if(preg_match('/\S{128,}/',$fields['uid'])) //https://stackoverflow.com/questions/12414258/how-to-find-out-if-some-word-in-a-string-is-bigger-than-50-characters-in-php
        {
                header("location: ../createuser.php?error=tooManyCharsInUid");
                exit();
        }
        if(preg_match('/\S{128,}/',$fields['fname']))
        {
            header("location: ../createuser.php?error=tooManyCharsInFName");
            exit();
        }
        if(preg_match('/\S{128,}/',$fields['lname'])) //https://stackoverflow.com/questions/12414258/how-to-find-out-if-some-word-in-a-string-is-bigger-than-50-characters-in-php
        {
                header("location: ../createuser.php?error=tooManyCharsInLName");
                exit();
        }
        if(preg_match('/\S{128,}/',$fields['pwd']))
        {
            header("location: ../createuser.php?error=tooManyCharsInPwd");
            exit();
        }
        if($fields['role'] !== "Admin" && $fields['role'] !== "Normal")
        {
            header("location: ../createuser.php?error=invalidRole");
            exit();
        }

        if(!preg_match("/^[a-zA-Z0-9]*$/",$fields['uid'])) //https://www.youtube.com/watch?v=gCo6JqGMi30
        {
            header("location: ../createuser.php?error=invalidUid");
            exit();
        }
        if ($fields['pwd'] !== $fields['pwdconfirm'])
        {
            header("location: ../createuser.php?error=invalidPwdMatch");
            exit();
        }
        if ($this->userModel->findUserByUsername($fields['uid']) !== false)
        {
            header("location: ../createuser.php?error=usernameTaken");
            exit();
        }

        $fields['pwd'] = password_hash($fields['pwdconfirm'], PASSWORD_DEFAULT);

        if ($this->userModel->register($fields))
        {
            header("location: ../manageusers.php?error=none");
            exit();
        }
        else
        {
            die("Something Went Wrong. Please Try Again Later");
        }

    }

    public function updateUser()
    {
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

        $fields = [
            'id' => trim($_POST['editId']),
            'uid' => trim($_POST["uid"]),
            'fname' => trim($_POST["fname"]),
            'lname' => trim($_POST["lname"]),
            'pwd' => trim($_POST["pwd"]),
            'pwdconfirm' => trim($_POST['pwdconfirm']),
            'role' => trim($_POST['role'])
        ];

        $_SESSION['editId'] = $fields['id'];

        if(empty($fields['uid']) || empty($fields['fname']) || empty($fields['lname']) || empty($fields['pwd']) || empty($fields['pwdconfirm']))
        {
            header("location: ../updateuser.php?error=emptyFields");
            exit();
        }

        if(preg_match('/\S{128,}/',$fields['uid'])) //https://stackoverflow.com/questions/12414258/how-to-find-out-if-some-word-in-a-string-is-bigger-than-50-characters-in-php
        {
                header("location: ../updateuser.php?error=tooManyCharsInUid");
                exit();
        }
        if(preg_match('/\S{128,}/',$fields['fname']))
        {
            header("location: ../updateuser.php?error=tooManyCharsInFName");
            exit();
        }
        if(preg_match('/\S{128,}/',$fields['lname'])) //https://stackoverflow.com/questions/12414258/how-to-find-out-if-some-word-in-a-string-is-bigger-than-50-characters-in-php
        {
                header("location: ../updateuser.php?error=tooManyCharsInLName");
                exit();
        }
        if(preg_match('/\S{128,}/',$fields['pwd']))
        {
            header("location: ../updateuser.php?error=tooManyCharsInPwd");
            exit();
        }
        if($fields['role'] !== "Admin" && $fields['role'] !== "Normal")
        {
            header("location: ../updateuser.php?error=invalidRole");
            exit();
        }

        if(!preg_match("/^[a-zA-Z0-9]*$/",$fields['uid'])) //https://www.youtube.com/watch?v=gCo6JqGMi30
        {
            header("location: ../updateuser.php?error=invalidUid");
            exit();
        }
        if ($fields['pwd'] !== $fields['pwdconfirm'])
        {
            header("location: ../updateuser.php?error=invalidPwdMatch");
            exit();
        }

        $fields['pwd'] = password_hash($fields['pwdconfirm'], PASSWORD_DEFAULT);

        if ($this->userModel->updateUser($fields))
        {
            unset($_SESSION['editId']);
            header("location: ../manageusers.php?error=none");
            exit();
        }
        else
        {
            unset($_SESSION['editId']);
            die("Something Went Wrong. Please Try Again Later");
        }

    }

    public function login()
    {
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

        $fields = [
            'uid' => trim($_POST["uid"]),
            'pwd' => trim($_POST["pwd"])
        ];

        if(empty($fields['uid']) || empty($fields['pwd']))
        {
            header("location: ../index.php?error=emptyFields");
            exit();
        }

        $row = $this->userModel->findUserByUsername($fields['uid']);

        if ($row == false)
        {
            header("location: ../index.php?error=invalidUsernameOrPassword");
            exit();
        }

        $hashedpwd = $row->userPwd;

        if (password_verify($fields['pwd'],$hashedpwd) === false)
        {
            header("location: ../index.php?error=invalidUsernameOrPassword");
            exit();
        }
        else if (password_verify($fields['pwd'],$hashedpwd) === true)
        {
            session_start();
            $_SESSION["userId"] = $row->userId;
            $_SESSION["userFullName"] = $row->userFName . " " . $row->userLName;
            $_SESSION["userUid"] = $row->userUid;
            $_SESSION["userRole"] = $row->userRole;
            $_SESSION["userFullNameandUid"] = $_SESSION["userFullName"] . " (" . $_SESSION["userUid"] . ")";
            header("location: ../index.php");
        }
        
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header("location: ../index.php");
        exit();
    }

    public function deleteUser()
    {
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

        $userId = $_POST['deleteId'];

        if($userId == $_SESSION['userId'])
        {
            header("location: ../manageusers.php?error=currentlyLoggedInUser");
            exit();
        }

        if($this->userModel->deleteUser($userId))
        {
            header("location: ../manageusers.php?error=none");
        }
        else
        {
            die("Something Went Wrong. Please Try Again Later");
        }
    }

}

$init = new Users;

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if($_POST['formtype'] == 'register')
    {
        $init->register();
    }
    else if ($_POST['formtype'] == 'login')
    {
        $init->login();
    }
    else if ($_POST['formtype'] == 'updateuser')
    {
        $init->updateUser();
    }
    else if ($_POST['formtype'] == 'deleteuser')
    {
        $init->deleteUser();
    }
}
else
{
    if($_GET['state'] == 'logout')
    {
        $init->logout();
    }
    else
    {
        header("location: ../index.php");
    }
}