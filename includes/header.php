
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>MEUBLE RENT</title>

    <!-- Bootstrap 5.3.9 installé avec npm -->
    <link rel="stylesheet" href="/meublo_rent/assets/bootstrap.min.css">

    <!-- Notre CSS personnalisé -->
    <link rel="stylesheet" href="/meublo_rent/assets/CSS/style.css">

</head>

<body>

<!-- Barre de navigation -->
<nav class="navbar navbar-expand-lg navbar-meuble sticky-top">
    <div class="container">

        <!-- Logo et nom -->
        <a class="navbar-brand fw-bold" href="/meublo_rent/index.php">
            <span class="logo-icon">M</span>
            MEUBLE RENT
        </a>

        <!-- Bouton pour mobile -->
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#menuPrincipal"
            aria-controls="menuPrincipal"
            aria-expanded="false"
            aria-label="Ouvrir le menu"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Liens de navigation -->
        <div class="collapse navbar-collapse" id="menuPrincipal">

            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">

                <li class="nav-item">
                    <a class="nav-link active" href="/meublo_rent/index.php">
                        Accueil
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/meublo_rent/pages/meubles.php">
                        Nos meubles
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/meublo_rent/pages/connexion.php">
                        Connexion
                    </a>
                </li>

                <li class="nav-item">
                    <a class="btn btn-orange" href="/meublo_rent/pages/inscriptin.php">
                        Créer un compte
                    </a>
                </li>

            </ul>

        </div>
    </div>
</nav>
