<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240913082809 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE borne (id INT AUTO_INCREMENT NOT NULL, le_type_borne_id INT DEFAULT NULL, la_station_id INT DEFAULT NULL, date_derniere_revision DATE NOT NULL, indice_compteur_unites INT NOT NULL, INDEX IDX_D7465BA5CF77CA31 (le_type_borne_id), INDEX IDX_D7465BA51BBF6E1 (la_station_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maintenance (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE station (id INT AUTO_INCREMENT NOT NULL, la_maintenance_id INT DEFAULT NULL, libelle_emplacement VARCHAR(255) NOT NULL, INDEX IDX_9F39F8B145538E20 (la_maintenance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technicien (id INT AUTO_INCREMENT NOT NULL, la_maintenance_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, INDEX IDX_96282C4C45538E20 (la_maintenance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_borne (id INT AUTO_INCREMENT NOT NULL, duree_revision INT NOT NULL, nb_jours_entre_revisions INT NOT NULL, nb_unites_entre_revisions INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visite (id INT AUTO_INCREMENT NOT NULL, la_station_id INT DEFAULT NULL, la_maintenance_id INT DEFAULT NULL, le_technicien_id INT DEFAULT NULL, etat VARCHAR(255) NOT NULL, duree_totale INT NOT NULL, INDEX IDX_B09C8CBB1BBF6E1 (la_station_id), INDEX IDX_B09C8CBB45538E20 (la_maintenance_id), INDEX IDX_B09C8CBB6ECFA5CD (le_technicien_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visite_borne (visite_id INT NOT NULL, borne_id INT NOT NULL, INDEX IDX_6BADA910C1C5DC59 (visite_id), INDEX IDX_6BADA9107F023A56 (borne_id), PRIMARY KEY(visite_id, borne_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE borne ADD CONSTRAINT FK_D7465BA5CF77CA31 FOREIGN KEY (le_type_borne_id) REFERENCES type_borne (id)');
        $this->addSql('ALTER TABLE borne ADD CONSTRAINT FK_D7465BA51BBF6E1 FOREIGN KEY (la_station_id) REFERENCES station (id)');
        $this->addSql('ALTER TABLE station ADD CONSTRAINT FK_9F39F8B145538E20 FOREIGN KEY (la_maintenance_id) REFERENCES maintenance (id)');
        $this->addSql('ALTER TABLE technicien ADD CONSTRAINT FK_96282C4C45538E20 FOREIGN KEY (la_maintenance_id) REFERENCES maintenance (id)');
        $this->addSql('ALTER TABLE visite ADD CONSTRAINT FK_B09C8CBB1BBF6E1 FOREIGN KEY (la_station_id) REFERENCES station (id)');
        $this->addSql('ALTER TABLE visite ADD CONSTRAINT FK_B09C8CBB45538E20 FOREIGN KEY (la_maintenance_id) REFERENCES maintenance (id)');
        $this->addSql('ALTER TABLE visite ADD CONSTRAINT FK_B09C8CBB6ECFA5CD FOREIGN KEY (le_technicien_id) REFERENCES technicien (id)');
        $this->addSql('ALTER TABLE visite_borne ADD CONSTRAINT FK_6BADA910C1C5DC59 FOREIGN KEY (visite_id) REFERENCES visite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE visite_borne ADD CONSTRAINT FK_6BADA9107F023A56 FOREIGN KEY (borne_id) REFERENCES borne (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE borne DROP FOREIGN KEY FK_D7465BA5CF77CA31');
        $this->addSql('ALTER TABLE borne DROP FOREIGN KEY FK_D7465BA51BBF6E1');
        $this->addSql('ALTER TABLE station DROP FOREIGN KEY FK_9F39F8B145538E20');
        $this->addSql('ALTER TABLE technicien DROP FOREIGN KEY FK_96282C4C45538E20');
        $this->addSql('ALTER TABLE visite DROP FOREIGN KEY FK_B09C8CBB1BBF6E1');
        $this->addSql('ALTER TABLE visite DROP FOREIGN KEY FK_B09C8CBB45538E20');
        $this->addSql('ALTER TABLE visite DROP FOREIGN KEY FK_B09C8CBB6ECFA5CD');
        $this->addSql('ALTER TABLE visite_borne DROP FOREIGN KEY FK_6BADA910C1C5DC59');
        $this->addSql('ALTER TABLE visite_borne DROP FOREIGN KEY FK_6BADA9107F023A56');
        $this->addSql('DROP TABLE borne');
        $this->addSql('DROP TABLE maintenance');
        $this->addSql('DROP TABLE station');
        $this->addSql('DROP TABLE technicien');
        $this->addSql('DROP TABLE type_borne');
        $this->addSql('DROP TABLE visite');
        $this->addSql('DROP TABLE visite_borne');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
