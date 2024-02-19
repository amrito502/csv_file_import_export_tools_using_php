<?php
session_start();
$conn = mysqli_connect("localhost","root","","csv_file_upload_tools");
 // delete file
 if(isset($_GET['delete_id'])){
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM students_table WHERE id = $delete_id";
    $result = mysqli_query($conn, $sql);
    if($result){
        $_SESSION['delete_status'] = "File Successfully Deleted!";
        header('location: index.php');    
    }else{
        $_SESSION['delete_status'] = "File Deleting Failed!";
        header('location: index.php');  
    }
}

?>