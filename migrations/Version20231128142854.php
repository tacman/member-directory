<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231128142854 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE communication_log_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE directory_collection_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE donation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE event_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE abstract_log_entry_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE member_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE member_status_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reset_password_request_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tag_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE communication_log (id INT NOT NULL, member_id INT NOT NULL, user_id INT DEFAULT NULL, logged_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, type VARCHAR(255) NOT NULL, summary TEXT NOT NULL, payload JSON DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_ED4161637597D3FE ON communication_log (member_id)');
        $this->addSql('CREATE INDEX IDX_ED416163A76ED395 ON communication_log (user_id)');
        $this->addSql('COMMENT ON COLUMN communication_log.logged_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE directory_collection (id INT NOT NULL, label VARCHAR(255) NOT NULL, icon VARCHAR(255) NOT NULL, show_member_status BOOLEAN NOT NULL, group_by VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, position INT DEFAULT NULL, filter_lost VARCHAR(255) DEFAULT NULL, filter_local_do_not_contact VARCHAR(255) DEFAULT NULL, filter_deceased VARCHAR(255) DEFAULT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE directory_collection_member_status (directory_collection_id INT NOT NULL, member_status_id INT NOT NULL, PRIMARY KEY(directory_collection_id, member_status_id))');
        $this->addSql('CREATE INDEX IDX_CC64EF66E9D937AC ON directory_collection_member_status (directory_collection_id)');
        $this->addSql('CREATE INDEX IDX_CC64EF662BDFD678 ON directory_collection_member_status (member_status_id)');
        $this->addSql('CREATE TABLE donation (id INT NOT NULL, member_id INT DEFAULT NULL, donor_first_name VARCHAR(255) DEFAULT NULL, donor_last_name VARCHAR(255) DEFAULT NULL, receipt_identifier VARCHAR(255) DEFAULT NULL, received_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, campaign VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, amount NUMERIC(10, 2) NOT NULL, currency VARCHAR(255) NOT NULL, processing_fee NUMERIC(10, 2) NOT NULL, net_amount NUMERIC(10, 2) NOT NULL, donor_comment VARCHAR(255) DEFAULT NULL, internal_notes TEXT DEFAULT NULL, donation_type VARCHAR(255) DEFAULT NULL, card_type VARCHAR(255) DEFAULT NULL, last_four VARCHAR(255) DEFAULT NULL, is_anonymous BOOLEAN NOT NULL, is_recurring BOOLEAN NOT NULL, transaction_payload JSON NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_31E581A07597D3FE ON donation (member_id)');
        $this->addSql('COMMENT ON COLUMN donation.received_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE event (id INT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, description TEXT NOT NULL, start_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN event.start_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE event_member (event_id INT NOT NULL, member_id INT NOT NULL, PRIMARY KEY(event_id, member_id))');
        $this->addSql('CREATE INDEX IDX_427D8D2A71F7E88B ON event_member (event_id)');
        $this->addSql('CREATE INDEX IDX_427D8D2A7597D3FE ON event_member (member_id)');
        $this->addSql('CREATE TABLE ext_log_entries (id INT NOT NULL, action VARCHAR(8) NOT NULL, logged_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, object_id VARCHAR(64) DEFAULT NULL, object_class VARCHAR(191) NOT NULL, version INT NOT NULL, data TEXT DEFAULT NULL, username VARCHAR(191) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX log_class_lookup_idx ON ext_log_entries (object_class)');
        $this->addSql('CREATE INDEX log_date_lookup_idx ON ext_log_entries (logged_at)');
        $this->addSql('CREATE INDEX log_user_lookup_idx ON ext_log_entries (username)');
        $this->addSql('CREATE INDEX log_version_lookup_idx ON ext_log_entries (object_id, object_class, version)');
        $this->addSql('COMMENT ON COLUMN ext_log_entries.data IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE member (id INT NOT NULL, status_id INT DEFAULT NULL, local_identifier VARCHAR(255) DEFAULT NULL, external_identifier VARCHAR(255) DEFAULT NULL, prefix VARCHAR(255) DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, preferred_name VARCHAR(255) DEFAULT NULL, middle_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, suffix VARCHAR(255) DEFAULT NULL, birth_date DATE DEFAULT NULL, join_date DATE DEFAULT NULL, class_year INT DEFAULT NULL, is_deceased BOOLEAN DEFAULT NULL, primary_email VARCHAR(255) DEFAULT NULL, primary_telephone_number VARCHAR(255) DEFAULT NULL, mailing_address_line1 VARCHAR(255) DEFAULT NULL, mailing_address_line2 VARCHAR(255) DEFAULT NULL, mailing_city VARCHAR(255) DEFAULT NULL, mailing_state VARCHAR(255) DEFAULT NULL, mailing_postal_code VARCHAR(255) DEFAULT NULL, mailing_country VARCHAR(255) DEFAULT NULL, mailing_latitude NUMERIC(10, 8) DEFAULT NULL, mailing_longitude NUMERIC(11, 8) DEFAULT NULL, employer VARCHAR(255) DEFAULT NULL, job_title VARCHAR(255) DEFAULT NULL, occupation VARCHAR(255) DEFAULT NULL, facebook_url VARCHAR(255) DEFAULT NULL, linkedin_url VARCHAR(255) DEFAULT NULL, photo_url VARCHAR(255) DEFAULT NULL, is_lost BOOLEAN DEFAULT NULL, is_local_do_not_contact BOOLEAN DEFAULT NULL, directory_notes TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_70E4FA78150DD93A ON member (local_identifier)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_70E4FA786DD00CB8 ON member (external_identifier)');
        $this->addSql('CREATE INDEX IDX_70E4FA786BF700BD ON member (status_id)');
        $this->addSql('CREATE INDEX IDX_70E4FA78A9D1C13261CD21AA59107AF8C808BA5A ON member (first_name, preferred_name, middle_name, last_name)');
        $this->addSql('CREATE TABLE member_status (id INT NOT NULL, code VARCHAR(255) NOT NULL, label VARCHAR(255) NOT NULL, is_inactive BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE reset_password_request (id INT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7CE748AA76ED395 ON reset_password_request (user_id)');
        $this->addSql('COMMENT ON COLUMN reset_password_request.requested_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN reset_password_request.expires_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE tag (id INT NOT NULL, tag_name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tag_member (tag_id INT NOT NULL, member_id INT NOT NULL, PRIMARY KEY(tag_id, member_id))');
        $this->addSql('CREATE INDEX IDX_99A5B354BAD26311 ON tag_member (tag_id)');
        $this->addSql('CREATE INDEX IDX_99A5B3547597D3FE ON tag_member (member_id)');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, totp_secret VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, last_login TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, timezone VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('ALTER TABLE communication_log ADD CONSTRAINT FK_ED4161637597D3FE FOREIGN KEY (member_id) REFERENCES member (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE communication_log ADD CONSTRAINT FK_ED416163A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE directory_collection_member_status ADD CONSTRAINT FK_CC64EF66E9D937AC FOREIGN KEY (directory_collection_id) REFERENCES directory_collection (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE directory_collection_member_status ADD CONSTRAINT FK_CC64EF662BDFD678 FOREIGN KEY (member_status_id) REFERENCES member_status (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE donation ADD CONSTRAINT FK_31E581A07597D3FE FOREIGN KEY (member_id) REFERENCES member (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_member ADD CONSTRAINT FK_427D8D2A71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_member ADD CONSTRAINT FK_427D8D2A7597D3FE FOREIGN KEY (member_id) REFERENCES member (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA786BF700BD FOREIGN KEY (status_id) REFERENCES member_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tag_member ADD CONSTRAINT FK_99A5B354BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tag_member ADD CONSTRAINT FK_99A5B3547597D3FE FOREIGN KEY (member_id) REFERENCES member (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE communication_log_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE directory_collection_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE donation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE event_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE abstract_log_entry_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE member_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE member_status_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reset_password_request_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tag_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('ALTER TABLE communication_log DROP CONSTRAINT FK_ED4161637597D3FE');
        $this->addSql('ALTER TABLE communication_log DROP CONSTRAINT FK_ED416163A76ED395');
        $this->addSql('ALTER TABLE directory_collection_member_status DROP CONSTRAINT FK_CC64EF66E9D937AC');
        $this->addSql('ALTER TABLE directory_collection_member_status DROP CONSTRAINT FK_CC64EF662BDFD678');
        $this->addSql('ALTER TABLE donation DROP CONSTRAINT FK_31E581A07597D3FE');
        $this->addSql('ALTER TABLE event_member DROP CONSTRAINT FK_427D8D2A71F7E88B');
        $this->addSql('ALTER TABLE event_member DROP CONSTRAINT FK_427D8D2A7597D3FE');
        $this->addSql('ALTER TABLE member DROP CONSTRAINT FK_70E4FA786BF700BD');
        $this->addSql('ALTER TABLE reset_password_request DROP CONSTRAINT FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE tag_member DROP CONSTRAINT FK_99A5B354BAD26311');
        $this->addSql('ALTER TABLE tag_member DROP CONSTRAINT FK_99A5B3547597D3FE');
        $this->addSql('DROP TABLE communication_log');
        $this->addSql('DROP TABLE directory_collection');
        $this->addSql('DROP TABLE directory_collection_member_status');
        $this->addSql('DROP TABLE donation');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_member');
        $this->addSql('DROP TABLE ext_log_entries');
        $this->addSql('DROP TABLE member');
        $this->addSql('DROP TABLE member_status');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_member');
        $this->addSql('DROP TABLE users');
    }
}
