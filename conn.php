<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "parker");
if(!$conn){
    die ("connection failed".mysqli_connect_error());
}

if (isset($_POST['save'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if(isset($_POST['captcha']) && $_POST['captcha'] == $_SESSION['captcha_text']){}else{
        $_SESSION['msg'] = "wrong captcha";
        header("Location: login.php");
        exit;
    }

    // Validate user credentials
    $sql = "SELECT * FROM signup WHERE email='$email'";
    $result = $conn->query($sql);
    
    
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $dbpsd = hash('sha256',$data['password'].$_SESSION['salt']);
        //echo $data['password']."</br>".$data['password'].$_SESSION['salt']."</br>".$dbpsd;exit;
        if($password == $dbpsd){
            header("Location: dasboard.php");
        }else{
            header("Location: login.php");
        }
        // echo "Login successful!";
        
    } else {
        echo "Invalid Credential.";
    }
}