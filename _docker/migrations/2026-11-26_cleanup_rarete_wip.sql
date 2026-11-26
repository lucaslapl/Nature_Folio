-- Migration production — 2026-11-26
-- À exécuter UNE FOIS sur la base de production (après backup) :
--   1. supprime la colonne `rarete` (jugée trop subjective)
--   2. vide les placeholders "En cours de rédaction." (repartition + description)
--   3. convertit les dates '0000-00-00' en NULL (elles bloquent les ALTER en mode strict)
--
-- Lancer par exemple :
--   mysql -h <host> -u <user> -p <dbname> < 2026-11-26_cleanup_rarete_wip.sql
-- ou importer via phpMyAdmin.

SET SESSION sql_mode='ALLOW_INVALID_DATES';

UPDATE `oiseaux` SET `repartition` = '' WHERE `repartition` LIKE 'En cours de r%daction%';
UPDATE `oiseaux` SET `description` = '' WHERE `description` LIKE 'En cours de r%daction%';
UPDATE `lepido`  SET `repartition` = '' WHERE `repartition` LIKE 'En cours de r%daction%';
UPDATE `lepido`  SET `description` = '' WHERE `description` LIKE 'En cours de r%daction%';

UPDATE `oiseaux` SET `premiere_obs` = NULL WHERE `premiere_obs` = '0000-00-00';
UPDATE `oiseaux` SET `date_obs`     = NULL WHERE `date_obs`     = '0000-00-00';
UPDATE `lepido`  SET `premiere_obs` = NULL WHERE `premiere_obs` = '0000-00-00';
UPDATE `lepido`  SET `date_obs`     = NULL WHERE `date_obs`     = '0000-00-00';

SET SESSION sql_mode = DEFAULT;

ALTER TABLE `oiseaux` DROP COLUMN `rarete`;
ALTER TABLE `lepido`  DROP COLUMN `rarete`;
