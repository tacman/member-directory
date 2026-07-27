<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260727143717 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE _timescaledb_catalog.hypertable_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE _timescaledb_catalog.tablespace_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE _timescaledb_catalog.dimension_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE _timescaledb_catalog.dimension_slice_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE _timescaledb_catalog.chunk_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE _timescaledb_catalog.chunk_constraint_name CASCADE');
        $this->addSql('DROP SEQUENCE _timescaledb_catalog.chunk_column_stats_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE _timescaledb_catalog.bgw_job_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE _timescaledb_internal.bgw_job_stat_history_id_seq CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA toolkit_experimental');
        $this->addSql('CREATE SCHEMA timescaledb_information');
        $this->addSql('CREATE SCHEMA timescaledb_experimental');
        $this->addSql('CREATE SCHEMA _timescaledb_internal');
        $this->addSql('CREATE SCHEMA _timescaledb_functions');
        $this->addSql('CREATE SCHEMA _timescaledb_config');
        $this->addSql('CREATE SCHEMA _timescaledb_catalog');
        $this->addSql('CREATE SCHEMA _timescaledb_cache');
        $this->addSql('CREATE SEQUENCE _timescaledb_catalog.hypertable_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE _timescaledb_catalog.tablespace_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE _timescaledb_catalog.dimension_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE _timescaledb_catalog.dimension_slice_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE _timescaledb_catalog.chunk_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE _timescaledb_catalog.chunk_constraint_name INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE _timescaledb_catalog.chunk_column_stats_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE _timescaledb_catalog.bgw_job_id_seq INCREMENT BY 1 MINVALUE 1000 START 1000');
        $this->addSql('CREATE SEQUENCE _timescaledb_internal.bgw_job_stat_history_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
    }
}
