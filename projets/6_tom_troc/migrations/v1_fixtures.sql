
INSERT INTO users (email, password_hash, username, registered_at, avatar_uri)
VALUES
    ('test@example.com', '$2y$10$mnyFhUluolw4w/iXk7Bg4upsrCMxB2.cgKTY6AEJr3vaqL9O/o8zq', 'test', NOW(), NULL),
    ('test2@example.com', '$2y$10$mnyFhUluolw4w/iXk7Bg4upsrCMxB2.cgKTY6AEJr3vaqL9O/o8zq', 'test2', NOW(), NULL),
    ('test3@example.com', '$2y$10$mnyFhUluolw4w/iXk7Bg4upsrCMxB2.cgKTY6AEJr3vaqL9O/o8zq', 'test3', NOW(), NULL);

INSERT INTO books (title, author, description, available, created_at, owner_id, illustration_uri)
VALUES
    ('Le Petit Prince', 'Antoine de Saint-Exupéry', 'Un classique à redécouvrir.', 1, NOW(), 1, NULL),
    ('L\'Étranger', 'Albert Camus', 'Un roman sur l\'étrangeté au monde.', 1, NOW(), 1, NULL),
    ('La Horde du Contrevent', 'Alain Damasio', 'Une expédition portée par le vent.', 0, NOW(), 2, NULL),
    ('Fondation', 'Isaac Asimov', 'Le début d\'une grande saga de science-fiction.', 1, NOW(), 3, NULL);

INSERT INTO messages (author_id, target_id, body, sended_at, seen_at)
VALUES
    (1, 2, 'Bonjour, ton livre est-il toujours disponible ?', NOW(), NULL),
    (2, 1, 'Oui, il est toujours disponible.', NOW(), NOW()),
    (3, 1, 'Je serais intéressé par Fondation.', NOW(), NULL),
    (1, 3, 'Parfait, je peux te le réserver.', NOW(), NOW());
