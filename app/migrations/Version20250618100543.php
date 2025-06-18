<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250618100543 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE artists (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, biography LONGTEXT NOT NULL, picture VARCHAR(255) NOT NULL, country VARCHAR(100) NOT NULL, url_soundcloud VARCHAR(255) DEFAULT NULL, url_spotify VARCHAR(255) DEFAULT NULL, artist_of_the_week TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, post_id INT DEFAULT NULL, user_id INT DEFAULT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_5F9E962A4B89032C (post_id), INDEX IDX_5F9E962AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE contains (id INT AUTO_INCREMENT NOT NULL, playlists_id INT NOT NULL, soundtracks_id INT NOT NULL, INDEX IDX_8EFA6A7E9F70CF56 (playlists_id), INDEX IDX_8EFA6A7EE682647F (soundtracks_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE genres (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE likes (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, playlists_id INT DEFAULT NULL, INDEX IDX_49CA4E7D67B3B43D (users_id), INDEX IDX_49CA4E7D9F70CF56 (playlists_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE playlists (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, is_public TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_5E06116FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE posts (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, cover_image VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE produce (id INT AUTO_INCREMENT NOT NULL, soundtracks_id INT NOT NULL, artists_id INT NOT NULL, INDEX IDX_B9FA245FE682647F (soundtracks_id), INDEX IDX_B9FA245F54A05007 (artists_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE `reads` (id INT AUTO_INCREMENT NOT NULL, posts_id INT DEFAULT NULL, users_id INT DEFAULT NULL, INDEX IDX_C8406CB1D5E258C5 (posts_id), INDEX IDX_C8406CB167B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE soundtracks (id INT AUTO_INCREMENT NOT NULL, genre_id INT NOT NULL, title VARCHAR(255) NOT NULL, cover VARCHAR(255) DEFAULT NULL, url_soundtrack VARCHAR(255) NOT NULL, INDEX IDX_B9A80D8B4296D31F (genre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A4B89032C FOREIGN KEY (post_id) REFERENCES posts (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contains ADD CONSTRAINT FK_8EFA6A7E9F70CF56 FOREIGN KEY (playlists_id) REFERENCES playlists (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contains ADD CONSTRAINT FK_8EFA6A7EE682647F FOREIGN KEY (soundtracks_id) REFERENCES soundtracks (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7D67B3B43D FOREIGN KEY (users_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7D9F70CF56 FOREIGN KEY (playlists_id) REFERENCES playlists (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE playlists ADD CONSTRAINT FK_5E06116FA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produce ADD CONSTRAINT FK_B9FA245FE682647F FOREIGN KEY (soundtracks_id) REFERENCES soundtracks (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produce ADD CONSTRAINT FK_B9FA245F54A05007 FOREIGN KEY (artists_id) REFERENCES artists (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `reads` ADD CONSTRAINT FK_C8406CB1D5E258C5 FOREIGN KEY (posts_id) REFERENCES posts (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `reads` ADD CONSTRAINT FK_C8406CB167B3B43D FOREIGN KEY (users_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE soundtracks ADD CONSTRAINT FK_B9A80D8B4296D31F FOREIGN KEY (genre_id) REFERENCES genres (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A4B89032C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contains DROP FOREIGN KEY FK_8EFA6A7E9F70CF56
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contains DROP FOREIGN KEY FK_8EFA6A7EE682647F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7D67B3B43D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7D9F70CF56
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE playlists DROP FOREIGN KEY FK_5E06116FA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produce DROP FOREIGN KEY FK_B9FA245FE682647F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produce DROP FOREIGN KEY FK_B9FA245F54A05007
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `reads` DROP FOREIGN KEY FK_C8406CB1D5E258C5
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `reads` DROP FOREIGN KEY FK_C8406CB167B3B43D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE soundtracks DROP FOREIGN KEY FK_B9A80D8B4296D31F
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE artists
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE comments
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE contains
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE genres
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE likes
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE playlists
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE posts
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE produce
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE `reads`
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE soundtracks
        SQL);
    }
}
