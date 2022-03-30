<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220329104658 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal (id INT AUTO_INCREMENT NOT NULL, animal_type_id INT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, is_alive TINYINT(1) NOT NULL, last_active DATETIME NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_6AAB231F4A93E3A9 (animal_type_id), INDEX IDX_6AAB231FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animal_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F4A93E3A9 FOREIGN KEY (animal_type_id) REFERENCES animal_type (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F4A93E3A9');
        $this->addSql('DROP TABLE animal');
        $this->addSql('DROP TABLE animal_type');
    }
}
