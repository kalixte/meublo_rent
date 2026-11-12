<?php

require_once "../config/database.php";

$erreur = "";
$succes = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupérer les informations du formulaire
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';

    // Vérifier les champs obligatoires
    if (
        $nom === '' ||
        $prenom === '' ||
        $telephone === '' ||
        $email === '' ||
        $mot_de_passe === ''
    ) {
        $erreur = "Veuillez remplir tous les champs.";
    }

    // Vérifier le format de l'adresse e-mail
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "Adresse e-mail invalide.";
    }

    // Vérifier la longueur du mot de passe
    elseif (strlen($mot_de_passe) < 8) {
        $erreur = "Le mot de passe doit contenir au moins 8 caractères.";
    }

    else {

        // Vérifier si l'e-mail existe déjà
        $sql = "SELECT id_client FROM CLIENT WHERE email = :email";

        $requete = $connexion->prepare($sql);

        $requete->execute([
            ':email' => $email
        ]);

        if ($requete->fetch()) {
            $erreur = "Cette adresse e-mail est déjà utilisée.";
        }
        else {

    // Sécuriser le mot de passe
    $mot_de_passe_hash = password_hash(
        $mot_de_passe,
        PASSWORD_DEFAULT
    );

    // Préparer l'insertion du client
    $sql = "
        INSERT INTO CLIENT (
            nom,
            prenom,
            telephone,
            email,
            mot_de_passe
        )
        VALUES (
            :nom,
            :prenom,
            :telephone,
            :email,
            :mot_de_passe
        )
    ";

    $requete = $connexion->prepare($sql);

    // Enregistrer le client dans la base de données
    $requete->execute([
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':telephone' => $telephone,
        ':email' => $email,
        ':mot_de_passe' => $mot_de_passe_hash
    ]);

    $succes = "Votre compte a été créé avec succès !";
}
    }
}
require_once "../includes/header.php";
?>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow">

                <div class="card-body p-4">

                    <h2 class="text-center mb-4">
                        Créer un compte
                    </h2>
                    <?php if ($erreur !== ''): ?>

    <div class="alert alert-danger">
        <?= htmlspecialchars($erreur) ?>
    </div>

<?php endif; ?>

<?php if ($succes !== ''): ?>

    <div class="alert alert-success">
        <?= htmlspecialchars($succes) ?>
    </div>

<?php endif; ?>

                    <form method="POST" action="">

                        <div class="mb-3">
                            <label class="form-label">Nom</label>
                            <input
                                type="text"
                                name="nom"
                                class="form-control"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Prénom</label>
                            <input
                                type="text"
                                name="prenom"
                                class="form-control"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Téléphone</label>
                            <input
                                type="tel"
                                name="telephone"
                                class="form-control"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Adresse e-mail</label>
                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mot de passe</label>
                            <input
                                type="password"
                                name="mot_de_passe"
                                class="form-control"
                                required
                                minlength="8"
                            >
                        </div>

                        <button
                            type="submit"
                            class="btn btn-dark w-100"
                        >
                            S'inscrire
                        </button>

                    </form>

                    <p class="text-center mt-3">
                        Déjà inscrit ?
                        <a href="connexion.php">Se connecter</a>
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

<?php require_once "../includes/footer.php"; ?>