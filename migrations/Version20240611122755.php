<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240611122755 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE groupe_user DROP FOREIGN KEY FK_257BA9FEA76ED395');
        $this->addSql('ALTER TABLE groupe_user DROP FOREIGN KEY FK_257BA9FE7A45358C');
        $this->addSql('DROP TABLE groupe_user');
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C21A76ED395');
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C21FF631228');
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C21150A48F1');
        $this->addSql('DROP INDEX IDX_4B98C21FF631228 ON groupe');
        $this->addSql('DROP INDEX IDX_4B98C21A76ED395 ON groupe');
        $this->addSql('DROP INDEX UNIQ_4B98C21150A48F1 ON groupe');
        $this->addSql('ALTER TABLE groupe DROP etablissement_id, DROP user_id, DROP chef_id, DROP nom');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649639521AC');
        $this->addSql('DROP INDEX UNIQ_8D93D649639521AC ON user');
        $this->addSql('ALTER TABLE user DROP groupe_cree_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE groupe_user (groupe_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_257BA9FE7A45358C (groupe_id), INDEX IDX_257BA9FEA76ED395 (user_id), PRIMARY KEY(groupe_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE groupe_user ADD CONSTRAINT FK_257BA9FEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_user ADD CONSTRAINT FK_257BA9FE7A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe ADD etablissement_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL, ADD chef_id INT NOT NULL, ADD nom VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C21A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C21FF631228 FOREIGN KEY (etablissement_id) REFERENCES etablissement (id)');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C21150A48F1 FOREIGN KEY (chef_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4B98C21FF631228 ON groupe (etablissement_id)');
        $this->addSql('CREATE INDEX IDX_4B98C21A76ED395 ON groupe (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4B98C21150A48F1 ON groupe (chef_id)');
        $this->addSql('ALTER TABLE user ADD groupe_cree_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649639521AC FOREIGN KEY (groupe_cree_id) REFERENCES groupe (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649639521AC ON user (groupe_cree_id)');
    }
}
