<?php

$pdo = new PDO('mysql:host=localhost:3306;dbname=artbox', 'artbox-user', 'artbox-password', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

return $pdo;