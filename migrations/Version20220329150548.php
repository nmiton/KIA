<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220329150548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal_caracteristic (id INT AUTO_INCREMENT NOT NULL, animal_id INT NOT NULL, caracteristic_id INT NOT NULL, value INT NOT NULL, INDEX IDX_B148B2618E962C16 (animal_id), INDEX IDX_B148B26181194CF4 (caracteristic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal_caracteristic ADD CONSTRAINT FK_B148B2618E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE animal_caracteristic ADD CONSTRAINT FK_B148B26181194CF4 FOREIGN KEY (caracteristic_id) REFERENCES caracteristic (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE animal_caracteristic');
    }
}
