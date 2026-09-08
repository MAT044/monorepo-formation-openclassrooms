
<div class="tt-grid">
    <img src="<?= $book->illustrationUri ?>" class="tt-img-cover">
    <div class="tt-book-info">
        <h1><?= htmlspecialchars($book->title) ?></h1>
        <p>par <?= htmlspecialchars($book->author) ?></p>
        <hr class="tt-text-separator">

        <h2 class="tt-description-title">DESCRIPTION</h2>
        <p><?= htmlspecialchars($book->description) ?></p>

        <h2 class="tt-description-title">PROPRIETAIRE</h2>
        <a href="/conversations/<?= $owner->id ?>" class="tt-pill">
            <img src="<?=  $owner->avatarUri ?>" class="tt-avatar tt-avatar-s"><span class="tt-pill-body"><?= $owner->username ?></span>
        </a>
        <div class="tt-form-actions">
            <a href="/conversations/<?= $owner->id ?>" class="tt-cta">
                Envoyer un message
            </a>
        </div>
    </div>
</div>