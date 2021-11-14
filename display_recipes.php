<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<title>Page Title</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="Styles/display_recipe.css">


	<body>
		<div class="topRecipes">

<?php		
		$host = "localhost";
		$user = "root";
		$db_password = "Happy124face1!";
		$database = "tutorial";
		
		$cxn = mysqli_connect($host, $user, $db_password, $database);
		
		if (mysqli_connect_errno()) {
			echo "Failed to connect to database: ".mysqli_connect_errno();
			die();
		}
		
		$stmt = $cxn->prepare("SELECT * FROM Recipe");
		$stmt-> execute();
		$rows= $stmt->get_result();
		
		$results_per_page = 10;
		
		$possible_pages = ceil($rows->nums_rows/$results_per_page);
		
	
		if(!isset($_GET['pn'])) {
			$pn = 1;
		}
		else {
			$pn = $_GET['pn'];
		}
		
		$page = ($pn - 1) * $results_per_page;
		
		
		$stmt = $cxn->prepare("SELECT * FROM Recipe LIMIT ".$page.",".$results_per_page."");
		$stmt-> execute();
		$result = $stmt->get_result();
		
		/*
		if ($result->num_rows > 0) {
			echo "Found ".$result->num_rows." rows";
		}
		else {
			echo "No rows found";
		}
		
		while($row = $result->fetch_assoc()) {
			echo "<div class=\"recipe\">";
			echo "<h3><a href=\"Recipes/".$row['recipe_name'].".html\">".$row['recipe_name']."</a></h3>";
				echo"<img class=\"recipeImage\" src=/".$row['meal_image']." alt=\"Image of the recipe\">";
				echo "<div>";
					echo "<p>".$row['description']."</p>";
				echo "</div>";
			echo "</div>";
		*/
		
		echo "Test";
		echo "</div>";


?>

</body>
</html>