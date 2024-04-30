CREATE DATABASE IF NOT EXISTS licitflow
DEFAULT CHARACTER SET utf8mb4
DEFAULT COLLATE utf8mb4_general_ci
;

# Visualizar Banco
# SHOW DATABASES;

# Usar Banco de Dados
USE licitflow;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    cpf VARCHAR(14) NOT NULL UNIQUE,
    cep VARCHAR(9) NOT NULL,
    n_da_casa VARCHAR(10) NOT NULL,
    rua VARCHAR(100) NOT NULL,
    estado VARCHAR(50) NOT NULL,
    cidade VARCHAR(100) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    nivel_acesso ENUM('admin', 'usuario', 'sem-acesso') NOT NULL DEFAULT 'sem-acesso'
);

CREATE TABLE IF NOT EXISTS licitacoes (
  id int NOT NULL AUTO_INCREMENT,
  titulo varchar(255) NOT NULL,
  servico varchar(255) NOT NULL,
  descricao text NOT NULL,
  documento varchar(255) DEFAULT NULL,
  data_criacao timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
);

-- Exemplo 1: Construção de Escola Municipal
INSERT INTO licitacoes (titulo, servico, descricao, documento, data_criacao) 
VALUES ('Construção de Escola Municipal na Zona Norte', 'Construção Civil', 
        'A prefeitura de nossa cidade está buscando propostas para a construção de uma escola municipal na zona norte. O projeto inclui a construção de salas de aula, laboratórios, quadras esportivas, e áreas administrativas.', 
        'Edital de Licitação Nº 001/2024', '2024-04-20');

-- Exemplo 2: Fornecimento de Equipamentos Médicos
INSERT INTO licitacoes (titulo, servico, descricao, documento, data_criacao) 
VALUES ('Fornecimento de Equipamentos Médicos para Hospital Municipal', 'Equipamentos Médicos', 
        'O hospital municipal está buscando fornecedores para a aquisição de equipamentos médicos modernos, incluindo aparelhos de raio-x, monitores cardíacos, ventiladores pulmonares, e outros equipamentos essenciais para o atendimento médico de qualidade.', 
        'Edital de Licitação Nº 002/2024', '2024-04-21');

-- Exemplo 3: Serviços de Manutenção de Estradas
INSERT INTO licitacoes (titulo, servico, descricao, documento, data_criacao) 
VALUES ('Serviços de Manutenção de Estradas Rurais', 'Manutenção de Estradas', 
        'A prefeitura está buscando empresas para realizar serviços de manutenção em estradas rurais do município. Isso inclui reparo de buracos, limpeza das vias, sinalização, e outros serviços de conservação.', 
        'Edital de Licitação Nº 003/2024', '2024-04-22');

