<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250618120228 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE artists_soundtracks (artists_id INT NOT NULL, soundtracks_id INT NOT NULL, INDEX IDX_2640A3FE54A05007 (artists_id), INDEX IDX_2640A3FEE682647F (soundtracks_id), PRIMARY KEY(artists_id, soundtracks_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE users_soundtracks (users_id INT NOT NULL, soundtracks_id INT NOT NULL, INDEX IDX_4E1D317967B3B43D (users_id), INDEX IDX_4E1D3179E682647F (soundtracks_id), PRIMARY KEY(users_id, soundtracks_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE artists_soundtracks ADD CONSTRAINT FK_2640A3FE54A05007 FOREIGN KEY (artists_id) REFERENCES artists (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE artists_soundtracks ADD CONSTRAINT FK_2640A3FEE682647F FOREIGN KEY (soundtracks_id) REFERENCES soundtracks (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users_soundtracks ADD CONSTRAINT FK_4E1D317967B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users_soundtracks ADD CONSTRAINT FK_4E1D3179E682647F FOREIGN KEY (soundtracks_id) REFERENCES soundtracks (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contains DROP FOREIGN KEY FK_8EFA6A7E9F70CF56
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contains DROP FOREIGN KEY FK_8EFA6A7EE682647F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produce DROP FOREIGN KEY FK_B9FA245F54A05007
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produce DROP FOREIGN KEY FK_B9FA245FE682647F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `reads` DROP FOREIGN KEY FK_C8406CB167B3B43D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `reads` DROP FOREIGN KEY FK_C8406CB1D5E258C5
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE contains
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE produce
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE `reads`
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE contains (id INT AUTO_INCREMENT NOT NULL, playlists_id INT NOT NULL, soundtracks_id INT NOT NULL, INDEX IDX_8EFA6A7EE682647F (soundtracks_id), INDEX IDX_8EFA6A7E9F70CF56 (playlists_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE produce (id INT AUTO_INCREMENT NOT NULL, soundtracks_id INT NOT NULL, artists_id INT NOT NULL, INDEX IDX_B9FA245F54A05007 (artists_id), INDEX IDX_B9FA245FE682647F (soundtracks_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE `reads` (id INT AUTO_INCREMENT NOT NULL, posts_id INT DEFAULT NULL, users_id INT DEFAULT NULL, INDEX IDX_C8406CB167B3B43D (users_id), INDEX IDX_C8406CB1D5E258C5 (posts_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contains ADD CONSTRAINT FK_8EFA6A7E9F70CF56 FOREIGN KEY (playlists_id) REFERENCES playlists (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contains ADD CONSTRAINT FK_8EFA6A7EE682647F FOREIGN KEY (soundtracks_id) REFERENCES soundtracks (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produce ADD CONSTRAINT FK_B9FA245F54A05007 FOREIGN KEY (artists_id) REFERENCES artists (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produce ADD CONSTRAINT FK_B9FA245FE682647F FOREIGN KEY (soundtracks_id) REFERENCES soundtracks (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `reads` ADD CONSTRAINT FK_C8406CB167B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `reads` ADD CONSTRAINT FK_C8406CB1D5E258C5 FOREIGN KEY (posts_id) REFERENCES posts (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE artists_soundtracks DROP FOREIGN KEY FK_2640A3FE54A05007
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE artists_soundtracks DROP FOREIGN KEY FK_2640A3FEE682647F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users_soundtracks DROP FOREIGN KEY FK_4E1D317967B3B43D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users_soundtracks DROP FOREIGN KEY FK_4E1D3179E682647F
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE artists_soundtracks
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE users_soundtracks
        SQL);
    }
}
