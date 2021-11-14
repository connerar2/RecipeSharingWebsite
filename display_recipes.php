<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<title>Page Title</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="Styles/display_recipe.css">


	<body>
		<div class="fiveReipces">

<?php		
		
		//echo "Testing Display Recipes<br><br>";
		
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
		
		while($row = $result->fetch_assoc()) {
			echo "<div class=\"recipe\">";
				echo"<h3>".$row['recipe_name']."</h3>";
				echo"<img class=\"recipeImage\" src=/".$row['meal_image']." alt=\"Image of the recipe\">";
				echo "<div>";
					echo "<p>".$row['description']."</p>";
				echo "</div>";
			echo "</div>";
		}
		echo "</div>";
		
		/*
		$recipe = $result->fetch_assoc();
		
		$possible_pages = ceil(result->nums_rows/$results_per_page);
		
		if(!isset($_GET['pn'])) {
			$pn = 1;
		}
		else {
			$pn = $_GET['pn']
		}
		
		
		echo "There are ".$possible_pages." possible pages<br>";
		
		if ($result->num_rows > 0) {
			echo "You have ".$result->num_rows." recipes <br>";
		}
		else {
			echo "Fetch Failed<br>";
		}
		*/

?>

</body>
</html>