<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210812074337 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_category (product_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_CDFC73564584665A (product_id), INDEX IDX_CDFC735612469DE2 (category_id), PRIMARY KEY(product_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_category ADD CONSTRAINT FK_CDFC73564584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_category ADD CONSTRAINT FK_CDFC735612469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product ADD manual_id INT DEFAULT NULL, ADD receipt_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD9BA073D6 FOREIGN KEY (manual_id) REFERENCES manual (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD2B5CA896 FOREIGN KEY (receipt_id) REFERENCES receipt (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04AD9BA073D6 ON product (manual_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04AD2B5CA896 ON product (receipt_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE product_category');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD9BA073D6');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD2B5CA896');
        $this->addSql('DROP INDEX UNIQ_D34A04AD9BA073D6 ON product');
        $this->addSql('DROP INDEX UNIQ_D34A04AD2B5CA896 ON product');
        $this->addSql('ALTER TABLE product DROP manual_id, DROP receipt_id');
    }
}
