-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 29-Abr-2015 às 14:48
-- Versão do servidor: 5.6.20-log
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bc`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `carnes`
--

CREATE TABLE IF NOT EXISTS `carnes` (
`id_boleto` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `codigo` varchar(100) NOT NULL,
  `fatura` varchar(60) DEFAULT NULL,
  `linha_digitavel` varchar(200) NOT NULL,
  `data_vencimento` varchar(20) NOT NULL,
  `cedente` varchar(100) NOT NULL,
  `agencia_codigo` varchar(50) NOT NULL,
  `data_documento` varchar(50) NOT NULL,
  `numero_documento` varchar(100) NOT NULL,
  `especie_doc` varchar(20) NOT NULL,
  `aceite` varchar(30) NOT NULL,
  `data_processamento` varchar(20) NOT NULL,
  `nosso_numero` varchar(20) NOT NULL,
  `carteira` varchar(20) NOT NULL,
  `especie` varchar(20) NOT NULL,
  `quantidade` varchar(20) NOT NULL,
  `valor_unitario` varchar(11) NOT NULL,
  `valor_boleto` varchar(10) NOT NULL,
  `instrucoes1` varchar(50) NOT NULL,
  `instrucoes2` varchar(50) NOT NULL,
  `sacado` varchar(50) NOT NULL,
  `endereco1` varchar(50) NOT NULL,
  `endereco2` varchar(50) NOT NULL,
  `codigo_barras` varchar(200) NOT NULL,
  `banco` varchar(60) DEFAULT NULL,
  `pedido` varchar(36) DEFAULT NULL,
  `situacao` varchar(2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
`id` int(11) NOT NULL,
  `nome` varchar(160) DEFAULT NULL,
  `doc` varchar(60) DEFAULT NULL,
  `endereco` varchar(160) DEFAULT NULL,
  `cidade` varchar(160) DEFAULT NULL,
  `estado` varchar(60) DEFAULT NULL,
  `cep` varchar(26) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `clientes`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `empresa`
--

CREATE TABLE IF NOT EXISTS `empresa` (
`id` int(11) NOT NULL,
  `empresa` varchar(160) DEFAULT NULL,
  `cnpj` varchar(60) DEFAULT NULL,
  `banco` varchar(60) DEFAULT NULL,
  `endereco` varchar(160) DEFAULT NULL,
  `cidade` varchar(160) DEFAULT NULL,
  `estado` varchar(60) DEFAULT NULL,
  `receberate` varchar(60) DEFAULT NULL,
  `instrucoes1` varchar(60) DEFAULT NULL,
  `instrucoes2` varchar(60) DEFAULT NULL,
  `instrucoes3` varchar(60) DEFAULT NULL,
  `carteira` varchar(60) DEFAULT NULL,
  `agencia` varchar(60) DEFAULT NULL,
  `digito_ag` varchar(60) DEFAULT NULL,
  `conta` varchar(60) DEFAULT NULL,
  `digito_co` varchar(60) DEFAULT NULL,
  `tipo_carteira` varchar(60) DEFAULT NULL,
  `convenio` varchar(60) DEFAULT NULL,
  `contrato` varchar(60) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `empresa`
--

INSERT INTO `empresa` (`id`, `empresa`, `cnpj`, `banco`, `endereco`, `cidade`, `estado`, `receberate`, `instrucoes1`, `instrucoes2`, `instrucoes3`, `carteira`, `agencia`, `digito_ag`, `conta`, `digito_co`, `tipo_carteira`, `convenio`, `contrato`, `email`, `url`) VALUES
(1, 'MEGACOMSISTEMAS LTDA', '12.111.111/0001-01', 'BRADESCO', 'Av Getúlio Vargas 211', 'Três Corações', 'Minas Gerais', '', 'Não receber após o vencimento', '', NULL, '05', '1425', '', '46792', '3', 'SR', '', '', 'megacomsistemas@gmail.com', 'http://localhost/carne/');

-- --------------------------------------------------------

--
-- Estrutura da tabela `financeiro`
--

CREATE TABLE IF NOT EXISTS `financeiro` (
`id` int(11) NOT NULL,
  `nfatura` varchar(11) DEFAULT NULL,
  `cliente` varchar(11) DEFAULT NULL,
  `pedido` int(60) DEFAULT NULL,
  `vencimento` varchar(60) DEFAULT NULL,
  `cadastro` varchar(26) DEFAULT NULL,
  `dia` varchar(2) DEFAULT NULL,
  `mes` varchar(2) DEFAULT NULL,
  `ano` varchar(4) DEFAULT NULL,
  `valor` varchar(60) DEFAULT NULL,
  `parcelaum` varchar(11) DEFAULT NULL,
  `taxa` varchar(11) DEFAULT '0.00',
  `valorparcela` varchar(60) DEFAULT NULL,
  `mesparcela` varchar(2) DEFAULT NULL,
  `boleto` varchar(60) DEFAULT NULL,
  `vencimento_fn` date NOT NULL,
  `pagamento_fn` date NOT NULL,
  `status_fn` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `data_fn` date NOT NULL,
  `hora_fn` time NOT NULL,
  `financ_data_fn` varchar(60) DEFAULT NULL,
  `financ_hora_fn` varchar(60) DEFAULT NULL,
  `retorno_fn` varchar(50) NOT NULL,
  `competencia_fn` int(11) NOT NULL,
  `obs` varchar(255) DEFAULT NULL,
  `situacao` varchar(2) DEFAULT NULL,
  `status` varchar(2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `retornos`
--

CREATE TABLE IF NOT EXISTS `retornos` (
`id` int(11) NOT NULL,
  `juros` float DEFAULT NULL,
  `codigo` int(26) DEFAULT NULL,
  `valor` float DEFAULT NULL,
  `dataefetivacao` varchar(26) DEFAULT NULL,
  `dataocorrencia` varchar(26) DEFAULT NULL,
  `datavencimento` varchar(25) DEFAULT NULL,
  `dataprocessado` varchar(26) DEFAULT NULL,
  `horaprocessado` varchar(16) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
`id` int(11) NOT NULL,
  `nome` varchar(160) DEFAULT NULL,
  `codigo` varchar(60) DEFAULT NULL,
  `empresa` varchar(11) DEFAULT NULL,
  `login` varchar(60) DEFAULT NULL,
  `senha` varchar(60) DEFAULT NULL,
  `salt` varchar(160) DEFAULT NULL,
  `email` varchar(160) DEFAULT NULL,
  `nivel` varchar(11) DEFAULT NULL,
  `status` varchar(2) DEFAULT 'S'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `codigo`, `empresa`, `login`, `senha`, `salt`, `email`, `nivel`, `status`) VALUES
(1, 'Administrador', '199283', NULL, 'admin', '202cb962ac59075b964b07152d234b70', 'MTIz', 'megacomsistemas@gmail.com', '1', 'S');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carnes`
--
ALTER TABLE `carnes`
 ADD PRIMARY KEY (`id_boleto`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `empresa`
--
ALTER TABLE `empresa`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `financeiro`
--
ALTER TABLE `financeiro`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `retornos`
--
ALTER TABLE `retornos`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carnes`
--
ALTER TABLE `carnes`
MODIFY `id_boleto` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `empresa`
--
ALTER TABLE `empresa`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `financeiro`
--
ALTER TABLE `financeiro`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `retornos`
--
ALTER TABLE `retornos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
