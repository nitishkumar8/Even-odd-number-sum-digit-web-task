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
    // $sql = "SELECT p.`Project_Id`, p.`Project_Code`,p.`Project_Name`,t.task_name FROM project p INNER JOIN task t ON p.`Project_Id` = t.Project_Id and t.`Project_Id`='$ProjectId'";
    $sql = "SELECT p.`Project_Id`, p.`Project_Code`,p.`Project_Name` FROM project as p  where p.`Project_Id`='$ProjectId'";

    

    $result = $conn->query($sql);
    //$rows = array();
    while ($row = mysqli_fetch_assoc($result)) {
      $data["project_code"]     = $row["Project_Code"];
      $data["Project_Name"]     = $row["Project_Name"];
      $data["Project_Id"]       = $row["Project_Id"];
    }
    echo json_encode($data);
    

    
  }