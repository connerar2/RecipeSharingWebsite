<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<title>Page Title</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="Styles/display_recipe.css">

	<head>
		<form id="filter" method="post" action="">
			<input type="text" name="creator">
			<input type="submit" name="creator_search" value="Search">
		</form>
	</head>
	
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
		
		$query = "SELECT * FROM Recipe";
		
		if (isset($_POST['creator'])) {
			$query += " WHERE owner = '".$_POST['creator']."'";
			echo $query."<br>";
		}
		
		$stmt = $cxn->prepare($query);
		$stmt-> execute();
		$rows = $stmt->get_result();
		
		$results_per_page = 10;
		
		$num_rows = mysqli_num_rows($rows);
		
		$possible_pages = ceil($num_rows / $results_per_page);
		
		if(!isset($_GET['pn'])) {
			$pn = 1;
		}
		else {
			$pn = $_GET['pn'];
		}
		
		if ($pn > $possible_pages || $pn < 1) {
			
			echo "<h1>This page cannot be found<h1>";
		}
else {
		
			$page = ($pn - 1) * $results_per_page;
			
			
			$stmt = $cxn->prepare("SELECT * FROM Recipe LIMIT ".$page.",".$results_per_page."");
			$stmt-> execute();
			$result = $stmt->get_result();
			
			while($row = $result->fetch_assoc()) {
				echo "<div class=\"recipe\">";
				echo "<h3><a href=\"Recipes/".$row['recipe_name'].".html\">".$row['recipe_name']."</a></h3>";
					echo"<img class=\"recipeImage\" src=/".$row['meal_image']." alt=\"Image of the recipe\">";
					echo "<div>";
						echo "<p>".$row['description']."</p>";
					echo "</div>";
				echo "</div>";
			}	
			echo "</div>";
			
			echo "<div class=\"prev_and_next\">";
				echo "<div id=\"prev\">";
					if ($pn == 1) {
						//No previous page button
					}
					else {
						echo "<a id=\"previous\" href=\"display_recipes.php?pn=".($pn - 1)."\">Previous</a>";
					}
				echo "</div>";
				
				echo "<div id=\"nxt\">";
					if ($pn == ceil($rows->num_rows / $results_per_page)) {
						//No Next Button
					}
					else {
						echo "<a id=\"next\" href=\"display_recipes.php?pn=".($pn + 1)."\">Next</a> ";
					}
				echo "</div>";
			echo "</div>";
		}


?>



</body>
</html>