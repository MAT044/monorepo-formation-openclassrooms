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
            Titre
        </th>
        <th>
            Commentaires
        </th>
        <th>
            Vues
        </th>
        <th>
            Date Publication
        </th>
    </thead>
    <tbody>
    <?php foreach ($articles as $article) { ?>
        <tr>
            <td><?= $article->getTitle() ?></div>
            <td><?= $commentsPerArticle[$article->getId()] ?></div>
            <td><?= $article->getVues() ?></td>
            <td><?= $article->getDateCreation()->format('d-m-Y') ?></td>
        </tr>
    <?php } ?>
</tbody>
</table>