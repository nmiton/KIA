<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220330225039 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal (id INT AUTO_INCREMENT NOT NULL, animal_type_id INT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, is_alive TINYINT(1) NOT NULL, last_active DATETIME NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_6AAB231F4A93E3A9 (animal_type_id), INDEX IDX_6AAB231FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animal_caracteristic (id INT AUTO_INCREMENT NOT NULL, animal_id INT NOT NULL, caracteristic_id INT NOT NULL, value INT NOT NULL, INDEX IDX_B148B2618E962C16 (animal_id), INDEX IDX_B148B26181194CF4 (caracteristic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animal_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE caracteristic (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, lost_by_hour INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inventory (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, objet_id INT NOT NULL, INDEX IDX_B12D4A36A76ED395 (user_id), INDEX IDX_B12D4A36F520CF5A (objet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE objects (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price INT NOT NULL, loss_percentage INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE score (id INT AUTO_INCREMENT NOT NULL, type_animal_id INT DEFAULT NULL, user_id INT DEFAULT NULL, score INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_329937513A506D06 (type_animal_id), INDEX IDX_32993751A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, pseudo VARCHAR(255) NOT NULL, money INT NOT NULL, score INT DEFAULT NULL, is_active TINYINT(1) NOT NULL, last_active DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, is_verified TINYINT(1) NOT NULL, last_connection DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F4A93E3A9 FOREIGN KEY (animal_type_id) REFERENCES animal_type (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE animal_caracteristic ADD CONSTRAINT FK_B148B2618E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE animal_caracteristic ADD CONSTRAINT FK_B148B26181194CF4 FOREIGN KEY (caracteristic_id) REFERENCES caracteristic (id)');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A36A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A36F520CF5A FOREIGN KEY (objet_id) REFERENCES objects (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE score ADD CONSTRAINT FK_329937513A506D06 FOREIGN KEY (type_animal_id) REFERENCES animal_type (id)');
        $this->addSql('ALTER TABLE score ADD CONSTRAINT FK_32993751A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal_caracteristic DROP FOREIGN KEY FK_B148B2618E962C16');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F4A93E3A9');
        $this->addSql('ALTER TABLE score DROP FOREIGN KEY FK_329937513A506D06');
        $this->addSql('ALTER TABLE animal_caracteristic DROP FOREIGN KEY FK_B148B26181194CF4');
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A36F520CF5A');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FA76ED395');
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A36A76ED395');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE score DROP FOREIGN KEY FK_32993751A76ED395');
        $this->addSql('DROP TABLE animal');
        $this->addSql('DROP TABLE animal_caracteristic');
        $this->addSql('DROP TABLE animal_type');
        $this->addSql('DROP TABLE caracteristic');
        $this->addSql('DROP TABLE inventory');
        $this->addSql('DROP TABLE objects');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE score');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
