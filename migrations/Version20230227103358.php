<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230227103358 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bien DROP FOREIGN KEY FK_45EDC3864DE7DC5C');
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP INDEX IDX_45EDC3864DE7DC5C ON bien');
        $this->addSql('ALTER TABLE bien ADD adresse VARCHAR(255) DEFAULT NULL, ADD code_postal VARCHAR(20) DEFAULT NULL, ADD ville VARCHAR(100) DEFAULT NULL, DROP adresse_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresse (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, code_postal VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ville VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE bien ADD adresse_id INT DEFAULT NULL, DROP adresse, DROP code_postal, DROP ville');
        $this->addSql('ALTER TABLE bien ADD CONSTRAINT FK_45EDC3864DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('CREATE INDEX IDX_45EDC3864DE7DC5C ON bien (adresse_id)');
    }
}
