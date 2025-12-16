-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 16/03/2024 às 10:58
-- Versão do servidor: 5.7.44
-- Versão do PHP: 8.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bdwebgestora_protesto_mecanico`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `notificacoes_encaminhamento`
--

CREATE TABLE `notificacoes_encaminhamento` (
  `id` int(11) NOT NULL,
  `id_email` text NOT NULL,
  `id_notificacao` int(11) NOT NULL,
  `data_envio` datetime NOT NULL,
  `texto` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `notificacoes_encaminhamento`
--

INSERT INTO `notificacoes_encaminhamento` (`id`, `id_email`, `id_notificacao`, `data_envio`, `texto`) VALUES
(1, 'danielrezende@lojadomecanico.com.br,ricardoishikawa@lojadomecanico.com.br', 13, '2024-03-07 16:11:14', 'Indícios de não pagamento do ICMS-ST referente às notas\nfiscais indicadas abaixo e que se referem a produtos submetidos ao regime de Substituição Tributária Interestadual\nPeríodo Referência: 30/11/2023 A 27/12/2023\nSérie/Número:\n002/000003359, 002/000004104'),
(2, 'danielrezende@lojadomecanico.com.br,ricardoishikawa@lojadomecanico.com.br,taxplanning@lojadomecanico.com.br,gersonturola@lojadomecanico.com.br', 11, '2024-03-07 17:40:10', 'Indícios de não pagamento do ICMS-ST referente às notas\nfiscais indicadas abaixo e que se referem a produtos submetidos ao regime de Substituição Tributária Interestadual\nPeríodo Referência: 23/11/2023 A 16/02/2024\nSérie/Número:\n001/000426471, 001/000426555, 001/000443501, 001/000446949, 001/000454259, 001/000475022, 001/000476230, 001/000476434,\n001/000479154, 001/000480910, 001/000483773, 001/000492655'),
(3, 'danielrezende@lojadomecanico.com.br,ricardoishikawa@lojadomecanico.com.br,taxplanning@lojadomecanico.com.br,gersonturola@lojadomecanico.com.br', 12, '2024-03-07 17:42:58', 'Indícios de não pagamento do ICMS-ST referente às notas\nfiscais indicadas abaixo e que se referem a produtos submetidos ao regime de Substituição Tributária Interestadual \nPeríodo Referência: 25/11/2023 A 30/11/2023\nSérie/Número:\n002/000019171, 002/000019408'),
(4, 'taxplanning@lojadomecanico.com.br,gersonturola@lojadomecanico.com.br', 13, '2024-03-07 17:45:02', 'Indícios de não pagamento do ICMS-ST referente às notas\nfiscais indicadas abaixo e que se referem a produtos submetidos ao regime de Substituição Tributária Interestadual\nPeríodo Referência: 30/11/2023 A 27/12/2023\nSérie/Número:\n002/000003359, 002/000004104 '),
(5, 'taxplanning@lojadomecanico.com.br,gersonturola@lojadomecanico.com.br', 13, '2024-03-07 17:45:03', 'Indícios de não pagamento do ICMS-ST referente às notas\nfiscais indicadas abaixo e que se referem a produtos submetidos ao regime de Substituição Tributária Interestadual\nPeríodo Referência: 30/11/2023 A 27/12/2023\nSérie/Número:\n002/000003359, 002/000004104 '),
(6, '', 14, '2024-03-15 10:02:57', ' Fica o contribuinte, acima identificado, cientificado a regularizar o(s) crédito(s) tributário(s) detalhados no Anexo I.\nA verificação do cumprimento dos termos deste comunicado será realizada de ofício, devendo desconsiderar caso a inconsistência já\ntenha sido saneada.\nA não regularização do(s) crédito(s) tributário(s) enseja a emissão do AVISO DE COBRANÇA DA CONTA CORRENTE FISCAL, com\naplicação da penalidade, quando cabível e o envio para INSCRIÇÃO EM DÍVIDA ATIVA, a cargo da PROCURADORIA GERAL DO\nESTADO - PGE-MT, demais efeitos previstos na Lei 10.496/2017.\nCaso o contribuinte possua tratamento diferenciado nas operações de importação, exportação ou usufrua de benefícios fiscais\ncondicionados à manutenção da regularidade fiscal, observar, respectivamente, o que preconizam o artigo 16, I e o artigo 16, §1º, I\nambos do Decreto 317/2019, o artigo 7º, III do Decreto 1.262/2017 e o artigo 12, §3º, I do Decreto 288/2019 c/c artigo 14 do Decreto\n2.212/2014. A falta de regularidade fiscal implicará a suspensão do direito à fruição do tratamento diferenciado e/ou benefício fiscal.\nNão cabe impugnação ao Comunicado'),
(7, '', 14, '2024-03-15 10:02:59', ' Fica o contribuinte, acima identificado, cientificado a regularizar o(s) crédito(s) tributário(s) detalhados no Anexo I.\nA verificação do cumprimento dos termos deste comunicado será realizada de ofício, devendo desconsiderar caso a inconsistência já\ntenha sido saneada.\nA não regularização do(s) crédito(s) tributário(s) enseja a emissão do AVISO DE COBRANÇA DA CONTA CORRENTE FISCAL, com\naplicação da penalidade, quando cabível e o envio para INSCRIÇÃO EM DÍVIDA ATIVA, a cargo da PROCURADORIA GERAL DO\nESTADO - PGE-MT, demais efeitos previstos na Lei 10.496/2017.\nCaso o contribuinte possua tratamento diferenciado nas operações de importação, exportação ou usufrua de benefícios fiscais\ncondicionados à manutenção da regularidade fiscal, observar, respectivamente, o que preconizam o artigo 16, I e o artigo 16, §1º, I\nambos do Decreto 317/2019, o artigo 7º, III do Decreto 1.262/2017 e o artigo 12, §3º, I do Decreto 288/2019 c/c artigo 14 do Decreto\n2.212/2014. A falta de regularidade fiscal implicará a suspensão do direito à fruição do tratamento diferenciado e/ou benefício fiscal.\nNão cabe impugnação ao Comunicado'),
(8, 'danielrezende@lojadomecanico.com.br,ricardoishikawa@lojadomecanico.com.br,taxplanning@lojadomecanico.com.br,gersonturola@lojadomecanico.com.br', 18, '2024-03-15 11:35:21', ' Informamos que o pedido de ressarcimento, solicitado pelo contribuinte em epígrafe, para transferência de ICMS-ST,na modalidade Nota Fiscal de Ressarcimento através do processo nº\n017.00007042/2023-41\nantigo SFP-EXP-2022/133868, foi\nDEFERIDO\n, para a empresa:\nMAKITA DO BARSIL FERR ELETRICAS LTDA\nCNPJ: 45.865.920/0001-00\nIE: 635.199.787.113'),
(10, 'gilberto@bdservicos.com.br,danielrezende@lojadomecanico.com.br,ricardoishikawa@lojadomecanico.com.br,taxplanning@lojadomecanico.com.br,gersonturola@lojadomecanico.com.br', 17, '2024-03-15 14:04:28', 'INCONSISTÊNCIA IDENTIFICADA Identificou-se que o contribuinte acima qualificado POSSUI CRÉDITO(S) TRIBUTÁRIO(S) QUE SE ENCONTRA(M) OMISSO(S),\nVENCIDO(S) E NÃO PAGO(S), REGISTRADO(S) NO SISTEMA DE CONTA CORRENTE FISCAL (SCCF) DA SECRETARIA DE\nESTADO DE FAZENDA DO MATO GROSSO - SEFAZ/MT.\nConforme previsto no inciso XI do artigo 17 da Lei 7098/98, é obrigação do contribuinte pagar o tributo devido na forma e prazo previstos\nno regulamento'),
(11, 'danielrezende@lojadomecanico.com.br,ricardoishikawa@lojadomecanico.com.br,taxplanning@lojadomecanico.com.br,gersonturola@lojadomecanico.com.br', 16, '2024-03-15 14:10:59', ' INCONSISTÊNCIA IDENTIFICADA\nIdentificou-se que o contribuinte acima qualificado POSSUI CRÉDITO(S) TRIBUTÁRIO(S) QUE SE ENCONTRA(M) OMISSO(S),\nVENCIDO(S) E NÃO PAGO(S), REGISTRADO(S) NO SISTEMA DE CONTA CORRENTE FISCAL (SCCF) DA SECRETARIA DE\nESTADO DE FAZENDA DO MATO GROSSO - SEFAZ/MT.\nConforme previsto no inciso XI do artigo 17 da Lei 7098/98, é obrigação do contribuinte pagar o tributo devido na forma e prazo previstos\nno regulamento.'),
(12, 'danielrezende@lojadomecanico.com.br,ricardoishikawa@lojadomecanico.com.br,taxplanning@lojadomecanico.com.br,gersonturola@lojadomecanico.com.br', 15, '2024-03-15 14:14:05', 'INCONSISTÊNCIA IDENTIFICADA Identificou-se que o contribuinte acima qualificado POSSUI CRÉDITO(S) TRIBUTÁRIO(S) QUE SE ENCONTRA(M) OMISSO(S),\nVENCIDO(S) E NÃO PAGO(S), REGISTRADO(S) NO SISTEMA DE CONTA CORRENTE FISCAL (SCCF) DA SECRETARIA DE\nESTADO DE FAZENDA DO MATO GROSSO - SEFAZ/MT.\nConforme previsto no inciso XI do artigo 17 da Lei 7098/98, é obrigação do contribuinte pagar o tributo devido na forma e prazo previstos\nno regulamento.'),
(13, 'danielrezende@lojadomecanico.com.br,ricardoishikawa@lojadomecanico.com.br,taxplanning@lojadomecanico.com.br,gersonturola@lojadomecanico.com.br', 14, '2024-03-15 14:17:05', ' INCONSISTÊNCIA IDENTIFICADA\nIdentificou-se que o contribuinte acima qualificado POSSUI CRÉDITO(S) TRIBUTÁRIO(S) QUE SE ENCONTRA(M) OMISSO(S),\nVENCIDO(S) E NÃO PAGO(S), REGISTRADO(S) NO SISTEMA DE CONTA CORRENTE FISCAL (SCCF) DA SECRETARIA DE\nESTADO DE FAZENDA DO MATO GROSSO - SEFAZ/MT.\nConforme previsto no inciso XI do artigo 17 da Lei 7098/98, é obrigação do contribuinte pagar o tributo devido na forma e prazo previstos\nno regulamento.'),
(14, 'danielrezende@lojadomecanico.com.br,ricardoishikawa@lojadomecanico.com.br,taxplanning@lojadomecanico.com.br,gersonturola@lojadomecanico.com.br', 19, '2024-03-15 14:42:24', ' Fica o contribuinte NOTIFICADO a promover o cancelamento da nota fiscal eletrônica\nabaixo relacionada, conforme solicitado pelo e-mail e referente ao processo em referência:\nNFE 3.273 – Chave 3522 0529 3023 4800 0387 5501 0000 0032 7310 0070 9106;\nPrazo para atendimento: 15 (quinze) dias.\nBase Legal: Art 494 do RICMS/00.\nObs.: O não atendimento dos termos desta Notificação implicará na adoção das\nsanções cabíveis.'),
(15, 'danielrezende@lojadomecanico.com.br,ricardoishikawa@lojadomecanico.com.br,taxplanning@lojadomecanico.com.br,gersonturola@lojadomecanico.com.br', 20, '2024-03-15 16:56:24', 'Foram encontradas as divergências listadas abaixo entre os arquivos da EFD e da GIA enviados.\n\nIE: 241.106.454.112\nPeríodo de referência: 06/2023\nNome do arquivo EFD: SpedEFD-29302348000387-241106454112-1-202306-28122023192223-017-28122023194654.txt\nControle da GIA transmitida: 262760648\nControle da GIA da EFD: 17785690 '),
(16, 'danielrezende@lojadomecanico.com.br,ricardoishikawa@lojadomecanico.com.br,taxplanning@lojadomecanico.com.br,gersonturola@lojadomecanico.com.br', 0, '2024-03-15 17:02:12', ' Foram encontradas as inconsistências listadas abaixo referentes ao arquivo da EFD enviado.\n\nIE: 241.106.454.112\nPeríodo de referência: 02/2023\nNome do arquivo EFD: SpedEFD-29302348000387-241106454112-1-202302-19022024150959-017-19022024152025.txt\nControle da GIA: 18320139'),
(17, 'danielrezende@lojadomecanico.com.br,ricardoishikawa@lojadomecanico.com.br,taxplanning@lojadomecanico.com.br,gersonturola@lojadomecanico.com.br', 0, '2024-03-15 17:02:40', ' Foram encontradas as inconsistências listadas abaixo referentes ao arquivo da EFD enviado.\n\nIE: 241.106.454.112\nPeríodo de referência: 02/2023\nNome do arquivo EFD: SpedEFD-29302348000387-241106454112-1-202302-19022024150959-017-19022024152025.txt\nControle da GIA: 18320139');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `notificacoes_encaminhamento`
--
ALTER TABLE `notificacoes_encaminhamento`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `notificacoes_encaminhamento`
--
ALTER TABLE `notificacoes_encaminhamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
