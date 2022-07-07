<?php
// Include config file
require_once "faqconfig.php";
require_once "functions.php";
 
// Define variables and initialize with empty values
$naam = $vraag = $antwoord = $categorie = "";
$name_err = $vraag_err = $antwoord_err = $categorie_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate naam
    //$input_name = trim($_POST["naam"]);
    $input_name = test_input($_POST["naam"]);

    if(empty($input_name)){
        $name_err = "Vul a.u.b. een naam in.";
    } else{
        $naam = $input_name;
    }
    
      // Validate vraag  
      $input_vraag = test_input($_POST["vraag"]);

      if(empty($input_vraag)){
          $vraag_err = "Voer een vraag in.";     
      } else{
          $vraag = $input_vraag;
      }
      //validate antwoord
      $input_antwoord = test_input($_POST["antwoord"]);
  
      if(empty($input_antwoord)){
          $antwoord_err = "Voer een antwoord in.";     
      } else{
          $antwoord = $input_antwoord;
      }

      //categorie
      $input_categorie = test_input($_POST["categorie"]);
  
      if(empty($input_categorie)){
          $categorie_err = "Voer een categorie in.";     
      } else{
          $categorie = $input_categorie;
      }
      

      
      //echo var_dump($categorie) . "<br>"; 
    
    
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($vraag_err) && empty($antwoord_err) && empty($categorie_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO faqbeheer (naam, vraag, antwoord, categorie) VALUES (:naam, :vraag, :antwoord, :categorie)";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":naam", $param_name);
            $stmt->bindParam(":vraag", $param_vraag);
            $stmt->bindParam(":antwoord", $param_antwoord);
            $stmt->bindParam(":categorie", $param_categorie);
           
            
            // Set parameters
            $param_name = $naam;
            $param_vraag = $vraag;
            $param_antwoord = $antwoord;
            $param_categorie = $categorie;
          
           
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
                header("location: faqCRUD.php");
                exit();
            } else{
                echo "Oops! Iets is fout gegaan. Probeer later opnieuw.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($pdo);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create FAQ</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create FAQ</h2>
                    <p>Voer onderstaande velden in om een FAQ toe te voegen.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Naam</label>
                            <input type="text" name="naam" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $naam; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Vraag</label>                            
                            <input type="text" name="vraag" class="form-control <?php echo (!empty($vraag_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $vraag; ?>">
                            <span class="invalid-feedback"><?php echo $vraag_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Antwoord</label>
                            <input type="text" name="antwoord" class="form-control <?php echo (!empty($antwoord_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $antwoord; ?>">
                            <span class="invalid-feedback"><?php echo $antwoord_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Categorie</label>
                            <input type="text" name="categorie" class="form-control <?php echo (!empty($categorie_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $categorie; ?>">
                            <span class="invalid-feedback"><?php echo $categorie_err;?></span>
                        </div>
                       
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>