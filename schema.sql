CREATE DATABASE IF NOT EXISTS `landing_page_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE `landing_page_db`;

--
-- Estrutura da tabela `servicos`
--
CREATE TABLE `servicos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Inserindo dados de exemplo na tabela `servicos`
--
INSERT INTO `servicos` (`id`, `nome`) VALUES
(1, 'Desenvolvimento de Website'),
(2, 'Marketing Digital'),
(3, 'Design Gráfico'),
(4, 'Otimização de SEO');

--
-- Estrutura da tabela `clientes`
--
CREATE TABLE `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `servico_id` int(11) NOT NULL,
  `data_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `servico_id` (`servico_id`),
  CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`servico_id`) REFERENCES `servicos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

select * from clientes