<?php
session_start();

if (!isset($_SESSION["connecte"]) || $_SESSION["connecte"] !== true) {
    header("HTTP/1.1 403 Forbidden");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["profilEmail"])) {
    $userEmail = isset($_SESSION["adressemail"]) ? $_SESSION["adressemail"] : 'null';
    $profilEmail = isset($_POST["profilEmail"]) ? $_POST["profilEmail"] : 'null';

    $contactFile = "../database/contact.txt";
    $contactLine = $userEmail . ";" . $profilEmail . "\n";

    file_put_contents($contactFile, $contactLine, FILE_APPEND | LOCK_EX);
    echo "Success";
} else {
    header("HTTP/1.1 400 Bad Request");
    exit();
}
?>
