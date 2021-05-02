<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210501212153 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product CHANGE hot_degree hot_degree_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD52F30384 FOREIGN KEY (hot_degree_id) REFERENCES hot_degree (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD52F30384 ON product (hot_degree_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD52F30384');
        $this->addSql('DROP INDEX IDX_D34A04AD52F30384 ON product');
        $this->addSql('ALTER TABLE product CHANGE hot_degree_id hot_degree INT DEFAULT NULL');
    }
}
