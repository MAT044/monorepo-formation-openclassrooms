<div class="tt-container">
	<h1>Mon compte</h1>

	<div class="tt-row">
		<div class="tt-panel-white tt-col-50">
			<h2><?= $user->username ?></h2>
			<p>Membre depuis X ans</p>
			<p>Bibilothèque</p>
			<p>4 livres</p>
		</div>
		<div class="tt-panel-white tt-col-50">
			<h3>Vos informations personnelles</h3>
			<?php foreach ($errors as $error): ?>
				<div class="tt-alert tt-alert-error">
					<p><?= $error ?></p>
				</div>
			<?php endforeach; ?>

			<form action="/mon-compte" method="post" class="tt-form">
				<div class="tt-form-row">
					<label class="tt-form-label">Adresse email</label>
					<input name="email" type="email" class="tt-form-input" value="<?= $user->email ?>">
				</div>
				<div class="tt-form-row">
					<label class="tt-form-label">Mot de passe</label>
					<input name="password" type="password" class="tt-form-input">
				</div>
				<div class="tt-form-row">
					<label class="tt-form-label">Pseudo</label>
					<input name="username" type="text" class="tt-form-input" value="<?= $user->username ?>">
				</div>
				<div class="tt-form-actions">
					<button class="tt-cta">Enregistrer</button>
				</div>
			</form>
		</div>
		<div class="tt-col-100">
			<table class="tt-table">
				<tbody>
					<tr>
						<th>
							Photo
						</th>
						<th>
							Titre
						</th>
						<th>
							Auteur
						</th>
						<th>
							Description
						</th>
						<th>
							Disponibilité
						</th>
						<th>
							Actions
						</th>
					</tr>
					<tr>
						<?php foreach ($books as $book): ?>
					<tr>
						<td>

						</td>
						<td>
							<?= htmlspecialchars($book->title) ?>
						</td>
						<td>
							<?= htmlspecialchars($book->author) ?>
						</td>
						<td>
							<?= htmlspecialchars($book->description) ?>
						</td>
						<td>
							<?= htmlspecialchars($book->available) ?>
						</td>
						<td>
							<a href="/mes-livres/<?= $book->id ?>/modifier">Modifier</a>
							<a href="/mes-livres/<?= $book->id ?>/supprimer">Supprimer</a>
						</td>
					</tr>
				<?php endforeach; ?>
				<td colspan="6"><a href="/mes-livres/nouveau">Ajouter un livre</a></td>
				</tr>
				</tbody>
			</table>
		</div>
	</div>



</div>