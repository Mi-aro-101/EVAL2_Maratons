<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240605080124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classement ALTER temps DROP NOT NULL');
        $this->addSql('ALTER TABLE classement ALTER penalite_temps DROP NOT NULL');
        $this->addSql('ALTER TABLE classement ALTER temps_final DROP NOT NULL');
        $this->addSql('ALTER TABLE classement_categorie ALTER genre DROP NOT NULL');
        $this->addSql('ALTER TABLE classement_categorie ALTER temps DROP NOT NULL');
        $this->addSql('ALTER TABLE classement_categorie ALTER penalite_temps DROP NOT NULL');
        $this->addSql('ALTER TABLE classement_categorie ALTER temps_final DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE penalite ALTER temps TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE classement ALTER temps SET NOT NULL');
        $this->addSql('ALTER TABLE classement ALTER penalite_temps SET NOT NULL');
        $this->addSql('ALTER TABLE classement ALTER temps_final SET NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX coureur_numero_dossard_key ON coureur (numero_dossard)');
        $this->addSql('ALTER TABLE classement_categorie ALTER genre SET NOT NULL');
        $this->addSql('ALTER TABLE classement_categorie ALTER temps SET NOT NULL');
        $this->addSql('ALTER TABLE classement_categorie ALTER penalite_temps SET NOT NULL');
        $this->addSql('ALTER TABLE classement_categorie ALTER temps_final SET NOT NULL');
    }
}
