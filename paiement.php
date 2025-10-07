<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = htmlspecialchars($_POST['nom']);
    $telephone = htmlspecialchars($_POST['telephone']);
    $panier = $_POST['panier'];
    $total = htmlspecialchars($_POST['total']);
    $panierArray = json_decode($panier, true);

    // === MAIL DE NOTIFICATION ===
    $to = "tonemail@example.com"; // ✅ Mets ton adresse email ici
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
    mail($to, $subject, $message, $headers);

    // === SAUVEGARDE EN FICHIER ===
    $data = date("d/m/Y H:i:s") . " | Nom: $nom | Tel: $telephone | Total: $total | Panier: $panier\n";
    file_put_contents("commandes.txt", $data, FILE_APPEND);

    // === ENVOI D'UNE NOTIFICATION WHATSAPP ===
    $numero = "2250102030405"; // ✅ Ton numéro WhatsApp (format international, sans +)
    $apiKey = "1234567"; // ✅ Mets ta clé CallMeBot ici

    $whatsappMessage = "🛍️ Nouvelle commande Shop-Shap Babi !%0A"
        . "👤 $nom%0A"
        . "📞 $telephone%0A"
        . "💰 $total FCFA";

    $url = "https://api.callmebot.com/whatsapp.php?phone=$numero&text=$whatsappMessage&apikey=$apiKey";

    // Appel API
    $response = file_get_contents($url);

    // Redirection
    header("Location: confirmation.html");
    exit();
} else {
    echo "⚠️ Accès non autorisé.";
}
?>
