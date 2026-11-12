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

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card shadow">

                <!-- Image du meuble -->
                <div class="card-body text-center">

                    <?php if (!empty($meuble['image'])): ?>

                        <img
                            src="../<?= htmlspecialchars($meuble['image']) ?>"
                            class="img-fluid rounded mb-4"
                            style="max-height: 350px;"
                            alt="<?= htmlspecialchars($meuble['nom']) ?>"
                        >

                    <?php else: ?>

                        <p class="text-muted">Image non disponible</p>

                    <?php endif; ?>

                    <!-- Nom du meuble -->
                    <h2 class="fw-bold">
                        <?= htmlspecialchars($meuble['nom']) ?>
                    </h2>
                    <p class="text-muted">
    Catégorie :
    <strong><?= htmlspecialchars($meuble['categorie']) ?></strong>
</p>

                    <!-- Description -->
                    <p class="text-muted mt-3">
                        <?= nl2br(htmlspecialchars($meuble['description'])) ?>
                    </p>

                    <hr>

                    <!-- Prix -->
                    <h4 class="text-success">
                        <?= number_format($meuble['prix_journalier'], 0, ',', ' ') ?> FCFA / jour
                    </h4>

                    <!-- Quantité disponible -->
                    <div class="mt-3">

    <p>
        Quantité disponible :
        <strong>
            <?= htmlspecialchars($meuble['quantite_stock']) ?>
        </strong>
    </p>

    <?php if ($meuble['quantite_stock'] > 0): ?>

        <span class="badge bg-success">
            Ce meuble est disponible à la location
        </span>

    <?php else: ?>

        <span class="badge bg-danger">
            Ce meuble est actuellement indisponible
        </span>

    <?php endif; ?>

</div>

                    <a href="meubles.php" class="btn btn-secondary mt-3">
                        Retour aux meubles
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<?php require_once "../includes/footer.php"; ?>s