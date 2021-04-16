<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210416161324 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE catalog DROP FOREIGN KEY FK_1B2C3247498DA827');
        $this->addSql('DROP INDEX IDX_1B2C3247498DA827 ON catalog');
        $this->addSql('ALTER TABLE catalog ADD property_name VARCHAR(255) NOT NULL, ADD property_value VARCHAR(255) NOT NULL, ADD property_name_ar VARCHAR(255) NOT NULL, ADD property_value_ar VARCHAR(255) NOT NULL, DROP size_id, DROP quantity');
        $this->addSql('ALTER TABLE product ADD quantity INT NOT NULL, DROP weight, DROP materials, DROP materials_ar');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE catalog ADD size_id INT DEFAULT NULL, ADD quantity INT NOT NULL, DROP property_name, DROP property_value, DROP property_name_ar, DROP property_value_ar');
        $this->addSql('ALTER TABLE catalog ADD CONSTRAINT FK_1B2C3247498DA827 FOREIGN KEY (size_id) REFERENCES size (id)');
        $this->addSql('CREATE INDEX IDX_1B2C3247498DA827 ON catalog (size_id)');
        $this->addSql('ALTER TABLE product ADD weight DOUBLE PRECISION DEFAULT NULL, ADD materials VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD materials_ar VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP quantity');
    }
}
