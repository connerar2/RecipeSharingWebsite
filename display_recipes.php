
<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<title>Page Title</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="Styles/display_recipe.css">

	<head>
		<form id="filter" method="get" action="">
			<input type="text" name="creator">
			<input type="submit" name="creator_search" value="Search">
		</form>
	</head>
	
	<body>
		
		<div class="topRecipes">

<?php		
		
		//access database
		$host = "localhost";
		$user = "root";
		$db_password = "Happy124face1!";
		$database = "tutorial";
		
		$cxn = mysqli_connect($host, $user, $db_password, $database);
		
		//check if connected
		if (mysqli_connect_errno()) {
			echo "Failed to connect to database: ".mysqli_connect_errno();
			die();
		}
		
		//check page
		if(!isset($_GET['pn'])) {
			$pn = 1;
		}
		else {
			$pn = $_GET['pn'];
		}
		
		//basic query
		$query = "SELECT * FROM Recipe";
		
		//edit query by filters
		if (isset($_GET['creator'])) {
			$query .= " WHERE owner = '".$_GET['creator']."'";
			//showPage($pn, $results_per_page, $query, $cxn);
		}
		else {
			//echo "No filter";
			//showPage($pn, $results_per_page, $query, $cxn);
		}
		
		//maximum results on a page
		$results_per_page = 3;
		
		//query
		$stmt = $cxn->prepare($query);
		$stmt-> execute();
		$rows = $stmt->get_result();
		
		//number of rows found
		$num_rows = mysqli_num_rows($rows);
		
		$page = ($pn - 1) * $results_per_page;
		
		$query .= " LIMIT ".$page.",".$results_per_page."";
		
		echo $query;
		
		//number of pages possible
		$possible_pages = ceil($num_rows / $results_per_page);
		
		if ($pn > $possible_pages || $pn < 1) {
			
			echo "<h1>This page cannot be found<h1>";
		}
		else {
			
			while($row = $rows->fetch_assoc()) {
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
		
/*
function showPage($pn, $results_per_page, $query, $cxn) {
		
			
			//$stmt = $cxn->prepare($query);
			//$stmt-> execute();
			//$result = $stmt->get_result();
			
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
		}
*/
?>



</body>
</html>