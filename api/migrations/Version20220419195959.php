<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220419195959 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Use jsonb type for json field in the account_transactions table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE account_transactions ALTER COLUMN tags TYPE jsonb USING tags::jsonb;');
    }

    public function down(Schema $schema): void
    {

    }
}
