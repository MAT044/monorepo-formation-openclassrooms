
<div class="tt-grid">
    <img class="tt-img-cover">
    <div class="tt-book-info">
        <h1><?= htmlspecialchars($book->title) ?></h1>
        <p>par <?= htmlspecialchars($book->author) ?></p>

        <p>Description</p>
        <p><?= htmlspecialchars($book->description) ?></p>

        <p>Propriétaire</p>
        <span class="tt-pill">
            <img src="<?=  $owner->avatarUri ?>">
            <p><?= $owner->username ?></p>
        </span>
    </div>
</div>