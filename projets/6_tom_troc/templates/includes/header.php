<header class="tt-header">
    <nav class="tt-navbar">
        <div class="tt-container">
            <a href="/" class="tt-logo-wrapper"><img src="/assets/logo/tom_troc.svg" alt="TomTroc" width="155px"
                    height="51px" class="tt-logo" /></a>
            <div class="tt-menu">
                <ul class="tt-menu-section">
                    <li>
                        <a href="/" class="tt-menu-item">Accueil</a>
                    </li>
                    <li>
                        <a href="/livres" class="tt-menu-item">Nos livres </a>
                    </li>
                </ul>
                <ul class="tt-menu-section">
                    <?php if($isConnected): ?>
                        <li><a href="/conversations" class="tt-menu-item"><img src="/assets/icon/msg.svg"> Messagerie <?= ($unreadNumber > 0) ? '<span class="tt-badge">' . $unreadNumber . '</span>' : '' ?></a></li>
                        <li><a href="/mon-compte" class="tt-menu-item"><img src="/assets/icon/acc.svg">  Mon compte</a></li>
                        <li><a href="/deconnexion" class="tt-menu-item">Déconnexion</a></li>
                    <?php else: ?>
                        <li><a href="/connexion" class="tt-menu-item">Connexion</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>