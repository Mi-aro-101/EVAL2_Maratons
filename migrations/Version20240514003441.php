<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240514003441 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE paiement_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE paiement (id INT NOT NULL, client_id INT NOT NULL, devis_id INT NOT NULL, montant NUMERIC(14, 2) NOT NULL, date_paiement DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B1DC7A1E19EB6921 ON paiement (client_id)');
        $this->addSql('CREATE INDEX IDX_B1DC7A1E41DEFADA ON paiement (devis_id)');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1E19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1E41DEFADA FOREIGN KEY (devis_id) REFERENCES devis (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE paiement_id_seq CASCADE');
        $this->addSql('ALTER TABLE paiement DROP CONSTRAINT FK_B1DC7A1E19EB6921');
        $this->addSql('ALTER TABLE paiement DROP CONSTRAINT FK_B1DC7A1E41DEFADA');
        $this->addSql('DROP TABLE paiement');
    }
}
