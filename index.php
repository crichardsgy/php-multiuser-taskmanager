<?php
    include_once 'header.php';
    include_once 'models/Init.php';
    require_once "models/Task.php";

    if (isset($_SESSION["userFullName"]))
    {
      echo "<h2>Welcome " . $_SESSION["userFullName"] . "</h2>";
      echo "<br/>";
    }
?>

<?php if(isset($_SESSION["userRole"]) && $_SESSION["userRole"] == "Admin"): ?>
  <?php
      $taskModel = new Task;
      $completedtasklist = $taskModel->findAllCompletedTasks();
      $incompletetasklist = $taskModel->findAllIncompleteTasks();
      unset($taskModel);
  ?>

  <h4 id=statuslabel>Incomplete Tasks</h4>
  <br/>
  <input type="text" id="incompletetasksearch" onkeyup="findIncompleteTasksByName()" placeholder="Search Via Assigned User..">
  <input type="text" id="completedtasksearch" onkeyup="findCompletedTasksByName()" placeholder="Search Via Assigned User..">
  <br/>
  <br/>
  <button id="showstatusbtn" class='btn btn-info' onclick="showCompleted()">Show Completed</button>
  <a class='btn btn-dark' style="float:right" href="createtask.php">Add Task</a>

  <table id="incompletetasktbl" class="table table-bordered table-responsive">
    <thead>
      <tr>
        <th>Task Name</th>
        <th>Task Description</th>
        <th>Task Creator</th>
        <th>Task Creation</th>
        <th>Task Deadline</th>
        <th>Assigned To</th>
        <th>Task Status</th>
      </tr>
    </thead>
    <tbody>
        <?php
            if(empty($incompletetasklist))
            {
                // echo "<p>You Have No Incomplete Tasks</p>";
                // echo "<br/>";
            } 
            else
            {
                foreach($incompletetasklist as $task) 
                {
                    $fullname = $task->userFName . " " . $task->userLName . " (" . $task->userUid . ")";
                    echo "<tr id='$task->taskId'>";
                    echo "<td>$task->taskName</td>";
                    echo "<td>$task->taskDescription</td>";
                    echo "<td>$task->taskCreator</td>";
                    echo "<td>$task->taskCreation</td>";
                    echo "<td>$task->taskDeadline</td>";
                    echo "<td>$fullname</td>";
                    if ($task->taskStatus == 0)
                    {
                      echo "<td>Incomplete</td>";
                    }
                    else
                    {
                      echo "<td>Complete</td>";
                    }
                    if ($task->taskStatus == 0)
                    {
                      echo "<td>
                      <form action='controllers/Tasks.ctrl.php' method='post'>
                        <input type='hidden' name='formtype' value='completetask'>
                        <button class='btn btn-primary' type='submit' name='statusId' value='$task->taskId'>Complete</button>
                      </form>
                      </td>";
                    }
                    else
                    {
                      echo "<td>
                      <form action='controllers/Tasks.ctrl.php' method='post'>
                        <input type='hidden' name='formtype' value='undocompletetask'>
                        <button class='btn btn-secondary' type='submit' name='statusId' value='$task->taskId'>Undo Complete</button>
                      </form>
                      </td>";
                    }

                    echo "<td>
                    <form action='updatetask.php' method='post'>
                      <button class='btn btn-light' type='submit' name='editId' value='$task->taskId'>Edit</button>
                    </form>
                    </td>";
                    echo "<td>
                    <form action='controllers/Tasks.ctrl.php' method='post'>
                      <input type='hidden' name='formtype' value='deletetask'>
                      <button class='btn btn-danger' type='submit' name='deleteId' value='$task->taskId'>Delete</button>
                    </form>
                    </td>";
                    echo "</tr>";
                }  
            }
        ?>
    </tbody>
  </table>

  <table id="completedtasktbl" class="table table-bordered table-responsive">
    <thead>
      <tr>
        <th>Task Name</th>
        <th>Task Description</th>
        <th>Task Creator</th>
        <th>Task Creation</th>
        <th>Task Deadline</th>
        <th>Assigned To</th>
        <th>Task Status</th>
      </tr>
    </thead>
    <tbody>
        <?php
            if(empty($completedtasklist))
            {
                // echo "<p>You Have No Completed Tasks</p>";
                // echo "<br/>";
            } 
            else
            {
                foreach($completedtasklist as $task) 
                {
                    $fullname = $task->userFName . " " . $task->userLName . " (" . $task->userUid . ")";
                    echo "<tr id='$task->taskId'>";
                    echo "<td>$task->taskName</td>";
                    echo "<td>$task->taskDescription</td>";
                    echo "<td>$task->taskCreator</td>";
                    echo "<td>$task->taskCreation</td>";
                    echo "<td>$task->taskDeadline</td>";
                    echo "<td>$fullname</td>";
                    if ($task->taskStatus == 0)
                    {
                      echo "<td>Incomplete</td>";
                    }
                    else
                    {
                      echo "<td>Complete</td>";
                    }
                    if ($task->taskStatus == 0)
                    {
                      echo "<td>
                      <form action='controllers/Tasks.ctrl.php' method='post'>
                        <input type='hidden' name='formtype' value='completetask'>
                        <button class='btn btn-primary' type='submit' name='statusId' value='$task->taskId'>Complete</button>
                      </form>
                      </td>";
                    }
                    else
                    {
                      echo "<td>
                      <form action='controllers/Tasks.ctrl.php' method='post'>
                        <input type='hidden' name='formtype' value='undocompletetask'>
                        <button class='btn btn-secondary' type='submit' name='statusId' value='$task->taskId'>Undo Complete</button>
                      </form>
                      </td>";
                    }

                    echo "<td>
                    <form action='updatetask.php' method='post'>
                      <button class='btn btn-light' type='submit' name='editId' value='$task->taskId'>Edit</button>
                    </form>
                    </td>";
                    echo "<td>
                    <form action='controllers/Tasks.ctrl.php' method='post'>
                      <input type='hidden' name='formtype' value='deletetask'>
                      <button class='btn btn-danger' type='submit' name='deleteId' value='$task->taskId'>Delete</button>
                    </form>
                    </td>";
                    echo "</tr>";
                }  
            }
        ?>
    </tbody>
  </table>

