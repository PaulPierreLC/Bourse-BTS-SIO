<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241004113016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE action (id INT AUTO_INCREMENT NOT NULL, symbole VARCHAR(255) NOT NULL, nom_entreprise VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE portefeuille (id INT AUTO_INCREMENT NOT NULL, le_trader_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_2955FFFECB6B8278 (le_trader_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE portefeuille_action (portefeuille_id INT NOT NULL, action_id INT NOT NULL, INDEX IDX_43B32156513EC3CA (portefeuille_id), INDEX IDX_43B321569D32F035 (action_id), PRIMARY KEY(portefeuille_id, action_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trader (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, le_portefeuille_id INT DEFAULT NULL, la_action_id INT DEFAULT NULL, quantite INT NOT NULL, prix DOUBLE PRECISION NOT NULL, date DATE NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_723705D1DB3CAAE6 (le_portefeuille_id), INDEX IDX_723705D1F4F39740 (la_action_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE portefeuille ADD CONSTRAINT FK_2955FFFECB6B8278 FOREIGN KEY (le_trader_id) REFERENCES trader (id)');
        $this->addSql('ALTER TABLE portefeuille_action ADD CONSTRAINT FK_43B32156513EC3CA FOREIGN KEY (portefeuille_id) REFERENCES portefeuille (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE portefeuille_action ADD CONSTRAINT FK_43B321569D32F035 FOREIGN KEY (action_id) REFERENCES action (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1DB3CAAE6 FOREIGN KEY (le_portefeuille_id) REFERENCES portefeuille (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1F4F39740 FOREIGN KEY (la_action_id) REFERENCES action (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE portefeuille DROP FOREIGN KEY FK_2955FFFECB6B8278');
        $this->addSql('ALTER TABLE portefeuille_action DROP FOREIGN KEY FK_43B32156513EC3CA');
        $this->addSql('ALTER TABLE portefeuille_action DROP FOREIGN KEY FK_43B321569D32F035');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1DB3CAAE6');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1F4F39740');
        $this->addSql('DROP TABLE action');
        $this->addSql('DROP TABLE portefeuille');
        $this->addSql('DROP TABLE portefeuille_action');
        $this->addSql('DROP TABLE trader');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
