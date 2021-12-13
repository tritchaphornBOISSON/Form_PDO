<?php

require_once 'connect.php';

$pdo = new \PDO(DSN, USER, PASS);

$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friends = $statement->fetchAll(PDO::FETCH_ASSOC);

$firstname = "";
$lastname = "";


if (isset($_POST['submit'])) {
    if (isset($_POST['firstname']) && strlen($_POST['firstname']) < 45){
        $firstname = $_POST['firstname'];
    } else {
        $errorFirstname = 'Invalid firstname';
    }
    if (isset($_POST['lastname']) && strlen($_POST['lastname']) < 45){
        $lastname = $_POST['lastname'];
    }else {
        $errorLastname = 'Invalid lastname';
    }

    if (!$errorFirstname && !$errorLastname) {
        $query = "INSERT INTO `friend` (firstname, lastname) VALUES (:firstname, :lastname)";
        $statement = $pdo->prepare($query);

        $statement->bindValue(':firstname', $firstname);
        $statement->bindValue(':lastname', $lastname);

        $statement->execute();
        header("Location: /index.php");
    }


}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Friends</title>
</head>
<body>
<h2>List Of All Friends Characters </h2>

        <ul>
            <?php foreach($friends as $friend) {?>
            <li><?= $friend['firstname'] ?>  <?= $friend['lastname'] ?></li>

    <?php } ?>
        </ul>

<h2>Add New Friend</h2>
    <form action="index.php" method="POST">
        <label for="firstname">First name : </label>
        <input type="text" name="firstname" id="firstname" required><br>
        <label for="lastname">Last name : </label>
        <input type="text" name="lastname" id="lastname" required><br>
        <?php
        if (isset($errorFirstname)) {
            echo '<p>'.$errorFirstname.'</p>';
        }
        if (isset($errorLastname)) {
            echo '<p>'.$errorLastname.'</p>';
        }
        ?>
        <input type="submit" value="Submit" name="submit">

    </form>

</body>
</html>

