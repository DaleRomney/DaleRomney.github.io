<?php

session_start();
?>

<!DOCTYPE html>
<title>Hangman Game</title>

<html>
<body>
	<?php
		
		if(!isset($_SESSION['random'])){
	        $_SESSION['random'] = rand(8,27);
			//echo $_SESSION['random'];
        }
		
		if(!isset($_SESSION['correctGuesses'])){
	            $_SESSION['correctGuesses'] = 0;
            }
			
		if(!isset($_SESSION['attempts'])){
			$_SESSION['attempts'] = 0;
		}
		
		if(!isset($_SESSION['guesses'])){
			$_SESSION['guesses'] = array();
		}
			
		$servername = "sql102.epizy.com";
		$username = "epiz_31690262";
		$password = "hhsBKJaGCBKMP";
		$dbname = "epiz_31690262_dromney";
		
		$conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
		
		$sql = "SELECT Word FROM words WHERE Id = " . $_SESSION['random'] . "";
		$sqlResult = $conn->query($sql);
		while($row = $sqlResult->fetch_assoc()){
			$_SESSION['word'] = $row['Word'];
		}
		
		//echo "" . $_SESSION['word'] . "<br>";
		
		
		
		function theGame($guess, $word){
			
			$length = strlen($word);
			$isCorrect = false;
			for($i = 0; $i < $length; $i++){
				if($word[$i] == $guess){
					$_SESSION['guesses'][$i] = $guess;
					$_SESSION['correctGuesses']++;
					echo "" . $guess . " is a correct guess.<br>";
					echo "Correct guesses: " . $_SESSION['correctGuesses'] . "<br>";
					foreach($_SESSION['guesses'] as $g){
						echo $g . " ";
					}
					$isCorrect = true;
				}
			}
			
			if($_SESSION['correctGuesses'] == $length){
				echo "Congratulations, you guessed the word correclty " . $data . ".<br>";
				
				$servername = "sql102.epizy.com";
				$username = "epiz_31690262";
				$password = "hhsBKJaGCBKMP";
				$dbname = "epiz_31690262_dromney";
				
				$conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                  die("Connection failed: " . $conn->connect_error);
                }
  
                $sql = "INSERT INTO hiscore (Username, Hiscore, Wordlength) VALUES('" . $_SESSION['uname'] . "', '" . $_SESSION['attempts'] . "', '" . $length . "')";
				// $result = $conn->query($sql);
				
				if ($conn->query($sql) === TRUE){
                    echo "Logged score<br>";
                } else {
                    echo "Failed to log score<br>";
                }
				
				echo "<h1>Hi Scores, golf style!</h1>";
				
				$sqlScores = "SELECT * FROM hiscore WHERE Wordlength = " . $length . " ORDER BY Hiscore ASC";
				
				$slqResult = $conn->query($sqlScores);
					while($row = $slqResult->fetch_assoc()){
						echo "Username: " . $row["Username"] . "<br> Score: " . $row["Hiscore"] . "<br>";
					}
				
                $conn->close();
				
				unset($_SESSION['random']);
				unset($_SESSION['correctGuesses']);
				unset($_SESSION['attempts']);
				unset($_SESSION['word']);
				unset($_SESSION['uname']);
				unset($_SESSION['guesses']);
			}
			
			if($isCorrect == false){	
				echo "Incorrect Guess.<br>";
				foreach($_SESSION['guesses'] as $g){
					echo $g . " ";
				}
				$_SESSION['attempts']++;
				if($_SESSION['attempts'] == 10){
					echo "I'm sorry but you have hung your man.<br>";
					echo "Your word was " . $_SESSION['word'] . "<br>";
					unset($_SESSION['word']);
					unset($_SESSION['random']);
					unset($_SESSION['correctGuesses']);
					unset($_SESSION['attempts']);
					unset($_SESSION['uname']);
					unset($_SESSION['guesses']);
				}
			}
			
			return $array;
		}
		
		
		if (isset($_POST['button1'])) {
			theGame($_POST['guess'], $_SESSION['word']);
		}
		
		if (isset($_POST['button2'])){
				unset($_SESSION['random']);
				unset($_SESSION['correctGuesses']);
				unset($_SESSION['attempts']);
				unset($_SESSION['word']);
				unset($_SESSION['uname']);
				unset($_SESSION['guesses']);
		}
	?>
	
	<form method = "post">
		    <label for="guess"><b>Guess</b></label><br> 
		    <input type="text" name="guess" required/><br><br>
			
			<input type="submit" name="button1" value="Guess"/>
			<a href="home.php">Logout</a>
		</form>
</body>
</html>