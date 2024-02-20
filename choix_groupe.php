<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="header">
    <img class="logo" src="logo.png" alt="Logo">
    <div class="title-container">
        <h1 class="title">Ditib - Selimiye Camii</h1>
    </div>
</div>

<form method="post" action="appel.php">

    <label for="groupe">Choisisser un groupe :</label>

    <select id="groupe" name="groupe">
        <?php
        $bdd = new PDO("mysql:host=localhost;dbname=kurs-selimiyecamii;charset=utf8", "root", "");
        $req = $bdd->prepare("SELECT nom FROM groupe;");
        $req->execute();
        $data = $req->fetch();

        while($data!=NULL) {


            echo '
        <option value=' . $data['nom'] . ' >' . $data['nom'] . '</option>';
            $data = $req->fetch();
        }
        ?>

    </select>
    <input  type="submit" name="choisir" value="choisir"></input
</form>

<div class="content">
    <p>Cliquez sur le lien ci-dessous pour revenir au home .</p>
    <a href="home.php" class="link-box">home</a>
</div>
</body>
</html>