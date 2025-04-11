<section class="form-section">
    <h2>Inscription</h2>

    <form method="post" action="?controller=utilisateur&function=store">
        <div class="form-group">
            <label for="nom">Nom:  <small>( Entre 2 et 25 caractères, lettres et espaces uniquement.) </small></label>
            <input type="text" id="nom" name="nom" value="<?php echo isset($request['nom']) ? htmlspecialchars($request['nom']) : ''; ?>" required>
            
            <div class="error">
                <?php if (!empty($errors['nom'])): ?>
                    <div class="error"><i class="fas fa-exclamation-circle"></i>&nbsp; <?php echo htmlspecialchars($errors['nom']); ?></div>
                <?php endif; ?>
            </div>

        </div>
        
        <div class="form-group">
            <label for="nom_utilisateur">Email:</label>
            <input type="email" id="nom_utilisateur" name="nom_utilisateur" value="<?php echo isset($request['nom_utilisateur']) ? htmlspecialchars($request['nom_utilisateur']) : ''; ?>" required>
            
            <div class="error">
                <?php if (!empty($errors['nom_utilisateur'])): ?>
                    <div class="error"><i class="fas fa-exclamation-circle"></i>&nbsp; <?php echo htmlspecialchars($errors['nom_utilisateur']); ?></div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="form-group">
            <label for="mot_de_passe">Mot de passe: <small>(Entre 6 et 20 caractères, doit contenir des chiffres et des lettres.)</small></label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            
            <div class="error">
                <?php if (!empty($errors['mot_de_passe'])): ?>
                    <div class="error"><i class="fas fa-exclamation-circle"></i>&nbsp; <?php echo htmlspecialchars($errors['mot_de_passe']); ?></div>
                <?php endif; ?>
            </div>

            
        </div>
        
        <div class="form-group">
            <label for="date_naissance">Date de naissance:</label>
            <input type="date" id="date_naissance" name="date_naissance" value="<?php echo isset($request['date_naissance']) ? htmlspecialchars($request['date_naissance']) : ''; ?>" required>
            
            <div class="error">
                <?php if (!empty($errors['date_naissance'])): ?>
                    <div class="error"><i class="fas fa-exclamation-circle"></i>&nbsp; <?php echo htmlspecialchars($errors['date_naissance']); ?></div>
                <?php endif; ?>
            </div>

        </div>
        
        <button type="submit" class="btn"><i class="fas fa-user-edit"></i>&nbsp; S'inscrire</button>
    </form>
    
    <p>Déjà inscrit? <a href="?controller=utilisateur&function=login">Connectez-vous</a></p>
</section>