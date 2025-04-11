<!-- l'en-tête et la navigation-->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Forum des Étudiants de Maisonneuve</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="ressources/css/style.css">
</head>
<body>
    <!-- Entete de page --->
    <header>
       
        <nav>
            <div><img src="ressources/img/logo.png" alt="college maisonnouevre"></div>
                <ul>
                    <li><a href="?controller=forum&function=all_articles" class="<?= is_active('forum', 'all_articles', true) ?>">Accueil</a></li>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li><a href="?controller=forum&function=create" class="<?= is_active('forum', 'create') ?>">Créer un article</a></li>
                        <li><a href="?controller=forum&function=articlesUser" class="<?= is_active('forum', 'articlesUser') ?>">Mes articles</a></li>
                        <li><a href="?controller=utilisateur&function=logout">Déconnexion (<?= $_SESSION['user_nom'] ?>)</a></li>
                    <?php else: ?>
                        <li><a href="?controller=utilisateur&function=login" class="<?= is_active('utilisateur', 'login') ?>">Connexion</a></li>
                        <li><a href="?controller=utilisateur&function=register" class="<?= is_active('utilisateur', 'register') ?>">Inscription</a></li>
                    <?php endif; ?>
                </ul>
        </nav>
    </header>
    <main>
        <h1 class="invisible">forum</h1>
        <div class="container">

        <?php
        
                // Pour afficher les messages d'erreur et de succès dans layout.php
                if(isset($_SESSION['error'])): ?>
                    <div class="error"><?php echo $_SESSION['error']; ?></div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <?php if(isset($_SESSION['success'])): ?>
                    <div class="success"><?php echo $_SESSION['success']; ?></div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php echo $content; ?>
        </div>
    </main>
<!-- Pied de page --->

    <footer>
        <p>&copy; 2025 Forum des Étudiants de Maisonneuve. Tous droits réservés.</p>
    </footer>      
</body>
</html>