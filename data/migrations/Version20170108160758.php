<?php

namespace App\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Add Display Name to users
 */
class Version20170108160758 extends AbstractMigration
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

        $this->addSql('ALTER TABLE "user" ADD display_name VARCHAR(1024)');
        $this->addSql('UPDATE "user" SET display_name = email');

        // No way of knowing names, so just populate with email; manually fix
        $this->addSql('ALTER TABLE "user" ALTER COLUMN display_name SET NOT NULL');
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

        $this->addSql('ALTER TABLE "user" DROP display_name');
    }
}
