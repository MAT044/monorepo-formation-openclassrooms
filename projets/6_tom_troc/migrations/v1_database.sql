CREATE TABLE IF NOT EXISTS users (
    id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    registered_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    avatar_uri VARCHAR(255) NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS books (
    id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    description TEXT NULL,
    available TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    owner_id INT NOT NULL,
    illustration_uri VARCHAR(255) NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_books_owner
        FOREIGN KEY (owner_id)
        REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS messages (
    id INT NOT NULL AUTO_INCREMENT,
    author_id INT NOT NULL,
    target_id INT NOT NULL,
    body TEXT NOT NULL,
    sended_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    seen_at DATETIME NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_messages_author
        FOREIGN KEY (author_id)
        REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_messages_target
        FOREIGN KEY (target_id)
        REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    INDEX idx_messages_conversation (author_id, target_id, sended_at),
    INDEX idx_messages_target_seen (target_id, seen_at)
);
