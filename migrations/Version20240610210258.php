<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240610210258 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE groupe_user (groupe_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_257BA9FE7A45358C (groupe_id), INDEX IDX_257BA9FEA76ED395 (user_id), PRIMARY KEY(groupe_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE groupe_user ADD CONSTRAINT FK_257BA9FE7A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_user ADD CONSTRAINT FK_257BA9FEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe ADD nombre_maximum INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD groupe_cree_id INT DEFAULT NULL, CHANGE numtel numtel INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649639521AC FOREIGN KEY (groupe_cree_id) REFERENCES groupe (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649639521AC ON user (groupe_cree_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE groupe_user DROP FOREIGN KEY FK_257BA9FE7A45358C');
        $this->addSql('ALTER TABLE groupe_user DROP FOREIGN KEY FK_257BA9FEA76ED395');
        $this->addSql('DROP TABLE groupe_user');
        $this->addSql('ALTER TABLE groupe DROP nombre_maximum');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649639521AC');
        $this->addSql('DROP INDEX UNIQ_8D93D649639521AC ON user');
        $this->addSql('ALTER TABLE user DROP groupe_cree_id, CHANGE numtel numtel NUMERIC(10, 0) NOT NULL');
    }
}
