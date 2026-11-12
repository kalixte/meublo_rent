
<?php

// Connexion à la base de données
require_once "../config/database.php";
$recherche = trim($_GET['recherche'] ?? '');
// Récupérer toutes les catégories
$sqlCategories = "SELECT * FROM CATEGORIE ORDER BY libelle ASC";

$categories = $connexion->query($sqlCategories)->fetchAll();
// Récupérer la catégorie choisie
$categorie = $_GET['categorie'] ?? '';

// Vérifier que l'identifiant est valide
if (!is_string($categorie) || !ctype_digit($categorie)) {
    $categorie = '';
}

// Récupération des meubles avec leur catégorie


$sql = "
    SELECT
        MEUBLE.id_meuble,
        MEUBLE.nom,
        MEUBLE.image,
        MEUBLE.description,
        MEUBLE.prix_journalier,
        MEUBLE.quantite_stock,
        CATEGORIE.libelle AS categorie
    FROM MEUBLE
    INNER JOIN CATEGORIE
    ON MEUBLE.id_categorie = CATEGORIE.id_categorie
";

$conditions = [];
$parametres = [];

// Filtre par nom de meuble
if ($recherche !== '') {

    $conditions[] = "
        MEUBLE.nom COLLATE utf8mb4_unicode_ci
        LIKE :recherche COLLATE utf8mb4_unicode_ci
    ";

    $parametres['recherche'] = '%' . $recherche . '%';
}

// Filtre par catégorie
if ($categorie !== '') {

    $conditions[] = "MEUBLE.id_categorie = :categorie";

    $parametres['categorie'] = (int) $categorie;
}

// Ajouter les conditions à la requête
if (!empty($conditions)) {

    $sql .= " WHERE " . implode(" AND ", $conditions);

}

// Trier les meubles
$sql .= " ORDER BY MEUBLE.nom ASC";

// Exécuter la requête
$requete = $connexion->prepare($sql);

$requete->execute($parametres);

$meubles = $requete->fetchAll();


// Inclusion de l'en-tête
require_once "../includes/header.php";

?>

<div class="container py-5">

    <h1 class="text-center mb-4">Nos meubles</h1>
    <div class="mb-4">
    <a href="../index.php" class="btn btn-outline-dark">
        ← Retour à l'accueil
    </a>
</div>




<form method="GET" action="meubles.php" class="mb-4">

    <div class="row g-2">

        <!-- Recherche par nom -->
        <div class="col-md-5">
            <input
                type="text"
                name="recherche"
                class="form-control"
                placeholder="Rechercher un meuble..."
                value="<?= htmlspecialchars($recherche) ?>"
            >
        </div>

        <!-- Filtre par catégorie -->
        <div class="col-md-5">
            <select name="categorie" class="form-select">

                <option value="">Toutes les catégories</option>

                <?php foreach ($categories as $cat): ?>

                    <option
                        value="<?= $cat['id_categorie'] ?>"
                        <?= $categorie == $cat['id_categorie'] ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($cat['libelle']) ?>
                    </option>

                <?php endforeach; ?>

            </select>
        </div>

        <!-- Bouton -->
        <div class="col-md-2">
            <button type="submit" class="btn btn-dark w-100">
                Filtrer
            </button>
        </div>

    </div>

</form>



    <div class="row">

        <?php if (count($meubles) > 0): ?>

            <?php foreach ($meubles as $meuble): ?>

                <div class="col-md-4 mb-4">

                   <div class="card h-100 shadow-sm">

    <?php if (!empty($meuble['image'])): ?>

        <img
            src="../<?= htmlspecialchars($meuble['image']) ?>"
            class="card-img-top"
            alt="<?= htmlspecialchars($meuble['nom']) ?>"
            style="height: 220px; object-fit: cover;"
        >

    <?php else: ?>

        <div class="text-center bg-light p-5">
            Photo non disponible
        </div>

    <?php endif; ?>

    <div class="card-body">
        <?php if ($meuble['quantite_stock'] > 0): ?>

    <span class="badge bg-success mb-2">
        Disponible
    </span>

<?php else: ?>

    <span class="badge bg-danger mb-2">
        Indisponible
    </span>

<?php endif; ?>

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

      <div class="mb-3">
    <small class="text-muted">Prix de location</small>

    <h4 class="text-primary fw-bold">
        <?= number_format($meuble['prix_journalier'], 0, ',', ' ') ?>
        FCFA
        <small class="text-muted fs-6">/ jour</small>
    </h4>
</div>

                            <p>
                                Quantité disponible :
                                <?= htmlspecialchars($meuble['quantite_stock']) ?>
                            </p>
<a
    href="details_meuble.php?id=<?= (int) $meuble['id_meuble'] ?>"
    class="btn btn-outline-dark w-100"
>
    Voir les détails
</a>
                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <div class="alert alert-info text-center">
                Aucun meuble ne correspond à votre recherche.
            </div>

        <?php endif; ?>

    </div>

</div>

<?php require_once "../includes/footer.php"; ?>
