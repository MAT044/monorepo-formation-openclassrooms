<?php
/** 
 * Affichage de la partie admin : liste des articles avec un bouton "modifier" pour chacun. 
 * Et un formulaire pour ajouter un article. 
 */
?>

<h2>Monitoring</h2>

<table class="table">
    <thead>
        <th>
            <a href="<?= Utils::route('monitoring', [
                'order' => "title",
                'direction' => ($order === "title" && $direction === 'ASC') ? "DESC" : "ASC"
            ]) ?>">
                Titre
                <?php if ($order === "title"):
                    echo ($direction === 'ASC') ? "&uarr;" : "&darr;";
                endif; ?>
            </a>
        </th>
        <th>
            <a href="<?= Utils::route('monitoring', [
                'order' => "comments",
                'direction' => ($order === "comments" && $direction === 'ASC') ? "DESC" : "ASC"
            ]) ?>">
                Commentaires
                <?php if ($order === "comments"):
                    echo ($direction === 'ASC') ? "&uarr;" : "&darr;";
                endif; ?>
            </a>
        </th>
        <th>
            <a href="<?= Utils::route('monitoring', [
                'order' => "vues",
                'direction' => ($order === "vues" && $direction === 'ASC') ? "DESC" : "ASC"
            ]) ?>">
                Vues
                <?php if ($order === "vues"):
                    echo ($direction === 'ASC') ? "&uarr;" : "&darr;";
                endif; ?>
            </a>
        </th>
        <th>
            <a href="<?= Utils::route('monitoring', [
                'order' => "date_creation",
                'direction' => ($order === "date_creation" && $direction === 'ASC') ? "DESC" : "ASC"
            ]) ?>">
                Date Publication
                <?php if ($order === "date_creation"):
                    echo ($direction === 'ASC') ? "&uarr;" : "&darr;";
                endif; ?>
            </a>
        </th>
    </thead>
    <tbody>
        <?php foreach ($articles as $article) { ?>
            <tr>
                <td><?= $article['title'] ?></div>
                <td><?= $article['comments'] ?></div>
                <td><?= $article['vues'] ?></td>
                <td><?= $article['date_creation'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>