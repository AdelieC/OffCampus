<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210807181016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE campus ADD location_id INT NOT NULL');
        $this->addSql('ALTER TABLE campus ADD CONSTRAINT FK_9D09681164D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9D09681164D218E ON campus (location_id)');
        $this->addSql('ALTER TABLE outing ADD campus_id INT DEFAULT NULL, ADD location_id INT NOT NULL, ADD organiser_id INT NOT NULL, ADD type_id INT NOT NULL, ADD day_and_time DATETIME NOT NULL, ADD creation_date DATETIME NOT NULL, ADD closing_date DATE NOT NULL, ADD fare INT DEFAULT NULL, ADD capacity INT NOT NULL');
        $this->addSql('ALTER TABLE outing ADD CONSTRAINT FK_F2A10625AF5D55E1 FOREIGN KEY (campus_id) REFERENCES campus (id)');
        $this->addSql('ALTER TABLE outing ADD CONSTRAINT FK_F2A1062564D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE outing ADD CONSTRAINT FK_F2A10625A0631C12 FOREIGN KEY (organiser_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE outing ADD CONSTRAINT FK_F2A10625C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('CREATE INDEX IDX_F2A10625AF5D55E1 ON outing (campus_id)');
        $this->addSql('CREATE INDEX IDX_F2A1062564D218E ON outing (location_id)');
        $this->addSql('CREATE INDEX IDX_F2A10625A0631C12 ON outing (organiser_id)');
        $this->addSql('CREATE INDEX IDX_F2A10625C54C8C93 ON outing (type_id)');
        $this->addSql('ALTER TABLE outing_image ADD outing_id INT NOT NULL');
        $this->addSql('ALTER TABLE outing_image ADD CONSTRAINT FK_D4B35038AF4C7531 FOREIGN KEY (outing_id) REFERENCES outing (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D4B35038AF4C7531 ON outing_image (outing_id)');
        $this->addSql('ALTER TABLE profile_image ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE profile_image ADD CONSTRAINT FK_32E99B8DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_32E99B8DA76ED395 ON profile_image (user_id)');
        $this->addSql('ALTER TABLE user ADD campus_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649AF5D55E1 FOREIGN KEY (campus_id) REFERENCES campus (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649AF5D55E1 ON user (campus_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE campus DROP FOREIGN KEY FK_9D09681164D218E');
        $this->addSql('DROP INDEX UNIQ_9D09681164D218E ON campus');
        $this->addSql('ALTER TABLE campus DROP location_id');
        $this->addSql('ALTER TABLE outing DROP FOREIGN KEY FK_F2A10625AF5D55E1');
        $this->addSql('ALTER TABLE outing DROP FOREIGN KEY FK_F2A1062564D218E');
        $this->addSql('ALTER TABLE outing DROP FOREIGN KEY FK_F2A10625A0631C12');
        $this->addSql('ALTER TABLE outing DROP FOREIGN KEY FK_F2A10625C54C8C93');
        $this->addSql('DROP INDEX IDX_F2A10625AF5D55E1 ON outing');
        $this->addSql('DROP INDEX IDX_F2A1062564D218E ON outing');
        $this->addSql('DROP INDEX IDX_F2A10625A0631C12 ON outing');
        $this->addSql('DROP INDEX IDX_F2A10625C54C8C93 ON outing');
        $this->addSql('ALTER TABLE outing DROP campus_id, DROP location_id, DROP organiser_id, DROP type_id, DROP day_and_time, DROP creation_date, DROP closing_date, DROP fare, DROP capacity');
        $this->addSql('ALTER TABLE outing_image DROP FOREIGN KEY FK_D4B35038AF4C7531');
        $this->addSql('DROP INDEX UNIQ_D4B35038AF4C7531 ON outing_image');
        $this->addSql('ALTER TABLE outing_image DROP outing_id');
        $this->addSql('ALTER TABLE profile_image DROP FOREIGN KEY FK_32E99B8DA76ED395');
        $this->addSql('DROP INDEX IDX_32E99B8DA76ED395 ON profile_image');
        $this->addSql('ALTER TABLE profile_image DROP user_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649AF5D55E1');
        $this->addSql('DROP INDEX IDX_8D93D649AF5D55E1 ON user');
        $this->addSql('ALTER TABLE user DROP campus_id');
    }
}
