<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231205162925 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE model (id INT AUTO_INCREMENT NOT NULL, marque_id_id INT NOT NULL, marque_id INT DEFAULT NULL, nom VARCHAR(50) NOT NULL, prix_depart DOUBLE PRECISION DEFAULT NULL, INDEX IDX_D79572D930964F9C (marque_id_id), INDEX IDX_D79572D94827B9B2 (marque_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D930964F9C FOREIGN KEY (marque_id_id) REFERENCES marque (id)');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D94827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE model DROP FOREIGN KEY FK_D79572D930964F9C');
        $this->addSql('ALTER TABLE model DROP FOREIGN KEY FK_D79572D94827B9B2');
        $this->addSql('DROP TABLE model');
    }
}
