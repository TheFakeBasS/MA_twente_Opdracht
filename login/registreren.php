<form method="post">
<label for="gebruikersnaam">Gebruikersnaam</label>
<input type="text" id="gebruikersnaam" name="gebruikersnaam">
<label for="wachtwoord">Wachtwoord</label>
<input type="password" id="wachtwoord" name="wachtwoord">
<label for="wachtwoordherhaling">Herhaal het wachtwoord</label>
<input type="password" id="wachtwoordherhaling" name="wachtwoordherhaling">
<br />
<input type="submit" name="submit" value="registreer">
</form>

<?php
include 'functie.php';
include 'connect.php';

if (isset($_POST['submit'])) {
$gebruikersnaam = htmlspecialchars($_POST['gebruikersnaam']);
$wachtwoord = htmlspecialchars($_POST['wachtwoord']);
$wachtwoordherhaling = htmlspecialchars($_POST['wachtwoordherhaling']);


$invoerFout = controleerLegeInvoer($_POST);
$wachtwoordenFout = controleerWachtwoorden($wachtwoord,$wachtwoordherhaling);
if (!empty($invoerFout) || !empty($wachtwoordenFout) ) {
echo $invoerFout;
echo $wachtwoordenFout;
exit;
}
    
if(gebruikersnaamBeschikbaar($gebruikersnaam)){
    voegGebruikerToe($gebruikersnaam,$wachtwoord);
    echo "Gebruiker: $gebruikersnaam is toegevoegd.";
    }
    else{
    echo "Gebruikersnaam bestaat al<br>";
}
}
?>