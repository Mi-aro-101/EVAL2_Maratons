<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240605075415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classement ADD genre VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE classement ADD temps VARCHAR(155) NOT NULL');
        $this->addSql('ALTER TABLE classement ADD penalite_temps VARCHAR(155) NOT NULL');
        $this->addSql('ALTER TABLE classement ADD temps_final VARCHAR(155) NOT NULL');
        $this->addSql('ALTER TABLE classement_categorie ADD genre VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE classement_categorie ADD temps VARCHAR(155) NOT NULL');
        $this->addSql('ALTER TABLE classement_categorie ADD penalite_temps VARCHAR(155) NOT NULL');
        $this->addSql('ALTER TABLE classement_categorie ADD temps_final VARCHAR(155) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE classement DROP genre');
        $this->addSql('ALTER TABLE classement DROP temps');
        $this->addSql('ALTER TABLE classement DROP penalite_temps');
        $this->addSql('ALTER TABLE classement DROP temps_final');
        $this->addSql('ALTER TABLE penalite ALTER temps TYPE VARCHAR(255)');
        $this->addSql('CREATE UNIQUE INDEX coureur_numero_dossard_key ON coureur (numero_dossard)');
        $this->addSql('ALTER TABLE classement_categorie DROP genre');
        $this->addSql('ALTER TABLE classement_categorie DROP temps');
        $this->addSql('ALTER TABLE classement_categorie DROP penalite_temps');
        $this->addSql('ALTER TABLE classement_categorie DROP temps_final');
    }
}
