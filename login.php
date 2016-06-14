<?php
require_once "dbconn.php";
//print_r($conn); exit;
//print_r($_POST); //exit;
if(isset($_POST['username']) && isset($_POST['password'])){
  $username = $_POST['username'];
  $password = md5($_POST['password']);
    
   $sql = "select * from users where user_name='".$username."' and user_password='".$password."'";
   $result = $conn->query($sql);

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
        //echo $row['user_id'] . '<br />';
           $result->free();
            $sql = "update users set user_logged_in = 1 where user_id = ".$row['user_id']."";
            $conn->query($sql);
        }
    
        echo "Logged in updated"; 
    }else{
        echo 'No user found <a href="index.html">Go back</a>';
    }
     
    
}else{
    echo '<a href="index.html">Go back</a>'; exit;
}

$conn->close();
?>