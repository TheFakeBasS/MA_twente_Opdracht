<?php
include 'connection.php';
function geefinfoHtml($info)
{

    $html = '';
    foreach ($info as $key => $rij) {
        $vraag          = $rij["vraag"];
        $antwoord       = $rij["antwoord"];
        $categorie       = $rij["categorie"];

        $html .= "<tr><td>$vraag</td><td>$antwoord</td><td>$categorie</td></tr>";
    }

    return $html;
}

function toonAlleinfo()
{
    $sql        = "SELECT vraag, antwoord, categorie, hoeveelgevraagd
                    FROM faqbeheer
                    ORDER BY hoeveelgevraagd DESC";
                    
    $pdo = maakPDO();

    $result = $pdo->query($sql);
    $info = $result->fetchAll();

    echo geefinfoHtml($info);
}

function toonfaqvraag($categorie)
{

    $sql = "SELECT vraag, categorie, antwoord
            FROM faqbeheer
            WHERE categorie=:categorie ";

    $pdo = maakPDO();

    $statement = $pdo->prepare($sql);
    $statement->bindParam(":categorie", $param_categorie);
    $param_categorie = $categorie;
    $statement->execute();

    $vraag = $statement->fetchAll();
    echo geefinfoHtml($vraag);
}

function toonAlleCat()
{
    $sql        = "SELECT DISTINCT categorie
                   FROM faqbeheer
                   ORDER BY categorie";
    $pdo = maakPDO();

    $result = $pdo->query($sql);
    $categorie = $result->fetchAll();

    foreach ($categorie as $key => $rij) {
        $categorie = $rij["categorie"];
        echo "<a href=?categorie=$categorie>$categorie</a> | ";
        // echo $rij["categorie"];
    }
}
?>