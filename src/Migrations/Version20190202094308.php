<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Symfony\Component\HttpFoundation\File\Exception\NoFileException;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190202094308 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\DBALException
     */
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSqlFromFile(__DIR__ . '/sql/init.sql');
    }

    public function down(Schema $schema) : void
    {

    }

    protected function addSqlFromFile(string $fileDir)
    {
        if (!file_exists($fileDir)) {
            throw new NoFileException("File {$fileDir} not found.");
        }

        $sql = file_get_contents($fileDir);
        $this->addSql($sql);
    }
}
