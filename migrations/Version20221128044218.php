<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221128044218 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contacte ADD comarca_id INT NOT NULL');
        $this->addSql('ALTER TABLE contacte ADD CONSTRAINT FK_C794A022BE4D4658 FOREIGN KEY (comarca_id) REFERENCES comarca (id)');
        $this->addSql('CREATE INDEX IDX_C794A022BE4D4658 ON contacte (comarca_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contacte DROP FOREIGN KEY FK_C794A022BE4D4658');
        $this->addSql('DROP INDEX IDX_C794A022BE4D4658 ON contacte');
        $this->addSql('ALTER TABLE contacte DROP comarca_id');
    }
}
