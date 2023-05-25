<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connexion à la base de données
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=agemcorporation", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "Erreur de connexion à la base de données: " . $e->getMessage();
        die();
    }

    // Vérification des données soumises
    if(isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['message'])) {
        $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

        // Validation des données soumises
        if(empty($nom) || empty($email) || empty($message))  {
            $response = array('status' => 'error', 'message' => 'Tous les champs sont obligatoires.');
            echo json_encode($response);
            die();
        } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response = array('status' => 'error', 'message' => 'Adresse email invalide.');
            echo json_encode($response);
            die();
        }

        // Insertion des données dans la base de données
        $stmt = $pdo->prepare("INSERT INTO formsiteinternet (nom, email, message) VALUES (:nom, :email, :message)");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':message', $message);
        $stmt->execute();

        // Envoi de la réponse
        $response = array('status' => 'success', 'message' => 'Message envoyé avec succès.');
        echo json_encode($response);
        die();
    } else {
        $response = array('status' => 'error', 'message' => 'Des données sont manquantes.');
        echo json_encode($response);
        die();
    }
}
?>
