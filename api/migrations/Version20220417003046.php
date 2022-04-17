<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220417003046 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create a table to store cached user accounts';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE user_accounts_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE user_accounts (
            id INT NOT NULL, 
            user_id VARCHAR(36) NOT NULL, 
            account_id VARCHAR(36) NOT NULL, 
            amount DOUBLE PRECISION NOT NULL, 
            PRIMARY KEY(id)
       )');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE user_accounts_id_seq CASCADE');
        $this->addSql('DROP TABLE user_accounts');
    }
}
