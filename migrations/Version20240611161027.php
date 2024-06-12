<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240611161027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etablissement ADD nbr_groupes_accueillis INT DEFAULT NULL, CHANGE nbr_place nbr_chambres INT NOT NULL');
        $this->addSql('ALTER TABLE groupe ADD etablissement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C21FF631228 FOREIGN KEY (etablissement_id) REFERENCES etablissement (id)');
        $this->addSql('CREATE INDEX IDX_4B98C21FF631228 ON groupe (etablissement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etablissement DROP nbr_groupes_accueillis, CHANGE nbr_chambres nbr_place INT NOT NULL');
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C21FF631228');
        $this->addSql('DROP INDEX IDX_4B98C21FF631228 ON groupe');
        $this->addSql('ALTER TABLE groupe DROP etablissement_id');
    }
}
