<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220418184605 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add table for transaction projections';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE account_transactions_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE account_transactions (
            id INT NOT NULL, 
            user_id VARCHAR(36) NOT NULL, 
            account_id VARCHAR(36) NOT NULL, 
            created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, 
            amount NUMERIC(10, 2) NOT NULL, 
            comment VARCHAR(255) DEFAULT NULL, 
            tags JSON DEFAULT NULL, 
            PRIMARY KEY(id))
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE account_transactions_id_seq CASCADE');
        $this->addSql('DROP TABLE account_transactions');
    }
}
