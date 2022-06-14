<?php
require_once "Database.php";

//(Qixotl LFC, 2021)
//https://www.youtube.com/watch?v=lSVGLzGBEe0
class User 
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function findUserByUsername($uid)
    {
        $this->db->query('SELECT * FROM users WHERE userUid = :uid');
        $this->db->bind(':uid',$uid);

        $row = $this->db->getRecord();

        if($this->db->getRowCount() > 0)
        {
            return $row;
        }
        else
        {
            return false;
        }
    }

    public function findUserById($id)
    {
        $this->db->query('SELECT * FROM users WHERE userId = :id');
        $this->db->bind(':id',$id);

        $row = $this->db->getRecord();

        if($this->db->getRowCount() > 0)
        {
            return $row;
        }
        else
        {
            return false;
        }
    }

    public function findUserByRole($role)
    {
        $this->db->query('SELECT * FROM users WHERE userRole = :role');
        $this->db->bind(':role',$role);

        $row = $this->db->getRecord();

        if($this->db->getRowCount() > 0)
        {
            return $row;
        }
        else
        {
            return false;
        }
    }


    public function findAllUsers()
    {
        $this->db->query('SELECT * FROM users');
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

    public function register($fields)
    {
        $this->db->query('INSERT INTO users (userFName,userLName,userUid,userPwd,userRole) VALUES (:fname,:lname,:uid,:pwd,:role)');
        $this->db->bind(':fname',$fields['fname']);
        $this->db->bind(':lname',$fields['lname']);
        $this->db->bind(':uid',$fields['uid']);
        $this->db->bind(':pwd',$fields['pwd']);
        $this->db->bind(':role',$fields['role']);

        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function updateUser($fields)
    {
        if (isset($fields['pwd']))
        {
            $this->db->query('UPDATE users SET userFName = :fname, userLName = :lname, userUid = :uid, userPwd = :pwd, userRole = :role WHERE userId = :id');
            $this->db->bind(':fname',$fields['fname']);
            $this->db->bind(':lname',$fields['lname']);
            $this->db->bind(':uid',$fields['uid']);
            $this->db->bind(':pwd',$fields['pwd']);
            $this->db->bind(':role',$fields['role']);
            $this->db->bind(':id',$fields['id']);
        }
        else
        {
            $this->db->query('UPDATE users SET userFName = :fname, userLName = :lname, userUid = :uid, userRole = :role WHERE userId = :id');
            $this->db->bind(':fname',$fields['fname']);
            $this->db->bind(':lname',$fields['lname']);
            $this->db->bind(':uid',$fields['uid']);
            $this->db->bind(':role',$fields['role']);
            $this->db->bind(':id',$fields['id']);
        }


        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function deleteUser($userId)
    {
        $this->db->query('DELETE FROM assignments WHERE userId = :userId; DELETE FROM users WHERE userId = :userId');
        $this->db->bind(':userId',$userId);

        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}