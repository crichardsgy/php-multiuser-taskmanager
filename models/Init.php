<?php 

    include_once "Database.php";
    $db = new Database;

    $createStatements = 
    [
        "CREATE TABLE IF NOT EXISTS users (
            userId int(10) NOT NULL AUTO_INCREMENT,
            userFName varchar(128) NOT NULL,
            userLName varchar(128) NOT NULL,
            userUid varchar(128) NOT NULL,
            userPwd varchar(128) NOT NULL,
            userRole varchar(10) NOT NULL,
            PRIMARY KEY (userId)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
          
          CREATE TABLE IF NOT EXISTS tasks( 
            taskId  INT NOT NULL AUTO_INCREMENT,
            taskName       VARCHAR(256) NOT NULL,
            taskDescription       VARCHAR(512),
            taskCreator       VARCHAR(128) NOT NULL,
            taskCreation   DATETIME NOT NULL,
            taskDeadline   DATETIME NOT NULL,
            taskStatus   CHAR(1) NOT NULL,
            PRIMARY KEY (taskId)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

          -- CREATE TABLE IF NOT EXISTS subtasks( 
          --   subtaskId  INT NOT NULL AUTO_INCREMENT,
          --   subtaskName       VARCHAR(128) NOT NULL,
          --   subtaskCreator       VARCHAR(128) NOT NULL,
          --   subtaskCreation   DATETIME NOT NULL,
          --   subtaskDeadline   DATETIME,
          --   subtaskStatus   CHAR(1) NOT NULL,
          --   taskId INT NOT NULL,
          --   PRIMARY KEY (subtaskId),
          --   FOREIGN KEY (taskId) REFERENCES tasks(taskId)
          -- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
          
          CREATE TABLE IF NOT EXISTS assignments( 
            assignmentId  INT NOT NULL AUTO_INCREMENT,
            taskId     INT NOT NULL,
            userId   INT NOT NULL,
            PRIMARY KEY (assignmentId),
            FOREIGN KEY (taskId) REFERENCES tasks(taskId),
            FOREIGN KEY (userId) REFERENCES users(userId)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
    ];

    try 
    {
      foreach($createStatements as $statement) {
          $db->query($statement);
          $db->execute();
      }
    }
    catch (PDOException $e) 
    {
        echo $e->getMessage();
    }

    $fields = [
      'uid' => "admin",
      'fname' => "admin",
      'lname' => "admin",
      'pwd' => "admin",
      'role' => "Admin"
  ];

  $fields['pwd'] = password_hash($fields['pwd'], PASSWORD_DEFAULT);

  $db->query("SELECT * FROM users WHERE userRole = 'Admin'");
  $db->execute();
  if($db->getRowCount() > 0)
  {
    return;
  }
  else
  {
    $db->query('INSERT INTO users (userFName,userLName,userUid,userPwd,userRole) VALUES (:fname,:lname,:uid,:pwd,:role)');
    $db->bind(':fname',$fields['fname']);
    $db->bind(':lname',$fields['lname']);
    $db->bind(':uid',$fields['uid']);
    $db->bind(':pwd',$fields['pwd']);
    $db->bind(':role',$fields['role']);
    try
    {
      $db->execute();
      echo "<h4>Default Username/Password Is admin/admin.</h4>";
      echo "<h5>Please Change Accordingly. This Message Will Not Be Displayed Again.</h5>";
    }
    catch (PDOException $e)
    {
      echo $e->getMessage();
    }
  }

  unset($db);




