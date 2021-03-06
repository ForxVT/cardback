-- On efface la base de donnée si elle existe déjà.
DROP DATABASE IF EXISTS cardback;

-- On la crée.
CREATE DATABASE IF NOT EXISTS cardback;

-- On l'utilise.
USE cardback;

-- On efface les tables si elles existe déjà.
DROP TABLE IF EXISTS cards, packCards, packs, userPacks, users;

-- On crée la table "users".
CREATE TABLE users(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    email VARCHAR(254) NOT NULL,
    password CHAR(255) NOT NULL,
    firstName VARCHAR(50) NOT NULL,
    lastName VARCHAR(50) NOT NULL,
    creationDate DATE NOT NULL,
    lastConnectionDate DATE NOT NULL,
    admin TINYINT(1) NOT NULL DEFAULT 0,
    description VARCHAR(255) NOT NULL DEFAULT '',
    hideFirstName TINYINT(1) NOT NULL DEFAULT 0,
    hideLastName TINYINT(1) NOT NULL DEFAULT 0,
    hideInSearch TINYINT(1) NOT NULL DEFAULT 0,
    keepConnected TINYINT(1) NOT NULL DEFAULT 1,

    PRIMARY KEY(id),
    UNIQUE KEY(email)
);

-- On crée la table connectionToken.
CREATE TABLE connectionTokens(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    serverToken CHAR(23) NOT NULL,
    userToken CHAR(32) NOT NULL,

    PRIMARY KEY(id),
    UNIQUE KEY(serverToken)
);

-- On crée la table "feedbacks".
CREATE TABLE feedbacks(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    message VARCHAR(5000) NOT NULL,
    recommended TINYINT(1) NOT NULL,
    creationDate DATE NOT NULL,

    PRIMARY KEY(id)
);

-- On crée la table "packs".
CREATE TABLE packs(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    difficulty VARCHAR(32) NOT NULL,
    theme VARCHAR(32) NOT NULL,
    published TINYINT(1) NOT NULL DEFAULT 0,
    creationDate DATE NOT NULL,
    description VARCHAR(255) DEFAULT '',

    PRIMARY KEY(id),
    UNIQUE KEY(name)
);

-- On crée la table "cards".
CREATE TABLE cards(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    question VARCHAR(254),
    answer VARCHAR(254),
    confirmed TINYINT(1) NOT NULL DEFAULT 0,

    PRIMARY KEY(id)
);

-- On crée la table "userPacks" (lien utilisateur-paquet).
CREATE TABLE userPacks(
    userId INT UNSIGNED NOT NULL,
    packId INT UNSIGNED NOT NULL,

    FOREIGN KEY(userId) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY(packId) REFERENCES packs(id) ON DELETE CASCADE,

    PRIMARY KEY (userId, packId)
);

-- On crée la table "userToken" (lien utilisateur-connectionToken).
CREATE TABLE userConnectionTokens(
    userId INT UNSIGNED NOT NULL,
    tokenId INT UNSIGNED NOT NULL,

    FOREIGN KEY(userId) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY(tokenId) REFERENCES connectionTokens(id) ON DELETE CASCADE,

    PRIMARY KEY (userId, tokenId)
);

-- On crée la table "userFeedback" (lien utilisateur-feedback).
CREATE TABLE userFeedbacks(
    userId INT UNSIGNED NOT NULL,
    feedbackId INT UNSIGNED NOT NULL,

    FOREIGN KEY(userId) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY(feedbackId) REFERENCES feedbacks(id) ON DELETE CASCADE,

    PRIMARY KEY (userId, feedbackId)
);

-- On crée la table "packCards" (lien paquet-carte).
CREATE TABLE packCards(
    packId INT UNSIGNED NOT NULL,
    cardId INT UNSIGNED NOT NULL,

    FOREIGN KEY(packId) REFERENCES packs(id) ON DELETE CASCADE,
    FOREIGN KEY(cardId) REFERENCES cards(id) ON DELETE CASCADE,

    PRIMARY KEY (packId, cardId)
);