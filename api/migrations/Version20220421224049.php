<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220421224049 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create stat_spans table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE stat_spans_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE stat_spans (
            id INT NOT NULL DEFAULT nextval(\'stat_spans_id_seq\'),
            user_id VARCHAR(36) NOT NULL,
            account_id VARCHAR(36) NOT NULL,
            start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            finish_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            income NUMERIC(10, 2) NOT NULL,
            spends NUMERIC(10, 2) NOT NULL,
            type VARCHAR(255) NOT NULL,
            PRIMARY KEY(id),
            CONSTRAINT unique_stats_span UNIQUE (user_id, account_id, start_date, finish_date)
        )');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE stat_spans_id_seq CASCADE');
        $this->addSql('DROP TABLE stat_spans');
    }
}
