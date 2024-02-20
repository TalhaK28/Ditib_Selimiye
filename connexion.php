<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Page de Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }


    </style>
</head>
<body>
<form method="post" action="">
    <h2>Connexion</h2>
    <label for="email">E-mail :</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password" required>

    <input name="submit" id="submit" type="submit" value="Se connecter"/>

</form>
</body>
</html>

<?php

if (isset($_POST["submit"])) {
    $mail = $_POST["email"];
    $password = $_POST["password"];

    session_start();
    $bdd = new PDO("mysql:host=localhost;dbname=kurs-selimiyecamii;charset=utf8", "root", "");
    $req = $bdd->prepare("SELECT id, mail, mot_de_passe FROM professeur;");
    $req->execute();
    $data = $req->fetch();

    $confirm = 0;

    while ($data != null) {
        if ($mail == $data['mail'] && $password == $data['mot_de_passe']) {
            $confirm = 1;
            // Stocker l'ID avant la fin de la boucle
            $_SESSION["p_id"] = $data['id'];
            break; // Sortir de la boucle une fois qu'une correspondance est trouvée
        }
        $data = $req->fetch();
    }

    if ($confirm == 1) {
        header('Location: home.php');
        exit();
    } else {
        echo '<script>alert("Adresse mail ou mot de passe incorrect !")</script>';
    }
}
?>

