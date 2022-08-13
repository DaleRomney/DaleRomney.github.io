# Hangman

In this program, we used PHP to play a game of Hangman where validation and the word was on the server side, so the client couldn't cheat and look at the client side code.
One of the issues I had with this project was displaying the word as you guess it. I still have yet to figure out how to properly display the php array.
 
 ```markdown
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
 ```
