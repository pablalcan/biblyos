-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 30/06/2025 às 00:10
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `biblioteca_digital_biblyos`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `livros`
--

CREATE TABLE `livros` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `autor` varchar(255) DEFAULT NULL,
  `ano_publicacao` int(11) DEFAULT NULL,
  `genero` varchar(100) DEFAULT NULL,
  `livro_pdf` varchar(255) DEFAULT NULL,
  `capa` varchar(255) DEFAULT NULL,
  `sinopse` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `livros`
--

INSERT INTO `livros` (`id`, `titulo`, `autor`, `ano_publicacao`, `genero`, `livro_pdf`, `capa`, `sinopse`) VALUES
(4, 'A Divina Comédia', 'Dante Alighieri', 1320, 'Poesia épica', 'a-divina-comedia.pdf', 'a_divina_comedia.jpg', 'A jornada de Dante pelos reinos do Inferno, Purgatório e Paraíso, uma alegoria moral e espiritual da alma humana.'),
(16, 'Dom Casmurro', 'Machado de Assis', 1899, 'Romance realista', 'dom_casmurro.pdf', 'dom_casmurro.jpg', 'Narrativa sobre um homem obcecado pela suposta traição de sua esposa, explorando ciúmes, memórias e ambiguidade moral.'),
(18, 'Memórias Póstumas de Brás Cubas', 'Machado de Assis', 1881, 'Romance realista', 'memorias_postumas_de_bras_cubas.pdf', 'memorias_postumas_de_bras_cubas.jpg', 'Um defunto-autor relembra sua vida com humor ácido e filosofia, questionando os valores da sociedade brasileira do século XIX.'),
(20, 'O Cortiço', 'Aluísio Azevedo', 1890, 'Romance naturalista', 'o_cortico.pdf', 'o_cortico.jpg', 'Obra que retrata a vida num cortiço carioca, denunciando a opressão social, a degradação e os impulsos humanos.'),
(22, 'O Triste Fim de Policarpo Quaresma', 'Lima Barreto', 1915, 'Romance satírico', 'o_triste_fim_de_policarpo_quaresma.pdf', 'o_triste_fim_de_policarpo_quaresma.jpg', 'A trajetória de um nacionalista ingênuo cujos sonhos patrióticos colidem com a dureza da burocracia e da política brasileira.'),
(23, 'O Anticristo', 'Friedrich Nietzsche', 1895, 'Filosofia', 'o_anticristo.pdf', 'o_anticristo.jpg', 'Crítica feroz ao cristianismo institucional e seus valores, exaltando a liberdade individual e a superação do homem.'),
(24, 'Os Dois Amores', 'Joaquim Manuel de Macedo', 1848, 'Romance', 'os_dois_amores.pdf', 'os_dois_amores.jpg', 'Um enredo sentimental que retrata triângulos amorosos e os costumes da juventude carioca do século XIX.'),
(25, 'Os Escravos', 'Castro Alves', 1869, 'Poesia social', 'os_escravos.pdf', 'os_escravos.jpg', 'Coletânea poética com duras críticas à escravidão, exaltando liberdade, justiça e igualdade entre os povos.'),
(26, 'Os Lusíadas', 'Luís de Camões', 1572, 'Épico', 'os_lusiadas.pdf', 'os_lusiadas.jpg', 'Poema épico que narra os feitos heroicos dos portugueses durante as Grandes Navegações, com forte mitologia clássica.'),
(27, 'Os Maias', 'Eça de Queirós', 1888, 'Romance realista', 'os_maias.pdf', 'os_maias.jpg', 'Saga da decadência de uma família tradicional portuguesa, marcada por adultério, desencanto e crítica social.'),
(28, 'Os Sertões', 'Euclides da Cunha', 1902, 'Ensaio sociológico', 'os_sertoes.pdf', 'os_sertoes.jpg', 'Análise profunda da Guerra de Canudos, misturando literatura, jornalismo e ciência social sobre o sertão nordestino.'),
(29, 'Primeiros Cantos', 'Gonçalves Dias', 1847, 'Poesia romântica', 'primeiros_cantos.pdf', 'primeiros_cantos.jpg', 'Coletânea de poemas líricos e indianistas, celebrando a natureza, o amor e o espírito nacional brasileiro.'),
(34, 'Senhora', 'José de Alencar', 1874, 'Romance', '685c940842892_senhora.pdf', '685c9408435a7_senhora.jpg', 'Senhora é uma história de amor e vingança, com uma visão à frente do seu tempo em torno da temática do casamento por interesse, uma prática comum no século XIX.\r\n\r\nAurélia Camargo, a personagem principal, é uma pobre órfã que se apaixona por Fernando Seixas, um ambicioso jovem que a troca por uma moça rica. Porém, numa das reviravoltas da vida, Aurélia recebe uma grande herança do avô e torna-se rica da noite para o dia. Decide então vingar-se do antigo namorado, armando um casamento por interesse sem que ele saiba quem é a noiva. Em um jogo de humilhações, acusações e mágoa, será que o amor prevalecerá?\r\n\r\nO livro faz parte do período de Romantismo da literatura brasileira.\r\n\r\nNesta edição em e-book do romance Senhora, foram acrescentadas notas explicativas sobre palavras, expressões e referências de época usadas na obra (basta passar o cursor na palavra), a fim de facilitar a leitura e oferecer um enriquecimento da experiência do leitor. Além disso, agregamos informações sobre filmes e novelas baseados na obra, links para críticas e resenhas.'),
(52, 'A Carne', 'Júlio Ribeiro', 1888, 'Romance naturalista', 'a-carne.pdf', 'a_carne.jpg', 'Romance polêmico que explora temas como sensualidade, desejo e conservadorismo na sociedade brasileira do século XIX.'),
(53, 'Caramuru', 'Frei José de Santa Rita Durão', 1781, 'Épico histórico', 'caramuru.pdf', 'caramuru.jpg', 'Poema épico sobre Diogo Álvares Correia, o Caramuru, que narra o encontro entre europeus e indígenas no Brasil colonial.'),
(54, 'Cinco Minutos', 'José de Alencar', 1856, 'Romance romântico', 'cinco-minutos.pdf', 'cinco_minutos.jpg', 'Uma história de amor que começa em um encontro casual num transporte público e se desenvolve de forma delicada e misteriosa.'),
(55, 'Esau e Jacó', 'Machado de Assis', 1904, 'Romance realista', 'esau_e_jaco.pdf', 'esau_e_jaco.jpg', 'Romance que acompanha a rivalidade entre dois irmãos gêmeos, com paralelos bíblicos e crítica à política e à sociedade brasileira.'),
(56, 'Iracema', 'José de Alencar', 1865, 'Romance indianista', 'iracema.pdf', 'iracema.jpeg', 'Narrativa poética sobre o amor entre o colono português Martim e a índia Iracema, símbolo da formação do povo brasileiro.'),
(57, 'Macbeth', 'William Shakespeare', 1606, 'Tragédia', 'macbeth.pdf', 'macbeth.jpg', 'Um general escocês é levado pela ambição e profecias sombrias a trair seu rei e mergulhar em um ciclo trágico de culpa e violência.'),
(58, 'Mãe', 'Máximo Gorki', 1906, 'Romance político', 'mae.pdf', 'mae.jpg', 'Uma mãe simples se envolve no movimento revolucionário russo ao acompanhar a luta de seu filho operário.'),
(59, 'Novas Relíquias', 'Julia Lopes de Almeida', 1891, 'Contos realistas', 'novas_reliquias.pdf', 'novas_reliquias.jpg', 'Coletânea que aborda dramas sociais e dilemas da mulher e da família na sociedade brasileira do século XIX.'),
(60, 'O Abolicionismo', 'Joaquim Nabuco', 1883, 'Ensaio político', 'o_abolicionismo.pdf', 'o_abolicionismo.jpg', 'Obra fundamental do movimento abolicionista, com argumentos morais, econômicos e sociais contra a escravidão no Brasil.'),
(61, 'O Ateneu', 'Raul Pompeia', 1888, 'Romance psicológico', 'o_ateneu.pdf', 'o_ateneu.jpg', 'Relato da vivência de um adolescente num internato tradicional, explorando temas como repressão, hipocrisia e amadurecimento.'),
(62, 'O Banqueiro Anarquista', 'Fernando Pessoa', 1922, 'Ensaio filosófico', 'o_banqueiro_anarquista.pdf', 'o_banqueiro_anarquista.jpg', 'Diálogo irônico entre um banqueiro e seu interlocutor sobre liberdade, capitalismo e anarquismo.'),
(63, 'O Cemitério dos Vivos', 'Lima Barreto', 1920, 'Romance autobiográfico', 'o_cemiterio_dos_vivos.pdf', 'o_cemiterio_dos_vivos.jpg', 'Reflexão sobre a experiência do autor internado em um hospício, revelando os abusos e o descaso com a saúde mental.'),
(64, 'O Mercador de Veneza', 'William Shakespeare', 1597, 'Drama', 'o_mercador_de_veneza.pdf', 'o_mercador_de_veneza.jpg', 'Uma peça que mistura romance e tensão jurídica ao explorar justiça, vingança e misericórdia em uma sociedade comercial.'),
(65, 'O Matuto', 'Manuel de Oliveira Paiva', 1890, 'Romance regionalista', 'o_matuto.pdf', 'o_matuto.jpg', 'Retrato crítico da vida no sertão e das transformações sociais do Nordeste brasileiro.'),
(66, 'O Mulato', 'Aluísio Azevedo', 1881, 'Romance abolicionista', 'o_mulato.pdf', 'o_mulato.jpg', 'Primeiro romance naturalista brasileiro, aborda o preconceito racial e o sofrimento dos negros no pós-abolição.'),
(67, 'O Noviço', 'Martins Pena', 1853, 'Comédia de costumes', 'o_novico.pdf', 'o_novico.jpg', 'Peça que satiriza os hábitos da sociedade brasileira do século XIX, focando em casamento por interesse e hipocrisia.'),
(68, 'O Sertanejo', 'José de Alencar', 1875, 'Romance regionalista', 'o_sertanejo.pdf', 'o_sertanejo.jpg', 'Narrativa sobre um vaqueiro nordestino que simboliza os valores da vida simples, da coragem e da honra no sertão.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `data_cadastro`) VALUES
(1, 'Pablo', 'pablo@gmail.com', '$2y$10$H7xOMXtbY71qWqJW2ZDpze9jUA5CSHB7U2OgFa6iQJiy216PMEe4u', '2025-06-18 23:55:35'),
(2, 'Jessica', 'jessica@gmail.com', '$2y$10$GLeMv2PDKy44B3nhdXA9Euxx/UmV3jBcC.dkX9yfvR6i4BES.8SlC', '2025-06-26 23:21:50');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `livros`
--
ALTER TABLE `livros`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `livros`
--
ALTER TABLE `livros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
