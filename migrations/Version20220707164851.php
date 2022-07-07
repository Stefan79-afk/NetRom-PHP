<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220707164851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plugs DROP FOREIGN KEY FK_FF8A283427C2E161');
        $this->addSql('DROP INDEX UNIQ_FF8A283427C2E161 ON plugs');
        $this->addSql('ALTER TABLE plugs CHANGE station_id_id station_id INT NOT NULL');
        $this->addSql('ALTER TABLE plugs ADD CONSTRAINT FK_FF8A283421BDB235 FOREIGN KEY (station_id) REFERENCES station (id)');
        $this->addSql('CREATE INDEX IDX_FF8A283421BDB235 ON plugs (station_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plugs DROP FOREIGN KEY FK_FF8A283421BDB235');
        $this->addSql('DROP INDEX IDX_FF8A283421BDB235 ON plugs');
        $this->addSql('ALTER TABLE plugs CHANGE station_id station_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE plugs ADD CONSTRAINT FK_FF8A283427C2E161 FOREIGN KEY (station_id_id) REFERENCES station (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FF8A283427C2E161 ON plugs (station_id_id)');
    }
}
