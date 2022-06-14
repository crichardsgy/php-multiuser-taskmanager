<?php
require_once "Database.php";
class Task
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function createTask($fields)
    {
        $this->db->query('INSERT INTO tasks (taskName,taskDescription,taskCreator,taskCreation,taskDeadline,taskStatus) VALUES (:taskname,:taskdescription,:taskcreator,:taskcreation,:taskdeadline,:taskstatus)');
        $this->db->bind(':taskname',$fields['taskname']);
        $this->db->bind(':taskdescription',$fields['taskdescription']);
        $this->db->bind(':taskcreator',$fields['taskcreator']);
        $this->db->bind(':taskcreation',$fields['taskcreation']);
        $this->db->bind(':taskdeadline',$fields['taskdeadline']);
        $this->db->bind(':taskstatus',$fields['taskstatus']);

        if($this->db->execute())
        {
            $taskid = $this->db->getLastId();
            $this->db->query('INSERT INTO assignments (taskId,userId) VALUES (:taskid,:userid)');

            foreach ($fields['assignments'] as $user)
            {
                $this->db->bind(':taskid',$taskid);
                $this->db->bind(':userid',$user);
                $this->db->execute();
            }
            return true;
        }
        else
        {
            return false;
        }
    }

    public function editTask($fields)
    {
        $this->db->query('UPDATE tasks SET taskName = :taskname, taskDescription = :taskdescription, taskCreator = :taskcreator, taskCreation = :taskcreation, taskDeadline = :taskdeadline, taskStatus = :taskstatus WHERE taskId = :taskid');
        $this->db->bind(':taskname',$fields['taskname']);
        $this->db->bind(':taskdescription',$fields['taskdescription']);
        $this->db->bind(':taskcreator',$fields['taskcreator']);
        $this->db->bind(':taskcreation',$fields['taskcreation']);
        $this->db->bind(':taskdeadline',$fields['taskdeadline']);
        $this->db->bind(':taskstatus',$fields['taskstatus']);
        $this->db->bind(':taskid',$fields['taskid']);

        if($this->db->execute())
        {
            $this->db->query('DELETE FROM assignments WHERE taskId = :taskid');
            $this->db->bind(':taskid',$fields['taskid']);
            $this->db->execute();

            $this->db->query('INSERT INTO assignments (taskId,userId) VALUES (:taskid,:userid)');

            foreach ($fields['assignments'] as $user)
            {
                $this->db->bind(':taskid',$fields['taskid']);
                $this->db->bind(':userid',$user);
                $this->db->execute();
            }
            return true;
        }
        else
        {
            return false;
        }
    }

    public function deleteTask($taskId)
    {
        $this->db->query('DELETE FROM assignments WHERE taskId = :taskId; DELETE FROM tasks WHERE taskId = :taskId');
        $this->db->bind(':taskId',$taskId);

        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function completeTask($taskId)
    {
        $this->db->query('UPDATE tasks SET taskStatus=1 WHERE taskId = :taskId');
        $this->db->bind(':taskId',$taskId);

        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function undoCompleteTask($taskId)
    {
        $this->db->query('UPDATE tasks SET taskStatus=0 WHERE taskId = :taskId');
        $this->db->bind(':taskId',$taskId);

        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function findAllTasks()
    {
        $this->db->query('SELECT tasks.*,users.*,assignments.* FROM assignments JOIN users ON users.userId = assignments.userId JOIN tasks ON tasks.taskId = assignments.taskId');
        $rows = $this->db->getRecordSet();

        if($this->db->getRowCount() > 0)
        {
            return $rows;
        }
        else
        {
            return false;
        }
    }

    public function findAllIncompleteTasks()
    {
        $this->db->query('SELECT tasks.*,users.*,assignments.* FROM assignments JOIN users ON users.userId = assignments.userId JOIN tasks ON tasks.taskId = assignments.taskId WHERE tasks.taskStatus = 0');
        $rows = $this->db->getRecordSet();

        if($this->db->getRowCount() > 0)
        {
            return $rows;
        }
        else
        {
            return false;
        }
    }

    public function findAllCompletedTasks()
    {
        $this->db->query('SELECT tasks.*,users.*,assignments.* FROM assignments JOIN users ON users.userId = assignments.userId JOIN tasks ON tasks.taskId = assignments.taskId WHERE tasks.taskStatus = 1');
        $rows = $this->db->getRecordSet();

        if($this->db->getRowCount() > 0)
        {
            return $rows;
        }
        else
        {
            return false;
        }
    }

    public function findTasksByUserId($userid)
    {
        $this->db->query('SELECT tasks.*,users.*,assignments.* FROM assignments JOIN users ON users.userId = assignments.userId JOIN tasks ON tasks.taskId = assignments.taskId WHERE assignments.userId = :userid');
        $this->db->bind(':userid',$userid);
        $rows = $this->db->getRecordSet();

        if($this->db->getRowCount() > 0)
        {
            return $rows;
        }
        else
        {
            return false;
        }
    }

    public function findIncompleteTasksByUserId($userid)
    {
        $this->db->query('SELECT tasks.*,users.*,assignments.* FROM assignments JOIN users ON users.userId = assignments.userId JOIN tasks ON tasks.taskId = assignments.taskId WHERE assignments.userId = :userid AND tasks.taskStatus = 0');
        $this->db->bind(':userid',$userid);
        $rows = $this->db->getRecordSet();

        if($this->db->getRowCount() > 0)
        {
            return $rows;
        }
        else
        {
            return false;
        }
    }

    public function findCompletedTasksByUserId($userid)
    {
        $this->db->query('SELECT tasks.*,users.*,assignments.* FROM assignments JOIN users ON users.userId = assignments.userId JOIN tasks ON tasks.taskId = assignments.taskId WHERE assignments.userId = :userid AND tasks.taskStatus = 1');
        $this->db->bind(':userid',$userid);
        $rows = $this->db->getRecordSet();

        if($this->db->getRowCount() > 0)
        {
            return $rows;
        }
        else
        {
            return false;
        }
    }

    public function findAssignmentsByTaskId($taskid)
    {
        $this->db->query('SELECT * FROM assignments WHERE taskId = :taskid');
        $this->db->bind(':taskid',$taskid);
        $rows = $this->db->getRecordSet();

        if($this->db->getRowCount() > 0)
        {
            return $rows;
        }
        else
        {
            return false;
        }
    }

    public function findTasksByTaskId($taskid)
    {
        $this->db->query('SELECT tasks.*,users.*,assignments.* FROM assignments JOIN users ON users.userId = assignments.userId JOIN tasks ON tasks.taskId = assignments.taskId WHERE assignments.taskId = :taskid');
        // $this->db->query('SELECT * FROM tasks WHERE taskId = :taskid');
        $this->db->bind(':taskid',$taskid);
        $rows = $this->db->getRecord();

        if($this->db->getRowCount() > 0)
        {
            return $rows;
        }
        else
        {
            return false;
        }
    }

    public function getCompletionRatio()
    {
        $this->db->query('SELECT * FROM tasks WHERE taskStatus = 0');
        $this->db->execute();
        $incomplete = $this->db->getRowCount();

        $this->db->query('SELECT * FROM tasks WHERE taskStatus = 1');
        $this->db->execute();
        $completed = $this->db->getRowCount();

        $ratio = 
        [
            'incomplete' => $incomplete,
            'completed' => $completed
        ];

        return $ratio;
    }

    public function getUserCompletionStats()
    {
        $this->db->query('SELECT * FROM users');
        $users = $this->db->getRecordSet();
        $stats = array();

        foreach ($users as $user)
        {
            $this->db->query('SELECT tasks.*,assignments.* FROM assignments JOIN tasks ON tasks.taskId = assignments.taskId WHERE assignments.userId = :userid AND tasks.taskStatus = 1');
            $this->db->bind(':userid',$user->userId);
            $this->db->execute();
            $completed = $this->db->getRowCount();
            $userFullName = $user->userFName . " " . $user->userLName;
            $userFullNameandUid = $userFullName . " (" . $user->userUid . ")";
            $stats[] = array("username" => $userFullNameandUid, "completed" => $completed);
        }

        return $stats;
    }
}