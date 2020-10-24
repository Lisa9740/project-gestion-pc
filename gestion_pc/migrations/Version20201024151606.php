<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201024151606 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attribution (id INT AUTO_INCREMENT NOT NULL, computer_id INT DEFAULT NULL, customer_id INT DEFAULT NULL, date DATE NOT NULL, hour INT NOT NULL, INDEX IDX_C751ED49A426D518 (computer_id), INDEX IDX_C751ED499395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE computer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attribution ADD CONSTRAINT FK_C751ED49A426D518 FOREIGN KEY (computer_id) REFERENCES computer (id)');
        $this->addSql('ALTER TABLE attribution ADD CONSTRAINT FK_C751ED499395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attribution DROP FOREIGN KEY FK_C751ED49A426D518');
        $this->addSql('ALTER TABLE attribution DROP FOREIGN KEY FK_C751ED499395C3F3');
        $this->addSql('DROP TABLE attribution');
        $this->addSql('DROP TABLE computer');
        $this->addSql('DROP TABLE customer');
    }
}
