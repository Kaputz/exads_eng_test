<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240126211226 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tv_series_intervals CHANGE id_tv_series id_tv_series_id INT NOT NULL');
        $this->addSql('ALTER TABLE tv_series_intervals ADD CONSTRAINT FK_6BD92DAA95A169D1 FOREIGN KEY (id_tv_series_id) REFERENCES tv_series (id)');
        $this->addSql('CREATE INDEX IDX_6BD92DAA95A169D1 ON tv_series_intervals (id_tv_series_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tv_series_intervals DROP FOREIGN KEY FK_6BD92DAA95A169D1');
        $this->addSql('DROP INDEX IDX_6BD92DAA95A169D1 ON tv_series_intervals');
        $this->addSql('ALTER TABLE tv_series_intervals CHANGE id_tv_series_id id_tv_series INT NOT NULL');
    }
}
