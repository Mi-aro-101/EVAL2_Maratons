<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240602093348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coureur ALTER equipe_id DROP NOT NULL');
        $this->addSql('ALTER TABLE equipe ADD utilisateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE equipe ADD CONSTRAINT FK_2449BA15FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2449BA15FB88E14F ON equipe (utilisateur_id)');
        $this->addSql('ALTER TABLE utilisateur DROP CONSTRAINT fk_1d1c63b36d861b89');
        $this->addSql('DROP INDEX uniq_1d1c63b36d861b89');
        $this->addSql('ALTER TABLE utilisateur DROP equipe_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE utilisateur ADD equipe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT fk_1d1c63b36d861b89 FOREIGN KEY (equipe_id) REFERENCES equipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_1d1c63b36d861b89 ON utilisateur (equipe_id)');
        $this->addSql('ALTER TABLE equipe DROP CONSTRAINT FK_2449BA15FB88E14F');
        $this->addSql('DROP INDEX UNIQ_2449BA15FB88E14F');
        $this->addSql('ALTER TABLE equipe DROP utilisateur_id');
        $this->addSql('ALTER TABLE coureur ALTER equipe_id SET NOT NULL');
    }
}
