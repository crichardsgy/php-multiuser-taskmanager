<?php
    include_once 'header.php';
    require_once "models/User.php";
    require_once "models/Task.php";

    $userModel = new User;
    $taskModel = new Task;

    $userlist = $userModel->findAllUsers();
    $taskratio = $taskModel->getCompletionRatio();
    $userstats = $taskModel->getUserCompletionStats();

    unset($userModel);
    unset($taskModel);

    if ($_SESSION['userRole'] !== "Admin")
    {
        header("location: index.php");
    }
?>

<section class="dashboard">

    <div class="chart-wrapper">
        <h2>All Completed Tasks</h2>
        <?php echo 'Of '.$taskratio["completed"]+$taskratio["incomplete"].' Total Tasks. '.$taskratio["completed"].' = Complete, And '.$taskratio["incomplete"].' = Incomplete.'; ?>
        <canvas id="allcompletedtasks"></canvas>
    </div>

    <br/><br/>

    <div class="chart-wrapper">
        <h2>Task Completion Per User</h2>
        <?php echo 'Of '.$taskratio["completed"]+$taskratio["incomplete"].' Total Tasks. '.$taskratio["completed"].' = Complete, And '.$taskratio["incomplete"].' = Incomplete.'; ?>
        <canvas id="usercompletedtasks"></canvas>
    </div>

</section>

<br/><br/><br/><br/>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<script> 
//(WebDevSHORTS, 2019)
//https://github.com/WebDevSHORTS/ChartJS-PieChart/blob/master/js/script.js
    let ctx = document.getElementById('allcompletedtasks').getContext('2d');
    let labels = ['Completed', 'Incomplete'];
    let colorHex = ['#2596BE', '#EFCA07'];

    let myChart = new Chart(ctx, {
    type: 'pie',
    data: 
    {
        datasets: 
        [{
            data: [<?php echo $taskratio["completed"] . "," . $taskratio["incomplete"];?>],
            backgroundColor: colorHex
        }],
        labels: labels
    },
        options: 
        {
            responsive: true,
            legend: 
            {
                position: 'bottom'
            },
            plugins: 
            {
                datalabels: 
                {
                    color: '#fff',
                    anchor: 'end',
                    align: 'start',
                    offset: -10,
                    borderWidth: 2,
                    borderColor: '#fff',
                    borderRadius: 25,
                    backgroundColor: (context) => {
                    return context.dataset.backgroundColor;
                    },
                    font: 
                    {
                        weight: 'bold',
                        size: '10'
                    },
                    formatter: (value) => {
                    return value + ' %';
                    }
                }
            }
        }
    })
</script>
            
<script> 
//(w3schools, n.d.)
//https://www.w3schools.com/js/tryit.asp?filename=tryai_chartjs_bars_colors_more
    var xValues = 
    [<?php 
        foreach ($userstats as $user)
        {
            echo '"'. $user["username"] . '", ';
        }
    ?>];
    var yValues =     
    [<?php 
        foreach ($userstats as $user)
        {
            echo $user["completed"] . ', ';
        }
    ?>];

    new Chart("usercompletedtasks", {
    type: "horizontalBar",
    data: {
        labels: xValues,
        datasets: [{
        backgroundColor: "#456bf1",
        data: yValues
        }]
    },
    options: {
        legend: {display: false},
        title: {
        display: true,
        text: "Task Completion Per User"
        }
    }
    });
</script>


<?php
    include_once 'footer.php';
?>