<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240602154437 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE etape_coureur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE etape_coureur (id INT NOT NULL, coureur_id INT NOT NULL, etape_course_id INT NOT NULL, arrivee TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D7A20492F4FA42E5 ON etape_coureur (coureur_id)');
        $this->addSql('CREATE INDEX IDX_D7A20492740F7C7D ON etape_coureur (etape_course_id)');
        $this->addSql('ALTER TABLE etape_coureur ADD CONSTRAINT FK_D7A20492F4FA42E5 FOREIGN KEY (coureur_id) REFERENCES coureur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE etape_coureur ADD CONSTRAINT FK_D7A20492740F7C7D FOREIGN KEY (etape_course_id) REFERENCES etape_course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE etape_coureur_id_seq CASCADE');
        $this->addSql('ALTER TABLE etape_coureur DROP CONSTRAINT FK_D7A20492F4FA42E5');
        $this->addSql('ALTER TABLE etape_coureur DROP CONSTRAINT FK_D7A20492740F7C7D');
        $this->addSql('DROP TABLE etape_coureur');
        $this->addSql('ALTER TABLE coureur ALTER genre DROP NOT NULL');
    }
}
