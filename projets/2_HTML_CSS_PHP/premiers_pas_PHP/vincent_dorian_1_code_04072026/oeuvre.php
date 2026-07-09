<?php include 'includes/header.php'; ?>
    <?php 
        $id = intval($_GET['id'] ??  1);
        $oeuvre = (include 'data/oeuvres.php')[$id] ?? [
            'id' => 0,
            'title' => '404',
            'artist' => 'Not found',
            'description' => 'L\'id de l\'oeuvre ne correspond à aucune oeuvre dans notre base de donnée.',
            'img' => 'logo.png'
        ];
    ?>
    <article id="detail-oeuvre">
        <div id="img-oeuvre">
            <img src="img/<?= $oeuvre['img'] ?>" alt="<?= $oeuvre['title'] ?>">
        </div>
        <div id="contenu-oeuvre">
            <h1><?= $oeuvre['title'] ?></h1>
            <p class="description"><?= $oeuvre['artist'] ?></p>
            <p class="description-complete">
                <?= $oeuvre['description'] ?>
            </p>
        </div>
    </article>
<?php include 'includes/footer.php'; ?>