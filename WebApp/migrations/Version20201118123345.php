<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201118123345 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mirror (id INT AUTO_INCREMENT NOT NULL, address VARCHAR(255) NOT NULL, nickname VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mirror_user (mirror_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_C095F95EFAC830AC (mirror_id), INDEX IDX_C095F95EA76ED395 (user_id), PRIMARY KEY(mirror_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mirror_user ADD CONSTRAINT FK_C095F95EFAC830AC FOREIGN KEY (mirror_id) REFERENCES mirror (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mirror_user ADD CONSTRAINT FK_C095F95EA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mirror_user DROP FOREIGN KEY FK_C095F95EFAC830AC');
        $this->addSql('DROP TABLE mirror');
        $this->addSql('DROP TABLE mirror_user');
    }
}
