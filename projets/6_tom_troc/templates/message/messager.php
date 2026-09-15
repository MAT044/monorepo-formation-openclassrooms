<section class="tt-messager-section" id="messager">
	<div class="tt-container">
		<div class="tt-messager-layout">
			<div class="tt-col-conversations ">
				<div class="tt-conversations-header">
					<h1>Messagerie</h1>
				</div>
				<div class="tt-conversations-list">
					<?php foreach ($conversations as $conversation):
						$isActive = $conversation['user']->id === $targetUser?->id;
						$backgroundClass = $isActive ? "tt-bg-white" : "tt-bg-default";
						?>
						<a href="/conversations/<?= $conversation['user']->id ?>"
							class="tt-card-conversation tt-card tt-card-vertical <?= $backgroundClass ?>">
							<div class="tt-center-wrapper">
								<img src="<?= htmlspecialchars($conversation['user']->avatarUri ?? '/assets/img/default-avatar.png') ?>" alt="Avatar de <?= htmlspecialchars($conversation['user']->username) ?>" class="tt-avatar tt-avatar-small">
							</div>

							<div class="tt-card-body">
								<div class="tt-card-header">
									<h5 class="tt-card-title">
										<span><?= $conversation['user']->username ?></span><span><?= $conversation['lastMessage']->sendedAt->format('H:i') ?></span>
									</h5>
								</div>
								<p class="tt-card-text"><?= $conversation['lastMessage']->body ?></p>
							</div>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="tt-col-conversation">
				<?php if ($targetUser): ?>
					<div class="">
						<h2><img src="<?= htmlspecialchars($targetUser->avatarUri ?? '/assets/img/default-avatar.png') ?>"
								alt="Avatar de <?= htmlspecialchars((string) $targetUser->username) ?>" class="tt-avatar tt-avatar-small">&nbsp;<?= htmlspecialchars((string) $targetUser->username) ?></h2>
					</div>
					<div class="tt-conversation-body">
						<?php foreach ($messages as $message):
							$isUserMsg = $message->authorId === $currentUser->id;
							$messageClass = $isUserMsg ? "tt-message-user" : "tt-message-target";
							?>
							<div class="tt-message <?= $messageClass ?>">
								<div class="tt-message-header">
									<p>
										<?php if(!$isUserMsg): ?>
												<img src="<?= htmlspecialchars($targetUser->avatarUri ?? '/assets/img/default-avatar.png') ?>" alt="Avatar de <?= htmlspecialchars((string) $targetUser->username) ?>" class="tt-avatar tt-avatar-xs">
										<?php endif; ?>
										<?= htmlspecialchars($message->sendedAt->format('d.m H:i')) ?>
									</p>
								</div>
								<div class="tt-message-body">
									<p><?= htmlspecialchars((string) $message->body) ?></p>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
					<div>
						<form method="post" class="tt-form">
							<div class="tt-form-inputBar">
								<input name="body" class="tt-form-input" placeholder="Entrez votre message ici">
								<button class="tt-cta">Envoyer</button>
							</div>
							<?php foreach ($errors as $error): ?>
								<div class="tt-alert tt-alert-error">
									<p><?= $error ?></p>
								</div>
							<?php endforeach; ?>
						</form>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>