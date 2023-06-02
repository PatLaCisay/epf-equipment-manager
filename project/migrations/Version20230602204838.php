<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230602204838 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item DROP state');
        $this->addSql('ALTER TABLE item_borrow RENAME INDEX fk_d322dd7f126f525e TO IDX_D322DD7F126F525E');
        $this->addSql('ALTER TABLE item_borrow RENAME INDEX fk_d322dd7fd4c006c8 TO IDX_D322DD7FD4C006C8');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item_borrow RENAME INDEX idx_d322dd7fd4c006c8 TO FK_D322DD7FD4C006C8');
        $this->addSql('ALTER TABLE item_borrow RENAME INDEX idx_d322dd7f126f525e TO FK_D322DD7F126F525E');
        $this->addSql('ALTER TABLE item ADD state VARCHAR(100) NOT NULL');
    }
}
