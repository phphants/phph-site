<?php

namespace App\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Create a table to store video links
 */
class Version20160925140055 extends AbstractMigration
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

        $this->addSql('CREATE TABLE video (id UUID NOT NULL, talk_id UUID NOT NULL, youtubeId VARCHAR(512) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7CC7DA2C6F0601D5 ON video (talk_id)');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C6F0601D5 FOREIGN KEY (talk_id) REFERENCES talk (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
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

        $this->addSql('DROP TABLE video');
    }
}
