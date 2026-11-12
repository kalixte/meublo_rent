
<?php

// Connexion à la base de données
require_once "config/database.php";

// Récupérer les 3 derniers meubles
$sqlAccueil = "
    SELECT
        MEUBLE.id_meuble,
        MEUBLE.nom,
        MEUBLE.image,
        MEUBLE.prix_journalier,
        MEUBLE.quantite_stock,
        CATEGORIE.libelle AS categorie
    FROM MEUBLE
    INNER JOIN CATEGORIE
        ON MEUBLE.id_categorie = CATEGORIE.id_categorie
    ORDER BY MEUBLE.id_meuble DESC
    LIMIT 3
";

$meublesAccueil = $connexion->query($sqlAccueil)->fetchAll();

// Inclusion de l'en-tête
require_once "includes/header.php";

?>

<!-- SECTION PRINCIPALE -->
<section class="hero-meuble py-5">
    <div class="container py-5">
        <div class="row align-items-center">

            <div class="col-lg-7 text-center text-lg-start">

                <span class="badge rounded-pill mb-3">
                    Bienvenue chez MEUBLE RENT
                </span>

                <h1 class="display-4 fw-bold">
                    Le meuble idéal,
                    <span>à portée de location.</span>
                </h1>

                <p class="lead mt-3">
                    Découvrez notre sélection de meubles et louez
                    facilement ceux qui correspondent à vos besoins.
                </p>

                <a href="pages/meubles.php"
                   class="btn btn-orange btn-lg mt-3">
                    Découvrir nos meubles
                </a>

            </div>

            <div class="col-lg-5 mt-4 mt-lg-0">
                <div class="hero-image">
                    <img
                        src="https://images.unsplash.com/photo-1600210492486-724fe5c67fb0"
                        alt="Salon moderne aménagé"
                        class="img-fluid rounded-4 shadow"
                    >
                </div>
            </div>

        </div>
    </div>
</section>


<!-- SECTION PRESENTATION -->
<section class="presentation-meuble py-5">
    <div class="container py-5">

        <div class="text-center mb-5">

            <span class="section-label">NOS AVANTAGES</span>

            <h2 class="fw-bold mt-2">
                Pourquoi choisir MEUBLE RENT ?
            </h2>

            <p class="text-muted">
                Une solution simple pour meubler votre espace.
            </p>

        </div>

        <div class="row g-4">

            <div class="col-md-4">
                <div class="card avantage-card h-100 text-center p-4">

                    <div class="avantage-icon">🛋️</div>

                    <h4 class="fw-bold mt-3">Large choix</h4>

                    <p>
                        Découvrez différentes catégories de meubles
                        adaptées à vos besoins.
                    </p>

                </div>
            </div>

            <div class="col-md-4">
                <div class="card avantage-card h-100 text-center p-4">

                    <div class="avantage-icon">📅</div>

                    <h4 class="fw-bold mt-3">Location simple</h4>

                    <p>
                        Choisissez vos meubles et organisez
                        votre période de location facilement.
                    </p>

                </div>
            </div>

            <div class="col-md-4">
                <div class="card avantage-card h-100 text-center p-4">

                    <div class="avantage-icon">📦</div>

                    <h4 class="fw-bold mt-3">Suivi des commandes</h4>

                    <p>
                        Retrouvez les informations concernant
                        vos commandes et vos locations.
                    </p>

                </div>
            </div>

        </div>
    </div>
</section>


<!-- SECTION MEUBLES POPULAIRES -->
<section class="meubles-populaires py-5">

    <div class="container py-4">

        <div class="text-center mb-5">

            <span class="section-label">NOTRE COLLECTION</span>

            <h2 class="fw-bold mt-2">
                Nos meubles disponibles
            </h2>

            <p class="text-muted">
                Découvrez quelques meubles de notre catalogue.
            </p>

        </div>

        <div class="row g-4">

            <?php if (count($meublesAccueil) > 0): ?>

                <?php foreach ($meublesAccueil as $meuble): ?>

                    <div class="col-md-4">

                        <div class="card meuble-card h-100">

                            <?php if (!empty($meuble['image'])): ?>

                                <img
                                    src="/meublo_rent/<?= htmlspecialchars($meuble['image']) ?>"
                                    class="card-img-top"
                                    alt="<?= htmlspecialchars($meuble['nom']) ?>"
                                >

                            <?php else: ?>

                                <div class="photo-indisponible">
                                    Photo non disponible
                                </div>

                            <?php endif; ?>

                            <div class="card-body">

                                <span class="badge bg-light text-dark mb-2">
                                    <?= htmlspecialchars($meuble['categorie']) ?>
                                </span>

                                <h5 class="fw-bold">
                                    <?= htmlspecialchars($meuble['nom']) ?>
                                </h5>

                                <h4 class="prix-meuble mt-3">

                                    <?= number_format($meuble['prix_journalier'], 0, ',', ' ') ?>

                                    FCFA

                                    <small>/ jour</small>

                                </h4>

                                <?php if ($meuble['quantite_stock'] > 0): ?>

                                    <span class="text-success">
                                        Disponible
                                    </span>

                                <?php else: ?>

                                    <span class="text-danger">
                                        Indisponible
                                    </span>

                                <?php endif; ?>

                                <a
                                    href="pages/details_meuble.php?id=<?= (int) $meuble['id_meuble'] ?>"
                                    class="btn btn-orange w-100 mt-3"
                                >
                                    Voir le meuble
                                </a>

                            </div>
                        </div>

                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="col-12">

                    <p class="text-center text-muted">
                        Aucun meuble n'est disponible pour le moment.
                    </p>

                </div>

            <?php endif; ?>

        </div>

        <div class="text-center mt-5">

            <a href="pages/meubles.php"
               class="btn btn-outline-dark btn-lg">

                Voir tous nos meubles

            </a>

        </div>

    </div>

</section>


<?php
require_once "includes/footer.php";
?>

