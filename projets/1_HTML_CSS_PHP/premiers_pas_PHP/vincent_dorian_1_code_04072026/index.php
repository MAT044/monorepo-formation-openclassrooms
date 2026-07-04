<?php include 'includes/header.php'; ?>
        <div id="liste-oeuvres">
            <?php 
                $oeuvres = include 'data/oeuvres.php';
                foreach($oeuvres as $oeuvre):
            ?>
                <article class="oeuvre">
                    <a href="oeuvre-<?= $oeuvre['id'] ?>.php">
                        <img src="img/<?= $oeuvre['img'] ?>" alt="<?= $oeuvre['title'] ?>">
                        <h2><?= $oeuvre['title'] ?></h2>
                        <p class="description"><?= $oeuvre['artist'] ?></p>
                    </a>
                </article>
            <?php endforeach; ?>
            
        </div>
<?php include 'includes/footer.php'; ?>