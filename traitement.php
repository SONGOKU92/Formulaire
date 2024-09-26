<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);

$servername = "localhost";
$username = "";  // Votre nom d'utilisateur 
$password = "";  // Votre mdp
$dbname = "";  // Nom de votre base de donnée

// Connexion 
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connexion à la base de donnée réussie.<br>";
}

if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {
    $nom = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Affichage des valeurs
    echo "Nom: $nom, Email: $email, Message: $message<br>";

    
    $stmt = $conn->prepare("INSERT INTO tables (nom, email, message) VALUES (?, ?, ?)");  // Remplacer tables par le nom de votre table

    if (!$stmt) {
        die("Erreur de préparation: " . $conn->error);
    }

    $stmt->bind_param("sss", $nom, $email, $message);

    
    if ($stmt->execute()) {
        echo "Message enregistré avec succès.<br>";
    } else {
        echo "Erreur lors de l'insertion: " . $stmt->error . "<br>";
    }

    $stmt->close(); // Fermeture de la requete preparée
} else {
    echo "Données manquantes.<br>";
}

//Importation de PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    // Paramètres du serveur SMTP
    $mail->isSMTP();                                            
    $mail->Host       = 'smtp.example.com';  // Remplacer example par votre service de messagerie                    
    $mail->SMTPAuth   = true;                                   
    $mail->Username   = 'example@gmail.com';  // Votre email                
    $mail->Password   = 'Secret';            // Votre mot de passe des applications SMTP
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
    $mail->Port       = 465;                                   

    // Configuration de l'e-mail
    $mail->setFrom('from@example.com', 'tuto'); // Email d'envoi et objet du message
    $mail->addAddress('johndoe@gmail.com');     // Email destinataire

    $mail->isHTML(true);                                  
    $mail->Subject = 'Here is the subject';
    $mail->Body    = $message;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

$conn->close(); // Fermeture de la connexion à la base de données
?>
