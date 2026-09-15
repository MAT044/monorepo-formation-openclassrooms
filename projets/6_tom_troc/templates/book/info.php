<div class="tt-bg-secondary">
    <div class="tt-container">
        <nav class="tt-breadcrumb">
            <ul>
                <li><a href="/nos-livres">Nos livres</a></li>
                <li><?= htmlspecialchars((string) $book->title) ?></li>
            </ul>
        </nav>
    </div>
</div>


<div class="tt-grid">
    <img src="<?= htmlspecialchars($book->illustrationUri ?? '/assets/img/default-book.png') ?>" alt="Illustration de <?= htmlspecialchars($book->title) ?>" class="tt-img-cover">
    <div class="tt-book-info">
        <h1><?= htmlspecialchars((string) $book->title) ?></h1>
        <p>par <?= htmlspecialchars((string) $book->author) ?></p>
        <hr class="tt-text-separator">

        <h2 class="tt-description-title">DESCRIPTION</h2>
        <p><?= nl2br(htmlspecialchars((string) $book->description)) ?></p>

        <h2 class="tt-description-title">PROPRIETAIRE</h2>
        <a href="/utilisateurs/<?= htmlspecialchars((string) $owner->id) ?>" class="tt-pill">
            <img src="<?= htmlspecialchars($owner->avatarUri ?? '/assets/img/default-avatar.png') ?>" alt="Avatar de <?= htmlspecialchars((string) $owner->username) ?>" class="tt-avatar tt-avatar-s"><span class="tt-pill-body"><?= htmlspecialchars((string) $owner->username) ?></span>
        </a>
        <div class="tt-form-actions">
            <a href="/conversations/<?= htmlspecialchars((string) $owner->id) ?>" class="tt-cta">
                Envoyer un message
            </a>
        </div>
    </div>
</div>