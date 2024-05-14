<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240513123458 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE travaux_maison_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE travaux_maison (id INT NOT NULL, type_maison_id INT NOT NULL, travaux_id INT NOT NULL, quantite DOUBLE PRECISION NOT NULL, duree TIME(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3B47D9E029A199BF ON travaux_maison (type_maison_id)');
        $this->addSql('CREATE INDEX IDX_3B47D9E09495C4E2 ON travaux_maison (travaux_id)');
        $this->addSql('ALTER TABLE travaux_maison ADD CONSTRAINT FK_3B47D9E029A199BF FOREIGN KEY (type_maison_id) REFERENCES type_maison (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE travaux_maison ADD CONSTRAINT FK_3B47D9E09495C4E2 FOREIGN KEY (travaux_id) REFERENCES travaux (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE travaux_maison_id_seq CASCADE');
        $this->addSql('ALTER TABLE travaux_maison DROP CONSTRAINT FK_3B47D9E029A199BF');
        $this->addSql('ALTER TABLE travaux_maison DROP CONSTRAINT FK_3B47D9E09495C4E2');
        $this->addSql('DROP TABLE travaux_maison');
        $this->addSql('ALTER TABLE travaux ALTER description TYPE TEXT');
    }
}
