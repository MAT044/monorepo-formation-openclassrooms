<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?= $title ?></title>

	<!--
		Source - https://stackoverflow.com/a/34458817
		Posted by serraosays, modified by community. See post 'Timeline' for change history
		Retrieved 2026-09-02, License - CC BY-SA 4.0
	-->
	<link rel="icon"  href="/assets/logo/tom_troc_minimal.svg" sizes="any" type="image/x-icon">

	<link rel="stylesheet" href="/style.css">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link
		href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
		rel="stylesheet">
</head>
<?= $header ?>
<main class="tt-main">
	<?= $content ?>
</main>
<?= $footer ?>
</body>

</html>