<?php elseif(isset($_SESSION["userRole"]) && $_SESSION["userRole"] == "Normal"): ?>
  <?php
      $taskModel = new Task;
      $completedtasklist = $taskModel->findCompletedTasksByUserId($_SESSION["userId"]);
      $incompletetasklist = $taskModel->findIncompleteTasksByUserId($_SESSION["userId"]);
      unset($taskModel);
  ?>

  <h3 id=statuslabel>Incomplete Tasks</h3>
  <br/>
  <input type="text" id="incompletetasksearch" onkeyup="findIncompleteTasksByName()" placeholder="Search Via Assigned User..">
  <input type="text" id="completedtasksearch" onkeyup="findCompletedTasksByName()" placeholder="Search Via Assigned User..">
  <br/>
  <button id="showstatusbtn" class='btn btn-info' onclick="showCompleted()">Show Completed</button>  

  <table id="incompletetasktbl" class="table table-bordered table-responsive">
    <thead>
      <tr>
        <th>Task Name</th>
        <th>Task Description</th>
        <th>Task Creator</th>
        <th>Task Creation</th>
        <th>Task Deadline</th>
        <th>Assigned To</th>
        <th>Task Status</th>
      </tr>
    </thead>

    <tbody>
        <?php
            if(empty($incompletetasklist))
            {
              // echo "<p>You Have No Incomplete Tasks</p>";
              // echo "<br/>";
            } 
            else
            {
                foreach($incompletetasklist as $task) 
                {
                    $fullname = $task->userFName . " " . $task->userLName . " (" . $task->userUid . ")";
                    echo "<tr id='$task->taskId'>";
                    echo "<td>$task->taskName</td>";
                    echo "<td>$task->taskDescription</td>";
                    echo "<td>$task->taskCreator</td>";
                    echo "<td>$task->taskCreation</td>";
                    echo "<td>$task->taskDeadline</td>";
                    echo "<td>$fullname</td>";
                    if ($task->taskStatus == 0)
                    {
                      echo "<td>Incomplete</td>";
                    }
                    else
                    {
                      echo "<td>Complete</td>";
                    }
                    if ($task->taskStatus == 0)
                    {
                      echo "<td>
                      <form action='controllers/Tasks.ctrl.php' method='post'>
                        <input type='hidden' name='formtype' value='completetask'>
                        <button class='btn btn-primary' type='submit' name='statusId' value='$task->taskId'>Complete</button>
                      </form>
                      </td>";
                    }
                    else
                    {
                      echo "<td>
                      <form action='controllers/Tasks.ctrl.php' method='post'>
                        <input type='hidden' name='formtype' value='undocompletetask'>
                        <button class='btn btn-secondary' type='submit' name='statusId' value='$task->taskId'>Undo Complete</button>
                      </form>
                      </td>";
                    }
                    echo "</tr>";
                }  
            }
        ?>
    </tbody>
  </table>

  <table id="completedtasktbl" class="table table-bordered table-responsive">
    <thead>
      <tr>
        <th>Task Name</th>
        <th>Task Description</th>
        <th>Task Creator</th>
        <th>Task Creation</th>
        <th>Task Deadline</th>
        <th>Assigned To</th>
        <th>Task Status</th>
      </tr>
    </thead>

    <tbody>
        <?php
            if(empty($completedtasklist))
            {
                // echo "<p>You Have No Completed Tasks</p>";
                // echo "<br/>";
            } 
            else
            {
                foreach($completedtasklist as $task) 
                {
                    $fullname = $task->userFName . " " . $task->userLName . " (" . $task->userUid . ")";
                    echo "<tr id='$task->taskId'>";
                    echo "<td>$task->taskName</td>";
                    echo "<td>$task->taskDescription</td>";
                    echo "<td>$task->taskCreator</td>";
                    echo "<td>$task->taskCreation</td>";
                    echo "<td>$task->taskDeadline</td>";
                    echo "<td>$fullname</td>";
                    if ($task->taskStatus == 0)
                    {
                      echo "<td>Incomplete</td>";
                    }
                    else
                    {
                      echo "<td>Complete</td>";
                    }
                    if ($task->taskStatus == 0)
                    {
                      echo "<td>
                      <form action='controllers/Tasks.ctrl.php' method='post'>
                        <input type='hidden' name='formtype' value='completetask'>
                        <button class='btn btn-primary' type='submit' name='statusId' value='$task->taskId'>Complete</button>
                      </form>
                      </td>";
                    }
                    else
                    {
                      echo "<td>
                      <form action='controllers/Tasks.ctrl.php' method='post'>
                        <input type='hidden' name='formtype' value='undocompletetask'>
                        <button class='btn btn-secondary' type='submit' name='statusId' value='$task->taskId'>Undo Complete</button>
                      </form>
                      </td>";
                    }
                    echo "</tr>";
                }  
            }
        ?>
    </tbody>
  </table>

  

