<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231230133551 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }



    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE demand ADD CONSTRAINT FK_428D79731B65292 FOREIGN KEY (employe_id) REFERENCES employees (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BA82C300E7927C74 ON employees (email)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE demand DROP FOREIGN KEY FK_428D79731B65292');
        $this->addSql('DROP INDEX UNIQ_BA82C300E7927C74 ON employees');
    }
}
