<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201202174451 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE to_do_role (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE to_do_role_user (to_do_role_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_DA023D8C58067CCC (to_do_role_id), INDEX IDX_DA023D8CA76ED395 (user_id), PRIMARY KEY(to_do_role_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE to_do_role_user ADD CONSTRAINT FK_DA023D8C58067CCC FOREIGN KEY (to_do_role_id) REFERENCES to_do_role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE to_do_role_user ADD CONSTRAINT FK_DA023D8CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user DROP user_role');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE to_do_role_user DROP FOREIGN KEY FK_DA023D8C58067CCC');
        $this->addSql('DROP TABLE to_do_role');
        $this->addSql('DROP TABLE to_do_role_user');
        $this->addSql('ALTER TABLE user ADD user_role VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
