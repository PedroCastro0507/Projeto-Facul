
mysql -u root

CREATE DATABASE nome_da_db;

USE nome_da_db;

-- Criar a tabela 'usuarios'
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    admin TINYINT(1) DEFAULT 0
);

-- Tabela 'recursos'
CREATE TABLE recursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT,
    tipo ENUM('evento', 'atlética', 'comodidade') DEFAULT 'comodidade',
    status ENUM('ativo', 'inativo', 'em_triagem') DEFAULT 'em_triagem',
    imagem VARCHAR(255),
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);


