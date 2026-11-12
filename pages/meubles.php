
<?php

// Connexion à la base de données
require_once "../config/database.php";

// Récupération des meubles avec leur catégorie
$sql = "
    SELECT
        MEUBLE.id_meuble,
        MEUBLE.nom,
        MEUBLE.description,
        MEUBLE.prix_journalier,
        MEUBLE.quantite_stock,
        CATEGORIE.libelle AS categorie
    FROM MEUBLE
    INNER JOIN CATEGORIE
    ON MEUBLE.id_categorie = CATEGORIE.id_categorie
    ORDER BY MEUBLE.nom ASC
";

$requete = $connexion->query($sql);

$meubles = $requete->fetchAll();

// Inclusion de l'en-tête
require_once "../includes/header.php";

?>

<div class="container py-5">

    <h1 class="text-center mb-4">Nos meubles</h1>

    <div class="row">

        <?php if (count($meubles) > 0): ?>

            <?php foreach ($meubles as $meuble): ?>

                <div class="col-md-4 mb-4">

                    <div class="card h-100 shadow-sm">

                        <div class="card-body">

                            <h5 class="card-title">
                                <?= htmlspecialchars($meuble['nom']) ?>
                            </h5>

                            <p class="text-muted">
                                Catégorie :
                                <?= htmlspecialchars($meuble['categorie']) ?>
                            </p>

                            <p class="card-text">
                                <?= htmlspecialchars($meuble['description']) ?>
                            </p>

                            <p>
                                Prix journalier :
                                <strong>
                                    <?= number_format($meuble['prix_journalier'], 0, ',', ' ') ?>
                                    FCFA
                                </strong>
                            </p>

                            <p>
                                Quantité disponible :
                                <?= htmlspecialchars($meuble['quantite_stock']) ?>
                            </p>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <div class="alert alert-info text-center">
                Aucun meuble disponible pour le moment.
            </div>

        <?php endif; ?>

    </div>

</div>

<?php require_once "../includes/footer.php"; ?>
