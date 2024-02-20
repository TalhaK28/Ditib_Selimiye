<?php
session_start();
$id = $_SESSION["p_id"];
$groupe = $_SESSION['groupe'];

$bdd = new PDO("mysql:host=localhost;dbname=kurs-selimiyecamii;charset=utf8", "root", "");
$req = $bdd->prepare("SELECT * FROM élèves AS e INNER JOIN groupe AS g ON e.id_groupe=g.id WHERE g.nom=?;");
$req->execute([$groupe]);
$data = $req->fetch();


$array_id = array();

$req1 = $bdd->prepare("UPDATE élèves SET note=note+? WHERE id=?;");

$i = 0;

if (isset($_POST['submit'])) {
    $array = $_POST['note'];

    while ($data != NULL) {
        $array_id[] = $data['id'];
        $req1->execute([$array[$i], $data['id']]);
        $i++;
        $data = $req->fetch();
    }

    header('Location: punition.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>notation</title>
    <link rel="stylesheet" href="style_appel.css">
</head>
<body>
<form method="post" action="">
    <h1>TEST1</h1>
    <table>
        <thead>
        <tr>
            <th>Photo</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Groupe</th>
            <th>Note</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($data != NULL) {
            echo '<tr>';
            echo '<td><img src="data:image/jpeg;base64,' . base64_encode($data['photo']) . '" alt="Image"></td>';
            echo '<td>' . $data['Nom'] . '</td>';
            echo '<td>' . $data['prenom'] . '</td>';
            echo '<td>' . $data['nom'] . '</td>';
            echo '<td><select id="niveau" name="note[]">
            <option value=0>-- Sélectionner --</option>
            <option value=0> </option>
            <option value=1>+</option>
            <option value=2>++</option>
            <option value=3>+++</option>
            <option value=5>☆</option>
        </select></td>';
            echo '</tr>';

            $data = $req->fetch();
        }
        ?>
        </tbody>
    </table>
    <input type="submit" name="submit" value="Enregistrer la notation">
    <div class="content">
        <a href="home.php" class="link-box">Annuler</a>
    </div>
</form>
</body>
</html>
