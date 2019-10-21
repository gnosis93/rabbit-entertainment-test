<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191020145210 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE app_hands (id INT AUTO_INCREMENT NOT NULL, file_id INT DEFAULT NULL, card_1 VARCHAR(2) NOT NULL, card_2 VARCHAR(2) NOT NULL, card_3 VARCHAR(2) NOT NULL, card_4 VARCHAR(2) NOT NULL, card_5 VARCHAR(2) NOT NULL, card_6 VARCHAR(2) NOT NULL, card_7 VARCHAR(2) NOT NULL, card_8 VARCHAR(2) NOT NULL, card_9 VARCHAR(2) NOT NULL, card_10 VARCHAR(2) NOT NULL, INDEX IDX_B0FDBE3593CB796C (file_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE app_hands ADD CONSTRAINT FK_B0FDBE3593CB796C FOREIGN KEY (file_id) REFERENCES app_files (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE app_hands');
    }
}
