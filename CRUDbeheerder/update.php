<?php

// Include config file
require_once "faqconfig.php";
require_once "functions.php";
 
// Define variables and initialize with empty values
$naam = $vraag = $antwoord = $categorie = "";
$name_err = $vraag_err = $antwoord_err = $categorie_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate naam
    $input_name = test_input($_POST["naam"]);
    if(empty($input_name)){
        $name_err = "Vul a.u.b. een naam in.";
    
    } else{
        $naam = $input_name;
    }
    
    // Validate vraag        
    
    $input_vraag = test_input($_POST["vraag"]);
    if(empty($input_vraag)){
        $vraag_err = "Vul a.u.b. een vraag in.";     
    } else{
        $vraag = $input_vraag;
    }
    
    // Validate antwoord        
    $input_antwoord = test_input($_POST["antwoord"]);
    if(empty($input_antwoord)){
        $antwoord_err = "
        Vul a.u.b. het antwoord in";         
    } else{
        $antwoord = $input_antwoord;
    }

    // Validate categorie      
    $input_categorie = test_input($_POST["categorie"]);
    if(empty($input_categorie)){
        $categorie_err = "
        Vul a.u.b. een categorie in";         
    } else{
        $categorie = $input_categorie;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($vraag_err) && empty($antwoord_err) && empty($categorie_err)){
        // Prepare an update statement
        $sql = "UPDATE faqbeheer SET naam=:naam, vraag=:vraag, antwoord=:antwoord categorie=:categorie WHERE id=:id";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":naam", $param_name);
            $stmt->bindParam(":vraag", $param_vraag);
            $stmt->bindParam(":antwoord", $param_antwoord);
            $stmt->bindParam(":id", $param_id);
            $stmt->bindParam(":categorie", $param_categorie);
            
            // Set parameters
            $param_name = $naam;
            $param_vraag = $vraag;
            $param_antwoord = $antwoord;
            $param_id = $id;
            $param_categorie = $categorie;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
                header("location: faqCRUD.php");
                exit();
            } else{
                echo "Oops! Iets ging fout. Probeer later opnieuw.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($pdo);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM faqbeheer WHERE id = :id";
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":id", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                    // Retrieve individual field value
                    $naam = $row["naam"];
                    $vraag = $row["vraag"];
                    $antwoord = $row["antwoord"];
                    $categorie = $row["categorie"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Iets ging fout. Probeer later opnieuw.";
            }
        }
        
        // Close statement
        unset($stmt);
        
        // Close connection
        unset($pdo);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                    <h2 class="mt-5">Update FAQ</h2>
                    <p>Werk de waarden bij om een update op het FAQ uit te voeren</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Naam</label>
                            <input type="text" name="naam" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $naam; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Straat</label>                            
                            <input type="text" name="vraag" class="form-control <?php echo (!empty($vraag_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $vraag; ?>">
                            <span class="invalid-feedback"><?php echo $vraag_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Plaats</label>                            
                            <input type="text" name="antwoord" class="form-control <?php echo (!empty($antwoord_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $antwoord; ?>">
                            <span class="invalid-feedback"><?php echo $antwoord_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>categorie</label>
                            <input type="text" name="categorie" class="form-control <?php echo (!empty($categorie_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $categorie; ?>">
                            <span class="invalid-feedback"><?php echo $categorie_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="faqCRUD.php" class="btn btn-secondary ml-2">annuleer</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>