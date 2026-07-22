<?php include 'includes/header.php'; ?>
        <div id="liste-oeuvres">
            <?php 
                /**
                 * @var PDO
                 */
                $pdo = include 'includes/bdd.php';
            
                $sql = "SELECT id, title, artist, description, img FROM oeuvres WHERE 1;";
                $request = $pdo->prepare($sql);
                $request->execute();
                

                while($oeuvre = $request->fetch(PDO::FETCH_ASSOC)):
            ?>
                <article class="oeuvre">
                    <a href="oeuvre.php?id=<?= $oeuvre['id'] ?>">
                        <img src="<?= $oeuvre['img'] ?>" alt="<?= $oeuvre['title'] ?>">
                        <h2><?= $oeuvre['title'] ?></h2>
                        <p class="description"><?= $oeuvre['artist'] ?></p>
                    </a>
                </article>
            <?php endwhile; ?>
            
        </div>
<?php include 'includes/footer.php'; ?>