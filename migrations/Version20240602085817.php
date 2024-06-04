<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240602085817 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coureur ADD equipe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE coureur ADD CONSTRAINT FK_8CCBA7496D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8CCBA7496D861B89 ON coureur (equipe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE coureur DROP CONSTRAINT FK_8CCBA7496D861B89');
        $this->addSql('DROP INDEX IDX_8CCBA7496D861B89');
        $this->addSql('ALTER TABLE coureur DROP equipe_id');
    }
}
