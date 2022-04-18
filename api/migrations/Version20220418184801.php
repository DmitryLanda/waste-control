<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220418184801 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Set amount as decimal for user_accounts table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user_accounts ALTER amount TYPE NUMERIC(10, 2)');
        $this->addSql('ALTER TABLE user_accounts ALTER amount SET DEFAULT \'0\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user_accounts ALTER amount TYPE DOUBLE PRECISION');
        $this->addSql('ALTER TABLE user_accounts ALTER amount DROP DEFAULT');
    }
}
