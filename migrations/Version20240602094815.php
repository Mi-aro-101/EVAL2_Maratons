<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240602094815 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE coureur_categorie_coureur (coureur_id INT NOT NULL, categorie_coureur_id INT NOT NULL, PRIMARY KEY(coureur_id, categorie_coureur_id))');
        $this->addSql('CREATE INDEX IDX_CAF43B33F4FA42E5 ON coureur_categorie_coureur (coureur_id)');
        $this->addSql('CREATE INDEX IDX_CAF43B336A338849 ON coureur_categorie_coureur (categorie_coureur_id)');
        $this->addSql('ALTER TABLE coureur_categorie_coureur ADD CONSTRAINT FK_CAF43B33F4FA42E5 FOREIGN KEY (coureur_id) REFERENCES coureur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE coureur_categorie_coureur ADD CONSTRAINT FK_CAF43B336A338849 FOREIGN KEY (categorie_coureur_id) REFERENCES categorie_coureur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE coureur_categorie_coureur DROP CONSTRAINT FK_CAF43B33F4FA42E5');
        $this->addSql('ALTER TABLE coureur_categorie_coureur DROP CONSTRAINT FK_CAF43B336A338849');
        $this->addSql('DROP TABLE coureur_categorie_coureur');
    }
}
