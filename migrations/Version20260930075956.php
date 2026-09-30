<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260930075956 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contacto (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, telefono VARCHAR(15) NOT NULL, email VARCHAR(255) NOT NULL, provincia_id INT DEFAULT NULL, INDEX IDX_2741493C4E7121AF (provincia_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE contacto ADD CONSTRAINT FK_2741493C4E7121AF FOREIGN KEY (provincia_id) REFERENCES provincia (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contacto DROP FOREIGN KEY FK_2741493C4E7121AF');
        $this->addSql('DROP TABLE contacto');
        $this->addSql('DROP TABLE user');
    }
}
