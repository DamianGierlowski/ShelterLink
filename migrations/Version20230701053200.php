<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230701053200 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE genre ADD file_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE genre ADD CONSTRAINT FK_835033F893CB796C FOREIGN KEY (file_id) REFERENCES file (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_835033F893CB796C ON genre (file_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE genre DROP CONSTRAINT FK_835033F893CB796C');
        $this->addSql('DROP INDEX UNIQ_835033F893CB796C');
        $this->addSql('ALTER TABLE genre DROP file_id');
    }
}
