<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250618101430 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE users_playlists (users_id INT NOT NULL, playlists_id INT NOT NULL, INDEX IDX_387B6B8E67B3B43D (users_id), INDEX IDX_387B6B8E9F70CF56 (playlists_id), PRIMARY KEY(users_id, playlists_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users_playlists ADD CONSTRAINT FK_387B6B8E67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users_playlists ADD CONSTRAINT FK_387B6B8E9F70CF56 FOREIGN KEY (playlists_id) REFERENCES playlists (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7D67B3B43D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7D9F70CF56
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE likes
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE likes (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, playlists_id INT DEFAULT NULL, INDEX IDX_49CA4E7D9F70CF56 (playlists_id), INDEX IDX_49CA4E7D67B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7D67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7D9F70CF56 FOREIGN KEY (playlists_id) REFERENCES playlists (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users_playlists DROP FOREIGN KEY FK_387B6B8E67B3B43D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users_playlists DROP FOREIGN KEY FK_387B6B8E9F70CF56
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE users_playlists
        SQL);
    }
}
