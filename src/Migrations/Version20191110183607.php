<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191110183607 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ban CHANGE id_user id_user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message CHANGE id_user id_user INT DEFAULT NULL, CHANGE id_sub_topic id_sub_topic INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sub_topic ADD topic_id INT NOT NULL, CHANGE id_user id_user INT DEFAULT NULL, CHANGE id_topic id_topic INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sub_topic ADD CONSTRAINT FK_7104BAA21F55203D FOREIGN KEY (topic_id) REFERENCES topic (id)');
        $this->addSql('CREATE INDEX IDX_7104BAA21F55203D ON sub_topic (topic_id)');
        $this->addSql('ALTER TABLE user CHANGE id_user_type id_user_type INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ban CHANGE id_user id_user INT NOT NULL');
        $this->addSql('ALTER TABLE message CHANGE id_sub_topic id_sub_topic INT NOT NULL, CHANGE id_user id_user INT NOT NULL');
        $this->addSql('ALTER TABLE sub_topic DROP FOREIGN KEY FK_7104BAA21F55203D');
        $this->addSql('DROP INDEX IDX_7104BAA21F55203D ON sub_topic');
        $this->addSql('ALTER TABLE sub_topic DROP topic_id, CHANGE id_topic id_topic INT NOT NULL, CHANGE id_user id_user INT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE id_user_type id_user_type INT NOT NULL');
    }
}
