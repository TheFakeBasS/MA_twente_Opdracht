<?php
// Include config file
require_once "accountconfig.php";
require_once "functions.php";
 
// Define variables and initialize with empty values
$naam = $wachtwoord = $herhaal = "";
$name_err = $wachtwoord_err = $herhaal_err = "";
 
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
    
      // Validate wachtwoord  
      $input_wachtwoord = test_input($_POST["wachtwoord"]);

      if(empty($input_wachtwoord)){
          $wachtwoord_err = "Voer een wachtwoord in.";     
      } else{
          $wachtwoord = $input_wachtwoord;
      }
      //validate herhaal
      $input_herhaal = test_input($_POST["herhaal"]);
  
      if(empty($input_herhaal)){
          $herhaal_err = "Voer een wachtwoord in.";     
      } 
      elseif($input_herhaal <> $input_wachtwoord){
          echo "Wachtwoord is niet identiek";
      } 
      else{
          $herhaal = $input_herhaal;
      }

      

      
      //echo var_dump($categorie) . "<br>"; 
    
    
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($wachtwoord_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO medewerkeraccount (naam, wachtwoord, herhaal) VALUES (:naam, :wachtwoord, :herhaal)";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":naam", $param_name);
            $stmt->bindParam(":wachtwoord", $param_wachtwoord);
            $stmt->bindParam(":herhaal", $param_herhaal);
           
            
            // Set parameters
            $param_name = $naam;
            $param_wachtwoord = $wachtwoord;
            $param_herhaal = $herhaal;
          
           
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
                header("location: accounts.php");
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
    <title>Create account</title>
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
                    <h2 class="mt-5">Create account</h2>
                    <p>Voer onderstaande velden in om een account toe te voegen.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Naam</label>
                            <input type="text" name="naam" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $naam; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Wachtwoord</label>                            
                            <input type="text" name="wachtwoord" class="form-control <?php echo (!empty($wachtwoord_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $wachtwoord; ?>">
                            <span class="invalid-feedback"><?php echo $wachtwoord_err;?></span>
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