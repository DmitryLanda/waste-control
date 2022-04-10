<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220410100715 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add table for account_events';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS account_events (
            event_id uuid primary key NOT NULL,
            aggregate_root_id uuid NOT NULL,
            version integer NOT NULL, 
            payload json NOT NULL
        )');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS account_events');
    }
}
