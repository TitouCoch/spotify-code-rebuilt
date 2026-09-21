<?php
session_start();

//On récupère les variables transmis par la méthode POST
$mail = htmlspecialchars($_POST['email']);
$passwd = $_POST['passwd'];

//Connexion à la base de donnée
require_once __DIR__ . '/../config/database.php';
$conn = getConnection();

//On verifie que l'email est valide
//Vérification de l'existence de la licence
$req = "SELECT * FROM inscrit WHERE mail=:mail";
$req = $conn->prepare($req);
$req->execute(['mail'=>$mail]);
$res = $req->fetchAll();
if(count($res)==1){
    //L'email est valide
    //LES VERIFICATION SONT SUCCINTE CAR C'EST UNE VERSION TEST DU PROJET
    //On vérifie que le mot de passe correspond à l'email
    $req = "SELECT mdp FROM inscrit WHERE mail=:mail";
    $req = $conn->prepare($req);
    $req->execute(['mail'=>$mail]);
    $res = $req->fetch();
    if(password_verify($passwd, $res['mdp'])){
        //Le mot de passe est bon
        //On démarre la session
        $_SESSION['user'] = $mail;
        header('location: home.php');
        exit;
    }else{
        //Le mot de passe est faux
        header('location: login.php?err=passwd');
        exit;
    }
}else{
    //L'email n'est pas valide
    header('location: login.php?err=mail');
    exit;
}

?>