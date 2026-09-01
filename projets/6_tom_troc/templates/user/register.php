
    <div class="tt-grid">
        <div class="tt-col">
            <h1>Inscription</h1>
            <?php foreach($errors as $error): ?>
                <div class="tt-alert tt-alert-error">
                    <p><?= $error ?></p>
                </div>
            <?php endforeach; ?>

            <form action="/inscription" method="post" class="tt-form">
                <div class="tt-form-row">
                    <label class="tt-form-label">Pseudo</label>
                    <input name="pseudo" type="text" class="tt-form-input">
                </div>
                <div class="tt-form-row">
                    <label class="tt-form-label">Adresse email</label>
                    <input name="email" type="email" class="tt-form-input">
                </div>
                <div class="tt-form-row">
                    <label class="tt-form-label">Mot de passe</label>
                    <input name="password" type="password" class="tt-form-input">
                </div>
                <div class="tt-form-actions">
                    <button class="tt-cta">Connexion</button>
                </div>
            </form>
            <p>Pas de compte ? <a href="/inscription">Inscrivez-vous</a></p>
        </div>
        <span class="tt-illustration-marialaura"></span>
    </div>
