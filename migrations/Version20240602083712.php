<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240602083712 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE point_rang_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE point_rang (id INT NOT NULL, etape_course_id INT NOT NULL, point DOUBLE PRECISION NOT NULL, rang INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_84F43AC740F7C7D ON point_rang (etape_course_id)');
        $this->addSql('ALTER TABLE point_rang ADD CONSTRAINT FK_84F43AC740F7C7D FOREIGN KEY (etape_course_id) REFERENCES etape_course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE point_rang_id_seq CASCADE');
        $this->addSql('ALTER TABLE point_rang DROP CONSTRAINT FK_84F43AC740F7C7D');
        $this->addSql('DROP TABLE point_rang');
    }
}
