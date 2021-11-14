<?php		
		
		echo "Testing Display Recipes<br><br>";
		
		$host = "localhost";
		$user = "root";
		$db_password = "Happy124face1!";
		$database = "tutorial";
		
		$cxn = mysqli_connect($host, $user, $db_password, $database);
		
		if (mysqli_connect_errno()) {
			echo "Failed to connect to database: ".mysqli_connect_errno();
			die();
		}
		
		$results_per_page = 10;
		
		$stmt = $cxn->prepare("SELECT * FROM Recipe");
		$stmt-> execute();
		
		$result = $stmt->get_result();
		$recipe = $result->fetch_assoc();
		
		if ($result->num_rows > 0) {
			echo "You have ".$result->num_rows." recipes <br>";
			
			while ($row = $recipe) {
				echo "ID: ".$row['id']." created ".$row['recipe_name']."<br>";
			}
		}
		else {
			echo "Fetch Failed<br>";
		}

?>