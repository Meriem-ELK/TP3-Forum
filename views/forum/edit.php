<section class="form-section">
    <h2>Modifier l'article</h2>

    <form method="post" action="?controller=forum&function=update">
    <input type="hidden" name="id" value="<?= isset($article['id_article']) ? $article['id_article'] : '' ?>">
        
        <div class="form-group">
            <label for="titre">Titre: <small>Entre 5 et 100 caractères.</small> </label>
            <input type="text" id="titre" name="titre" value="<?= htmlspecialchars($article['titre']) ?>" required>
            
            <div class="error">
                <?php if (!empty($errors['titre'])): ?>
                    <div class="error"><i class="fas fa-exclamation-circle"></i>&nbsp; <?php echo htmlspecialchars($errors['titre']); ?></div>
                <?php endif; ?>
            </div>

        </div>
        
        <div class="form-group">
            <label for="article">Contenu:  <small>Maximum 1000 caractères.</small> </label>
            <textarea id="article" name="article" rows="10" required><?= htmlspecialchars($article['article']) ?></textarea>

            <div class="error">
                <?php if (!empty($errors['article'])): ?>
                    <div class="error"><i class="fas fa-exclamation-circle"></i>&nbsp; <?php echo htmlspecialchars($errors['article']); ?></div>
                <?php endif; ?>
            </div>

        </div>
        
        <button type="submit" class="btn"><i class="fas fa-floppy-disk"></i>&nbsp; Enregistrer les modifications</button>
    </form>
    
    <a href="?controller=forum&function=articlesUser" class="btn back"><i class="fas fa-chevron-left"></i>&nbsp; Retour à mes articles</a>
</section>