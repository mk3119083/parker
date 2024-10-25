<!--// Purpose: This file is used to create a form for signup and store the data in the database.-->

<?php include_once("conn.php");$salt=rand(999,99999);$_SESSION['salt'] = $salt; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Form</title>
    <script src="jquery-3.7.1.min.js"></Script>
    <script src="sha256.js"></Script>
    <script>
    function encryptpwd(){
        var pwdpolicy = /^(?=.*\d)(?=.*[a-z])(?=.*[!@#$&*_])(?=.*[A-Z]).{8,20}$/;
        var pass= jQuery("input[name=password]").val();
        if(pass.match(pwdpolicy)) {
            var x = sha256(pass);
            var y= <?php echo $salt; ?>;
            var z= x+y;
            var z1= sha256(z);
            jQuery("input[name=password]").val(z1);
        } else {
            alert("Password does not meet the policy requirements.");
            window.location="login.php";
        }
    } 
    </script>
</head>
<body>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Times New Roman', Times, serif;

    }
    .container {

        display: flex;
        justify-content: center;
        align-items: center;

    }
    .signup-here {
        text-align: center;
        padding-block: 3rem;
        color: black;
        font-size: 2rem;
    }
    form {
        width: 100%;
        height: fit-content;
        box-shadow: 0px 0px 10px 1px rgb(98, 85, 85);
        margin-block: 10px;
        padding: 20px;
    }

    /* form:hover{
        box-shadow:0px 0px 20px 1px rgba(194, 16, 16, 0.532); 

    } */
    .input, select {
        width: 100%;
        padding: 10px 10px;
        border: 0;
        border: 1px solid black;
        border-radius: 5px;
        margin-block: 5px;
    }
    .save-btn {
        margin-top: 1rem;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .save-btn button {
        width: 100px;
        padding: 10px;
        background-color: rgb(28, 109, 186);
        color: white;
        cursor: pointer;
        border: 1px solid rgb(28, 109, 186);
        border-radius: 5px;
        font-size: 1.3rem;
    }
    .form-details {
        margin-block: 5px;
    }
    .captcha-container {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    .captcha {
        font-size: 24px;
        font-weight: bold;
        margin-right: 10px;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 3px;
        background-color: #f9f9f9;
    }
    .refresh-button {
        padding: 5px 10px;
        cursor: pointer;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 3px;
    }
    .refresh-button:hover {
        background-color: #0056b3;
    }
</style>




<!--// Signup form-->
<div class="container">
    <div>
        <div class="signup-here"><h1>Login Here</h1></div>
<?php 
if(isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>
        <form id="userForm" class="userForm" method="POST">
        <div class="form-details">
            <label for="email"><b>Email</b></label><br>
            <input type="email" name="email" placeholder="email address" class="input">
        </div>

        <div class="form-details">
            <lable for="password"><b>Password</b></lable><br>
            <input type="password" name="password" placeholder="enter your password"  class="input">
        </div>
    
        <div class="captcha-container">
            <img src="cp.php" alt="CAPTCHA" class="captcha-image"><i class="fas fa-redo refresh-captcha">Refresh</i>
    <br>
        </div>

        <label for="captcha-input">Enter CAPTCHA:</label>
        <input type="text" id="captcha-input" name="captcha" required>

        <div class="save-btn">
            <button type="submit" name="save" class="submit" value="Submit" OnClick="encryptpwd();">Submit</button>
        </div>
        </form>
    </div>

</div>
<script>
    var refreshButton = document.querySelector(".refresh-captcha");
refreshButton.onclick = function() {
  document.querySelector(".captcha-image").src = 'cp.php?' + Date.now();
}
</script>
</body>
</html>