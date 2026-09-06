<div class="tt-container">
    <h1>Livres disponibles</h1>
    <div class="tt-cards-grid">
        <?php foreach($books ?? [] as $book): ?>
            <a href="/livres/<?=  $book->id ?>" class="tt-card">
                <img class="tt-card-img">
                <div class="tt-card-body">
                    <p class="tt-card-title"><?=  $book->title ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>