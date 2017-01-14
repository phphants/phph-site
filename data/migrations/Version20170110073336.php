<?php

namespace App\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Add third party authentication table for storing logins
 */
class Version20170110073336 extends AbstractMigration
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

        $this->addSql('CREATE TABLE "user_third_party_authentication" (id UUID NOT NULL, user_id UUID NOT NULL, unique_id VARCHAR(1024) NOT NULL, user_data JSON NOT NULL, service VARCHAR(1024) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7264D15DA76ED395 ON "user_third_party_authentication" (user_id)');
        $this->addSql('ALTER TABLE "user_third_party_authentication" ADD CONSTRAINT FK_7264D15DA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
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

        $this->addSql('DROP TABLE "user_third_party_authentication"');
    }
}
