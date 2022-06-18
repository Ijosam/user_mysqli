<?php

session_start();

require_once "../config.php";

//register users
function registerUser($fullnames, $email, $password, $country, $gender){
    //create a connection variable using the db function in config.php
    $conn = db();
   //check if user with this email already exist in the database
   $query = mysqli_query($conn, "SELECT * FROM students WHERE email = '".$email."'");
   if(mysqli_num_rows($query)) {
       exit('This email address is already used!');
  
   }
   else{
        $query = mysqli_query($conn,"INSERT INTO students (`fullnames`, `email`, `password`, `country`, `gender`)
                VALUES ('$fullnames', '$email', '$password', '$country', '$gender')")or exit(mysqli_error($conn));  
    
       
        echo "New record created successfully";
        
      
      $conn->close();  
    }
    }  
                



//login users
function loginUser($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();

    echo "<h1 style='color: red'> LOG ME IN (IMPLEMENT ME) </h1>";
    //open connection to the database and check if username exist in the database
    //if it does, check if the password is the same with what is given
    //if true then set user session for the user and redirect to the dasbboard

    if (!empty($email) && !empty($password)) {
        $sql = "SELECT email, password FROM students
                WHERE email = '$email' AND password = '$password' LIMIT 1 ";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_assoc($result);
        }
    }
    //if it does, check if the password is the same with what is given
    if ($data['email'] === $email && $data['password'] === $password) {
        $_SESSION['username'] = $data['fullnames'];
        echo "<script> alert('Login Successful') </script>";
        header("Location: ../dashboard.php");
        die();
    } else {
        header("Location: ../forms/login.html");
        echo "<script> alert('Could Not Login') </script>";
    }
    $conn->close();
}

   

function resetPassword($email, $password)
{
    //create a connection variable using the db function in config.php
    $conn = db();
    echo "<h1 style='color: red'>RESET YOUR PASSWORD (IMPLEMENT ME)</h1>";
    //open connection to the database and check if username exist in the database
    $sql = "SELECT email FROM students
    WHERE email = '$email' LIMIT 1 ";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        if ($data) {
            if ($data['email'] === $email) {
                $update_sql = "UPDATE students
                                SET password = '$password'
                                WHERE email = '$email'";
                mysqli_query($conn, $update_sql);
                echo "<script> alert('Password Reset Successful') </script>";
                header("Location: ../forms/login.html");
                die();
                
            }
        }
    }
    echo "<script> alert('User Does Not Exist') </script>";
    $conn->close();
}

function getusers(){
    $conn = db();
    $sql = "SELECT * FROM Students";
    $result = mysqli_query($conn, $sql);
    echo"<html>
    <head></head>
    <body>
    <center><h1><u> ZURI PHP STUDENTS </u> </h1> 
    <table border='1' style='width: 700px; background-color: magenta; border-style: none'; >
    <tr style='height: 40px'><th>ID</th><th>Full Names</th> <th>Email</th> <th>Gender</th> <th>Country</th> <th>Action</th></tr>";
    if(mysqli_num_rows($result) > 0){
        while($data = mysqli_fetch_assoc($result)){
            //show data
            echo "<tr style='height: 30px'>".
                "<td style='width: 50px; background: blue'>" . $data['id'] . "</td>
                <td style='width: 150px'>" . $data['fullnames'] .
                "</td> <td style='width: 150px'>" . $data['email'] .
                "</td> <td style='width: 150px'>" . $data['gender'] . 
                "</td> <td style='width: 150px'>" . $data['country'] . 
                "</td>
                <form action='action.php' method='post'>
                <input type='hidden' name='id'" .
                 "value=" . $data['id'] . ">".
                "<td style='width: 150px'> <button type='submit', name='delete'> DELETE </button>".
                "</tr>";
        }
        echo "</table></table></center></body></html>";
    }
    //return users from the database
    //loop through the users and display them on a table
}

 function deleteaccount($id){
     $conn = db();
     //delete user with the given id from the database
     if (isset($_GET['all'])) {
        $all = $_GET['all'];
        $sql = "DELETE FROM students
                WHERE id = '$all' ";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo "<script> alert('Delete Successful') </script>";
        }else{
            die(mysqli_error($conn));
        }
    }


 }


