<?php
session_start();
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



function generateCsrfToken() {
    return bin2hex(random_bytes(32));
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = generateCsrfToken();
}

$csrfToken = $_SESSION['csrf_token'];


if(isset($_POST['submitform']))
{

    
      if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']){
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
                 $task  = "insert into task(Task_Name,Project_Id)values('$task_name','$lastId')";
                $taskquery  = mysqli_query($conn,$task);
            }
            

        }
        
        
        
      }else {
        echo "CSRF token validation failed!";
    }

}

if(isset($_POST['EditSubmitData']))
  {

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']){
         $projectId =   $_POST['projectId'];
         $pcode = filter_var($_POST['projectCode'],FILTER_SANITIZE_STRING);
        $pname = filter_var($_POST['projectName'],FILTER_SANITIZE_STRING);

        $sql="UPDATE `project` SET `Project_Code` = '$pcode',Project_Name='$pname' where Project_Id='$projectId '";
        $query= mysqli_query($conn,$sql);
        if($query){
          echo '<script type="text/javascript">
            window.onload = function () { alert("Updated Successfully."); }
            </script>';
        }else{
          echo '<script type="text/javascript">
            window.onload = function () { alert("Something Went Wrong,Please Try Again"); }
            </script>';

        }

      }else {
        echo "CSRF token validation failed!";
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
            <input type="text" class="form-control" name="projectCode" id="projectCode" placeholder="Enter Project Code" autocomplete="off"  required>
        </div>
        <div class="form-group col-sm-6">
            <label for="projectName">Project Name:</label>
            <input type="text" class="form-control" name="projectName" id="projectName" placeholder="Enter Project Name" autocomplete="off"  required>
        </div>
        <div class="task-container">
            <div class="form-group task-group col-sm-3">
                <label for="taskName">Task Name:</label>
                <input type="text" class="form-control" name="taskName[]" placeholder="Enter Task Name" autocomplete="off" required >
            </div>         
        </div>
        <div class="form-group col-sm-12">
        <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
        <button type="button" class="btn btn-primary" onclick="addTask()">Add Task</button>
        <input type="submit" class="btn btn-primary" Value="submit" name="submitform">
      </div>
    </form>
    </div>
    <hr>
    <h3>Project and Tasks List</h3>
    <div class="row">
    <form action="#" method="GET" class="form-inline">
     <div class="form-group col-sm-2">
        <!-- <label for="search">Search:</label> -->
        <input type="text" id="search" name="query" class="form-control" placeholder="Enter your Project Code or Name">
      </div>
      <div class="form-group col-sm-1">
        <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>
      
      </div>
    <table>
    <tr>
        <th>Project Code</th>
        <th>Project Name</th>
        <th>Action</th>
    </tr>

    <?php
    ///search functionlity
if (isset($_GET['query'])) {
  $searchQuery =  filter_var($_GET['query'],FILTER_SANITIZE_STRING);
 
  echo "<h2>Search Results for: " . htmlspecialchars($searchQuery) . "</h2>";
  $sql = "SELECT p.`Project_Id`, p.`Project_Code`,p.`Project_Name`,t.task_name FROM project p INNER JOIN task t ON p.`Project_Id` = t.Project_Id where (p.`Project_Code` like '%$searchQuery%') or (p.`Project_Name` like '%$searchQuery%')  ORDER BY p.Project_Id, t.Task_Id";
} else { 
    $sql = "SELECT p.`Project_Id`, p.`Project_Code`,p.`Project_Name`,t.task_name FROM project p INNER JOIN task t ON p.`Project_Id` = t.Project_Id ORDER BY p.Project_Id, t.Task_Id";
}

$result = $conn->query($sql);
$current_project = "";
    while ($row = $result->fetch_assoc()) {
        $project_code     = filter_var($row["Project_Code"],FILTER_SANITIZE_STRING);
        $project_name     = filter_var($row["Project_Name"],FILTER_SANITIZE_STRING);
        $Project_Id       = filter_var($row["Project_Id"],FILTER_SANITIZE_STRING);
        $task_name        = filter_var($row["task_name"],FILTER_SANITIZE_STRING);

        if ($project_name != $current_project) {
            echo "<tr><td>$project_code</td>
            <td>$project_name</td><td><button type='button' class='btn btn-primary' value='$Project_Id' data-toggle='modal' data-target='#editModal' onClick='Edit($Project_Id)'>Edit</button><button type='button' class='btn btn-danger' value='$Project_Id'  onClick='Delete($Project_Id)'>Delete</button></td></tr>";
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

<div class="container">
    <!-- Edit Modal -->
  <div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Project Modules</h4>
        </div>
        <div class="modal-body">
                <form method="POST" action="#">
                    <div class="form-group row">
                        <div class="col-sm-10">
                           <label for="projectName">Project Code</label>
                          <input type="text" class="form-control" name="projectCode" id="pcode" placeholder="Enter Project Code" required autocomplete="off" >
                          </div>
                        </div>
                        <div class="form-group row">                            
                            <div class="col-sm-10">
                            <label for="projectName">Project Name:</label>
                               <input type="text" class="form-control" name="projectName" id="pname" placeholder="Enter Project Name" autocomplete="off"  required/>
                            </div>
                        </div>
                        
                        <!-- <div class="form-group row">
                            <div class="col-sm-10">
                            <label for="taskName">Task Name:</label>                            
                             <input type="text" class="form-control" name="taskName[]" placeholder="Enter Task Name" required>
                            </div>
                        </div> -->
                        <div class="form-group row">
                        <div class="col-sm-10">
                        <input type="hidden" class="form-control" name="projectId" id="pId" required>
                        <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                         <input type="submit" class="btn btn-primary" Value="submit" name="EditSubmitData">
                        </div>
                    </div>
                    </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
</div>

<script>
    function addTask() {
        var newTaskGroup = $('.task-group:first').clone();
        $('.task-container').append(newTaskGroup);
        newTaskGroup.find('input, textarea').val('');
    }

    function Edit(Project_Id){
        $id = Project_Id;
        $.ajax({
        url: 'edit.php',
        data: {'ProjectId':$id}, 
        method: 'GET',
        dataType: 'json',
        success: function(response) {
          document.getElementById("pcode").value   =  response.project_code;
          document.getElementById("pname").value =  response.Project_Name;
          document.getElementById("pId").value  =  response.Project_Id;
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
});
    }

    function Delete(Project_Id){
              $id = Project_Id;
              $.ajax({
              url: 'delete.php',
              data: {'ProjectId':$id}, 
              method: 'GET',
              dataType: 'json',
              success: function(response) {
                var result = confirm("Are you sure you want to delete?");
                if(result){
                   console.log('Deleted Successfully');
                   
                  }
                  location.reload();
              },
              error: function(xhr, status, error) {
                  console.error('Error:', error);
              }
      });
    }
</script>

</body>
</html>