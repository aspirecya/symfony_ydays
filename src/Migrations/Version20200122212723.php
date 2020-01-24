<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200122212723 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC2792419D3E');
        $this->addSql('DROP INDEX IDX_29A5EC2792419D3E ON produit');
        $this->addSql('ALTER TABLE produit ADD salle_id INT NOT NULL, DROP salle_id_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE produit ADD salle_id_id INT DEFAULT NULL, DROP salle_id');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC2792419D3E FOREIGN KEY (salle_id_id) REFERENCES salle (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC2792419D3E ON produit (salle_id_id)');
    }
}
