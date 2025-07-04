<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250702113253 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE artists DROP FOREIGN KEY FK_68D3801E6A3B2603
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_68D3801E6A3B2603 ON artists
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE artists CHANGE genres_id genre_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE artists ADD CONSTRAINT FK_68D3801E4296D31F FOREIGN KEY (genre_id) REFERENCES genres (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_68D3801E4296D31F ON artists (genre_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A67B3B43D
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_5F9E962A67B3B43D ON comments
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE comments CHANGE users_id user_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_5F9E962AA76ED395 ON comments (user_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE artists DROP FOREIGN KEY FK_68D3801E4296D31F
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_68D3801E4296D31F ON artists
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE artists CHANGE genre_id genres_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE artists ADD CONSTRAINT FK_68D3801E6A3B2603 FOREIGN KEY (genres_id) REFERENCES genres (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_68D3801E6A3B2603 ON artists (genres_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_5F9E962AA76ED395 ON comments
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE comments CHANGE user_id users_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_5F9E962A67B3B43D ON comments (users_id)
        SQL);
    }
}