<?php else: include_once 'login.php';?>
<?php endif;?>

<script> //(w3schools, n.d.)
  function showCompleted() //https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_toggle_hide_show
  {
    var x = document.getElementById("completedtasktbl");
    var y = document.getElementById("incompletetasktbl");
    var showbutton = document.getElementById("showstatusbtn");
    var showlabel = document.getElementById("statuslabel");
    var incompletetasksearch = document.getElementById("incompletetasksearch");
    var completedtasksearch = document.getElementById("completedtasksearch");
    y.style.display = "none";
    completedtasksearch.style.display = "none";
    
    if (x.style.display === "none") 
    {
      x.style.display = "block";
      y.style.display = "none";
      showbutton.innerHTML = "Show Incomplete";
      showlabel.innerHTML = "Completed Tasks";
      incompletetasksearch.style.display = "none";
      completedtasksearch.style.display = "block";
    } else 
    {
      x.style.display = "none";
      y.style.display = "block";
      showbutton.innerHTML = "Show Completed";
      showlabel.innerHTML = "Incomplete Tasks";
      incompletetasksearch.style.display = "block";
      completedtasksearch.style.display = "none";
    }
  }
  window.onload = showCompleted;
</script>

<script>
function findIncompleteTasksByName() //(w3schools, n.d.)
{ //https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_filter_table
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("incompletetasksearch");
  filter = input.value.toUpperCase();
  table = document.getElementById("incompletetasktbl");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) 
  {
    td = tr[i].getElementsByTagName("td")[5];
    if (td) 
    {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) 
      {
        tr[i].style.display = "";
      } else 
      {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>

<script>
function findCompletedTasksByName() //(w3schools, n.d.)
{ //https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_filter_table
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("completedtasksearch");
  filter = input.value.toUpperCase();
  table = document.getElementById("completedtasktbl");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) 
  {
    td = tr[i].getElementsByTagName("td")[5];
    if (td) 
    {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) 
      {
        tr[i].style.display = "";
      } else 
      {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>



<?php
    include_once 'footer.php';
?>