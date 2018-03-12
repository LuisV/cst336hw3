<?php


if(isset($_GET['tag']))
{
    $tag= $_GET['tag'];
    $quantity = $_GET['quantity'];
    $type = $_GET['type'];
    $nutrition = $_GET['nutrition'];
    include './api/spoonacularAPI.php';
    
    
    
    


}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Recipe Finder</title>
        <link href = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel = "stylesheet">
       
        <style>
            @import url("./css/styles.css");
        </style>
        <link href="https://fonts.googleapis.com/css?family=EB+Garamond" rel="stylesheet">
    </head>
    <header>
        <h1>Recipe Search</h1>
    </header>
    <body>
        <form>
        <input type="text" name="tag" placeholder = "Keyword" value="<?=$_GET['tag']?>"/>
        Number of recipes: 
        <input type="number" name= "quantity" min="1" max= "3" value= "<?php echo $_GET['quantity']; ?>">
        </br>
        <input type="radio" id="searchIngredient" name="type" value="1" >
        <label for="Ingredient"></label><label for="searchIngredient">By Ingredient</label>        
        <input type="radio" id="searchType" name="type" value="2" checked>
        <label for="Category"></label><label for="searchType">By Category</label>
        <br/>    
        
        <input type="checkbox" id= "Nutrition" name="nutrition" value=1>
        <label for= "Nutrition">Show nutrition data</label>
        
        <input type="Submit" value="Search"/>
        </form>
        
        
        
        
        
        <?php
        if(empty($_GET)) { // form was not submitted
        echo"<h2> Type a keyword to search for a recipe. <br/> </h2> Seperate multiple ingredients by commas, no spaces.";
        } else { // form was submitted
        if(empty($tag))
        {
            echo "<h1>Please enter a search term</h1>";
        }
        else{
            
        
        if(empty($quantity))
        {
            echo "<h1>Please fill in quantity.</h1>";
        }
        else
        {
            echo "<h1 style= 'margin: 0'>You searched for: " . $_GET['tag']. "</h1>";
            //echo"!$quantity!";
        switch($type)
    {
        case 1:
            $recipe = ingredientSearch($_GET['tag'], $_GET['quantity']);
            break;
        case 2:
            $recipe = randomRecipe($_GET['tag'], $_GET['quantity']);  
            break;
    }
        //print_r($recipe);
        echo "<br/>";
        switch ($type) {
            case 1:
                    foreach ($recipe as $r) {
                        echo "<img src= '" . $r['image'] ."' alt= '".$r['title']."'><br/>";
                        echo $r['title'];
                        echo "<br/>";
                        if(!empty($nutrition))
                            visualizeData($r['id']);
                    }
                break;
            case 2:
                for ($k = 0; $k < $quantity; $k++) {
                echo "<img src= '" . $recipe['recipes'][$k]['image'] ."' alt= '".$recipe['recipes'][$k]['title']."'><br/>";
       
                echo $recipe['recipes'][$k]['title'];
                echo "<br/>";
                $i=1;
                echo "<div class= 'recipeInfo'>";
                foreach ($recipe['recipes'][$k]['extendedIngredients'] as $ingredient) {
                        echo "$i. " . $ingredient['originalString']."<br/>";
                        $i++;
                    }
                    echo "</div>";
                    if(!empty($nutrition))
                        visualizeData($recipe['recipes'][$k]['id']);
                }
        }
        
        
        
        }
        }
        }
        ?>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>    
</html>