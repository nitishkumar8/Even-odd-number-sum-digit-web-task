<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname="collection";

// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


if(isset($_POST['submitform']))
{

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $projectCode            =   $_POST['projectCode'];
        $projectName            =   $_POST['projectName'];
        $taskName               =   $_POST['taskName'];       
        
        $checkProjectCode       =   "select count(Project_Code) as Project_Code  from project where Project_Code='$projectCode'";
        $projectcodeQuery       =   mysqli_query($conn,$checkProjectCode);
        $projectcodeQueryfetch  =   mysqli_fetch_assoc($projectcodeQuery);
        $exitProjectCode        =   $projectcodeQueryfetch['Project_Code'];
        
        if($exitProjectCode >0)
        {
           echo "This Project Code Is Duplicate,Please Try To New Project Code ";

        }else{
            
            $projectinsert  = "insert into project(Project_Code,Project_Name)values('$projectCode','$projectName')";
            $projectquery   = mysqli_query($conn,$projectinsert);
             $lastId   = mysqli_insert_id($conn);
            foreach($taskName as $task_name)
            {
                echo $task  = "insert into task(Task_Name,Project_Id)values('$task_name','$lastId')";
                $taskquery  = mysqli_query($conn,$task);
            }
            

        }
        
        
        
      }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Project and Tasks Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<div class="container">
    <h2> Add Project and Tasks </h2>
    <div class="row">
    <form id="projectForm" action="#" method="post">
        <div class="form-group col-sm-6">
            <label for="projectName">Project Code</label>
            <input type="text" class="form-control" name="projectCode" id="projectCode" placeholder="Enter Project Code" required>
        </div>
        <div class="form-group col-sm-6">
            <label for="projectName">Project Name:</label>
            <input type="text" class="form-control" name="projectName" id="projectName" placeholder="Enter Project Name" required>
        </div>
        <div class="task-container">
            <div class="form-group task-group col-sm-3">
                <label for="taskName">Task Name:</label>
                <input type="text" class="form-control" name="taskName[]" placeholder="Enter Task Name" required>
            </div>         
        </div>
        <div class="form-group col-sm-12">
        <button type="button" class="btn btn-primary" onclick="addTask()">Add Task</button>
        <input type="submit" class="btn btn-primary" Value="submit" name="submitform">
      </div>
    </form>
    </div>
    <hr>
    <h3>Project and Tasks List</h3>
    <table>
    <tr>
        <th>Project Code</th>
        <th>Project Name</th>
        <th>Action</th>
    </tr>

    <?php
    $sql = "SELECT p.`Project_Id`, p.`Project_Code`,p.`Project_Name`,t.task_name FROM project p INNER JOIN task t ON p.`Project_Id` = t.Project_Id ORDER BY p.Project_Id, t.Task_Id";

$result = $conn->query($sql);
$current_project = "";
    while ($row = $result->fetch_assoc()) {
        $project_code     = $row["Project_Code"];
        $project_name     = $row["Project_Name"];
        $Project_Id       = $row["Project_Id"];
        $task_name        = $row["task_name"];

        if ($project_name != $current_project) {
            echo "<tr><td>$project_code</td>
            <td>$project_name</td><td><button type='button' class='btn btn-primary' value='$Project_Id' onchange='Edit(Project_Id)'>Edit</button><button type='button' class='btn btn-danger' value='$Project_Id' onchange='Delete(Project_Id)'>Delete</button></td></tr>";
            echo "<tr><th rowspan='1'></th><td>$task_name</td><td></td></tr>";
            $current_project = $project_name;
        } else {
           echo "<tr><th rowspan='1'></th><td>$task_name</td><td></td></tr>";
        }
    }
    ?>

</table>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>
    function addTask() {
        var newTaskGroup = $('.task-group:first').clone();
        $('.task-container').append(newTaskGroup);
        newTaskGroup.find('input, textarea').val('');
    }
</script>

</body>
</html>