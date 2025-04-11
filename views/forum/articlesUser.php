<section class="my-articles">
    <h2>Mes articles</h2>
    
    <a href="?controller=forum&function=create" class="btn"><i class="fas fa-pen-to-square"></i>&nbsp; Créer un nouvel article</a>
    
    <?php if(empty($articles)): ?>
        <p>Vous n'avez pas encore publié d'articles.</p>
    <?php else: ?>
        <?php foreach($articles as $article): ?>
            <article class="article-card">
                <h3><?= htmlspecialchars($article['titre']) ?></h3>
                <div class="article-meta">
                    <span><strong>Date:</strong> <?= htmlspecialchars($article['date_creation']) ?></span>
                </div>
                <p><i class="fas fa-comments"></i> <?= nl2br(htmlspecialchars($article['article'])) ?></p>
                <div class="article-actions">
                    <a href="?controller=forum&function=edit&id=<?= $article['id_article'] ?>" class="btn"><i class="fas fa-pencil-alt"></i>&nbsp; Modifier</a>
                    <a href="?controller=forum&function=delete&id=<?= $article['id_article'] ?>" class="btn danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article?')"><i class="fas fa-trash"></i>&nbsp; Supprimer</a>
                </div>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</section>