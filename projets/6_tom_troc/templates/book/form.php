<div class="tt-container tt-py-5">
	<h1><?= $book !== null ? 'Modifier les informations' : 'Ajouter un livre' ?></h1>
	<div class="tt-grid tt-panel-white">
	<div>
		<img src="<?= htmlspecialchars($book?->illustrationUri ?? '/assets/img/default-book.png') ?>" alt="Illustration de <?= htmlspecialchars($book?->title ?? 'Livre') ?>" class="tt-img-cover">
		<?php if ($book !== null): ?>
			<div class="tt-avatar-modal">
				<input type="checkbox" id="book-illustration-modal-toggle-<?= htmlspecialchars((string) $book->id) ?>" class="tt-avatar-modal-toggle">
				<label for="book-illustration-modal-toggle-<?= htmlspecialchars((string) $book->id) ?>" class="tt-avatar-edit-link">Modifier la photo</label>
				<dialog class="tt-avatar-modal-panel">
					<form method="dialog" class="tt-avatar-modal-close-form">
						<label for="book-illustration-modal-toggle-<?= htmlspecialchars((string) $book->id) ?>" class="tt-avatar-modal-close" aria-label="Fermer">×</label>
					</form>
					<h3>Modifier l'illustration</h3>
					<form action="/mes-livres/<?= htmlspecialchars((string) $book->id) ?>/illustration" method="post" enctype="multipart/form-data" class="tt-form tt-form-modal">
						<div class="tt-form-row">
							<label class="tt-form-label">Image de l'illustration</label>
							<input name="illustration_file" type="file" accept="image/*" class="tt-form-input">
						</div>
						<div class="tt-form-actions">
							<button class="tt-cta" type="submit">Enregistrer</button>
						</div>
					</form>
				</dialog>
			</div>
		<?php endif; ?>
	</div>
	<div class="tt-book-info">
	<form method="post" class="tt-form">
		<div class="tt-form-row">
			<label class="tt-form-label">Titre</label>
			<input name="title" type="text" class="tt-form-input" value="<?= htmlspecialchars((string) ($book?->title ?? '')) ?>">
		</div>
		<div class="tt-form-row">
			<label class="tt-form-label">Auteur</label>
			<input name="author" type="text" class="tt-form-input" value="<?= htmlspecialchars((string) ($book?->author ?? '')) ?>">
		</div>
		<div class="tt-form-row">
			<label class="tt-form-label">Description</label>
			<textarea name="description" class="tt-form-input" rows="15"><?= htmlspecialchars((string) ($book?->description ?? '')) ?></textarea>
		</div>
		<div class="tt-form-row">
			<label class="tt-form-label">Disponible</label>
			<select name="available" class="tt-form-select">
				<option value="true">Disponible</option>
				<option value="false">Indisponible</option>
			</select>
		</div>
		<div class="tt-form-actions">
			<button class="tt-cta">Créer</button>
		</div>
	</form></div>
</div>
</div>