
<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<title>Page Title</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="Styles/display_recipe.css">

	<head>
		<ul>
			<li><a href="index.html"><strong>Home</strong></a></li>
			<li><a href="login.php"><strong>Login</strong></a></li>
			<li><a href="add_recipe.html"><strong>Add Recipe</strong></a></li>
			<li><a href="display_recipes.php"><strong>View Recipes</strong></a></li>
		</ul>
		
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
		
		$query = "SELECT * FROM Recipe";
		
		//basic query
		if ($_GET['creator'] == "" && $_GET['ingredient'] == "") {
			$stmt = $cxn->prepare($query);
		}
		else {
			if ($_GET['creator'] != "" && $_GET['ingredient'] == "") {
				$query .= " where Recipe.owner = (?)";
				
				$stmt = $cxn->prepare($query);
				$stmt->bind_param("s", $_GET['creator']);
			}
			
			else if ($_GET['creator'] == "" && $_GET['ingredient'] != "") {
				$query .= " inner join recipe_ingredient on Recipe.id = recipe_ingredient.recipe_id 
				inner join Ingredients on Ingredients.ingredient = recipe_ingredient.ingredient
				where recipe_ingredient.ingredient = (?)";
				
				$stmt = $cxn->prepare($query);
				$stmt->bind_param("s", $_GET['ingredient']);
				
			}
			
			else {
				$query .=  " inner join recipe_ingredient on Recipe.id = recipe_ingredient.recipe_id 
				inner join Ingredients on Ingredients.ingredient = recipe_ingredient.ingredient 
				where Recipe.owner = (?) and recipe_ingredient.ingredient = (?)";
				
				$stmt = $cxn->prepare($query);
				$stmt->bind_param("ss",$_GET['creator'], $_GET['ingredient']);
			}
			
		}
		$stmt-> execute();
		$rows = $stmt->get_result();
		
		$num_rows = mysqli_num_rows($rows);
		
		//maximum results on a page
		
		$results_per_page = 10;
		
		$page = ($pn - 1) * $results_per_page;
		
		$query .= " LIMIT ".$page.",".$results_per_page."";
		
		$stmt = $cxn->prepare($query);
		
		if ($_GET['creator'] != "" && $_GET['ingredient'] == "") {
			$stmt->bind_param("s", $_GET['creator']);
		}
		else if ($_GET['creator'] == "" && $_GET['ingredient'] != "") {
			$stmt->bind_param("s", $_GET['ingredient']);
		}
		else {
			$stmt->bind_param("ss",$_GET['creator'], $_GET['ingredient']);
		}
		$stmt-> execute();
		$result = $stmt->get_result();
		
		
		//number of pages possible
		$possible_pages = ceil($num_rows / $results_per_page);
		
		if ($pn > $possible_pages || $pn < 1) {
			
			echo "<h1>This page cannot be found<h1>";
		}
		else {
			while($row = $result->fetch_assoc()) {
				echo "<div class=\"recipe\">";
				echo "<h3><a href=\"".$row['filename']."\">".$row['recipe_name']."</a></h3>";
					echo "By ".$row['owner'];
					echo"<img class=\"recipeImage\" src=/".$row['meal_image']." alt=\"Image of the recipe\">";
					echo "<div>";
						echo "<p id=\"description\">".$row['description']."</p>";
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
							$display_previous .= "&ingredient=".$_GET['ingredient'];
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
							$display_next .= "&ingredient=".$_GET['ingredient'];
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