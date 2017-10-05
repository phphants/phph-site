<?php

namespace App\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Add new primary key column and check-in status for users
 */
class Version20170712151355 extends AbstractMigration
{
    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function up(Schema $schema)
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql('DROP INDEX IDX_FB2E8EEC591E2316');
        $this->addSql('DROP INDEX IDX_FB2E8EECA76ED395');
        $this->addSql('ALTER TABLE meetup_attendees RENAME TO meetup_attendees_old');

        $this->addSql('CREATE TABLE meetup_attendees (id UUID NOT NULL, meetup_id UUID NOT NULL, user_id UUID NOT NULL, check_in_time TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FB2E8EEC591E2316 ON meetup_attendees (meetup_id)');
        $this->addSql('CREATE INDEX IDX_FB2E8EECA76ED395 ON meetup_attendees (user_id)');
        $this->addSql('CREATE UNIQUE INDEX meetup_user ON meetup_attendees (meetup_id, user_id)');
        $this->addSql('ALTER TABLE meetup_attendees ADD CONSTRAINT FK_FB2E8EEC591E2316 FOREIGN KEY (meetup_id) REFERENCES meetup (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE meetup_attendees ADD CONSTRAINT FK_FB2E8EECA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE;');

        $this->addSql('INSERT INTO meetup_attendees (id, meetup_id, user_id, check_in_time) SELECT gen_random_uuid(), meetup_id, user_id, NULL FROM meetup_attendees_old');

        $this->addSql('DROP TABLE meetup_attendees_old');
    }

    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function down(Schema $schema)
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql('DROP INDEX IDX_FB2E8EEC591E2316');
        $this->addSql('DROP INDEX IDX_FB2E8EECA76ED395');
        $this->addSql('ALTER TABLE meetup_attendees RENAME TO meetup_attendees_old');

        $this->addSql('CREATE TABLE meetup_attendees (meetup_id UUID NOT NULL, user_id UUID NOT NULL, PRIMARY KEY(meetup_id, user_id))');
        $this->addSql('CREATE INDEX IDX_FB2E8EEC591E2316 ON meetup_attendees (meetup_id)');
        $this->addSql('CREATE INDEX IDX_FB2E8EECA76ED395 ON meetup_attendees (user_id)');
        $this->addSql('ALTER TABLE meetup_attendees ADD CONSTRAINT FK_FB2E8EEC591E2316 FOREIGN KEY (meetup_id) REFERENCES meetup (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE meetup_attendees ADD CONSTRAINT FK_FB2E8EECA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');

        $this->addSql('INSERT INTO meetup_attendees (meetup_id, user_id) SELECT meetup_id, user_id FROM meetup_attendees_old');

        $this->addSql('DROP TABLE meetup_attendees_old');
    }
}
