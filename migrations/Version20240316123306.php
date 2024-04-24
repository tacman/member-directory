<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240316123306 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE member ALTER birth_date TYPE DATE');
        $this->addSql('ALTER TABLE member ALTER join_date TYPE DATE');
        $this->addSql('COMMENT ON COLUMN member.birth_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN member.join_date IS \'(DC2Type:date_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE member ALTER birth_date TYPE DATE');
        $this->addSql('ALTER TABLE member ALTER join_date TYPE DATE');
        $this->addSql('COMMENT ON COLUMN member.birth_date IS NULL');
        $this->addSql('COMMENT ON COLUMN member.join_date IS NULL');
    }
}
