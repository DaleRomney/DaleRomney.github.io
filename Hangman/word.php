<?php
//Start a session
session_start();
?>
<!DOCTYPE html>
<head>
<title>Word upload</title>
</head>
<html
<body>
<?php
	
	function enterWord($word){
		
		$servername = "sql102.epizy.com";
		$username = "epiz_31690262";	
		$password = "hhsBKJaGCBKMP";
		$dbname = "epiz_31690262_dromney";
			
		$conn = new mysqli($servername, $username, $password, $dbname);
		
		//check connection
		if ($conn->connect_error){
			die("Connection failed: " . $conn->connection_error);
		}
		
		$sql = "INSERT INTO words (Word) VALUES ('" . $word . "')";
		if ($conn->query($sql) === TRUE) {
		   echo "New Entry";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	
	}
	
	if (isset($_POST['button1'])) {
			    enterWord($_POST['word']);
			}
	?>
	<form method="post">
		<div class="Container">
		    <label for="word"><b>Word</b></label><br> 
		    <input type="text" placeholder="Enter Word" name="word" required/><br><br>
			
			<input type="submit" name="button1" value="Submit"/>
		</div>
	</form>
</body>
</html>
