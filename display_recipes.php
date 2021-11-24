
<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<title>Page Title</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="Styles/display_recipe.css">

	<head>
		<form id="filter" method="get" action="">
			<input type="text" name="creator" placeholder="Search Creator">
			<input type="text" name="ingredient" placeholder="Search Ingredient">
			<input type="submit" name="filter" value="Search">
		</form>
	</head>
	
	<body>
		
		<div class="topRecipes">

<?php		
		
		//access database info
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
		
		
		if (isset($_GET['ingredient'])) {
			$query = "select recipe_id from recipe_ingredient where ingredient=(?)";
			$stmt = $cxn->prepare($query);
			$stmt->bind_param("s", $_GET['ingredient']);
			$stmt-> execute();
			$filtered_by_ingredients = $stmt->get_result();
		}
		
		
		
		//basic query
		$query = "SELECT * FROM Recipe";
		
		
		//edit query by filters
		if (isset($_GET['creator'])) {
			$query .= " WHERE owner=(?)";
			
			
			if (isset($_GET['ingredient']) && $_GET['ingredient'] != "") {
				$query .= " and id in (";
				while ($row = $filtered_by_ingredients->fetch_assoc()) {
					$query .= $row['recipe_id'].",";
				}
				$query = substr($query, 0, -1);
				
				echo $query.")<br>";
			}
			
		}
		else {
			//no filter
		}
		
		//maximum results on a page
		
		$results_per_page = 3;
		
		$page = ($pn - 1) * $results_per_page;
		
		echo "Preparing Query <br>";
		//query
		$stmt = $cxn->prepare($query);
		$stmt->bind_param("s", $_GET['creator']);
		echo "About to execute<br>";
		$stmt-> execute();
		echo "Attempting to get results<br>";
		$rows = $stmt->get_result();
		
		//number of rows found
		echo "getting number of rows <br>";
		$num_rows = mysqli_num_rows($rows);
		echo "Rows: ".$num_rows."<br>";
		
		echo "Right before limiting query<br>";
		$query .= " LIMIT ".$page.",".$results_per_page."";
		
		echo $query."<br>";
		
		$stmt = $cxn->prepare($query);
		$stmt-> execute();
		$result = $stmt->get_result();
		
		echo "Got past here";
		
		
		//number of pages possible
		$possible_pages = ceil($num_rows / $results_per_page);
		
		if ($pn > $possible_pages || $pn < 1) {
			
			echo "<h1>This page cannot be found<h1>";
		}
		else {
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
						"echo no previous button pn = ".$pn."<br>";
						//No previous page button
					}
					else {
						$display_previous = "<a id=\"previous\" href=\"display_recipes.php?pn=".($pn - 1);
						
						if (isset($_GET['creator'])) {
							$display_previous .= "&creator=".$_GET['creator'];
						}
						
						$display_previous .= "\">Previous</a>";
						echo $display_previous;
					}
				echo "</div>";
				
				echo "<div id=\"nxt\">";
					if ($pn == ceil($rows->num_rows / $results_per_page)) {
						//No Next Button
					}
					else {
						$display_next = "<a id=\"next\" href=\"display_recipes.php?pn=".($pn + 1);
						
							if (isset($_GET['creator'])) {
							$display_next .= "&creator=".$_GET['creator'];
						}
						$display_next .= "\">Next</a>";
						
						echo $display_next;
						
					}
				echo "</div>";
			echo "</div>";
		}
?>



</body>
</html>