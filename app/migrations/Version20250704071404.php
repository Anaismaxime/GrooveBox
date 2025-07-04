<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250704071404 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE posts_artists (posts_id INT NOT NULL, artists_id INT NOT NULL, INDEX IDX_C7B39975D5E258C5 (posts_id), INDEX IDX_C7B3997554A05007 (artists_id), PRIMARY KEY(posts_id, artists_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE posts_artists ADD CONSTRAINT FK_C7B39975D5E258C5 FOREIGN KEY (posts_id) REFERENCES posts (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE posts_artists ADD CONSTRAINT FK_C7B3997554A05007 FOREIGN KEY (artists_id) REFERENCES artists (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE posts_artists DROP FOREIGN KEY FK_C7B39975D5E258C5
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE posts_artists DROP FOREIGN KEY FK_C7B3997554A05007
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE posts_artists
        SQL);
    }
}
