<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220609132637 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, country_code VARCHAR(255) NOT NULL, iso3166_2 VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE house (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE house_location (house_id INT NOT NULL, location_id INT NOT NULL, INDEX IDX_3D0C32946BB74515 (house_id), INDEX IDX_3D0C329464D218E (location_id), PRIMARY KEY(house_id, location_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, city_id INT DEFAULT NULL, country_id INT DEFAULT NULL, municipality_id INT DEFAULT NULL, neighbourhood_id INT DEFAULT NULL, postcode_id INT DEFAULT NULL, road_id INT DEFAULT NULL, state_id INT DEFAULT NULL, address_id INT DEFAULT NULL, latitude NUMERIC(10, 8) NOT NULL, longitude NUMERIC(11, 8) NOT NULL, importance NUMERIC(3, 2) DEFAULT NULL, osmid INT DEFAULT NULL, INDEX IDX_5E9E89CB8BAC62AF (city_id), INDEX IDX_5E9E89CBF92F3E70 (country_id), INDEX IDX_5E9E89CBAE6F181C (municipality_id), INDEX IDX_5E9E89CBF05C3E1C (neighbourhood_id), INDEX IDX_5E9E89CBEECBFDF1 (postcode_id), INDEX IDX_5E9E89CB962F8178 (road_id), INDEX IDX_5E9E89CB5D83CC1 (state_id), INDEX IDX_5E9E89CBF5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE municipality (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE neighbourhood (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE postcode (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE road (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE state (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE house_location ADD CONSTRAINT FK_3D0C32946BB74515 FOREIGN KEY (house_id) REFERENCES house (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE house_location ADD CONSTRAINT FK_3D0C329464D218E FOREIGN KEY (location_id) REFERENCES location (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CBF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CBAE6F181C FOREIGN KEY (municipality_id) REFERENCES municipality (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CBF05C3E1C FOREIGN KEY (neighbourhood_id) REFERENCES neighbourhood (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CBEECBFDF1 FOREIGN KEY (postcode_id) REFERENCES postcode (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB962F8178 FOREIGN KEY (road_id) REFERENCES road (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB5D83CC1 FOREIGN KEY (state_id) REFERENCES state (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CBF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBF5B7AF75');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB8BAC62AF');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBF92F3E70');
        $this->addSql('ALTER TABLE house_location DROP FOREIGN KEY FK_3D0C32946BB74515');
        $this->addSql('ALTER TABLE house_location DROP FOREIGN KEY FK_3D0C329464D218E');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBAE6F181C');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBF05C3E1C');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBEECBFDF1');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB962F8178');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB5D83CC1');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE house');
        $this->addSql('DROP TABLE house_location');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE municipality');
        $this->addSql('DROP TABLE neighbourhood');
        $this->addSql('DROP TABLE postcode');
        $this->addSql('DROP TABLE road');
        $this->addSql('DROP TABLE state');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
