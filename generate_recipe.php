
<?php
	session_start();
	
	function writeHeader($file, $name) {
		fwrite($file, "<!DOCTYPE html>\n");
		fwrite($file, "<html lang=\"en\">\n");
		fwrite($file, "<head>\n");
		fwrite($file, "<meta charset=\"UTF-8\">\n");
		fwrite($file, "<title>".$name."</title>\n");
		fwrite($file, "<meta name=\"viewport\" content=\"width=device-width,initial-scale=1\">\n");
		fwrite($file, "<link rel=\"stylesheet\" href=\"../Styles/recipe.css\">\n");	
	}
	
	function writeNavBar($file) {
		fwrite($file, "<ul id=\"navbar\">\n");
		fwrite($file, "<li class=\"nav\"><a href=\"../index.html\"><strong>Home</strong></a></li>\n");
		fwrite($file, "<li class=\"nav\"><a href=\"../login.php\"><strong>Login</strong></a></li>\n");
		fwrite($file, "<li class=\"nav\"><a href=\"../add_recipe.html\"><strong>Add Recipe</strong></a></li>\n");
		fwrite($file, "<li class=\"nav\"><a href=\"../display_recipes.php\"><strong>View Recipes</strong></a></li>\n");
		fwrite($file, "</ul>\n");
		fwrite($file, "</head>\n");
		fwrite($file, "<body>\n");

	}
	
	function writeRecipeName($file, $name) {
		fwrite($file, "\t<div class=\"name\">\n");
		fwrite($file, "\t\t<div id=\"name_position\">\n");
		fwrite($file, "\t\t\t<h1 id=\"recipe_name\">".$name."</h1><br>\n");
		fwrite($file, "\t\t</div>\n");
	}
	
	function writeRecipeDescription($file, $description) {
		fwrite($file, "\t\t<div id=\"description_position\">\n");
		fwrite($file, "\t\t\t<p id=\"description\">".$description."<p>\n");
		fwrite($file, "\t\t</div>\n");
	}
	
	function writePrepCookTime ($file, $prep, $cook) {
		fwrite($file, "\t\t<div id=\"time_position\">\n");
		fwrite($file, "\t\t\t<strong>Prep Time: ".$prep." minutes</strong><br>\n");
		fwrite($file, "\t\t\t<strong>Cook Time: ".$cook." minutes</strong>\n");
		fwrite($file, "\t\t</div>\n");
	}
	
	function writeIngredients ($file, $ingredients) {
		fwrite($file, "\t\t<div id=\"ingredient_position\">\n");
		fwrite($file, "\t\t\t<h3>Ingredients</h3>\n");
		fwrite($file, "\t\t\t<ul style=\"list-style-type:none;\">\n");
		for ($i = 0; $i < count($ingredients); $i++) {
			fwrite($file, "\t\t\t\t<li>".$ingredients["$i"]."</li>\n");
		}
		fwrite($file, "\t\t\t</ul>\n");
		fwrite($file, "\t\t</div>\n");
	}
	
	function writeInstructions($file, $instructions) {
		fwrite($file, "\t\t<div id=\"instruction_position\">\n");
		fwrite($file, "\t\t\t<h3>Instructions</h3>\n");
		fwrite($file, "\t\t\t<ol id=\"instruction_list\">\n");
		
		for ($i = 0; $i < count($instructions); $i++) {
			fwrite($file, "\t\t\t\t<li>".$instructions["$i"]."</li>\n");
		}
		fwrite($file, "\t\t\t</ol>\n");
		fwrite($file, "\t\t</div>\n");
	}
	
	function addImage($file, $img) {
		fwrite($file, "<div id=\"image_position\">\n");
		fwrite($file, "<img src=\"../".$img."\" alt=\"image of finished recipe\" id=\"image\">\n"); 
		fwrite($file, "</div>\n");
	}
	
	function writeCloser($file) {
		fwrite($file, "\t</div>\n");
		fwrite($file, "</body>\n");
		fwrite($file, "</html>");
	}
	
	function validate($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = strip_tags($data);
			return $data;
	}
	
	if (isset($_POST['rname'])) {
		$recipe_name = validate($_POST['rname']);
		$recipe_description = validate($_POST['description']);
		$prep_time = $_POST['prep'];
		$cook_time = $_POST['cook'];
		$ingredient_list = $_POST['ingredient_list'];
		$instruction_list = $_POST['instruction_list'];
		
		$image = $_FILES['meal_image']['name'];
		
		$unique_id = uniqid();
		
		$recipe_file_name = 'Recipes/'.$_SESSION['username'].''.$unique_id.'.html';
		
		//Testing
	    $recipefile = fopen($recipe_file_name, "w");
	
		$targetdir = "Images/";
		
		
		$targetfile = $targetdir.str_replace(' ', '_', $unique_id.basename($image));
			
		if (move_uploaded_file($_FILES['meal_image']['tmp_name'], $targetfile)) {
			//File uploaded
		}
		else {
			//File no uploaded
		}
		
		//info for database
		$host = "localhost";
		$user = "root";
		$db_password = "";
		$database = "tutorial";
	
		//connect to database
		$cxn = mysqli_connect($host, $user, $db_password, $database);
		//check if connected, 
		if (mysqli_connect_errno()) {
			echo "Failed to connect to database: ".mysqli_connect_errno();
			die();
		}
		
		//Add recipe info to database
		$stmt = $cxn->prepare("INSERT INTO Recipe (owner, recipe_name, description, meal_image, filename) VALUES (?, ?, ?, ?, ?)");
		$stmt->bind_param("sssss",$_SESSION['username'], $recipe_name, $recipe_description,  $targetfile, $recipe_file_name);
		$stmt->execute();
		
		//get the inserted recipes ID value
		$query = "select id from Recipe where filename=(?)";
		$stmt = $cxn->prepare($query);
		$stmt-> bind_param("s", $recipe_file_name);
		$stmt->execute();
		$result = $stmt->get_result();
		
		while ($row = $result->fetch_assoc()) {
			$id = $row['id'];
		}
		
		foreach ($ingredient_list as $ingredient) {
			$possible_units = '/ (tsp|tbsp|oz|lb|cup|pinch|small|medium|large|gallon|quart|pint) /';
			$ingre = preg_split ($possible_units, $ingredient);
			
			$stmt = $cxn->prepare("SELECT (?) from Ingredients");
			$stmt-> bind_param("s", strtolower($ingre[1]));
			$stmt->execute();
			$result = $stmt->get_result();
			
			if($result->num_rows == 0) {
			
				//Add ingredient to database
				$stmt = $cxn->prepare("Insert INTO Ingredients (ingredient) value (?)");
				$stmt-> bind_param("s", strtolower($ingre[1]));
				$stmt->execute();
				
				//Add ingredient recipe id to junction table
				$stmt = $cxn->prepare("insert into recipe_ingredient (recipe_id, ingredient) values (?, ?)");
				$stmt->bind_param("is", $id, strtolower($ingre[1]));
				$stmt->execute();
			}
		}
		
		
		writeHeader($recipefile, $recipe_name);
		writeNavBar($recipefile);
		writeRecipeName($recipefile, $recipe_name);
		writeRecipeDescription($recipefile, $recipe_description);
		writePrepCookTime($recipefile, $prep_time, $cook_time);
		writeIngredients($recipefile, $ingredient_list);
		writeInstructions($recipefile, $instruction_list);
		addImage($recipefile, $targetfile);
		writeCloser($recipefile);
		
		fclose($recipefile);
		
		header("Location: ".$recipe_file_name);
		exit();
	}

?>
