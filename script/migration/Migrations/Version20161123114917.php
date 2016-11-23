<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161123114917 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $sql = "CREATE TABLE `user` (
            `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
            `username` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '用户名',
            PRIMARY KEY (`id`)
        )
        COMMENT='用户表'
        COLLATE='utf8_general_ci'
        ENGINE=InnoDB";
        $this->addSql($sql);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
