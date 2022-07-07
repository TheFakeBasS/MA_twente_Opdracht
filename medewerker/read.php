
<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "accountconfig.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM medewerkeraccount WHERE id = :id";
    
    if($stmt = $pdo->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":id", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
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
                // URL doesn't contain valid id parameter. Redirect to error page
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
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Read account</title>
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
                    <h1 class="mt-5 mb-3">Read FAQ</h1>
                    <div class="form-group">
                        <label>Naam</label>
                        <p><b><?php echo $row["naam"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>wachtwoord</label>
                        <p><b><?php echo $row["wachtwoord"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Herhaal</label>
                        <p><b><?php echo $row["herhaal"]; ?></b></p>
                    </div>
                   
                    <p><a href="accounts.php" class="btn btn-primary">Terug</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>