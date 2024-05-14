<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240513193129 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE devis_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE devis_details_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE devis (id INT NOT NULL, type_maison_id INT NOT NULL, type_finition_id INT NOT NULL, prix NUMERIC(14, 2) NOT NULL, date_devis DATE NOT NULL, date_debut_travaux DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8B27C52B29A199BF ON devis (type_maison_id)');
        $this->addSql('CREATE INDEX IDX_8B27C52B804F223E ON devis (type_finition_id)');
        $this->addSql('CREATE TABLE devis_details (id INT NOT NULL, devis_id INT NOT NULL, pourcentage_finition NUMERIC(5, 2) NOT NULL, quantite_travaux DOUBLE PRECISION NOT NULL, prix_unitaire NUMERIC(14, 2) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E0C890D641DEFADA ON devis_details (devis_id)');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52B29A199BF FOREIGN KEY (type_maison_id) REFERENCES type_maison (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52B804F223E FOREIGN KEY (type_finition_id) REFERENCES type_finition (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devis_details ADD CONSTRAINT FK_E0C890D641DEFADA FOREIGN KEY (devis_id) REFERENCES devis (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE travaux ALTER description TYPE VARCHAR(255)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE devis_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE devis_details_id_seq CASCADE');
        $this->addSql('ALTER TABLE devis DROP CONSTRAINT FK_8B27C52B29A199BF');
        $this->addSql('ALTER TABLE devis DROP CONSTRAINT FK_8B27C52B804F223E');
        $this->addSql('ALTER TABLE devis_details DROP CONSTRAINT FK_E0C890D641DEFADA');
        $this->addSql('DROP TABLE devis');
        $this->addSql('DROP TABLE devis_details');
        $this->addSql('ALTER TABLE travaux ALTER description TYPE TEXT');
    }
}
