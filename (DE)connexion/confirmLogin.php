<?php
$email = $_POST["username"];
$mdp = $_POST["password"];

function compteRebours() //fonction pour controler le temps d'inactivité d'un utilisateur
{
    $tempOffLimite = 300; //temps d'inactivité permis en secondes
    $tempActuel = time();
    $dureeCo = $tempActuel - $_SESSION["temps"];

    if($dureeCo >= $tempOffLimite && $input==0)
    {
        session_destroy();
    }
}

function verifieLecture($file)
{
    if(!$file)
    {
        die("Erreur Impossible d'ouvrir PATH, chemin non trouvé");
    }
}

function confirmationLogin($email, $mdp)
{
    $PATH = "../database/userList.txt";
    $utilisateurs = file($PATH, FILE_IGNORE_NEW_LINES); // Lire le fichier et stocker chaque ligne dans un tableau

    verifieLecture($utilisateurs);

    // Vérifier chaque ligne pour trouver une correspondance
    foreach ($utilisateurs as $utilisateur) {
        $info = explode(",", $utilisateur);
        if ($info[3] === $email && $info[1] === $mdp) {
            // Afficher chaque élément de la ligne correspondante
            foreach ($info as $element) {
                echo $element . "<br>";
            }
            session_start();
            $_SESSION["connecte"] = true;
            $_SESSION["pseudo"] = $info[0];
            $_SESSION["prenom"] = $info[2];
            $_SESSION["adressemail"] = $info[3];
            $_SESSION["nomdefamille"] = $info[4];
            $_SESSION["datedenaissance"] = $info[5];
            $_SESSION["genre"] = $info[6];
            $_SESSION["preference"] = $info[7];
            $_SESSION["typedutilisateur"] = $info[8];
            $email = $_SESSION['adressemail'];         
            $chemin_fichier = "../database/profil/".$email;
            $_SESSION["cheminImage"] = $chemin_fichier;
            if($_SESSION["typedutilisateur"] === "admin"){
            header("Location: ../Admin/Admin.php");
        }
            else{
               header("Location: welcome.php");
            }
            exit();
        }
    }

    // Si l'utilisateur n'est pas trouvé, rediriger vers la page de connexion
    header("Location:../index.html");
    exit();
}

// Vérifier si le formulaire est soumis avec des champs vides
if($mdp == "" || $email == "")
    header("Location:../index.html");

// Appeler la fonction pour vérifier l'authentification
confirmationLogin($email, $mdp);

session_start();
$_SESSION["duree"] = time();


echo "here";
?>
