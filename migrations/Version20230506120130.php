<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230506120130 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE employee_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE employee (id INT NOT NULL, first_name VARCHAR(30) NOT NULL, last_name VARCHAR(40) NOT NULL, email VARCHAR(255) NOT NULL, phone_number VARCHAR(20) DEFAULT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE employee_id_seq CASCADE');
        $this->addSql('DROP TABLE employee');
    }
}
