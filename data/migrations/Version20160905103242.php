<?php
declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Create initial database structure
 */
class Version20160905103242 extends AbstractMigration
{
    /**
     * {@inheritdoc}
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function up(Schema $schema)
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql('CREATE TABLE meetup (id UUID NOT NULL, location_id UUID NOT NULL, from_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, to_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, topic VARCHAR(1024) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9377E2864D218E ON meetup (location_id)');
        $this->addSql('CREATE TABLE talk (id UUID NOT NULL, meetup_id UUID NOT NULL, speaker_id UUID DEFAULT NULL, time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, title VARCHAR(1024) NOT NULL, abstract TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9F24D5BB591E2316 ON talk (meetup_id)');
        $this->addSql('CREATE INDEX IDX_9F24D5BBD04A0F27 ON talk (speaker_id)');
        $this->addSql('CREATE TABLE speaker (id UUID NOT NULL, full_name VARCHAR(1024) NOT NULL, twitterHandle VARCHAR(1024) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE eventbrite_data (id UUID NOT NULL, meetup_id UUID NOT NULL, url VARCHAR(1024) NOT NULL, eventbriteId VARCHAR(1024) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9A8A6D6C591E2316 ON eventbrite_data (meetup_id)');
        $this->addSql('CREATE TABLE location (id UUID NOT NULL, name VARCHAR(1024) NOT NULL, address VARCHAR(1024) NOT NULL, url VARCHAR(1024) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE meetup ADD CONSTRAINT FK_9377E2864D218E FOREIGN KEY (location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE talk ADD CONSTRAINT FK_9F24D5BB591E2316 FOREIGN KEY (meetup_id) REFERENCES meetup (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE talk ADD CONSTRAINT FK_9F24D5BBD04A0F27 FOREIGN KEY (speaker_id) REFERENCES speaker (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE eventbrite_data ADD CONSTRAINT FK_9A8A6D6C591E2316 FOREIGN KEY (meetup_id) REFERENCES meetup (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * {@inheritdoc}
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function down(Schema $schema)
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql('ALTER TABLE talk DROP CONSTRAINT FK_9F24D5BB591E2316');
        $this->addSql('ALTER TABLE eventbrite_data DROP CONSTRAINT FK_9A8A6D6C591E2316');
        $this->addSql('ALTER TABLE talk DROP CONSTRAINT FK_9F24D5BBD04A0F27');
        $this->addSql('ALTER TABLE meetup DROP CONSTRAINT FK_9377E2864D218E');
        $this->addSql('DROP TABLE meetup');
        $this->addSql('DROP TABLE talk');
        $this->addSql('DROP TABLE speaker');
        $this->addSql('DROP TABLE eventbrite_data');
        $this->addSql('DROP TABLE location');
    }
}
