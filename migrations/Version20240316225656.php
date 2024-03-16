<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240316225656 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE eloquence_contest (id INT AUTO_INCREMENT NOT NULL, year SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eloquence_contest_eloquence_contest_participant (eloquence_contest_id INT NOT NULL, eloquence_contest_participant_id INT NOT NULL, INDEX IDX_D7528F0AF6AC0BD0 (eloquence_contest_id), INDEX IDX_D7528F0AF2A6ADF7 (eloquence_contest_participant_id), PRIMARY KEY(eloquence_contest_id, eloquence_contest_participant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE eloquence_contest_eloquence_contest_participant ADD CONSTRAINT FK_D7528F0AF6AC0BD0 FOREIGN KEY (eloquence_contest_id) REFERENCES eloquence_contest (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eloquence_contest_eloquence_contest_participant ADD CONSTRAINT FK_D7528F0AF2A6ADF7 FOREIGN KEY (eloquence_contest_participant_id) REFERENCES eloquence_contest_participant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eloquence_contest_participant DROP year');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eloquence_contest_eloquence_contest_participant DROP FOREIGN KEY FK_D7528F0AF6AC0BD0');
        $this->addSql('ALTER TABLE eloquence_contest_eloquence_contest_participant DROP FOREIGN KEY FK_D7528F0AF2A6ADF7');
        $this->addSql('DROP TABLE eloquence_contest');
        $this->addSql('DROP TABLE eloquence_contest_eloquence_contest_participant');
        $this->addSql('ALTER TABLE eloquence_contest_participant ADD year SMALLINT DEFAULT NULL');
    }
}
