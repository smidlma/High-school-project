<?php
require "db_connect.php";

if($_POST){
    session_start();
    $user = $_POST['user'];
    $password = md5($_POST['password']);
    
    $query = "SELECT provozovatel_id, admin
    FROM provozovatel
    WHERE email LIKE '$user' AND password LIKE '$password'";

    if($conn->query($query)->num_rows > 0){
        $result = $conn->query($query);
        while($row = $result->fetch_array(MYSQLI_ASSOC)){
            $id = $row['provozovatel_id'];
            $admin  = $row['admin'];
        }
        $_SESSION['admin'] = $admin;
        if($admin == 1){
            header("Location: dashboard.php");
        }else{
            $_SESSION['id'] = $id;
            header("Location: userDashboard.php");
        }

    }else{
        $_SESSION['info'] = "error";
        header("Location: login.php");
    }
}