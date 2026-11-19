<?php

// Connexion à la base de données
require_once "../config/database.php";

// Récupérer l'identifiant du meuble dans l'URL
$id_meuble = $_GET['id'] ?? null;

// Vérifier si un identifiant a été fourni
if (!$id_meuble || !filter_var($id_meuble, FILTER_VALIDATE_INT) || $id_meuble <= 0) {
    die("Meuble introuvable.");
}

// Préparer la requête SQL
$sql = "
    SELECT
        MEUBLE.*,
        CATEGORIE.libelle AS categorie
    FROM MEUBLE
    INNER JOIN CATEGORIE
        ON MEUBLE.id_categorie = CATEGORIE.id_categorie
    WHERE MEUBLE.id_meuble = :id
";

// Préparer et exécuter la requête
$stmt = $connexion->prepare($sql);
$stmt->execute([
    ':id' => $id_meuble
]);

// Récupérer les informations du meuble
$meuble = $stmt->fetch();

// Vérifier si le meuble existe
if (!$meuble) {
    die("Ce meuble n'existe pas.");
}

?>
<?php require_once "../includes/header.php"; ?>


<div class="container py-5">

    <div class="row g-4 align-items-center">

        <!-- Photo du meuble -->
        <div class="col-md-6">

            <div class="meuble-detail-image">

                <?php if (!empty($meuble['image'])): ?>

                    <img
                        src="../<?= htmlspecialchars($meuble['image']) ?>"
                        alt="<?= htmlspecialchars($meuble['nom']) ?>"
                    >

                <?php else: ?>

                    <div class="photo-indisponible">
                        Image non disponible
                    </div>

                <?php endif; ?>

            </div>

        </div>

        <!-- Informations du meuble -->
        <div class="col-md-6">

            <span class="badge bg-warning text-dark mb-3">
                <?= htmlspecialchars($meuble['categorie']) ?>
            </span>

            <h1 class="fw-bold mb-3">
                <?= htmlspecialchars($meuble['nom']) ?>
            </h1>

            <p class="text-muted">
                <?= nl2br(htmlspecialchars($meuble['description'])) ?>
            </p>

            <hr>

            <h2 class="prix-meuble mb-3">
                <?= number_format($meuble['prix_journalier'], 0, ',', ' ') ?>
                FCFA
                <small>/ jour</small>
            </h2>

            <p>
                Quantité disponible :
                <strong>
                    <?= htmlspecialchars($meuble['quantite_stock']) ?>
                </strong>
            </p>

            <?php if ($meuble['quantite_stock'] > 0): ?>

                <span class="badge bg-success mb-3">
                    Disponible à la location
                </span>

                <div>
                    <a href="../pages/inscriptin.php"
                       class="btn btn-orange">
                        Louer ce meuble
                    </a>
                </div>

            <?php else: ?>

                <span class="badge bg-danger mb-3">
                    Actuellement indisponible
                </span>

            <?php endif; ?>

            <a href="meubles.php"
               class="btn btn-outline-secondary mt-3">
                Retour aux meubles
            </a>

        </div>

    </div>

</div>


<?php require_once "../includes/footer.php"; ?>