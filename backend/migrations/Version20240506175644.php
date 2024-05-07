<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240506175644 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actors (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image_url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genres (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movies (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, image_url VARCHAR(255) NOT NULL, plot LONGTEXT NOT NULL, year INT NOT NULL, release_date DATE NOT NULL, duration VARCHAR(255) NOT NULL, rating INT NOT NULL, wikipedia_url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movies_actors (id INT AUTO_INCREMENT NOT NULL, movie_id INT DEFAULT NULL, actor_id INT DEFAULT NULL, star TINYINT(1) NOT NULL, INDEX IDX_A85722518F93B6FC (movie_id), INDEX IDX_A857225110DAF24A (actor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movies_genres (id INT AUTO_INCREMENT NOT NULL, movie_id INT DEFAULT NULL, genre_id INT DEFAULT NULL, INDEX IDX_DF9737A28F93B6FC (movie_id), INDEX IDX_DF9737A24296D31F (genre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movies_keywords (id INT AUTO_INCREMENT NOT NULL, movie_id INT DEFAULT NULL, keyword VARCHAR(255) NOT NULL, INDEX IDX_422B1A668F93B6FC (movie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE movies_actors ADD CONSTRAINT FK_A85722518F93B6FC FOREIGN KEY (movie_id) REFERENCES movies (id)');
        $this->addSql('ALTER TABLE movies_actors ADD CONSTRAINT FK_A857225110DAF24A FOREIGN KEY (actor_id) REFERENCES actors (id)');
        $this->addSql('ALTER TABLE movies_genres ADD CONSTRAINT FK_DF9737A28F93B6FC FOREIGN KEY (movie_id) REFERENCES movies (id)');
        $this->addSql('ALTER TABLE movies_genres ADD CONSTRAINT FK_DF9737A24296D31F FOREIGN KEY (genre_id) REFERENCES genres (id)');
        $this->addSql('ALTER TABLE movies_keywords ADD CONSTRAINT FK_422B1A668F93B6FC FOREIGN KEY (movie_id) REFERENCES movies (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movies_actors DROP FOREIGN KEY FK_A85722518F93B6FC');
        $this->addSql('ALTER TABLE movies_actors DROP FOREIGN KEY FK_A857225110DAF24A');
        $this->addSql('ALTER TABLE movies_genres DROP FOREIGN KEY FK_DF9737A28F93B6FC');
        $this->addSql('ALTER TABLE movies_genres DROP FOREIGN KEY FK_DF9737A24296D31F');
        $this->addSql('ALTER TABLE movies_keywords DROP FOREIGN KEY FK_422B1A668F93B6FC');
        $this->addSql('DROP TABLE actors');
        $this->addSql('DROP TABLE genres');
        $this->addSql('DROP TABLE movies');
        $this->addSql('DROP TABLE movies_actors');
        $this->addSql('DROP TABLE movies_genres');
        $this->addSql('DROP TABLE movies_keywords');
    }
}
