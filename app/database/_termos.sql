-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 10-Jun-2019 às 13:59
-- Versão do servidor: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `termos`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categorias_nome_unique` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Material de Escritório', '2019-04-26 00:00:00', '0000-00-00 00:00:00', NULL),
(2, 'Mobiliário', '2019-04-26 00:00:00', '0000-00-00 00:00:00', NULL),
(3, 'Informática', '2019-04-26 00:00:00', '0000-00-00 00:00:00', NULL),
(4, 'Gêneros Alimentícios', '2019-04-26 00:00:00', '0000-00-00 00:00:00', NULL),
(5, 'Veículos Automotores', '2019-04-26 00:00:00', '0000-00-00 00:00:00', NULL),
(6, 'Farmácia', '2019-04-26 00:00:00', '0000-00-00 00:00:00', NULL),
(7, 'Limpeza', '2019-04-26 00:00:00', '0000-00-00 00:00:00', NULL),
(8, 'Construção Civil', '2019-04-26 00:00:00', '0000-00-00 00:00:00', NULL),
(9, 'Eletrodomésticos', '2019-04-26 00:00:00', '0000-00-00 00:00:00', NULL),
(10, 'Eletroeletrônicos', '2019-04-26 00:00:00', '0000-00-00 00:00:00', NULL),
(11, 'Vestuário', '2019-04-26 00:00:00', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `itens`
--

DROP TABLE IF EXISTS `itens`;
CREATE TABLE IF NOT EXISTS `itens` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  `especificacao` text NOT NULL,
  `tipo` enum('BENS DE CONSUMO','BENS PERMANENTES','SERVIÇOS') NOT NULL,
  `subcategoria_id` int(10) UNSIGNED NOT NULL,
  `unidade_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `itens_descricao_unique` (`descricao`),
  KEY `itens_subcategoria_id_foreign` (`subcategoria_id`),
  KEY `itens_unidade_id_foreign` (`unidade_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `itens_tags`
--

DROP TABLE IF EXISTS `itens_tags`;
CREATE TABLE IF NOT EXISTS `itens_tags` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_id` int(10) UNSIGNED NOT NULL,
  `tag_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `itens_tags_item_id_index` (`item_id`),
  KEY `itens_tags_tag_id_index` (`tag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `loggers`
--

DROP TABLE IF EXISTS `loggers`;
CREATE TABLE IF NOT EXISTS `loggers` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `action` varchar(30) NOT NULL,
  `message` varchar(255) NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `loggers_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2018_11_30_000001_create_users_table', 1),
('2018_11_30_000002_create_roles_table', 1),
('2018_11_30_000003_pivot_users_roles_table', 1),
('2018_11_30_000004_create_password_reminders_table', 1),
('2018_11_30_000005_create_loggers_table', 1),
('2018_11_30_000006_create_throttles_table', 1),
('2019_03_06_000007_create_modelos_table', 1),
('2019_03_11_000008_create_secretarias_table', 1),
('2019_03_12_000009_create_categorias_table', 1),
('2019_03_13_000010_create_subcategorias_table', 1),
('2019_03_13_000011_create_unidades_table', 1),
('2019_03_14_000012_create_itens_table', 1),
('2019_03_21_000013_create_tags_table', 1),
('2019_03_22_000014_pivot_itens_tags_table', 1),
('2019_04_01_000015_create_termos_table', 1),
('2019_04_02_000016_pivot_termos_itens_table', 1),
('2019_04_16_000017_pivot_users_secretarias_table', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `modelos`
--

DROP TABLE IF EXISTS `modelos`;
CREATE TABLE IF NOT EXISTS `modelos` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `texto` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `modelos`
--

INSERT INTO `modelos` (`id`, `texto`) VALUES
(1, '<h3 style=\"text-align:center;\"><strong>1. OBJETO</strong></h3><p>1.1 Constitui objeto do presente pregão, selecionar pessoa jurídica para fornecimento de <mark class=\"marker-yellow\"><strong>itens para uso em atendimentos diversos em todas as Secretarias e Prédios Públicos da Administração Direta</strong></mark>. As especificações mínimas e quantidades dos itens estão apresentadas na planilha de especificações técnicas mínimas, que foi compilada de acordo com as solicitações e justificativas da <code>$__var_[secretaria_origem_nome]</code> e de requisitantes das diversas Secretarias.</p><h3 style=\"text-align:center;\"><strong>2. AVALIAÇÃO</strong></h3><p style=\"text-align:justify;\">2.1 O licitante deverá apresentar, no ato do credenciamento, catálogos com foto(s) e descrição completa de todos os itens, para aprovação da equipe técnica da <code>$__var_[secretaria_origem_nome]</code> e sendo aprovado, credenciar-se-á ao certame. As especificações técnicas e instruções de configuração, certificados ou termos de garantia, não poderão estar divergentes das especificações deste Termo de Referência e deverão estar em português para a análise das informações, contendo todos os dados especificados.</p><p style=\"text-align:justify;\">2.2 A empresa vencedora deverá, no prazo de <mark class=\"marker-pink\">N dias úteis</mark>, após a Licitação, apresentar na Sede da <code>$__var_[secretaria_origem_nome]</code>, cito à <code>$__var_[secretaria_origem_endereco]</code>, uma unidade de cada equipamento, bem como catálogos com fotos e descritivos de todos os itens, para análise e validação dos técnicos da <code>$__var_[secretaria_origem_nome]</code>, que terão o prazo de <mark class=\"marker-pink\">N dias uteis</mark>, a contar da data e hora da entrega, para efetuar a análise e emitir o parecer da avaliação do item apresentado.</p><h3 style=\"text-align:center;\"><strong>3. ESPECIFICAÇÕES TÉCNICAS</strong></h3><p style=\"text-align:justify;\">3.1 Abaixo as especificações mínimas do item a ser licitado. Todas as empresas vencedoras deverão apresentar atestado de capacidade técnica, no ato da Licitação, onde serão analisadas pelos técnicos da <code>$__var_[secretaria_origem_nome]</code>.</p><p><code>$__var_[tabela_itens]</code></p><p style=\"text-align:justify;\">Todos os itens deverão ter no mínimo <mark class=\"marker-pink\">N ano</mark> de garantia, a contar da entrega dos mesmos.</p><p style=\"text-align:justify;\">Em caso de problemas do equipamento que venham a acarretar demora no atendimento, o equipamento deverá ser trocado por um novo equivalente e/ou superior, no prazo de <mark class=\"marker-pink\">N horas</mark>.</p><p style=\"text-align:justify;\">Condições de entrega: em até <mark class=\"marker-pink\">N (ene) dias</mark> após o recebimento da Autorização de Fornecimento (A.F.)</p><p style=\"text-align:justify;\">** O(s) material(is) deverá(ão) ser entregue(s) no <mark class=\"marker-blue\">ENDEREÇO DO LOCAL DE ENTREGA</mark> - Caraguatatuba/SP, em <mark class=\"marker-pink\">N dias úteis</mark>, no horário da 08 as 16:30 minutos, onde será conferido pelo responsável.</p><h4 style=\"text-align:center;\"><strong>4. DA PRESTAÇÃO DO SERVIÇO</strong></h4><p style=\"text-align:justify;\">Equipe técnica própria:</p><ul><li style=\"text-align:justify;\">Item 1</li><li style=\"text-align:justify;\">Item 2</li><li style=\"text-align:justify;\">Item 3</li></ul><p style=\"text-align:justify;\">A Prefeitura do Município de Caraguatatuba poderá solicitar substituição de funcionário da contratada a qualquer tempo, desde que justificando o motivo.</p><p style=\"text-align:justify;\">Equipe técnica terceirizada:</p><ul><li style=\"text-align:justify;\">Item 1</li><li style=\"text-align:justify;\">Item 2</li><li style=\"text-align:justify;\">Item 3</li></ul><p style=\"text-align:justify;\">Equipamentos de segurança:</p><ul><li style=\"text-align:justify;\">Item 1</li><li style=\"text-align:justify;\">Item 2</li><li style=\"text-align:justify;\">Item 3</li></ul><h4 style=\"text-align:center;\"><strong>5. DAS GARANTIAS</strong></h4><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>');

-- --------------------------------------------------------

--
-- Estrutura da tabela `password_reminders`
--

DROP TABLE IF EXISTS `password_reminders`;
CREATE TABLE IF NOT EXISTS `password_reminders` (
  `email` varchar(100) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_reminders_email_index` (`email`),
  KEY `password_reminders_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'ROOT', 'Desenvolvedor'),
(2, 'SUPER', 'Gestor de Sistemas'),
(3, 'ADMIN', 'Responsável(is) na Secretaria'),
(4, 'MANAGER', 'Gestores - Secretário / Adjunto'),
(5, 'SUPERVISOR', 'Diretores da Secretaria'),
(6, 'LEADER', 'Chefes de Sessão'),
(7, 'WORKER', 'Funcionários em Geral'),
(8, 'USER', 'Usuários que não são funcionários');

-- --------------------------------------------------------

--
-- Estrutura da tabela `secretarias`
--

DROP TABLE IF EXISTS `secretarias`;
CREATE TABLE IF NOT EXISTS `secretarias` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `endereco` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `secretarias_nome_unique` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `secretarias`
--

INSERT INTO `secretarias` (`id`, `nome`, `endereco`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Secretaria Municipal de Administração', 'Rua Siqueira Campos, N° 44 - Centro - Caraguatatuba/SP', '0000-00-00 00:00:00', '2019-05-24 15:10:14', '2019-05-24 15:10:14'),
(2, 'Secretaria Municipal de Assuntos Jurídicos', 'Av. Prefeito Geraldo Nogueira da Silva, nº 2.182 - Jd. Aruan - Caraguatatuba/SP', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(3, 'Secretaria Municipal de Comunicação Social', 'Rua José Damazo dos Santos, N° 39 - Centro - Caraguatatuba/SP', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(4, 'Secretaria Municipal de Desenvolvimento Social e Cidadania', 'Rua Vereador Antônio Cruz Arouca, Nº 121 - Indaiá- Caraguatatuba/SP', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(5, 'Secretaria Municipal de Educação', 'Av. Rio de Janeiro, N° 860 - Indaiá - Caraguatatuba/SP', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(6, 'Secretaria Municipal de Esportes e Recreação', 'Av. José Herculano, N° 50 - Jd. Britânia - Caraguatatuba/SP', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(7, 'Secretaria Municipal de Fazenda', 'Rua Major Aires, N° 365 - Centro - Caraguatatuba/SP', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(8, 'Secretaria Municipal de Governo', 'Av. Frei Pacífico Wagner, 1011 - Centro - Caraguatatuba/SP', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(9, 'Secretaria Municipal de Habitação', 'Av. Minas Gerais, 1.290 - Indaiá - Caraguatatuba/SP', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(10, 'Secretaria Municipal de Meio Ambiente, Agricultura e Pesca', 'Rua Santos Dumont, 502 - Centro - Caraguatatuba/SP', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(11, 'Secretaria Municipal de Obras Públicas', 'Rua Luiz Passos Júnior, N° 50 - Centro - Caraguatatuba/SP', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(12, 'Secretaria Municipal dos Direitos da Pessoa com Deficiência e do Idoso', 'Rua Jorge Burihan, N° 10 - Jd. Jaqueira - Caraguatatuba/SP', '0000-00-00 00:00:00', '2019-05-13 18:04:35', '2019-05-13 18:04:35'),
(13, 'Secretaria Municipal de Planejamento Estratégico e Desenvolvimento', 'Av. Frei Pacífico Wagner, nº 163, piso Superior - Centro - Caraguatatuba/SP', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(14, 'Secretaria Municipal de Saúde', 'Av. Maranhão, N° 451 - 2° ANDAR - Jd. Primavera - Caraguatatuba/SP', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(15, 'Secretaria Municipal de Serviços Públicos', 'Av. Senador Feijó, N° 165 - Jd. Aruan - Caraguatatuba/SP', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(16, 'Secretaria Municipal de Tecnologia da Informação', 'Rua São Benedito, Nº 436 - Centro - Caraguatatuba/SP', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(17, 'Secretaria Municipal de Mobilidade Urbana e Proteção ao Cidadão', 'Rua Irmã São Francisco, Nº 83 - Caputera - Caraguatatuba/SP', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(18, 'Secretaria Municipal de Turismo', 'Av. Dr. Arthur Costa Filho, N°25 - Centro - Caraguatatuba/SP', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(19, 'Secretaria Municipal de Urbanismo', 'Av. Brasil, N° 749 - Sumaré - Caraguatatuba/SP', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(20, 'Diversas Secretarias', '', '2019-05-15 12:56:45', '2019-05-24 15:10:08', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `subcategorias`
--

DROP TABLE IF EXISTS `subcategorias`;
CREATE TABLE IF NOT EXISTS `subcategorias` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `categoria_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subcategorias_nome_unique` (`nome`),
  KEY `subcategorias_categoria_id_foreign` (`categoria_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `subcategorias`
--

INSERT INTO `subcategorias` (`id`, `nome`, `categoria_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Itens de Papelaria', 1, '2019-04-26 00:00:00', '0000-00-00 00:00:00', NULL),
(2, 'Móveis para Escritório', 2, '2019-04-26 00:00:00', '0000-00-00 00:00:00', NULL),
(3, 'Móveis Hospitalares', 2, '2019-04-26 00:00:00', '0000-00-00 00:00:00', NULL),
(4, 'Móveis para Consultório', 2, '2019-04-26 00:00:00', '0000-00-00 00:00:00', NULL),
(5, 'Hardware', 3, '2019-04-26 00:00:00', '0000-00-00 00:00:00', NULL),
(6, 'Software', 3, '2019-04-26 00:00:00', '0000-00-00 00:00:00', NULL),
(7, 'Periféricos', 3, '2019-04-26 00:00:00', '0000-00-00 00:00:00', NULL),
(8, 'Sistemas', 3, '2019-04-26 00:00:00', '0000-00-00 00:00:00', NULL),
(9, 'Televisão', 10, '2019-04-26 00:00:00', '0000-00-00 00:00:00', NULL),
(10, 'Microondas', 9, '2019-04-26 00:00:00', '0000-00-00 00:00:00', NULL),
(11, 'Dedetização', 7, '2019-04-26 00:00:00', '0000-00-00 00:00:00', NULL),
(12, 'Cesta Básica', 4, '2019-04-26 00:00:00', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tags_nome_unique` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `termos`
--

DROP TABLE IF EXISTS `termos`;
CREATE TABLE IF NOT EXISTS `termos` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `texto` longtext NOT NULL,
  `tipo` enum('AQUISIÇÃO','SERVIÇOS','AQUISIÇÃO & SERVIÇOS') NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `origem_id` int(10) UNSIGNED NOT NULL,
  `destino_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `termos_user_id_foreign` (`user_id`),
  KEY `termos_origem_id_foreign` (`origem_id`),
  KEY `termos_destino_id_foreign` (`destino_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `termos_itens`
--

DROP TABLE IF EXISTS `termos_itens`;
CREATE TABLE IF NOT EXISTS `termos_itens` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `termo_id` int(10) UNSIGNED NOT NULL,
  `item_id` int(10) UNSIGNED NOT NULL,
  `quantidade` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `termos_itens_termo_id_index` (`termo_id`),
  KEY `termos_itens_item_id_index` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `throttles`
--

DROP TABLE IF EXISTS `throttles`;
CREATE TABLE IF NOT EXISTS `throttles` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(35) DEFAULT NULL,
  `is_default_password` tinyint(1) NOT NULL DEFAULT '1',
  `last_access_at` timestamp NULL DEFAULT NULL,
  `attempts` tinyint(4) NOT NULL DEFAULT '0',
  `last_attempt_at` timestamp NULL DEFAULT NULL,
  `suspended` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `throttles_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `throttles`
--

INSERT INTO `throttles` (`id`, `ip_address`, `is_default_password`, `last_access_at`, `attempts`, `last_attempt_at`, `suspended`, `user_id`) VALUES
(1, NULL, 1, NULL, 0, NULL, 0, 1),
(2, NULL, 1, NULL, 0, NULL, 0, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `unidades`
--

DROP TABLE IF EXISTS `unidades`;
CREATE TABLE IF NOT EXISTS `unidades` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tipo` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unidades_tipo_unique` (`tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `unidades`
--

INSERT INTO `unidades` (`id`, `tipo`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'UNIDADE(S)', '2019-04-25 17:35:24', '2019-04-25 17:35:24', NULL),
(2, 'SERVICO(S)', '2019-04-30 13:49:27', '2019-05-23 17:11:35', NULL),
(3, 'METRO(S)', '2019-04-30 14:13:12', '2019-05-15 14:36:12', NULL),
(4, 'LITRO(S)', '2019-05-23 17:09:03', '2019-05-23 17:12:40', NULL),
(5, 'M²', '2019-05-24 17:04:07', '2019-05-24 17:04:07', NULL),
(6, 'M³', '2019-05-24 17:04:38', '2019-05-24 17:04:38', NULL),
(7, 'KG', '2019-04-26 00:00:00', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(60) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'ANDRE TIMOTEO DO ROZARIO', 'andre.rosario@caraguatatuba.sp.gov.br', '$2y$10$TPZOfAb7xRYXpnCbaWctJOEN49MinFL0xyxqnbrloGhkANRzsckeS', NULL, '2019-04-26 00:00:00', '0000-00-00 00:00:00', NULL),
(2, 'ALEXANDRE GUDIN NOVAK', 'alexandre.novak@caraguatatuba.sp.gov.br', '$2y$10$mtXUBxMjGS30jc8bHpm8B.3IwY5GboghW2kXRQLU4xwBbVpCkNyNa', NULL, '2019-04-26 00:00:00', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users_roles`
--

DROP TABLE IF EXISTS `users_roles`;
CREATE TABLE IF NOT EXISTS `users_roles` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `users_roles_user_id_index` (`user_id`),
  KEY `users_roles_role_id_index` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `users_roles`
--

INSERT INTO `users_roles` (`id`, `user_id`, `role_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 2, 2),
(10, 2, 3),
(11, 2, 4),
(12, 2, 5),
(13, 2, 6),
(14, 2, 7),
(15, 2, 8);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users_secretarias`
--

DROP TABLE IF EXISTS `users_secretarias`;
CREATE TABLE IF NOT EXISTS `users_secretarias` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `secretaria_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `users_secretarias_user_id_index` (`user_id`),
  KEY `users_secretarias_secretaria_id_index` (`secretaria_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `itens`
--
ALTER TABLE `itens`
  ADD CONSTRAINT `itens_subcategoria_id_foreign` FOREIGN KEY (`subcategoria_id`) REFERENCES `subcategorias` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `itens_unidade_id_foreign` FOREIGN KEY (`unidade_id`) REFERENCES `unidades` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `itens_tags`
--
ALTER TABLE `itens_tags`
  ADD CONSTRAINT `itens_tags_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `itens` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `itens_tags_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `loggers`
--
ALTER TABLE `loggers`
  ADD CONSTRAINT `loggers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Limitadores para a tabela `subcategorias`
--
ALTER TABLE `subcategorias`
  ADD CONSTRAINT `subcategorias_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);

--
-- Limitadores para a tabela `termos`
--
ALTER TABLE `termos`
  ADD CONSTRAINT `termos_destino_id_foreign` FOREIGN KEY (`destino_id`) REFERENCES `secretarias` (`id`),
  ADD CONSTRAINT `termos_origem_id_foreign` FOREIGN KEY (`origem_id`) REFERENCES `secretarias` (`id`),
  ADD CONSTRAINT `termos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Limitadores para a tabela `termos_itens`
--
ALTER TABLE `termos_itens`
  ADD CONSTRAINT `termos_itens_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `itens` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `termos_itens_termo_id_foreign` FOREIGN KEY (`termo_id`) REFERENCES `termos` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `throttles`
--
ALTER TABLE `throttles`
  ADD CONSTRAINT `throttles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Limitadores para a tabela `users_roles`
--
ALTER TABLE `users_roles`
  ADD CONSTRAINT `users_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `users_secretarias`
--
ALTER TABLE `users_secretarias`
  ADD CONSTRAINT `users_secretarias_secretaria_id_foreign` FOREIGN KEY (`secretaria_id`) REFERENCES `secretarias` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_secretarias_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
