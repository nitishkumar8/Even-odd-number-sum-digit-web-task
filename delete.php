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

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['ProjectId'])) {
    $ProjectId = $_GET['ProjectId'];
     $sql = "DELETE FROM project  where project.Project_Id='$ProjectId'";
     $sql1 = "DELETE FROM task  where task.Project_Id='$ProjectId'";
    $result = mysqli_query($conn,$sql);;
    $result1 = mysqli_query($conn,$sql1);;
    
    if($result)
    {
        $data["success"]="1";
    }else
    {
        $data["success"]="0";
    }

    echo json_encode($data);
    

    
  }