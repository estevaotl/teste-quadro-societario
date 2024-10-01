<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240930221158 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Criação da tabela empresa
        $this->addSql('CREATE TABLE IF NOT EXISTS empresa (
            id SERIAL NOT NULL PRIMARY KEY,
            nome VARCHAR(255) NOT NULL,
            cnpj VARCHAR(255) NOT NULL,
            endereco VARCHAR(255) NOT NULL
        )');

        // Inserindo dados fictícios na tabela empresa
        $this->addSql("INSERT INTO empresa (nome, cnpj, endereco) VALUES
            ('Empresa A', '12.345.678/0001-95', 'Rua Exemplo, 123'),
            ('Empresa B', '98.765.432/0001-10', 'Avenida Teste, 456')
        ");

        // Criação da tabela socio
        $this->addSql('CREATE TABLE IF NOT EXISTS socio (
            id SERIAL NOT NULL PRIMARY KEY,
            nome VARCHAR(255) NOT NULL,
            cpf VARCHAR(11) NOT NULL,
            empresa_id INT NOT NULL,
            FOREIGN KEY (empresa_id) REFERENCES empresa(id) ON DELETE CASCADE
        )');

        // Inserindo dados fictícios na tabela socio
        $this->addSql("INSERT INTO socio (nome, cpf, empresa_id) VALUES
            ('João da Silva', '12345678901', 1),
            ('Maria Oliveira', '10987654321', 1),
            ('Carlos Souza', '12312312312', 2),
            ('Ana Santos', '32132132132', 2)
        ");
    }

    public function down(Schema $schema): void
    {
        // Revertendo as alterações
        $this->addSql('DROP TABLE IF EXISTS socio');
        $this->addSql('DROP TABLE IF EXISTS empresa');
    }
}
