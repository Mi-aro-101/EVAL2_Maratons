<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240603130957 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE resultat_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE resultat (id INT NOT NULL, etape_rang VARCHAR(5) NOT NULL, numero_dossard VARCHAR(5) NOT NULL, nom VARCHAR(255) NOT NULL, genre VARCHAR(1) NOT NULL, date_naissance VARCHAR(50) NOT NULL, equipe VARCHAR(100) NOT NULL, arrivee VARCHAR(155) NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE resultat_id_seq CASCADE');
        $this->addSql('DROP TABLE resultat');
        $this->addSql('ALTER TABLE coureur ALTER equipe_id SET NOT NULL');
    }
}
