<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210415105507 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE about (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, title_ar VARCHAR(255) NOT NULL, description1 LONGTEXT DEFAULT NULL, description_ar1 LONGTEXT DEFAULT NULL, description2 LONGTEXT DEFAULT NULL, description_ar2 LONGTEXT DEFAULT NULL, description3 LONGTEXT DEFAULT NULL, description_ar3 LONGTEXT DEFAULT NULL, word LONGTEXT DEFAULT NULL, word_ar LONGTEXT DEFAULT NULL, word_honor VARCHAR(255) DEFAULT NULL, word_honor_ar VARCHAR(255) DEFAULT NULL, file_name VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE catalog (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, size_id INT DEFAULT NULL, quantity INT NOT NULL, INDEX IDX_1B2C32474584665A (product_id), INDEX IDX_1B2C3247498DA827 (size_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, name_ar VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE connected (id INT AUTO_INCREMENT NOT NULL, ip VARCHAR(255) NOT NULL, timestamp INT NOT NULL, page VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, full_name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, confirmation_token VARCHAR(40) DEFAULT NULL, UNIQUE INDEX UNIQ_81398E09E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE governorate (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, name_ar VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, filename VARCHAR(255) NOT NULL, INDEX IDX_C53D045F4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, created_at DATETIME NOT NULL, delivery_price DOUBLE PRECISION NOT NULL, marking LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', stripe_session_id VARCHAR(255) DEFAULT NULL, reference VARCHAR(255) NOT NULL, shipping_first_name VARCHAR(255) DEFAULT NULL, shipping_last_name VARCHAR(255) DEFAULT NULL, shipping_address VARCHAR(255) DEFAULT NULL, shipping_city VARCHAR(255) DEFAULT NULL, shipping_province VARCHAR(255) DEFAULT NULL, shipping_postal_code VARCHAR(255) DEFAULT NULL, shipping_lat DOUBLE PRECISION DEFAULT NULL, shipping_lng DOUBLE PRECISION DEFAULT NULL, shipping_email VARCHAR(255) DEFAULT NULL, shipping_phone VARCHAR(255) DEFAULT NULL, total DOUBLE PRECISION NOT NULL, paid_at DATETIME DEFAULT NULL, in_delivering_at DATETIME DEFAULT NULL, delivered_at DATETIME DEFAULT NULL, cancelled_at DATETIME DEFAULT NULL, INDEX IDX_F52993989395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_details (id INT AUTO_INCREMENT NOT NULL, my_order_id INT NOT NULL, product VARCHAR(255) NOT NULL, size VARCHAR(255) NOT NULL, quantity INT NOT NULL, price DOUBLE PRECISION NOT NULL, total DOUBLE PRECISION NOT NULL, INDEX IDX_845CA2C1BFCDF877 (my_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, created_by_id INT NOT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, name_ar VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, description_ar LONGTEXT NOT NULL, price DOUBLE PRECISION NOT NULL, discount_price DOUBLE PRECISION DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, long_description LONGTEXT NOT NULL, long_description_ar LONGTEXT NOT NULL, weight DOUBLE PRECISION DEFAULT NULL, materials VARCHAR(255) DEFAULT NULL, materials_ar VARCHAR(255) DEFAULT NULL, INDEX IDX_D34A04ADB03A8386 (created_by_id), INDEX IDX_D34A04AD12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE size (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE size_category (size_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_58778D1D498DA827 (size_id), INDEX IDX_58778D1D12469DE2 (category_id), PRIMARY KEY(size_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slide (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, title_ar VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL, content_ar VARCHAR(255) NOT NULL, btn_title VARCHAR(255) NOT NULL, btn_title_ar VARCHAR(255) NOT NULL, btn_url VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_product (tag_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_E17B2907BAD26311 (tag_id), INDEX IDX_E17B29074584665A (product_id), PRIMARY KEY(tag_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tog (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tog_product (tog_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_FFB219B45E2DD70 (tog_id), INDEX IDX_FFB219B44584665A (product_id), PRIMARY KEY(tog_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visit_stats (id INT AUTO_INCREMENT NOT NULL, ip VARCHAR(255) NOT NULL, visit_at DATETIME NOT NULL, visit_number INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE catalog ADD CONSTRAINT FK_1B2C32474584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE catalog ADD CONSTRAINT FK_1B2C3247498DA827 FOREIGN KEY (size_id) REFERENCES size (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993989395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE order_details ADD CONSTRAINT FK_845CA2C1BFCDF877 FOREIGN KEY (my_order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE size_category ADD CONSTRAINT FK_58778D1D498DA827 FOREIGN KEY (size_id) REFERENCES size (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE size_category ADD CONSTRAINT FK_58778D1D12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_product ADD CONSTRAINT FK_E17B2907BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_product ADD CONSTRAINT FK_E17B29074584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tog_product ADD CONSTRAINT FK_FFB219B45E2DD70 FOREIGN KEY (tog_id) REFERENCES tog (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tog_product ADD CONSTRAINT FK_FFB219B44584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE size_category DROP FOREIGN KEY FK_58778D1D12469DE2');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993989395C3F3');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE order_details DROP FOREIGN KEY FK_845CA2C1BFCDF877');
        $this->addSql('ALTER TABLE catalog DROP FOREIGN KEY FK_1B2C32474584665A');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F4584665A');
        $this->addSql('ALTER TABLE tag_product DROP FOREIGN KEY FK_E17B29074584665A');
        $this->addSql('ALTER TABLE tog_product DROP FOREIGN KEY FK_FFB219B44584665A');
        $this->addSql('ALTER TABLE catalog DROP FOREIGN KEY FK_1B2C3247498DA827');
        $this->addSql('ALTER TABLE size_category DROP FOREIGN KEY FK_58778D1D498DA827');
        $this->addSql('ALTER TABLE tag_product DROP FOREIGN KEY FK_E17B2907BAD26311');
        $this->addSql('ALTER TABLE tog_product DROP FOREIGN KEY FK_FFB219B45E2DD70');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADB03A8386');
        $this->addSql('DROP TABLE about');
        $this->addSql('DROP TABLE catalog');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE connected');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE governorate');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_details');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE size');
        $this->addSql('DROP TABLE size_category');
        $this->addSql('DROP TABLE slide');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_product');
        $this->addSql('DROP TABLE tog');
        $this->addSql('DROP TABLE tog_product');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE visit_stats');
    }
}
