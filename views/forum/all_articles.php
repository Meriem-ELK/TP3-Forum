<section class="all-articles">
    <h2>Tous les articles</h2>
    
    <?php if(empty($articles)): ?>
        <p>Aucun article n'a été publié pour le moment.</p>
    <?php else: ?>
        <?php foreach($articles as $article): ?>
            <article class="article-card">
                <h3><?= htmlspecialchars($article['titre']) ?></h3>
                <div class="article-meta">
                    <span class="nom"><?= htmlspecialchars($article['nom']) ?></span>
                    <span class="date"><strong>Date:</strong> <?= date('d/m/Y', strtotime($article['date_creation'])) ?></span>
                </div>
                <p><i class="fas fa-comments"></i>&nbsp; <?= nl2br(htmlspecialchars($article['article'])) ?></p>
                
                <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $article['id_utilisateur']): ?>
                    <div class="article-actions">
                        <a href="?controller=forum&function=edit&id=<?= $article['id_article'] ?>" class="btn"><i class="fas fa-pencil-alt"></i>&nbsp; Modifier</a>
                        <a href="?controller=forum&function=delete&id=<?= $article['id_article'] ?>" class="btn danger" onclick="return confirm('Êtes-vous sûr?')"><i class="fas fa-trash"></i>&nbsp; Supprimer</a>
                    </div>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</section>