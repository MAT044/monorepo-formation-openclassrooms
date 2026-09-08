<div class="tt-container-cards">
    <h1>Nos livres à l'échange</h1>
    <div class="tt-cards-grid">
        <?php foreach($books ?? [] as $book): ?>
            <a href="/livres/<?=  $book->id ?>" class="tt-card tt-book-card">
                <img class="tt-card-img">
                <div class="tt-card-body">
                    <h5 class="tt-card-title"><?=  $book->title ?></h5>
                    <p class="tt-card-subtitle"><?=  $book->author ?></p>
                    <p class="tt-card-footnote">Vendu par : <?=  $book->author ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>