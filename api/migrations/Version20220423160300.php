<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220423160300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add table for category counter projection';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE category_stats (
            id SERIAL NOT NULL, 
            user_id VARCHAR(36) NOT NULL, 
            account_id VARCHAR(36) NOT NULL, 
            name VARCHAR(255) NOT NULL, 
            counter INT NOT NULL, 
            PRIMARY KEY(id),
            CONSTRAINT unique_category_stat UNIQUE (account_id, name)
        )');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE category_stats');
    }
}
