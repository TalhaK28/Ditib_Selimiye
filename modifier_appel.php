<?php
session_start();
$id = $_SESSION["p_id"];


$bdd = new PDO("mysql:host=localhost;dbname=kurs-selimiyecamii;charset=utf8", "root", "");
$req = $bdd->prepare("SELECT * FROM appel AS a INNER JOIN groupe AS g ON a.id_groupe=g.Id INNER JOIN professeur 
    AS p ON a.id_professeur=p.id LIMIT 5;");
$req->execute();
$data= $req->fetch();

if(isset($_POST['modifier'])) {
    header('Location: modification.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appel</title>
    <link rel="stylesheet" href="style_appel.css">
</head>
<body>
<form method="post" action="">
    <table>
        <thead>
        <tr>
            <th>Groupe</th>
            <th>Date</th>
            <th>Professeur</th>
            <th>Modifier</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($data != NULL) {
            echo '<tr>';
            echo '<td>' . $data['cours'] . '</td>';
            echo '<td>' . $data['date'] . '</td>';
            echo '<td>' . $data['nom'] . " " . $data['prenom'] .'</td>';
            echo '<td><button type="submit" name="modifier" value="' . $data['id'] . '">Modifier</button></td>';
            echo '</tr>';


            $data = $req->fetch();
        }
        ?>
        </tbody>
    </table>
    <div class="content">
        <a href="home.php" class="link-box">Annuler</a>
    </div>
</form>
</body>
</html>

