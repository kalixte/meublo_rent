
<?php
// Démarrer la session avant tout affichage HTML
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../config/database.php";

$erreur = "";
$retour = $_GET['retour'] ?? '';
$id_meuble_retour = $_GET['id'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupérer les informations saisies
    $email = trim($_POST['email'] ?? '');
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';

    if ($email === '' || $mot_de_passe === '') {
        $erreur = "Veuillez remplir tous les champs.";
    } else {

        // Rechercher le client avec son adresse e-mail
        $sql = "
            SELECT id_client, nom, prenom, email, mot_de_passe
            FROM CLIENT
            WHERE email = :email
        ";

        $requete = $connexion->prepare($sql);

        $requete->execute([
            ':email' => $email
        ]);

        $client = $requete->fetch(PDO::FETCH_ASSOC);

        // Vérifier le mot de passe
        if ($client && password_verify($mot_de_passe, $client['mot_de_passe'])) {

            // Sécuriser l'identifiant de session
            session_regenerate_id(true);

            // Mémoriser les informations du client
            $_SESSION['id_client'] = $client['id_client'];
            $_SESSION['nom_client'] = $client['nom'];
            $_SESSION['prenom_client'] = $client['prenom'];

           // Vérifier si le client doit revenir sur une fiche meuble
if (
    $retour === 'details' &&
    filter_var($id_meuble_retour, FILTER_VALIDATE_INT) &&
    $id_meuble_retour > 0
) {
    header("Location: details_meuble.php?id=" . $id_meuble_retour);
    exit;
}

// Sinon, retourner à l'accueil
header("Location: ../index.php");
exit;

        } else {
            $erreur = "Adresse e-mail ou mot de passe incorrect.";
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

                    <h2 class="text-center mb-4">Connexion</h2>

                    <?php if ($erreur !== ''): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($erreur) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <input type="hidden" name="retour"
       value="<?= htmlspecialchars($retour) ?>">

<input type="hidden" name="id"
       value="<?= htmlspecialchars($id_meuble_retour) ?>">

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
                            >
                        </div>

                        <button type="submit" class="btn btn-dark w-100">
                            Se connecter
                        </button>

                    </form>

                    <p class="text-center mt-3">
                        Pas encore inscrit ?
                        <a href="inscriptin.php">Créer un compte</a>
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once "../includes/footer.php"; ?>

