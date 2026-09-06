<div>
	<form method="post" class="tt-form">
		<div class="tt-form-row">
			<label class="tt-form-label">Titre</label>
			<input name="title" type="text" class="tt-form-input" value="<?= $book?->title ?>">
		</div>
		<div class="tt-form-row">
			<label class="tt-form-label">Auteur</label>
			<input name="author" type="text" class="tt-form-input" value="<?= $book?->author ?>">
		</div>
		<div class="tt-form-row">
			<label class="tt-form-label">Description</label>
			<textarea name="description" class="tt-form-input" rows="15"><?= $book?->description ?></textarea>
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
	</form>
</div>