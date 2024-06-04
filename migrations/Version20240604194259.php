<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240604194259 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE penalite_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE penalite (id INT NOT NULL, etape_course_id INT NOT NULL, temps TIME(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C62D8C5D740F7C7D ON penalite (etape_course_id)');
        $this->addSql('ALTER TABLE penalite ADD CONSTRAINT FK_C62D8C5D740F7C7D FOREIGN KEY (etape_course_id) REFERENCES etape_course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE penalite_id_seq CASCADE');
        $this->addSql('ALTER TABLE penalite DROP CONSTRAINT FK_C62D8C5D740F7C7D');
        $this->addSql('DROP TABLE penalite');
        $this->addSql('ALTER TABLE coureur ALTER equipe_id SET NOT NULL');
    }
}
