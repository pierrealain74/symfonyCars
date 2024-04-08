<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240407182000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE color (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE energy (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cars ADD color_id INT NOT NULL, ADD energy_id INT NOT NULL, ADD description LONGTEXT NOT NULL, ADD date_creation DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD price INT NOT NULL, ADD nb_door INT DEFAULT NULL, ADD ct TINYINT(1) DEFAULT NULL, ADD adress_product LONGTEXT DEFAULT NULL, CHANGE color energy VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE cars ADD CONSTRAINT FK_95C71D147ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id)');
        $this->addSql('ALTER TABLE cars ADD CONSTRAINT FK_95C71D14EDDF52D FOREIGN KEY (energy_id) REFERENCES energy (id)');
        $this->addSql('CREATE INDEX IDX_95C71D147ADA1FB5 ON cars (color_id)');
        $this->addSql('CREATE INDEX IDX_95C71D14EDDF52D ON cars (energy_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cars DROP FOREIGN KEY FK_95C71D147ADA1FB5');
        $this->addSql('ALTER TABLE cars DROP FOREIGN KEY FK_95C71D14EDDF52D');
        $this->addSql('DROP TABLE color');
        $this->addSql('DROP TABLE energy');
        $this->addSql('DROP INDEX IDX_95C71D147ADA1FB5 ON cars');
        $this->addSql('DROP INDEX IDX_95C71D14EDDF52D ON cars');
        $this->addSql('ALTER TABLE cars DROP color_id, DROP energy_id, DROP description, DROP date_creation, DROP updated_at, DROP price, DROP nb_door, DROP ct, DROP adress_product, CHANGE energy color VARCHAR(255) DEFAULT NULL');
    }
}
