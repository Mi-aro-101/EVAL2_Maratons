<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240603210311 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE classement_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE classement (id INT NOT NULL, coureur_id INT NOT NULL, etape_course_id INT NOT NULL, rang INT NOT NULL, point DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_55EE9D6DF4FA42E5 ON classement (coureur_id)');
        $this->addSql('CREATE INDEX IDX_55EE9D6D740F7C7D ON classement (etape_course_id)');
        $this->addSql('ALTER TABLE classement ADD CONSTRAINT FK_55EE9D6DF4FA42E5 FOREIGN KEY (coureur_id) REFERENCES coureur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE classement ADD CONSTRAINT FK_55EE9D6D740F7C7D FOREIGN KEY (etape_course_id) REFERENCES etape_course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE classement_id_seq CASCADE');
        $this->addSql('ALTER TABLE classement DROP CONSTRAINT FK_55EE9D6DF4FA42E5');
        $this->addSql('ALTER TABLE classement DROP CONSTRAINT FK_55EE9D6D740F7C7D');
        $this->addSql('DROP TABLE classement');
        $this->addSql('ALTER TABLE coureur ALTER equipe_id SET NOT NULL');
        $this->addSql('ALTER TABLE coureur ALTER genre SET NOT NULL');
    }
}
