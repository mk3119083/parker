<?php

// $file = $_FILES["file"]["name"];
// $tempname = $_FILES["file"]["tmp_name"];
// $folder = "./image/" . $file;
session_start();
$conn = mysqli_connect("localhost", "root", "", "parker");
if(!$conn){
    die ("connection failed".mysqli_connect_error());
}

else{}
    $name           = $_POST['name'];
    $email          = $_POST['email'];
    $dob            = $_POST['dob'];
    $gender         = $_POST['gender'];
    $mobile         = $_POST['mobile'];
    $address        = $_POST['address'];
    $password       = $_POST['password'];
    $status         = $_POST['status'];
    $created        = $_POST['created'];
    $modified       = $_POST['modified'];
    $FileType       = $_FILES['file']['type'];
    // serverside validation
    if(empty($name)){
		$_SESSION['msg'] = 'Name Can not be empty..';    
		echo "<script>window.location='signup.php'</script>";
		exit;
    }elseif(strlen($name)<2){
		$_SESSION['msg'] = 'name must be atlest 2 characters..';    
		echo "<script>window.location='signup.php'</script>";
		exit;
	}elseif(!ctype_alpha(str_replace('','',$name))){
		$_SESSION['msg'] = 'name must contain only alphabets..';    
		echo "<script>window.location='signup.php'</script>";
		exit;
	}elseif(empty($email)){
		$_SESSION['msg'] = 'email Can not be empty..';    
		echo "<script>window.location='signup.php'</script>";
		exit;
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['msg'] = "Invalid email format..";
    }elseif(empty($dob)){
		$_SESSION['msg'] = 'dob Can not be empty..'; 
		$age = (int) ((time() - strtotime($dob)) / (365 * 24 * 60 * 60));
		if ($age < 18 || $age > 23) {
			$_SESSION['msg'] = "Age must be between 18 and 23 years..";
		}
		echo "<script>window.location='signup.php'</script>";
		exit;
    }elseif(empty($gender)){
        $_SESSION['msg'] = 'gender Can not be empty..';    
        echo "<script>window.location='signup.php'</script>";
        exit;
    }elseif(empty($mobile)){
        $_SESSION['msg'] = 'mobile Can not be empty..'; 
		echo "<script>window.location='signup.php'</script>";
        exit;
    }elseif (!preg_match('/^[6-9][0-9]{9}$/', $mobile)) {
        $_SESSION['msg'] = "Phone number must start with 6, 7, 8, or 9 and be 10 digits long..";
        echo "<script>window.location='signup.php'</script>";
        exit;
    }elseif(empty($address)){
        $_SESSION['msg'] = 'address Can not be empty..';
		echo "<script>window.location='signup.php'</script>";
        exit;
    }elseif(empty($password)){
        $_SESSION['msg'] = 'password Can not be empty..';
		echo "<script>window.location='signup.php'</script>";
        exit;
    }elseif(strlen($password) < 8) {
		$_SESSION['msg'] = "Password must be at least 8 characters long..";
		echo "<script>window.location='signup.php'</script>";
        exit;
    }elseif(!preg_match('/[a-zA-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
		$_SESSION['msg'] = "Password must contain both letters and numbers..";
		echo "<script>window.location='signup.php'</script>";
        exit;
    }elseif (($_FILES["file"]["size"] > 512000)){
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
        exit;
    }elseif($FileType != "image/jpg" &&  $FileType != "image/png" && $FileType != "image/jpeg" && $FileType != "image/gif" ) {
          echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
          $uploadOk = 0;
          exit;

    }else{
        $move = "../img/";
        $_FILES["file"]['name']."<br>";
        $_FILES["file"]['tmp_name']."<br>";
        $_FILES["file"]['size']."<br>";
        $_FILES['file']['error']."<br>";
        $_FILES['file']['type']."<br>";
        $asd = $move.$_FILES["file"]['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $move.$_FILES["file"]['name']);

        if (file_exists($asd)) {
            $set = "INSERT INTO signup (name, email, dob, gender,mobile, address, password,file,status,created,modified) VALUES ('$name', '$email', '$dob','$gender', '$mobile','$address', '".hash('sha256',$password)."','".$asd."','$status', '$created','$modified')"; 
            if(mysqli_query($conn, $set)){
                $_SESSION['msg'] = "New record created successfully";
                echo "<script>window.location='signup.php'</script>";
            } else{
                $_SESSION['msg'] = "Error: " . $set . "<br>" . mysqli_error($conn);
                echo "<script>window.location='signup.php'</script>";
            }
        }
    }
mysqli_close($conn);
