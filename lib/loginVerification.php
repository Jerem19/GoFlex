<?php
try {
    $bdd = new PDO('mysql:host=localhost;dbname=goflexdb;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$username = htmlspecialchars($_POST['username']);
$password = htmlspecialchars($_POST['password']);

$req = $bdd->prepare('SELECT password FROM userstable WHERE username = :username');
$req->execute(array(
    'username' => $username
));
$passworddatabase = $req->fetch();


$req = $bdd->prepare('SELECT role FROM userstable WHERE username = :username');
$req->execute(array(
    'username' => $username
));
$typeUser = $req->fetch();


//if(password_verify($password, $passCrypt[0])) {
if($password == $passworddatabase[0])
{
    session_start();
    $_SESSION['userStatus'] = "valide"; // if password changes ?
    $_SESSION['userType'] = $typeUser;
    $_SESSION['userName'] = $username;

    header("location: ../views/index.php");

    //header('Location: ../login.html');
} else {
    echo "<script>alert('Mot de passe incorrect'); document.location='../views/login.html' </script>";
}

$req->closecursor();

?>