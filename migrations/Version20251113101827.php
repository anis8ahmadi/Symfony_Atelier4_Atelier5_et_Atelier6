<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251113101827 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE modele (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, pays VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP INDEX UNIQ_C7440455ABE530DA ON client');
        $this->addSql('ALTER TABLE client ADD telephone VARCHAR(255) NOT NULL, DROP cin, CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE prenom prenom VARCHAR(255) NOT NULL, CHANGE adresse adresse VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE location ADD voiture_id INT DEFAULT NULL, ADD client_id INT DEFAULT NULL, CHANGE date_retour date_fin DATETIME NOT NULL, CHANGE prix prix_total NUMERIC(10, 2) NOT NULL');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB181A8BA FOREIGN KEY (voiture_id) REFERENCES voiture (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_5E9E89CB181A8BA ON location (voiture_id)');
        $this->addSql('CREATE INDEX IDX_5E9E89CB19EB6921 ON location (client_id)');
        $this->addSql('DROP INDEX UNIQ_E9E2810FAA3A9334 ON voiture');
        $this->addSql('ALTER TABLE voiture ADD modele_id INT DEFAULT NULL, DROP modele, CHANGE serie serie VARCHAR(255) DEFAULT NULL, CHANGE prix_jour prix_jour DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810FAC14B70A FOREIGN KEY (modele_id) REFERENCES modele (id)');
        $this->addSql('CREATE INDEX IDX_E9E2810FAC14B70A ON voiture (modele_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810FAC14B70A');
        $this->addSql('DROP TABLE modele');
        $this->addSql('ALTER TABLE client ADD cin VARCHAR(8) NOT NULL, DROP telephone, CHANGE nom nom VARCHAR(100) NOT NULL, CHANGE prenom prenom VARCHAR(100) NOT NULL, CHANGE adresse adresse VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455ABE530DA ON client (cin)');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB181A8BA');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB19EB6921');
        $this->addSql('DROP INDEX IDX_5E9E89CB181A8BA ON location');
        $this->addSql('DROP INDEX IDX_5E9E89CB19EB6921 ON location');
        $this->addSql('ALTER TABLE location DROP voiture_id, DROP client_id, CHANGE date_fin date_retour DATETIME NOT NULL, CHANGE prix_total prix NUMERIC(10, 2) NOT NULL');
        $this->addSql('DROP INDEX IDX_E9E2810FAC14B70A ON voiture');
        $this->addSql('ALTER TABLE voiture ADD modele VARCHAR(50) NOT NULL, DROP modele_id, CHANGE serie serie VARCHAR(50) NOT NULL, CHANGE prix_jour prix_jour NUMERIC(10, 2) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E9E2810FAA3A9334 ON voiture (serie)');
    }
}
