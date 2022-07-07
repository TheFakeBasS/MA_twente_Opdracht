<form method="post">
<label for="gebruikersnaam">Gebruikersnaam</label>
<input type="text" id="gebruikersnaam" name="gebruikersnaam">
<label for="wachtwoord">Wachtwoord</label>
<input type="password" id="wachtwoord" name="wachtwoord">
<br />
<input type="submit" name="submit" value="login">
</form>

<?php
include 'functie.php';
include 'connect.php';

if (isset($_POST['submit'])) {

$gebruikersnaam = htmlspecialchars($_POST['gebruikersnaam']);
$wachtwoord = htmlspecialchars($_POST['wachtwoord']);

$foutmelding = controleerLegeInvoer($_POST);
if (!empty($foutmelding)) {
echo $foutmelding;
exit;
}

$loginGelukt = loginGebruiker($gebruikersnaam,$wachtwoord);
if ($loginGelukt){
echo "Login is gelukt";
session_start();
$_SESSION["ingelogd"]       = true;            
$_SESSION["gebruikersnaam"] = $gebruikersnaam;
header("location: index.php");
}
else
{
echo "Gebruikersnaam en/of wachtwoord is incorrect";
}
}
