<?php
//Start a session
session_start();
?>
<!DOCTYPE html>
<title>Hangman Sign Up</title>
<html>
    <body>
	    <?php
		    //include("ConnectionInfo.php");
			
			
			function signUp($uname, $pwd, $rpwd){
				
			$servername = "sql102.epizy.com";
			$username = "epiz_31690262";
			$password = "hhsBKJaGCBKMP";
			$dbname = "epiz_31690262_dromney";
				
				if($pwd == $rpwd){
				
				$charset = "0123456789abcdefghijklmnopqrstuvwxyz";
				$salt = "";
				$randStringLen = 10;
				
				for($i=0;$i < $randStringLen;$i++){
				    $salt .= $charset[mt_rand(0, 35)];
				}
				$pwd .= $salt;
			    $hash = hash('sha256', $pwd);
				
				
			    $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                   die("Connection failed: " . $conn->connect_error);
                }
				
				$sql1 = "SELECT Username, Password, Salt FROM users WHERE Username = '$uname'";
				$result = $conn->query($sql1);
				
				if($result->num_rows > 1){
					echo "User already exists. Please select a new username.";
				}else {
				$sql = "INSERT INTO users (Username, Password, Salt) VALUES ('" . $uname . "', '" . $hash . "', '" . $salt . "')";
				if ($conn->query($sql) === TRUE) {
				   echo "New Entry";
				   header('Location:http://daleromneysum22.epizy.com/home.php');
				} else {
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
				}

                $conn->close();
				}
			}
			
			
			if (isset($_POST['button1'])) {
			    signUp($_POST['uname'], $_POST['pwd'], $_POST['pwd-repeat']);
			}
		?>
	    <form method="post">
		    <div class="Container">
		        <h1> Sing Up Now!</h1>
			    <p>Please.</p>
			    <hr>
		        <label for="uname"><b>Username</b></label><br> 
		        <input type="text" placeholder="Enter Username" name="uname" required/><br><br>
				
				<label for="pwd"><b>Password</b></label><br>
		        <input type="password" placeholder="Enter Password" name="pwd" required/><br><br>
				
				<label for="pwd-repeat"><b>Repeat Password</b></label><br>
		        <input type="password" placeholder="Repeat Password" name="pwd-repeat" required/><br><br>

				<input type="submit" name="button1" value="Submit"/>
			</div>
		</form>
		<a href = "home.php">Back Home</a>
    </body>
</html>
