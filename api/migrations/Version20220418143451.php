<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220418143451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add name column to the user_accounts projection';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user_accounts ADD account_name VARCHAR(255) DEFAULT \'Основной\' NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user_accounts DROP account_name');
    }
}
