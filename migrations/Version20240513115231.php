<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240513115231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE unite_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE unite (id INT NOT NULL, designation VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE type_travaux ALTER code TYPE VARCHAR(3)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE unite_id_seq CASCADE');
        $this->addSql('DROP TABLE unite');
        $this->addSql('ALTER TABLE type_travaux ALTER code TYPE CHAR(3)');
    }
}
