<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250701122411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE users_soundtracks DROP FOREIGN KEY FK_4E1D317967B3B43D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users_soundtracks DROP FOREIGN KEY FK_4E1D3179E682647F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE soundtracks DROP FOREIGN KEY FK_B9A80D8B4296D31F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A4B89032C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE artists_soundtracks DROP FOREIGN KEY FK_2640A3FE54A05007
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE artists_soundtracks DROP FOREIGN KEY FK_2640A3FEE682647F
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE users_soundtracks
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE soundtracks
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE comments
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE artists_soundtracks
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE users_soundtracks (users_id INT NOT NULL, soundtracks_id INT NOT NULL, INDEX IDX_4E1D3179E682647F (soundtracks_id), INDEX IDX_4E1D317967B3B43D (users_id), PRIMARY KEY(users_id, soundtracks_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE soundtracks (id INT AUTO_INCREMENT NOT NULL, genre_id INT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, cover VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, url_soundtrack VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_B9A80D8B4296D31F (genre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, post_id INT DEFAULT NULL, user_id INT DEFAULT NULL, content LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_5F9E962A4B89032C (post_id), INDEX IDX_5F9E962AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE artists_soundtracks (artists_id INT NOT NULL, soundtracks_id INT NOT NULL, INDEX IDX_2640A3FEE682647F (soundtracks_id), INDEX IDX_2640A3FE54A05007 (artists_id), PRIMARY KEY(artists_id, soundtracks_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users_soundtracks ADD CONSTRAINT FK_4E1D317967B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users_soundtracks ADD CONSTRAINT FK_4E1D3179E682647F FOREIGN KEY (soundtracks_id) REFERENCES soundtracks (id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE soundtracks ADD CONSTRAINT FK_B9A80D8B4296D31F FOREIGN KEY (genre_id) REFERENCES genres (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A4B89032C FOREIGN KEY (post_id) REFERENCES posts (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE artists_soundtracks ADD CONSTRAINT FK_2640A3FE54A05007 FOREIGN KEY (artists_id) REFERENCES artists (id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE artists_soundtracks ADD CONSTRAINT FK_2640A3FEE682647F FOREIGN KEY (soundtracks_id) REFERENCES soundtracks (id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
    }
}
