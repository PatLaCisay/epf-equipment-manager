<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230602161912 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE item_borrow (id INT AUTO_INCREMENT NOT NULL, item_id INT NOT NULL, borrow_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE item_borrow ADD quantity INT NOT NULL');
        $this->addSql('ALTER TABLE item_borrow ADD CONSTRAINT FK_D322DD7F126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE item_borrow ADD CONSTRAINT FK_D322DD7FD4C006C8 FOREIGN KEY (borrow_id) REFERENCES borrow (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item_borrow MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON item_borrow');
        $this->addSql('ALTER TABLE item_borrow DROP id, DROP quantity');
        $this->addSql('ALTER TABLE item_borrow ADD CONSTRAINT FK_D322DD7F126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item_borrow ADD CONSTRAINT FK_D322DD7FD4C006C8 FOREIGN KEY (borrow_id) REFERENCES borrow (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item_borrow ADD PRIMARY KEY (item_id, borrow_id)');
    }
}
