<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200124194201 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE produit CHANGE date_arrivee date_arrivee DATE NOT NULL, CHANGE date_depart date_depart DATE NOT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27DC304035 FOREIGN KEY (salle_id) REFERENCES salle (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27DC304035 ON produit (salle_id)');
        $this->addSql('ALTER TABLE membre ADD nom VARCHAR(20) NOT NULL, ADD pseudo VARCHAR(20) NOT NULL, ADD prenom VARCHAR(20) NOT NULL, ADD civilite VARCHAR(255) NOT NULL, ADD date_enregistrement DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE membre DROP nom, DROP pseudo, DROP prenom, DROP civilite, DROP date_enregistrement');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27DC304035');
        $this->addSql('DROP INDEX IDX_29A5EC27DC304035 ON produit');
        $this->addSql('ALTER TABLE produit CHANGE date_arrivee date_arrivee DATETIME NOT NULL, CHANGE date_depart date_depart DATETIME NOT NULL');
    }
}
