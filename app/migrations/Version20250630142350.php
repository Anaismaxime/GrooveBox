<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250630142350 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE playlists ADD genre_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE playlists ADD CONSTRAINT FK_5E06116F4296D31F FOREIGN KEY (genre_id) REFERENCES genres (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_5E06116F4296D31F ON playlists (genre_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE posts ADD genre_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE posts ADD CONSTRAINT FK_885DBAFA4296D31F FOREIGN KEY (genre_id) REFERENCES genres (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_885DBAFA4296D31F ON posts (genre_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFA4296D31F
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_885DBAFA4296D31F ON posts
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE posts DROP genre_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE playlists DROP FOREIGN KEY FK_5E06116F4296D31F
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_5E06116F4296D31F ON playlists
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE playlists DROP genre_id
        SQL);
    }
}
