<?php
session_start();
$id = $_SESSION["p_id"];

if (isset($_POST['groupe'])) {
    $groupe = $_POST['groupe'];
    $_SESSION['groupe'] = $_POST['groupe'];
} else {
    $groupe = $_SESSION['groupe'];
}

$bdd = new PDO("mysql:host=localhost;dbname=kurs-selimiyecamii;charset=utf8", "root", "");
$req = $bdd->prepare("SELECT * FROM élèves AS e INNER JOIN groupe AS g ON e.id_groupe=g.id WHERE g.nom=?;");
$req->execute([$groupe]);
$data = $req->fetch();

$array = isset($_POST['presence']) ? $_POST['presence'] : array();





if (isset($_POST['submit'])) {

    $array = $_POST['presence'];

    foreach ($array as $id) {

        $array_id[] = $id;
    }




    $id_groupe = 0;
    switch ($groupe) {
        case 'Bronze':
            $id_groupe = 1;
            break;
        case 'Argent':
            $id_groupe = 2;
            break;
        case 'Or':
            $id_groupe = 3;
            break;
        case 'Diamant':
            $id_groupe = 4;
            break;
    }

    $req = $bdd->prepare("INSERT INTO appel (cours, id_groupe, id_professeur) VALUES(?, ?, ?)");
    $req->execute([$groupe, $id_groupe, $id]);

    $req = $bdd->prepare("SELECT * FROM appel ORDER BY id_cours DESC");
    $req->execute();
    $data = $req->fetch();
    $id_cours = $data['id_cours'];

    $req = $bdd->prepare("INSERT INTO joint (id_élève, id_cours, présence) VALUES(?, ?, ?)");

    $req1 = $bdd->prepare("SELECT * FROM élèves WHERE id_groupe=?");
    $req1->execute([$id_groupe]);
    $data1 = $req1->fetch();

    while ($data1 != NULL) {
        $check = 0;

        foreach ($array_id as $id_e) {
            if ($data1['id'] == $id_e) {
                $check = 1;
                break; // Ajoutez cette ligne pour sortir de la boucle dès qu'un match est trouvé
            }
        }


        if ($check == 1) {
            $req->execute([$data1['id'], $id_cours, 1]);
        } else {
            $req->execute([$data1['id'], $id_cours, 0]);
        }

        $data1 = $req1->fetch();
    }


    header('Location: notation.php');
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
            <th>Photo</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Groupe</th>
            <th>Présence</th>
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
            echo '<td><input type="checkbox" name="presence[]" value="' . $data['id'] . '"></td>';
            echo '</tr>';


            $data = $req->fetch();
        }
        ?>
        </tbody>
    </table>
    <input type="submit" name="submit" value="Enregistrer la présence">
    <div class="content">
        <a href="home.php" class="link-box">Annuler</a>
    </div>
</form>
</body>
</html>
