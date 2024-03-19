<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240319221726 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE winner ADD award_id INT NOT NULL');
        $this->addSql('ALTER TABLE winner ADD CONSTRAINT FK_CF6600E3D5282CF FOREIGN KEY (award_id) REFERENCES award (id)');
        $this->addSql('CREATE INDEX IDX_CF6600E3D5282CF ON winner (award_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE winner DROP FOREIGN KEY FK_CF6600E3D5282CF');
        $this->addSql('DROP INDEX IDX_CF6600E3D5282CF ON winner');
        $this->addSql('ALTER TABLE winner DROP award_id');
    }
}
