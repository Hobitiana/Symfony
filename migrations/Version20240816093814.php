<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240816093814 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE renseignement_cin (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, num_cin VARCHAR(255) NOT NULL, date_cin DATE NOT NULL, lieu_cin VARCHAR(255) NOT NULL, duplicata_cin VARCHAR(255) NOT NULL, lieu_duplicata_cin VARCHAR(255) NOT NULL, profession VARCHAR(255) NOT NULL, nom_pere VARCHAR(255) NOT NULL, nom_mere VARCHAR(255) NOT NULL, INDEX IDX_6E2870E6A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE renseignement_entreprise (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, denomination_social VARCHAR(255) NOT NULL, enseigne_commercial VARCHAR(255) NOT NULL, adresse_entreprise VARCHAR(255) NOT NULL, registre_commerce VARCHAR(255) NOT NULL, telephone_entreprise VARCHAR(255) NOT NULL, mail_entreprise VARCHAR(255) NOT NULL, INDEX IDX_3D940D74A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE renseignement_individuelle (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, individu_nom VARCHAR(255) NOT NULL, individu_prenom VARCHAR(255) NOT NULL, adresse_individu VARCHAR(255) NOT NULL, mail_individu VARCHAR(255) NOT NULL, phone_individu VARCHAR(255) NOT NULL, INDEX IDX_86D40981A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE renseignement_responsable (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, responsable VARCHAR(255) NOT NULL, INDEX IDX_48B8548DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE renseignement_type_entreprise (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, type_entrprise VARCHAR(255) NOT NULL, INDEX IDX_A8608D39A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE renseignement_visa (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, num_passeport VARCHAR(255) NOT NULL, statut VARCHAR(255) NOT NULL, nom_passeport VARCHAR(255) NOT NULL, prenom_passeport VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, nationalite VARCHAR(255) NOT NULL, date_delivrance DATE NOT NULL, validite DATE NOT NULL, categorie VARCHAR(255) NOT NULL, INDEX IDX_391B1ACFA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE renseignement_cin ADD CONSTRAINT FK_6E2870E6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE renseignement_entreprise ADD CONSTRAINT FK_3D940D74A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE renseignement_individuelle ADD CONSTRAINT FK_86D40981A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE renseignement_responsable ADD CONSTRAINT FK_48B8548DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE renseignement_type_entreprise ADD CONSTRAINT FK_A8608D39A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE renseignement_visa ADD CONSTRAINT FK_391B1ACFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE renseignement_cin DROP FOREIGN KEY FK_6E2870E6A76ED395');
        $this->addSql('ALTER TABLE renseignement_entreprise DROP FOREIGN KEY FK_3D940D74A76ED395');
        $this->addSql('ALTER TABLE renseignement_individuelle DROP FOREIGN KEY FK_86D40981A76ED395');
        $this->addSql('ALTER TABLE renseignement_responsable DROP FOREIGN KEY FK_48B8548DA76ED395');
        $this->addSql('ALTER TABLE renseignement_type_entreprise DROP FOREIGN KEY FK_A8608D39A76ED395');
        $this->addSql('ALTER TABLE renseignement_visa DROP FOREIGN KEY FK_391B1ACFA76ED395');
        $this->addSql('DROP TABLE renseignement_cin');
        $this->addSql('DROP TABLE renseignement_entreprise');
        $this->addSql('DROP TABLE renseignement_individuelle');
        $this->addSql('DROP TABLE renseignement_responsable');
        $this->addSql('DROP TABLE renseignement_type_entreprise');
        $this->addSql('DROP TABLE renseignement_visa');
    }
}
