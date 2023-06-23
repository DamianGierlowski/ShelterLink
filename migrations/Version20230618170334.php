<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230618170334 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal ADD colour VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE animal ALTER guid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE genre ALTER guid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE room ALTER guid TYPE VARCHAR(255)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE genre ALTER guid TYPE UUID');
        $this->addSql('ALTER TABLE animal DROP colour');
        $this->addSql('ALTER TABLE animal ALTER guid TYPE UUID');
        $this->addSql('ALTER TABLE room ALTER guid TYPE UUID');
    }
}
