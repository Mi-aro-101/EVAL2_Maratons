<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240603085448 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE etape_course_mirror_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE etape_course_mirror (id INT NOT NULL, etape VARCHAR(255) NOT NULL, longueur VARCHAR(255) NOT NULL, nbr_coureur VARCHAR(2) NOT NULL, rang VARCHAR(2) NOT NULL, date_depart VARCHAR(30) NOT NULL, heure_depart VARCHAR(30) NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE etape_course_mirror_id_seq CASCADE');
        $this->addSql('DROP TABLE etape_course_mirror');
        $this->addSql('ALTER TABLE coureur ALTER equipe_id SET NOT NULL');
        $this->addSql('ALTER TABLE etape_course ALTER rang_etape SET NOT NULL');
    }
}
