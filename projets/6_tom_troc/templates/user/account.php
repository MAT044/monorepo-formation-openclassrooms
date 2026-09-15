<?php
$now = new DateTimeImmutable();
$diff = $now->diff($user->registeredAt);

if ($diff->y > 0) {
    $memberSince = $diff->y . ' an' . ($diff->y > 1 ? 's' : '');
} elseif ($diff->m > 0) {
    $memberSince = $diff->m . ' mois';
} elseif ($diff->d > 0) {
    $memberSince = $diff->d . ' jour' . ($diff->d > 1 ? 's' : '');
} else {
    $memberSince = 'aujourd\'hui';
}
?>

<div class="tt-container tt-py-5">
	<h1>Mon compte</h1>

	<div class="tt-row">
		<div class="tt-panel-white tt-col-50">
			<div class="tt-account-profile">
				<img src="<?= htmlspecialchars($user->avatarUri ?? '/assets/img/default-avatar.png') ?>" alt="Avatar de <?= htmlspecialchars($user->username) ?>" class="tt-avatar tt-avatar-large">
				<div class="tt-avatar-modal">
					<input type="checkbox" id="avatar-modal-toggle" class="tt-avatar-modal-toggle">
					<label for="avatar-modal-toggle" class="tt-avatar-edit-link">Modifier</label>
					<dialog class="tt-avatar-modal-panel">
						<form method="dialog" class="tt-avatar-modal-close-form">
							<label for="avatar-modal-toggle" class="tt-avatar-modal-close" aria-label="Fermer">×</label>
						</form>
						<form action="/mon-compte/avatar" method="post" enctype="multipart/form-data" class="tt-form tt-form-modal">
							<div class="tt-form-row">
								<label class="tt-form-label">Image de l'avatar</label>
								<input name="avatar_file" type="file" accept="image/*" class="tt-form-input">
							</div>
							<div class="tt-form-actions">
								<button class="tt-cta" type="submit">Enregistrer</button>
							</div>
						</form>
					</dialog>
				</div>
				<div class="tt-account-separator"></div>
				<h2 class="tt-account-username"><?= htmlspecialchars($user->username) ?></h2>
				<p class="tt-account-member-since">Membre depuis <?= htmlspecialchars($memberSince) ?></p>
				<p class="tt-account-library-label">Bibliothèque</p>
				<p class="tt-account-library-count"><?= count($books) ?> livre<?= count($books) > 1 ? 's' : '' ?></p>
			</div>
		</div>
		<div class="tt-panel-white tt-col-50">
			<h3>Vos informations personnelles</h3>
			<?php foreach ($errors as $error): ?>
				<div class="tt-alert tt-alert-error">
					<p><?= htmlspecialchars((string) $error) ?></p>
				</div>
			<?php endforeach; ?>

			<form action="/mon-compte" method="post" class="tt-form">
				<div class="tt-form-row">
					<label class="tt-form-label">Adresse email</label>
					<input name="email" type="email" class="tt-form-input" value="<?= htmlspecialchars((string) $user->email) ?>">
				</div>
				<div class="tt-form-row">
					<label class="tt-form-label">Mot de passe</label>
					<input name="password" type="password" class="tt-form-input">
				</div>
				<div class="tt-form-row">
					<label class="tt-form-label">Pseudo</label>
					<input name="username" type="text" class="tt-form-input" value="<?= htmlspecialchars((string) $user->username) ?>">
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
							<img src="<?= htmlspecialchars($book->illustrationUri ?? '/assets/img/default-book.png') ?>" alt="Illustration de <?= htmlspecialchars($book->title) ?>" class="tt-book-miniature">
						</td>
						<td>
							<?= htmlspecialchars((string) $book->title) ?>
						</td>
						<td>
							<?= htmlspecialchars((string) $book->author) ?>
						</td>
						<td>
							<?= htmlspecialchars((string) (mb_substr($book->description, 0, 127, 'UTF-8') . (mb_strlen($book->description, 'UTF-8') > 127 ? '...' : ''))) ?>
						</td>
						<td>
							<span class="tt-book-status <?= $book->available ? 'tt-book-status-available' : 'tt-book-status-unavailable' ?>">
								<?= htmlspecialchars((string) ($book->available ? 'DISPONIBLE' : 'NON DISPO.')) ?>
							</span>
						</td>
						<td>
							<a href="/mes-livres/<?= htmlspecialchars((string) $book->id) ?>/modifier">Modifier</a>
							<a href="/mes-livres/<?= htmlspecialchars((string) $book->id) ?>/supprimer">Supprimer</a>
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