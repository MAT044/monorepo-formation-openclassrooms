<div class="tt-container-cards tt-py-5">
    <div class="tt-header-row">
        <h1>Nos livres à l'échange</h1>
        <form method="get" action="/livres" class="tt-search-form">
            <input
                type="search"
                name="search"
                value="<?= htmlspecialchars((string) ($_GET['search'] ?? '')) ?>"
                class="tt-form-input"
                placeholder="Rechercher un livre"
            >
        </form>
    </div>
    <div class="tt-cards-grid">
        <?php foreach($books ?? [] as $book): ?>
            <a href="/livres/<?= htmlspecialchars((string) $book->id) ?>" class="tt-card tt-book-card">
                <img src="<?= htmlspecialchars($book->illustrationUri ?? '/assets/img/default-book.png') ?>" alt="Illustration de <?= htmlspecialchars((string) $book->title) ?>" class="tt-card-img">
                <div class="tt-card-body">
                    <h5 class="tt-card-title"><?= htmlspecialchars((string) $book->title) ?></h5>
                    <p class="tt-card-subtitle"><?= htmlspecialchars((string) $book->author) ?></p>
                    <p class="tt-card-footnote">Vendu par : <?= htmlspecialchars((string) $book->owner->username) ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>