<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251130101211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, property_id INT NOT NULL, filename VARCHAR(255) NOT NULL, INDEX IDX_16DB4F89549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE preference (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, surface INT NOT NULL, rooms INT NOT NULL, bedrooms INT NOT NULL, floor INT NOT NULL, price INT NOT NULL, heat INT NOT NULL, city VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, sold TINYINT(1) DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, lat DOUBLE PRECISION NOT NULL, lng DOUBLE PRECISION NOT NULL, no VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property_preference (property_id INT NOT NULL, preference_id INT NOT NULL, INDEX IDX_E8C89060549213EC (property_id), INDEX IDX_E8C89060D81022C0 (preference_id), PRIMARY KEY(property_id, preference_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE property_preference ADD CONSTRAINT FK_E8C89060549213EC FOREIGN KEY (property_id) REFERENCES property (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE property_preference ADD CONSTRAINT FK_E8C89060D81022C0 FOREIGN KEY (preference_id) REFERENCES preference (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89549213EC');
        $this->addSql('ALTER TABLE property_preference DROP FOREIGN KEY FK_E8C89060549213EC');
        $this->addSql('ALTER TABLE property_preference DROP FOREIGN KEY FK_E8C89060D81022C0');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP TABLE preference');
        $this->addSql('DROP TABLE property');
        $this->addSql('DROP TABLE property_preference');
        $this->addSql('DROP TABLE user');
    }
}
