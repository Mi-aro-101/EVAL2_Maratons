<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240602083003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE etape_course_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE etape_course (id INT NOT NULL, course_id INT NOT NULL, nbr_coureur INT NOT NULL, nom_etape VARCHAR(155) NOT NULL, longueur DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A193A906591CC992 ON etape_course (course_id)');
        $this->addSql('ALTER TABLE etape_course ADD CONSTRAINT FK_A193A906591CC992 FOREIGN KEY (course_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE etape_course_id_seq CASCADE');
        $this->addSql('ALTER TABLE etape_course DROP CONSTRAINT FK_A193A906591CC992');
        $this->addSql('DROP TABLE etape_course');
    }
}
