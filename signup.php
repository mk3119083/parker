<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input, select, textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .error {
            color: red;
            font-size: 0.9em;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <form id="signupForm" action="db.php" method="POST" onsubmit="test(event)" enctype="multipart/form-data">
    <div>
	<?php 
    if (isset($_SESSION['msg'])){
        echo "<p class='error'>".$_SESSION['msg']."</p>";
		unset($_SESSION['msg']);
    }
    ?>
	</div>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" minlength="2">
        <span class="text-danger" id = "nameError"><?php if(!empty($name_error)){echo $name_error;}?></span><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" >
        <span class="text-danger" ><?php if(!empty($email_error)){echo $email_error;}?></span><br>
        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" >
        <span class="text-danger" ><?php if(!empty($dob_error)){echo $dob_error;}?></span><br>
        <label for="gender">Gender:</label>
        <select id="gender" name="gender" >
            <option value="">Select</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select>
        <span class="error" id="genderError"></span><br>

        <label for="mobile">Mobile:</label>
        <input type="text" id="mobile" name="mobile"  minlength="10" maxlength="10">
        <span class="text-danger" ><?php if(!empty($mobile_error)){echo $mobile_error;}?></span><br>

        <label for="address">Address:</label>
        <textarea id="address" name="address" ></textarea>
        <span class="error" id="addressError"></span><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password"  minlength="6">
        <span class="error" id="passwordError"></span><br>

        <label for="file">Upload id :</label>
        <input type="file" id="file" name="file" enctype="multipart/form-data">

        
        <input type="hidden" name="status" value="1">
        <input type="hidden" name="created" value="<?php echo date('Y-m-d H:i:s'); ?>">
        <input type="hidden" name="modified" value="<?php echo date('Y-m-d H:i:s'); ?>">

        <!--<span type="submit" name="submit" onclick="test()">Submit</span>-->
        <button type="submit" name="submit">Submit</button>
        <div class="login">Already Registered <a href="login.php">Login Now</a></div>
    </form>
    
<!-- client side validation -->
    <script>
        //document.getElementById('signupForm').addEventListener('submit', function(event) {
		function test(event){
            var valid = true;
            var name = document.getElementById('name').value;
			var nameError = document.getElementById('nameError');
			if (name == '') {
                nameError.textContent = "Name should not empty.";
                valid = false;
            } else if (!/^[a-zA-Z]+$/.test(name)) {
                nameError.textContent = "Name should contain only alphabets.";
                valid = false;
            } else {
                nameError.textContent = "";
            }
			
			
            const mobile = document.getElementById('mobile').value;
			var mobileError = document.getElementById('mobileError');
            if (!/^[6-9]\d{9}$/.test(mobile)) {
                mobileError.textContent = "Mobile number must start with 6, 7, 8, or 9 and be 10 digits long.";
                valid = false;
            } else {
                mobileError.textContent = "";
            }
			
            const dob = new Date(document.getElementById('dob').value);
            const today = new Date();
            const age = today.getFullYear() - dob.getFullYear();
            const monthDiff = today.getMonth() - dob.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                age--;
            }
            if (age < 18) {
                document.getElementById('dobError').textContent = "You must be 18 years or older to register.";
                valid = false;
            } else {
                document.getElementById('dobError').textContent = "";
            }
			
            if (!valid) {
				event.preventDefault();
            }
		}
        //});
    </script>
</body>
</html>