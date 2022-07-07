
<?php

// Include config file
require_once "accountconfig.php";
require_once "functions.php";
 
// Define variables and initialize with empty values
$naam = $wachtwoord = $herhaal = "";
$name_err = $wachtwoord_err = $herhaal_err = "";
 
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
    
    $input_wachtwoord = test_input($_POST["wachtwoord"]);
    if(empty($input_wachtwoord)){
        $wachtwoord_err = "Vul a.u.b. een wachtwoord in.";     
    } else{
        $wachtwoord = $input_wachtwoord;
    }
    
    // validate herhaal
    if(empty($input_herhaal)){
        $herhaal_err = "Voer een wachtwoord in.";     
    } elseif($input_herhaal <> $input_wachtwoord){
        echo "Wachtwoord is niet identiek";
    } 
    else{
        $herhaal = $input_herhaal;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($wachtwoord_err) && empty($herhaal_err)){
        // Prepare an update statement
        $sql = "UPDATE medewerkeraccount SET naam=:naam, wachtwoord=:wachtwoord, herhaal=:herhaal WHERE id=:id";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":naam", $param_name);
            $stmt->bindParam(":wachtwoord", $param_wachtwoord);
            $stmt->bindParam(":herhaal", $param_herhaal);
            $stmt->bindParam(":id", $param_id);
            
            
            // Set parameters
            $param_name = $naam;
            $param_wachtwoord = $wachtwoord;
            $param_herhaal = $herhaal;
            $param_id = $id;
            
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
                header("location: accountconfig.php");
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
        $sql = "SELECT * FROM medewerkeraccount WHERE id = :id";
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
                    $wachtwoord = $row["wachtwoord"];
                    $herhaal = $row["herhaal"];
                    
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
                    <h2 class="mt-5">Update account</h2>
                    <p>Werk de waarden bij om een update op het account uit te voeren</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Naam</label>
                            <input type="text" name="naam" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $naam; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>wachtwoord</label>                            
                            <input type="text" name="wachtwoord" class="form-control <?php echo (!empty($wachtwoord_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $wachtwoord; ?>">
                            <span class="invalid-feedback"><?php echo $wachtwoord_err;?></span>
                        </div>
                      
                       
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="accountconfig.php" class="btn btn-secondary ml-2">annuleer</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>