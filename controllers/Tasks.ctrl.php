<?php
session_start();
require_once "../models/Task.php";

class Tasks
{
    private $taskModel;

    public function __construct()
    {
        $this->taskModel = new Task;
    }

    public function createTask()
    {
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

        $fields = 
        [
            'taskname' => $_POST['taskname'],
            'taskdescription' => $_POST['taskdescription'],
            'taskcreator' => $_SESSION['userFullNameandUid'],
            'taskcreation' => date('Y-m-d H:i:s'),
            'taskdeadline' => $_POST['taskdeadline'],
            'taskstatus' => "0",
            'assignments' => $_POST['assignments']
        ];

        if(empty($fields['taskname']) || empty($fields['assignments']) || empty($fields['taskdeadline']))
        {
            header("location: ../createtask.php?error=emptyFields");
            exit();
        }

        if(preg_match('/\S{256,}/',$fields['taskname']))
        {
            header("location: ../createtask.php?error=tooManyCharsInName");
            exit();
        }

        if(preg_match('/\S{512,}/',$fields['taskdescription']))
        {
            header("location: ../createtask.php?error=tooManyCharsInDescription");
            exit();
        }

        if($this->taskModel->createTask($fields))
        {
            header("location: ../index.php?error=none");
        }
        else
        {
            die("Something Went Wrong. Please Try Again Later");
        }

    }

    public function editTask()
    {
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

        $fields = 
        [
            'taskid' => $_POST['editId'],
            'taskname' => $_POST['taskname'],
            'taskdescription' => $_POST['taskdescription'],
            'taskcreator' => $_SESSION['userFullNameandUid'],
            'taskcreation' => date('Y-m-d H:i:s'),
            'taskdeadline' => $_POST['taskdeadline'],
            'taskstatus' => "0",
            'assignments' => $_POST['assignments']
        ];

        $_SESSION['editId'] = $fields['taskid'];

        if(empty($fields['taskname']) || empty($fields['assignments']) || empty($fields['taskdeadline']))
        {
            header("location: ../updatetask.php?error=emptyFields");
            exit();
        }

        if(preg_match('/\S{256,}/',$fields['taskname'])) //https://stackoverflow.com/questions/12414258/how-to-find-out-if-some-word-in-a-string-is-bigger-than-50-characters-in-php
        {
            header("location: ../updatetask.php?error=tooManyCharsInName");
            exit();
        }

        if(preg_match('/\S{512,}/',$fields['taskdescription']))
        {
            header("location: ../updatetask.php?error=tooManyCharsInDescription");
            exit();
        }

        if($this->taskModel->editTask($fields))
        {
            unset($_SESSION['editId']);
            header("location: ../index.php?error=none");
        }
        else
        {
            unset($_SESSION['editId']);
            die("Something Went Wrong. Please Try Again Later");
        }
    }

    public function deleteTask()
    {
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

        $taskId = $_POST['deleteId'];

        if($this->taskModel->deleteTask($taskId))
        {
            header("location: ../index.php?error=none");
        }
        else
        {
            die("Something Went Wrong. Please Try Again Later");
        }
    }

    public function completeTask()
    {
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

        $taskId = $_POST['statusId'];

        if($this->taskModel->completeTask($taskId))
        {
            header("location: ../index.php?error=none");
        }
        else
        {
            die("Something Went Wrong. Please Try Again Later");
        }
    }

    public function undoCompleteTask()
    {
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

        $taskId = $_POST['statusId'];

        if($this->taskModel->undoCompleteTask($taskId))
        {
            header("location: ../index.php?error=none");
        }
        else
        {
            die("Something Went Wrong. Please Try Again Later");
        }
    }

}

$init = new Tasks;

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if($_POST['formtype'] == 'createtask')
    {
        $init->createTask();
    }
    else if($_POST['formtype'] == 'updatetask')
    {
        $init->editTask();
    }
    else if($_POST['formtype'] == 'deletetask')
    {
        $init->deleteTask();
    }
    else if($_POST['formtype'] == 'completetask')
    {
        $init->completeTask();
    }
    else if($_POST['formtype'] == 'undocompletetask')
    {
        $init->undoCompleteTask();
    }
}