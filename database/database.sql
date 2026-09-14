create database recanto_do_cafe;

create table usuario(
	id int primary key not null auto_increment,
	nome varchar(100) not null,
    senha varchar(250) not null,
    email varchar(100),
    telefone varchar(30)
);

CREATE TABLE produtos (
    id_produtos INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    preco varchar(15) not null,
    codigo_barras VARCHAR(50) UNIQUE,
    descricao TEXT,
    categoria VARCHAR(50),
    ativo BOOLEAN DEFAULT TRUE,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    produto_id INT NOT NULL,
    data_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    quantidade INT NOT NULL,
    FOREIGN KEY (cliente_id) REFERENCES usuario(id),
    FOREIGN KEY (produto_id) REFERENCES produtos(id_produtos)
);

select * from pedidos;


SELECT u.nome AS nome_cliente, p.nome AS nome_produto, ped.quantidade
FROM pedidos AS ped
INNER JOIN usuario AS u ON ped.cliente_id = u.id
INNER JOIN produtos AS p ON ped.produto_id = p.id_produtos;
