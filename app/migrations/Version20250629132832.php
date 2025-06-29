<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250629132832 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Ajoute une valeur par défaut [] si la colonne contient des NULL
        $this->addSql("UPDATE users SET favorite_playlists = '[]' WHERE favorite_playlists IS NULL");

        // Applique la contrainte NOT NULL sur la colonne JSON
        $this->addSql("ALTER TABLE users CHANGE favorite_playlists favorite_playlists JSON NOT NULL");
    }


    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE users CHANGE favorite_playlists favorite_playlists JSON DEFAULT NULL
        SQL);
    }
}
