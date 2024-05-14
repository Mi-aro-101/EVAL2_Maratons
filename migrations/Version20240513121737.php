<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240513121737 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE travaux_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE travaux (id INT NOT NULL, type_travaux_id INT NOT NULL, unite_id INT NOT NULL, description TEXT NOT NULL, prix_unitaire NUMERIC(14, 2) NOT NULL, code VARCHAR(3) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6C24F39B899612C7 ON travaux (type_travaux_id)');
        $this->addSql('CREATE INDEX IDX_6C24F39BEC4A74AB ON travaux (unite_id)');
        $this->addSql('ALTER TABLE travaux ADD CONSTRAINT FK_6C24F39B899612C7 FOREIGN KEY (type_travaux_id) REFERENCES type_travaux (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE travaux ADD CONSTRAINT FK_6C24F39BEC4A74AB FOREIGN KEY (unite_id) REFERENCES unite (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE travaux_id_seq CASCADE');
        $this->addSql('ALTER TABLE travaux DROP CONSTRAINT FK_6C24F39B899612C7');
        $this->addSql('ALTER TABLE travaux DROP CONSTRAINT FK_6C24F39BEC4A74AB');
        $this->addSql('DROP TABLE travaux');
    }
}
