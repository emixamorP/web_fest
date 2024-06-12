<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240610115510 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C21EEB69F7B');
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C21FF631228');
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C21A76ED395');
        $this->addSql('DROP INDEX IDX_4B98C21FF631228 ON groupe');
        $this->addSql('DROP INDEX IDX_4B98C21A76ED395 ON groupe');
        $this->addSql('DROP INDEX IDX_4B98C21EEB69F7B ON groupe');
        $this->addSql('ALTER TABLE groupe DROP attribution_id, DROP etablissement_id, DROP user_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE groupe ADD attribution_id INT DEFAULT NULL, ADD etablissement_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C21EEB69F7B FOREIGN KEY (attribution_id) REFERENCES attribution (id)');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C21FF631228 FOREIGN KEY (etablissement_id) REFERENCES etablissement (id)');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C21A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4B98C21FF631228 ON groupe (etablissement_id)');
        $this->addSql('CREATE INDEX IDX_4B98C21A76ED395 ON groupe (user_id)');
        $this->addSql('CREATE INDEX IDX_4B98C21EEB69F7B ON groupe (attribution_id)');
    }
}
