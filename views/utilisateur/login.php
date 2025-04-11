<section class="form-section">
    <h2>Connexion</h2>
    
    <form method="post" action="?controller=utilisateur&function=authenticate">
        <div class="form-group">
            <label for="nom_utilisateur">Email:</label>
            <input type="email" id="nom_utilisateur" name="nom_utilisateur" value="<?= isset($nom_utilisateur) ? htmlspecialchars($nom_utilisateur) : '' ?>" required>
        </div>
        
        <div class="form-group">
            <label for="mot_de_passe">Mot de passe:</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>
        </div>
        
        <button type="submit" class="btn"><i class="fas fa-right-to-bracket"></i>&nbsp; Se connecter</button>
    </form>
    
    <p>Pas encore inscrit? <a href="?controller=utilisateur&function=register">Inscrivez-vous</a></p>
</section>