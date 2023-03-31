<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230330174953 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE borrow (id INT AUTO_INCREMENT NOT NULL, stakeholder_id INT NOT NULL, room_id INT DEFAULT NULL, team_id INT DEFAULT NULL, start_date DATE NOT NULL, end_date DATE DEFAULT NULL, description LONGTEXT DEFAULT NULL, return_description LONGTEXT DEFAULT NULL, restituted TINYINT(1) NOT NULL, quantity INT NOT NULL, INDEX IDX_55DBA8B0F2D3711A (stakeholder_id), INDEX IDX_55DBA8B054177093 (room_id), INDEX IDX_55DBA8B0296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, namname VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_user (group_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_A4C98D39FE54D947 (group_id), INDEX IDX_A4C98D39A76ED395 (user_id), PRIMARY KEY(group_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, state VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item_borrow (item_id INT NOT NULL, borrow_id INT NOT NULL, INDEX IDX_D322DD7F126F525E (item_id), INDEX IDX_D322DD7FD4C006C8 (borrow_id), PRIMARY KEY(item_id, borrow_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, description LONGTEXT DEFAULT NULL, reserved TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, item_id INT DEFAULT NULL, image LONGBLOB DEFAULT NULL, description LONGTEXT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, stock INT DEFAULT NULL, INDEX IDX_8CDE5729126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE borrow ADD CONSTRAINT FK_55DBA8B0F2D3711A FOREIGN KEY (stakeholder_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE borrow ADD CONSTRAINT FK_55DBA8B054177093 FOREIGN KEY (room_id) REFERENCES room (id)');
        $this->addSql('ALTER TABLE borrow ADD CONSTRAINT FK_55DBA8B0296CD8AE FOREIGN KEY (team_id) REFERENCES `group` (id)');
        $this->addSql('ALTER TABLE group_user ADD CONSTRAINT FK_A4C98D39FE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE group_user ADD CONSTRAINT FK_A4C98D39A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item_borrow ADD CONSTRAINT FK_D322DD7F126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item_borrow ADD CONSTRAINT FK_D322DD7FD4C006C8 FOREIGN KEY (borrow_id) REFERENCES borrow (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE type ADD CONSTRAINT FK_8CDE5729126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE borrow DROP FOREIGN KEY FK_55DBA8B0F2D3711A');
        $this->addSql('ALTER TABLE borrow DROP FOREIGN KEY FK_55DBA8B054177093');
        $this->addSql('ALTER TABLE borrow DROP FOREIGN KEY FK_55DBA8B0296CD8AE');
        $this->addSql('ALTER TABLE group_user DROP FOREIGN KEY FK_A4C98D39FE54D947');
        $this->addSql('ALTER TABLE group_user DROP FOREIGN KEY FK_A4C98D39A76ED395');
        $this->addSql('ALTER TABLE item_borrow DROP FOREIGN KEY FK_D322DD7F126F525E');
        $this->addSql('ALTER TABLE item_borrow DROP FOREIGN KEY FK_D322DD7FD4C006C8');
        $this->addSql('ALTER TABLE type DROP FOREIGN KEY FK_8CDE5729126F525E');
        $this->addSql('DROP TABLE borrow');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE group_user');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE item_borrow');
        $this->addSql('DROP TABLE room');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
