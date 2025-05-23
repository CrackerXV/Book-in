<?php
if (!isset($_SESSION['emailUser'])) {
    echo "<h3 style='color: red;'>Vous devez être connecté pour accéder à cette page.</h3>";
} elseif (empty($isAdmin) || $isAdmin == 0) {
    require_once("controleur/controleur.class.php");
    $unControleur = new Controleur();

    $idUser = $_SESSION['idUser'];

    // Récupérer les données d'abonnement
    $abonnementData = $unControleur->selectDateAbonnement($idUser);
    $jourRestant = is_array($abonnementData) && isset($abonnementData[0]['jourRestant']) 
        ? $abonnementData[0]['jourRestant'] 
        : null;

    // Affichage abonnement
    if ($jourRestant === null || $jourRestant <= 0) {
        echo "<br> <h3> Vous n'avez pas d'abonnement en cours. </h3>";
    } else {
        echo "<h3> Votre abonnement prend fin dans $jourRestant jours. </h3>";
    }

    // Vue
    require_once("vue/abonnement/vue_abonnement.php");

    // Traitement abonnement selon la durée
    if (isset($_POST['Abonnement1m'])) {
        if ($jourRestant === null || $jourRestant < 0) {
            $success = $unControleur->insertAbonnement1m($idUser);
            $msg = $success ? "Souscription réussie à l'abonnement de 1 mois." : "Erreur : Impossible de souscrire.";
        } else {
            $success = $unControleur->updateAbonnement1m($idUser);
            $msg = $success ? "Modification réussie de l'abonnement actuel pour 1 mois." : "Erreur : Impossible de modifier.";
        }
        echo "<div class='alert " . ($success ? "alert-success" : "alert-danger") . "'>$msg</div>";
    }

    if (isset($_POST['Abonnement3m'])) {
        if ($jourRestant === null || $jourRestant < 0) {
            $success = $unControleur->insertAbonnement3m($idUser);
            $msg = $success ? "Souscription réussie à l'abonnement de 3 mois." : "Erreur : Impossible de souscrire.";
        } else {
            $success = $unControleur->updateAbonnement3m($idUser);
            $msg = $success ? "Modification réussie de l'abonnement actuel pour 3 mois." : "Erreur : Impossible de modifier.";
        }
        echo "<div class='alert " . ($success ? "alert-success" : "alert-danger") . "'>$msg</div>";
    }

    if (isset($_POST['Abonnement1a'])) {
        if ($jourRestant === null || $jourRestant < 0) {
            $success = $unControleur->insertAbonnement1a($idUser);
            $msg = $success ? "Souscription réussie à l'abonnement de 1 an." : "Erreur : Impossible de souscrire.";
        } else {
            $success = $unControleur->updateAbonnement1a($idUser);
            $msg = $success ? "Modification réussie de l'abonnement actuel pour 1 an." : "Erreur : Impossible de modifier.";
        }
        echo "<div class='alert " . ($success ? "alert-success" : "alert-danger") . "'>$msg</div>";
    }

    if (isset($_POST['ResilierAbonnement'])) {
        $success = $unControleur->updateAbonnement0($idUser);
        $msg = $success ? "Votre abonnement a été résilié avec succès." : "Erreur : Impossible de résilier l'abonnement.";
        echo "<div class='alert " . ($success ? "alert-success" : "alert-danger") . "'>$msg</div>";
    }

} else {
    echo "<h3 style='color: red;'>Page indisponible pour le rôle admin.</h3>";
}
