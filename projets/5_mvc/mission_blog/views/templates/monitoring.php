<?php
/** 
 * Affichage de la partie admin : liste des articles avec un bouton "modifier" pour chacun. 
 * Et un formulaire pour ajouter un article. 
 */
?>

<h2>Monitoring</h2>

<div class="info">
    <p>Cliquez sur les titres des colonnes pour trier le tableau</p>
</div>

<table class="table">
    <thead>
        <th <?= ($order === "title") ? 'class="active"' : '' ?> >
            <a href="<?= Utils::route('monitoring', [
                'order' => "title",
                'direction' => ($order === "title" && $direction === 'ASC') ? "DESC" : "ASC"
            ]) ?>"
                title="Trier par titre" >
                Titre
                <?php if ($order === "title"):
                    echo ($direction === 'ASC') ? "&uarr;" : "&darr;";
                endif; ?>
            </a>
        </th>
        <th <?= ($order === "comments") ? 'class="active"' : '' ?>>
            <a href="<?= Utils::route('monitoring', [
                'order' => "comments",
                'direction' => ($order === "comments" && $direction === 'ASC') ? "DESC" : "ASC"
            ]) ?>"
            title="Trier par nombre de commentaires" >
                Commentaires
                <?php if ($order === "comments"):
                    echo ($direction === 'ASC') ? "&uarr;" : "&darr;";
                endif; ?>
            </a>
        </th>
        <th <?= ($order === "vues") ? 'class="active"' : '' ?>>
            <a href="<?= Utils::route('monitoring', [
                'order' => "vues",
                'direction' => ($order === "vues" && $direction === 'ASC') ? "DESC" : "ASC"
            ]) ?>"
            title="Trier par nombre de vues">
                Vues
                <?php if ($order === "vues"):
                    echo ($direction === 'ASC') ? "&uarr;" : "&darr;";
                endif; ?>
            </a>
        </th>
        <th <?= ($order === "date_creation") ? 'class="active"' : '' ?>>
            <a href="<?= Utils::route('monitoring', [
                'order' => "date_creation",
                'direction' => ($order === "date_creation" && $direction === 'ASC') ? "DESC" : "ASC"
            ]) ?>"
            title="Trier par date de création" >
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