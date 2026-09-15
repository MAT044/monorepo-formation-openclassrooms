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
	<div class="tt-row">
		<div class="tt-panel-white tt-col-25">
			<div class="tt-account-profile">
				<img src="<?= htmlspecialchars($user->avatarUri ?? '/assets/img/default-avatar.png') ?>" alt="Avatar de <?= htmlspecialchars($user->username) ?>" class="tt-avatar tt-avatar-large">
				<div class="tt-account-separator"></div>
				<h2 class="tt-account-username"><?= htmlspecialchars($user->username) ?></h2>
				<p class="tt-account-member-since">Membre depuis <?= htmlspecialchars($memberSince) ?></p>
				<p class="tt-account-library-label">Bibliothèque</p>
				<p class="tt-account-library-count"><img src="/assets/icon/bok.svg"> <?= htmlspecialchars((string) count($books)) ?> livre<?= count($books) > 1 ? 's' : '' ?></p>
                <a href="/conversations/<?= htmlspecialchars((string) $owner->id) ?>" class="tt-cta-outline">
                Ecrire un message
            </a>
            </div>
		</div>
		<div>
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
					</tr>
				<?php endforeach; ?>
				</tr>
				</tbody>
			</table>
		</div>
	</div>



</div>