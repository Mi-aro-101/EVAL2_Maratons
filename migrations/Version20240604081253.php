<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240604081253 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE classement_categorie_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE classement_categorie (id INT NOT NULL, coureur_id INT NOT NULL, etape_course_id INT NOT NULL, categorie_coureur_id INT NOT NULL, rang INT NOT NULL, point DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FC95ACC3F4FA42E5 ON classement_categorie (coureur_id)');
        $this->addSql('CREATE INDEX IDX_FC95ACC3740F7C7D ON classement_categorie (etape_course_id)');
        $this->addSql('CREATE INDEX IDX_FC95ACC36A338849 ON classement_categorie (categorie_coureur_id)');
        $this->addSql('ALTER TABLE classement_categorie ADD CONSTRAINT FK_FC95ACC3F4FA42E5 FOREIGN KEY (coureur_id) REFERENCES coureur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE classement_categorie ADD CONSTRAINT FK_FC95ACC3740F7C7D FOREIGN KEY (etape_course_id) REFERENCES etape_course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE classement_categorie ADD CONSTRAINT FK_FC95ACC36A338849 FOREIGN KEY (categorie_coureur_id) REFERENCES categorie_coureur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE classement_categorie_id_seq CASCADE');
        $this->addSql('ALTER TABLE classement_categorie DROP CONSTRAINT FK_FC95ACC3F4FA42E5');
        $this->addSql('ALTER TABLE classement_categorie DROP CONSTRAINT FK_FC95ACC3740F7C7D');
        $this->addSql('ALTER TABLE classement_categorie DROP CONSTRAINT FK_FC95ACC36A338849');
        $this->addSql('DROP TABLE classement_categorie');
        $this->addSql('ALTER TABLE coureur ALTER equipe_id SET NOT NULL');
    }
}
