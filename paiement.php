<?php
// Vérifie si le formulaire a bien été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sécurisation des données reçues
    $nom = htmlspecialchars($_POST['nom']);
    $telephone = htmlspecialchars($_POST['telephone']);
    $panier = $_POST['panier']; // JSON
    $total = htmlspecialchars($_POST['total']);

    // Convertir le panier JSON en tableau PHP
    $panierArray = json_decode($panier, true);

    // === 1️⃣ ENVOI D'UN MAIL DE NOTIFICATION ===
    $to = "tonemail@example.com"; // 👉 Remplace par ton adresse email
    $subject = "🛍️ Nouvelle commande Shop-Shap Babi";
    
    $message = "Une nouvelle commande vient d'être passée :\n\n";
    $message .= "👤 Client : $nom\n";
    $message .= "📞 Téléphone : $telephone\n";
    $message .= "💰 Total : $total FCFA\n\n";
    $message .= "🧾 Détails du panier :\n";
    foreach ($panierArray as $item) {
        $message .= "- " . $item['name'] . " : " . $item['price'] . " FCFA\n";
    }

    $headers = "From: Shop-Shap Babi <no-reply@shopshap.com>\r\n";

    // Envoi du mail
    mail($to, $subject, $message, $headers);

    // === 2️⃣ SAUVEGARDE EN FICHIER LOCAL (optionnel) ===
    $data = date("d/m/Y H:i:s") . " | Nom: $nom | Tel: $telephone | Total: $total | Panier: $panier\n";
    file_put_contents("commandes.txt", $data, FILE_APPEND);

    // === 3️⃣ REDIRECTION VERS LA PAGE DE CONFIRMATION ===
    header("Location: confirmation.html");
    exit();
} else {
    echo "⚠️ Accès non autorisé.";
}
?>
