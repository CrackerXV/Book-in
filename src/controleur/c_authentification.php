<?php
// Connexion
if (isset($_POST['Connexion'])) {
    $emailUser = $_POST['emailUser'];
    $mdpUser = $_POST['mdpUser'];

    $unUser = $unControleur->verifConnexion($emailUser, $mdpUser);
    if ($unUser) {
        $_SESSION['idUser'] = $unUser['idUser'];
        $_SESSION['emailUser'] = $emailUser;
        $_SESSION['mdpUser'] = $mdpUser;
        $_SESSION['roleUser'] = $unUser['roleUser'];

        echo "<script>window.location.href = 'index.php?page=1';</script>";
    } else {
        echo "<br> Vérifier les identifiants.";
    }
}

// Inscription Particulier
if (isset($_POST['InscriptionParticulier'])) {
    $emailUser = $_POST['emailUser'];
    $mdpUser = $_POST['mdpUser'];
    $adresseUser = $_POST['adresseUser'];
    $nomUser = $_POST['nomUser'];
    $prenomUser = $_POST['prenomUser'];
    $dateNaissanceUser = $_POST['dateNaissanceUser'];
    $sexeUser = $_POST['sexeUser'];

    $result = $unControleur->selectEmail($emailUser);
    $resultEmail = $result[0][0] ?? null;

    if (empty($resultEmail)) {
        $resultParticulier = $unControleur->insertParticulier(
            $emailUser, $mdpUser, $adresseUser,
            $nomUser, $prenomUser, $dateNaissanceUser, $sexeUser
        );

        if ($resultParticulier) {
            echo "<div class='alert alert-success'>Inscription de $prenomUser $nomUser réussie !</div>";
        } else {
            echo "<div class='alert alert-danger'>Erreur lors de l'inscription de $prenomUser $nomUser !</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>L'email $emailUser est déjà utilisé !</div>";
    }
}

// Inscription Entreprise
if (isset($_POST['InscriptionEntreprise'])) {
    $emailUser = $_POST['emailUser'];
    $mdpUser = $_POST['mdpUser'];
    $adresseUser = $_POST['adresseUser'];
    $siretUser = $_POST['siretUser'];
    $raisonSocialeUser = $_POST['raisonSocialeUser'];
    $capitalSocialUser = $_POST['capitalSocialUser'];

    $result = $unControleur->selectEmail($emailUser);
    $resultEmail = $result[0][0] ?? null;

    if (empty($resultEmail)) {
        $resultEntreprise = $unControleur->insertEntreprise(
            $emailUser, $mdpUser, $adresseUser,
            $siretUser, $raisonSocialeUser, $capitalSocialUser
        );

        if ($resultEntreprise) {
            echo "<div class='alert alert-success'>Inscription de $raisonSocialeUser réussie !</div>";
        } else {
            echo "<div class='alert alert-danger'>Erreur lors de l'inscription de $raisonSocialeUser !</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>L'email $emailUser est déjà utilisé !</div>";
    }
}
?>

<!-- HTML Authentification -->
<div class="auth-main-container">
    <div class="auth-container">
        <div class="auth-section">
            <h2 class="auth-title">Inscription</h2>

            <div class="inscription-options">
                <a href="index.php?page=12&inscription=particulier">
                    <button class="auth-btn auth-btn-primary">Particulier</button>
                </a>
                <a href="index.php?page=12&inscription=entreprise">
                    <button class="auth-btn auth-btn-primary">Entreprise</button>
                </a>
            </div>

            <?php
            $inscription = $_GET['inscription'] ?? '';

            switch ($inscription) {
                case "particulier":
                    require_once("vue/auth/vue_inscription_particulier.php");
                    break;
                case "entreprise":
                    require_once("vue/auth/vue_inscription_entreprise.php");
                    break;
            }
            ?>
        </div>

        <br>

        <div class="auth-section">
            <h2 class="auth-title">Connexion</h2>
            <?php
            require_once("vue/auth/vue_connexion.php");
            ?>
        </div>
    </div>
</div>
