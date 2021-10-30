
<?php
	function writeHeader($file, $name) {
		fwrite($file, "<!DOCTYPE html>\n");
		fwrite($file, "<html lang=\"en\">\n");
		fwrite($file, "<meta charset=\"UTF-8\">\n");
		fwrite($file, "<title>".$name."</title>\n");
		fwrite($file, "<meta name=\"viewport\" content=\"width=device-width,initial-scale=1\">\n");
		fwrite($file, "<link rel=\"stylesheet\" href=\"../Styles/recipe.css\">\n"); //TODO Add css file
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
		fwrite($file, "\t\t\t<ol>\n");
		
		for ($i = 0; $i < count($instructions); $i++) {
			fwrite($file, "\t\t\t\t<li>".$instructions["$i"]."</li>\n");
		}
		fwrite($file, "\t\t\t</ol>\n");
		fwrite($file, "\t\t</div>\n");
	}
	
	function addImage($file, $img) {
		fwrite($file, "<div id=\"image_position\">\n");
		fwrite($file, "<img src=\"../Images/".basename($img)."\" alt=\"image of finished recipe\" id=\"image\">\n"); 
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
		
	    $recipefile = fopen('Recipes/'.$recipe_name.'.html', "w");
	
		$targetdir = "Images/";
		
		$targetfile = $targetdir.basename($image);
		
		$path = pathinfo($targetfile);
		fwrite($recipefile, "".$path['dirname']." ".$path['basename']."<br>");
			
		if (move_uploaded_file($_FILES['meal_image']['tmp_name'], $targetfile)) {
			fwrite($recipefile, "File uploaded");
		}
		else {
			fwrite($recipefile, "File not uploaded");
		}
		
		writeHeader($recipefile, $recipe_name);
		writeRecipeName($recipefile, $recipe_name);
		writeRecipeDescription($recipefile, $recipe_description);
		writePrepCookTime($recipefile, $prep_time, $cook_time);
		writeIngredients($recipefile, $ingredient_list);
		writeInstructions($recipefile, $instruction_list);
		addImage($recipefile, $image);
		writeCloser($recipefile);
		
		fclose($recipefile);
		
		header("Location: Recipes/".$recipe_name.".html");
		exit();
	}

?>
