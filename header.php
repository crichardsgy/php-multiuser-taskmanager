<?php
  session_start();
?>

<!DOCTYPE html>

<head>
  <title>Task Manager</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>
<!-- (Bootstrap, n.d) -->
<!-- https://getbootstrap.com/docs/4.0/components/navbar/ -->
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="collapse navbar-collapse" id="navbarSupportedContent">

    <a class="navbar-brand" href="index.php">Task Manager</a>

    <ul class="navbar-nav mr-auto">
      <li <?php if(basename($_SERVER['SCRIPT_NAME'])=="index.php") { ?>  class="active"   <?php   }  ?>><a class="nav-link" href="index.php">Manage Tasks</a></li>
      <?php
        if (isset($_SESSION["userId"]) && $_SESSION['userRole'] == "Admin")
        {
          //echo '<li><a class="nav-link" href="createtask.php">Add Task</a></li>';
          echo '<li><a class="nav-link" href="manageusers.php">Manage Users</a></li>';
          //echo '<li><a class="nav-link" href="createuser.php">Add User</a></li>';
          echo '<li><a class="nav-link" href="graphs.php">Graphs</a></li>';
        }
      ?>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <?php
        if (isset($_SESSION["userId"]))
        {
          echo '<li><a class="nav-link" href="./controllers/Users.ctrl.php?state=logout">Log Out</a></li>';
        }
      ?>
    </ul>
  </div>
</nav>
  
<br/><br/>

<div class="container p-3 my-3">