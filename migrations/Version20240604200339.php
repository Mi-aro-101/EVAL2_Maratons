<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240604200339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE penalite ADD equipe_id INT NOT NULL');
        $this->addSql('ALTER TABLE penalite ADD CONSTRAINT FK_C62D8C5D6D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_C62D8C5D6D861B89 ON penalite (equipe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE coureur ALTER equipe_id SET NOT NULL');
        $this->addSql('ALTER TABLE penalite DROP CONSTRAINT FK_C62D8C5D6D861B89');
        $this->addSql('DROP INDEX IDX_C62D8C5D6D861B89');
        $this->addSql('ALTER TABLE penalite DROP equipe_id');
    }
}
