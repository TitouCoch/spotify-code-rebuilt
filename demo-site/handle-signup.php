<?php
//On récupère les variables transmis par la méthode POST
$licence = htmlspecialchars($_POST['numLicence']);
$mail = htmlspecialchars($_POST['email']);
$passwd = $_POST['passwd'];

//Connexion à la base de donnée
require_once __DIR__ . '/../config/database.php';
$conn = getConnection();
//Vérification des inputs
//Vérification de l'existence de la licence
$req = "SELECT * FROM joueur WHERE licence=:licence";
$req = $conn->prepare($req);
$req->execute(['licence'=>$licence]);
$res = $req->fetchAll();
if(count($res) == 1){
    //La licence existe bel et bien
    //On vérifie que la licence n'est pas déjà utilisé pour un profil inscrit
    $req = "SELECT * FROM inscrit WHERE licence=:licence";
    $req = $conn->prepare($req);
    $req->execute(['licence'=>$licence]);
    $res = $req->fetchAll();
    if(count($res) == 0){
        //La licence n'est pas utilisé
        //DANS CETTE VERSION NOUS N'ALLONS PAS VERIFIER LA VALIDITER LE L'EMAIL NI DU MDP
        //Insertion dans la base de donnée -> Inscription
        $req = "INSERT INTO inscrit(licence, mail, mdp) VALUES(:licence, :mail, :mdp)";
        $req = $conn->prepare($req);
        $req->execute(['licence'=>$licence, 'mail'=>$mail, 'mdp'=>password_hash($passwd, PASSWORD_DEFAULT)]);
        //Redirection vers connexion
        header("Location: login.php");
        exit;
    }else{
        //La licence est utilisé
        //Redirection avec le paramètre erreur
        header("Location: signup.php?err=alreadyUse");
        exit;
    }
}else{
    //La licence n'existe pas
    //Redirection avec le paramètre erreur
    header("Location: signup.php?err=notExiste");
    exit;
}


?>