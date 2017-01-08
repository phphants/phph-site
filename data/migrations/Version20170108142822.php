<?php

namespace App\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Add meetup attendance records
 */
class Version20170108142822 extends AbstractMigration
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

        $this->addSql('CREATE TABLE meetup_attendees (meetup_id UUID NOT NULL, user_id UUID NOT NULL, PRIMARY KEY(meetup_id, user_id))');
        $this->addSql('CREATE INDEX IDX_FB2E8EEC591E2316 ON meetup_attendees (meetup_id)');
        $this->addSql('CREATE INDEX IDX_FB2E8EECA76ED395 ON meetup_attendees (user_id)');
        $this->addSql('ALTER TABLE meetup_attendees ADD CONSTRAINT FK_FB2E8EEC591E2316 FOREIGN KEY (meetup_id) REFERENCES meetup (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE meetup_attendees ADD CONSTRAINT FK_FB2E8EECA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
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

        $this->addSql('DROP TABLE meetup_attendees');
    }
}
