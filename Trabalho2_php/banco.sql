CREATE TABLE cliente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100)
);

CREATE TABLE pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT,
    produto VARCHAR(100),
    valor DECIMAL(10,2),
    data_pedido DATE,
    FOREIGN KEY (cliente_id) REFERENCES cliente(id) ON DELETE CASCADE
);

INSERT INTO cliente (nome) VALUES
('João Pereira'),
('Mariana Alves'),
('Carlos Souza'),
('Fernanda Lima'),
('Ricardo Gomes'),
('Patrícia Martins'),
('Lucas Fernandes'),
('Juliana Rocha'),
('Bruno Carvalho'),
('Camila Ribeiro'),
('Diego Santos'),
('Aline Costa'),
('Rafael Oliveira'),
('Beatriz Nunes'),
('Gustavo Freitas');

INSERT INTO pedido (cliente_id, produto, valor, data_pedido) VALUES
(1, 'Mouse Logitech G203', 129.90, '2025-03-10'),
(1, 'Teclado Mecânico Redragon Kumara', 249.90, '2025-03-15'),

(2, 'Fone JBL Tune 510BT', 199.90, '2025-03-11'),
(2, 'Carregador Turbo USB-C', 59.90, '2025-03-18'),

(3, 'Monitor LG 24\" Full HD', 899.00, '2025-03-09'),

(4, 'Notebook Dell Inspiron 15', 3499.00, '2025-03-12'),
(4, 'Mouse Sem Fio Multilaser', 49.90, '2025-03-13'),

(5, 'SSD Kingston 480GB', 289.90, '2025-03-08'),
(5, 'Memória RAM 8GB DDR4', 179.90, '2025-03-14'),

(6, 'Smartphone Samsung Galaxy A34', 1599.00, '2025-03-16'),

(7, 'Headset HyperX Cloud Stinger', 299.90, '2025-03-17'),
(7, 'Mousepad Gamer Grande', 79.90, '2025-03-18'),

(8, 'Tablet Samsung Galaxy Tab A7', 999.00, '2025-03-10'),

(9, 'Controle Xbox Series S/X', 399.90, '2025-03-11'),
(9, 'Bateria Recarregável + Cabo', 89.90, '2025-03-12'),

(10, 'Cadeira Gamer ThunderX3', 1299.00, '2025-03-13'),

(11, 'Placa de Vídeo RTX 3060', 2499.00, '2025-03-14'),

(12, 'HD Externo Seagate 1TB', 349.90, '2025-03-15'),

(13, 'Fonte Corsair 650W', 459.90, '2025-03-16'),

(14, 'Teclado Sem Fio Logitech K380', 199.90, '2025-03-17'),

(15, 'Notebook Lenovo IdeaPad 3', 2799.00, '2025-03-18');