<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230222102604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bien ADD adresse_id INT DEFAULT NULL, DROP adresse');
        $this->addSql('ALTER TABLE bien ADD CONSTRAINT FK_45EDC3864DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('CREATE INDEX IDX_45EDC3864DE7DC5C ON bien (adresse_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bien DROP FOREIGN KEY FK_45EDC3864DE7DC5C');
        $this->addSql('DROP INDEX IDX_45EDC3864DE7DC5C ON bien');
        $this->addSql('ALTER TABLE bien ADD adresse VARCHAR(255) DEFAULT NULL, DROP adresse_id');
    }
}
