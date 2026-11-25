-- Schéma de base pour le portfolio naturaliste.
-- Exécuté automatiquement au premier démarrage du conteneur MySQL.

USE nature_folio;

CREATE TABLE IF NOT EXISTS oiseaux (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    nom_latin VARCHAR(255) DEFAULT NULL,
    famille VARCHAR(255) DEFAULT NULL,
    rarete VARCHAR(255) DEFAULT NULL,
    repartition TEXT,
    description TEXT,
    premiere_obs DATE DEFAULT NULL,
    lien_inpn VARCHAR(512) DEFAULT NULL,
    image_path VARCHAR(512) DEFAULT NULL,
    image_path_min VARCHAR(512) DEFAULT NULL,
    date_obs DATE DEFAULT NULL,
    lieu_obs VARCHAR(255) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS lepido (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    nom_latin VARCHAR(255) DEFAULT NULL,
    famille VARCHAR(255) DEFAULT NULL,
    rarete VARCHAR(255) DEFAULT NULL,
    repartition TEXT,
    description TEXT,
    premiere_obs DATE DEFAULT NULL,
    lien_inpn VARCHAR(512) DEFAULT NULL,
    image_path VARCHAR(512) DEFAULT NULL,
    image_path_min VARCHAR(512) DEFAULT NULL,
    date_obs DATE DEFAULT NULL,
    lieu_obs VARCHAR(255) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
