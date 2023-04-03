<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230402211143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE product_id_seq CASCADE');
        $this->addSql('
            CREATE TABLE comment (
                id UUID NOT NULL, 
                post_id UUID DEFAULT NULL,
                content VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT NULL,
                PRIMARY KEY(id)
            )
        ');
        $this->addSql('CREATE INDEX IDX_9474526C4B89032C ON comment (post_id)');
        $this->addSql('COMMENT ON COLUMN comment.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN comment.post_id IS \'(DC2Type:uuid)\'');
        $this->addSql('
            CREATE TABLE post (
                id UUID NOT NULL,
                user_id UUID DEFAULT NULL,
                title VARCHAR(255) NOT NULL,
                content TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT NULL,
                PRIMARY KEY(id)
            )
        ');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DA76ED395 ON post (user_id)');
        $this->addSql('COMMENT ON COLUMN post.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN post.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('
            CREATE TABLE "user" (
                id UUID NOT NULL,
                email VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                first_name VARCHAR(255) DEFAULT NULL,
                last_name VARCHAR(255) DEFAULT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT NULL,
                PRIMARY KEY(id)
            )
        ');
        $this->addSql('COMMENT ON COLUMN "user".id IS \'(DC2Type:uuid)\'');
        $this->addSql('
            ALTER TABLE comment 
                ADD CONSTRAINT FK_9474526C4B89032C 
                FOREIGN KEY (post_id) REFERENCES post (id)
                ON DELETE CASCADE
        ');
        $this->addSql(
            'ALTER TABLE post
                ADD CONSTRAINT FK_5A8A6C8DA76ED395
                FOREIGN KEY (user_id) REFERENCES "user" (id)
                ON DELETE CASCADE
        ');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526C4B89032C');
        $this->addSql('ALTER TABLE post DROP CONSTRAINT FK_5A8A6C8DA76ED395');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE "user"');
    }
}
