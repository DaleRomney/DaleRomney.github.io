<?php
//Start a session
session_start();
?>
<!DOCTYPE html>
<title>Hangman Game</title>

<html>
    <body>
	    <?php
		    //include("ConnectionInfo.php");
			
			
			
			function login($uname, $pwd){
				$servername = "sql102.epizy.com";
				$username = "epiz_31690262";	
				$password = "hhsBKJaGCBKMP";
				$dbname = "epiz_31690262_dromney";
				
				$conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                  die("Connection failed: " . $conn->connect_error);
                }
  
                $sql = "SELECT Username, Password, Salt FROM users WHERE Username = '$uname'";
				$result = $conn->query($sql);
				
				if ($result->num_rows > 0){
					while($row = $result->fetch_assoc()){
						//echo "Username: " . $row["Username"]. " - Password: " . $row["Password"]. " - Salt: " . $row["Salt"]. "<br>";
						$pwd .= $row["Salt"];
						$hash = hash('sha256', $pwd);
						
						if($hash == $row["Password"]){
							$_SESSION['uname'] = $uname;
							header("Location: http://daleromneysum22.epizy.com/game.php");
							die();
						} else {
							echo "Incorrect Username/Password!";
						}
					}
				} else {
					echo "Incorrect Username/Password!";
				}
                $conn->close();
			}
			
			//$pwd .= $salt;
			//$hash = hash('sha256', $pwd);
			if (isset($_POST['button1'])) {
			    login($_POST['uname'], $_POST['pwd']);
			}
		?>
	    <form method="post">
		    <div class="container">
		        <label for="uname"><b>Username</b></label><br> 
		        <input type="text" placeholder="Enter Username" name="uname" required/><br><br>
				
				<label for="pwd"><b>Password</b></label><br>
		        <input type="password" placeholder="Enter Password" name="pwd" required/><br><br>
				
				<label>
					<input type="checkbox" checked="checked" name="remember">Remember me
				</label>
		        <br>
			    <input type="submit" name="button1" value="Submit"/>
			</div>
			
			<div class="container">
			    <a href="signup.php">Sign Up</a>
			</div>
		</form>
    </body>
</html>