<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231205163123 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE model DROP FOREIGN KEY FK_D79572D930964F9C');
        $this->addSql('DROP INDEX IDX_D79572D930964F9C ON model');
        $this->addSql('ALTER TABLE model CHANGE marque_id_id marque_id INT NOT NULL');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D94827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id)');
        $this->addSql('CREATE INDEX IDX_D79572D94827B9B2 ON model (marque_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE model DROP FOREIGN KEY FK_D79572D94827B9B2');
        $this->addSql('DROP INDEX IDX_D79572D94827B9B2 ON model');
        $this->addSql('ALTER TABLE model CHANGE marque_id marque_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D930964F9C FOREIGN KEY (marque_id_id) REFERENCES marque (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D79572D930964F9C ON model (marque_id_id)');
    }
}
