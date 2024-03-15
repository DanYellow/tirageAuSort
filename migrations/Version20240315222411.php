<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240315222411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE award (id INT AUTO_INCREMENT NOT NULL, category VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, prize VARCHAR(255) NOT NULL, year SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE award_winner (award_id INT NOT NULL, winner_id INT NOT NULL, INDEX IDX_C343D3D73D5282CF (award_id), INDEX IDX_C343D3D75DFCD4B8 (winner_id), PRIMARY KEY(award_id, winner_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eloquence_contest_participant (id INT AUTO_INCREMENT NOT NULL, subject_id INT DEFAULT NULL, formation_id INT DEFAULT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, photo VARCHAR(255) DEFAULT NULL, year SMALLINT DEFAULT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_A329DC9523EDC87 (subject_id), INDEX IDX_A329DC955200282E (formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eloquence_subject (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, year SMALLINT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE winner (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE award_winner ADD CONSTRAINT FK_C343D3D73D5282CF FOREIGN KEY (award_id) REFERENCES award (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE award_winner ADD CONSTRAINT FK_C343D3D75DFCD4B8 FOREIGN KEY (winner_id) REFERENCES winner (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eloquence_contest_participant ADD CONSTRAINT FK_A329DC9523EDC87 FOREIGN KEY (subject_id) REFERENCES eloquence_subject (id)');
        $this->addSql('ALTER TABLE eloquence_contest_participant ADD CONSTRAINT FK_A329DC955200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE award_winner DROP FOREIGN KEY FK_C343D3D73D5282CF');
        $this->addSql('ALTER TABLE award_winner DROP FOREIGN KEY FK_C343D3D75DFCD4B8');
        $this->addSql('ALTER TABLE eloquence_contest_participant DROP FOREIGN KEY FK_A329DC9523EDC87');
        $this->addSql('ALTER TABLE eloquence_contest_participant DROP FOREIGN KEY FK_A329DC955200282E');
        $this->addSql('DROP TABLE award');
        $this->addSql('DROP TABLE award_winner');
        $this->addSql('DROP TABLE eloquence_contest_participant');
        $this->addSql('DROP TABLE eloquence_subject');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE winner');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
