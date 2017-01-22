--
-- Zbirka podatkov: `astronomicstore`
--

-- --------------------------------------------------------

--
-- Struktura tabele `ARTIKEL`
--

CREATE TABLE `ARTIKEL` (
  `SIFRA_ARTIKLA` int(11) NOT NULL,
  `ID_SKUPINE` int(11) NOT NULL,
  `NAZIV_ARTIKLA` varchar(50) CHARACTER SET utf8 NOT NULL,
  `CENA` decimal(10,2) NOT NULL,
  `PROIZVAJALEC` varchar(25) DEFAULT NULL,
  `ENOTA_MER` char(5) NOT NULL,
  `OPIS` varchar(500) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Odloži podatke za tabelo `ARTIKEL`
--

INSERT INTO `ARTIKEL` (`SIFRA_ARTIKLA`, `ID_SKUPINE`, `NAZIV_ARTIKLA`, `CENA`, `PROIZVAJALEC`, `ENOTA_MER`, `OPIS`) VALUES
(122, 1, 'Teleskop', '500.17', 'Celsteron', '1', 'Največji refraktor, ki je še primeren za EQ2 ekvatorialno montažo - večja odprtina pripomore k svetlejši sliki. V paketu je iskalo, diagonala, 2 okularja (10 in 25 mm) ter 1,25" 2x barlow leča .'),
(123, 3, '4mm TS Plossl okular, 1,25', '26.90', 'Telesor', '4', 'Najnovejši okularji!'),
(124, 1, '130mm Newton reflektor (F=900mm) na EQ-2 montaži', '229.12', 'Sky Watcher', '2', 'Največji Newton, ki je še primeren za EQ2 ekvatorialno montažo - večja odprtina pripomore k svetlejši sliki in nekaj večji maksimalni uporabni povečavi, kot pri podobnem 114mm teleskopu. V paketu so še iskalo, 2 okularja (10 in 25mm) ter 1,25" 2x barlow leča.\n'),
(125, 3, 'Optična cevk', '123.17', 'Leo', '3', 'Nova serija kvalitetnih Orion Optics newton optičnih cevi je nadomestila serije Europa, SPX in OD.\n\nkvaliteta optike: vse VX cevi se ponašajo z odlično 1/6PV optiko s Hilux premazom, možne so tudi nadgrandje na 1/8PV ali 1/10PV (vprašajte za ceno).Za vsako optično cev dobite tudi Zygo optični certifikat (izmerjena kvaliteta zrcala).Celica primarnega zrcala: aluminijasta z 9-točkovno podporo za boljšo stabilnost (s preprostim sistemom kolimacije).'),
(127, 2, 'Zaščitna očala', '87.21', 'Ray', '1', 'Filter za zaščito pred soncem stopnje 3 • G15 toniranje za izjemno prepoznavanje barv • polarizirana stekla za zmanjšanje bleščanja • anatomsko oblikovana, nastavljiv nosnik • ergonomski zaušniki.'),
(128, 3, 'Velika Kmicina vrtljiva zvezdna karta', '10.50', 'Kmica', '5', 'Karta z največjim premerom neba v slovenskem jeziku. Premer karte je 270 mm. Nepogrešljiv pripomoček na tekmovanjih iz astronomije.');

-- --------------------------------------------------------

--
-- Struktura tabele `DNEVNIK_PRIJAV`
--

CREATE TABLE `DNEVNIK_PRIJAV` (
  `ID_PRIJAVE` int(11) NOT NULL,
  `IP` varchar(20) DEFAULT NULL,
  `CAS_PRIJAVE` datetime DEFAULT NULL,
  `CAS_ODJAVE` datetime DEFAULT NULL,
  `USPESNOST` smallint(6) NOT NULL,
  `ID_UPORABNIKA` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Odloži podatke za tabelo `DNEVNIK_PRIJAV`
--

INSERT INTO `DNEVNIK_PRIJAV` (`ID_PRIJAVE`, `IP`, `CAS_PRIJAVE`, `CAS_ODJAVE`, `USPESNOST`, `ID_UPORABNIKA`) VALUES
(1, '69.123.21.22', '2015-07-06 22:23:11', '2016-07-06 22:25:01', 1, '1'),
(2, '52.98.223.1', '2015-08-08 09:45:45', '2015-08-08 09:50:32', 1, '1'),
(3, '123.99.50.21', '2016-11-11 14:25:01', '2016-11-11 14:25:01', 0, '1'),
(4, NULL, '2017-01-19 19:53:48', '2017-01-19 19:58:43', 1, ''),
(5, NULL, '2017-01-19 20:20:13', '2017-01-19 20:20:21', 1, '3'),
(6, NULL, '2017-01-19 20:21:13', '2017-01-19 20:22:38', 1, '1'),
(7, NULL, '2017-01-19 20:22:48', '2017-01-19 20:42:37', 1, '3'),
(8, '127.0.0.1', '2017-01-19 20:52:42', '2017-01-19 20:52:45', 1, '3'),
(9, '127.0.0.1', '2017-01-20 17:28:23', NULL, 1, ''),
(10, '127.0.0.1', '2017-01-20 17:28:27', NULL, 1, ''),
(11, '127.0.0.1', '2017-01-20 17:28:33', NULL, 1, ''),
(12, '127.0.0.1', '2017-01-20 17:28:50', NULL, 1, ''),
(13, '127.0.0.1', '2017-01-20 17:29:46', '2017-01-20 17:30:37', 1, ''),
(14, '127.0.0.1', '2017-01-20 18:19:04', '2017-01-20 18:26:14', 1, '3'),
(15, '127.0.0.1', '2017-01-20 20:22:49', NULL, 1, '3'),
(16, '127.0.0.1', '2017-01-20 20:23:39', NULL, 1, '3'),
(17, '127.0.0.1', '2017-01-20 20:24:07', '2017-01-20 20:30:10', 1, '3'),
(18, '::1', '2017-01-20 21:44:06', NULL, 1, '3'),
(19, '::1', '2017-01-20 22:05:24', '2017-01-20 22:07:42', 1, '3'),
(20, '::1', '2017-01-20 22:07:47', NULL, 1, '2'),
(21, '::1', '2017-01-20 22:08:20', '2017-01-20 22:08:24', 1, '3'),
(22, '::1', '2017-01-20 22:08:28', NULL, 1, '2'),
(23, '::1', '2017-01-20 22:09:25', NULL, 1, '2'),
(24, '::1', '2017-01-20 22:09:32', NULL, 1, '2'),
(25, '::1', '2017-01-20 22:10:25', NULL, 1, '2'),
(26, '::1', '2017-01-20 22:10:48', NULL, 1, '2'),
(27, '::1', '2017-01-20 22:11:15', NULL, 1, '2'),
(28, '::1', '2017-01-20 22:11:27', NULL, 1, '2'),
(29, '::1', '2017-01-20 22:11:57', NULL, 1, '2'),
(30, '::1', '2017-01-20 22:12:12', NULL, 1, '2'),
(31, '::1', '2017-01-20 22:12:21', NULL, 1, '2'),
(32, '::1', '2017-01-20 22:14:15', NULL, 1, '2'),
(33, '::1', '2017-01-20 22:14:39', '2017-01-20 22:14:44', 1, '1'),
(34, '::1', '2017-01-20 22:14:57', NULL, 1, '3'),
(35, '::1', '2017-01-20 22:21:30', '2017-01-20 22:27:13', 1, '2'),
(36, '::1', '2017-01-20 22:36:27', '2017-01-20 22:36:42', 1, '1'),
(37, '::1', '2017-01-20 22:37:51', NULL, 1, '1'),
(38, '::1', '2017-01-20 22:42:33', NULL, 1, '1'),
(39, '::1', '2017-01-20 23:10:21', NULL, 1, '1');

-- --------------------------------------------------------

--
-- Struktura tabele `KOMERCIALNA_SKUPINA`
--

CREATE TABLE `KOMERCIALNA_SKUPINA` (
  `ID_SKUPINE` int(11) NOT NULL,
  `NAZIV_SKUPINE` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Odloži podatke za tabelo `KOMERCIALNA_SKUPINA`
--

INSERT INTO `KOMERCIALNA_SKUPINA` (`ID_SKUPINE`, `NAZIV_SKUPINE`) VALUES
(1, 'Skupina 1'),
(2, 'Skupina 2'),
(3, 'Skupina 3');

-- --------------------------------------------------------

--
-- Struktura tabele `NAROCILO`
--

CREATE TABLE `NAROCILO` (
  `ID_NAROCILA` int(11) NOT NULL,
  `ID_UPORABNIK` int(11) NOT NULL,
  `DATUM_NAROCILA` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `STATUS_NAROCILA` int(11) NOT NULL,
  `ZAPOREDNA_STEVILKA` int(11) NOT NULL,
  `KOLICINA_ARTIKLA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Odloži podatke za tabelo `NAROCILO`
--

INSERT INTO `NAROCILO` (`ID_NAROCILA`, `ID_UPORABNIK`, `DATUM_NAROCILA`, `STATUS_NAROCILA`, `ZAPOREDNA_STEVILKA`, `KOLICINA_ARTIKLA`) VALUES
(1, 8, '2017-01-17 12:39:21', 4, 0, 2),
(2, 8, '2017-01-17 12:24:44', 6, 0, 4),
(3, 8, '2017-01-17 12:39:45', 4, 0, 1),
(7, 8, '2017-01-17 12:29:17', 10, 3, 4),
(8, 8, '2017-01-17 13:30:13', 4, 3, 1),
(9, 8, '2017-01-18 10:45:00', 4, 5, 4),
(10, 8, '2017-01-17 12:38:56', 4, 5, 1),
(11, 8, '2017-01-17 12:26:19', 5, 7, 80),
(12, 8, '2017-01-17 12:26:19', 5, 7, 10),
(13, 8, '2017-01-17 14:30:32', 4, 9, 10),
(14, 8, '2017-01-17 12:40:58', 6, 9, 8),
(15, 8, '2017-01-17 15:06:07', 4, 11, 1),
(16, 8, '2017-01-17 13:55:02', 1, 12, 1),
(17, 8, '2017-01-17 15:05:49', 10, 13, 4),
(18, 8, '2017-01-17 14:30:14', 6, 13, 1),
(19, 8, '2017-01-18 10:44:53', 10, 15, 7),
(20, 8, '2017-01-17 14:06:55', 2, 15, 1),
(21, 8, '2017-01-17 15:05:54', 6, 15, 1),
(22, 8, '2017-01-17 14:30:18', 10, 18, 5),
(23, 8, '2017-01-17 14:13:15', 2, 19, 1),
(24, 8, '2017-01-17 14:31:33', 5, 20, 7),
(25, 8, '2017-01-20 17:37:58', 1, 21, 2),
(26, 8, '2017-01-20 17:37:58', 1, 21, 3),
(27, 3, '2017-01-20 21:27:24', 1, 23, 1),
(28, 3, '2017-01-20 21:29:16', 1, 24, 1),
(29, 3, '2017-01-20 21:37:08', 5, 25, 1),
(30, 3, '2017-01-20 21:37:08', 5, 25, 1),
(31, 3, '2017-01-20 21:37:08', 5, 25, 1),
(32, 3, '2017-01-20 21:37:21', 5, 28, 1),
(33, 3, '2017-01-20 21:37:21', 5, 28, 1),
(34, 3, '2017-01-20 21:37:21', 5, 28, 1);

-- --------------------------------------------------------

--
-- Struktura tabele `SLIKA`
--

CREATE TABLE `SLIKA` (
  `ID_SLIKE` int(11) NOT NULL,
  `SIFRA_ARTIKLA` int(11) NOT NULL,
  `IME_SLIKE` varchar(100) CHARACTER SET utf8 NOT NULL,
  `POT_SLIKE` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Odloži podatke za tabelo `SLIKA`
--

INSERT INTO `SLIKA` (`ID_SLIKE`, `SIFRA_ARTIKLA`, `IME_SLIKE`, `POT_SLIKE`) VALUES
(1, 122, 'teleksop', 'http://astronomska-revija-spika.si/media/2014/11/teleskop-dobron-25cm.jpg'),
(2, 124, 'Sky Wathcer Teleskop', 'http://www.mojteleskop.si/images/catalog/800_bk1309eq2.jpg'),
(3, 127, 'očala za sonce', 'http://astronomska-revija-spika.si/media/2014/11/ocala-opazovanje-sonca.jpg'),
(4, 125, 'optična cev', 'http://www.mojteleskop.si/images/catalog/800_bk15012ota.jpg'),
(5, 128, 'Zvezdna karta', 'http://www.mojteleskop.si/images/catalog/800_cmb-karta.jpg'),
(6, 123, 'Plossl okular', 'http://www.mojteleskop.si/images/catalog/800_ts-tsplossl.jpg');

-- --------------------------------------------------------

--
-- Struktura tabele `UPORABNIK`
--

CREATE TABLE `UPORABNIK` (
  `ID_UPORABNIK` int(11) NOT NULL,
  `TIP` int(11) NOT NULL,
  `IME` varchar(100) CHARACTER SET utf8 NOT NULL,
  `PRIIMEK` varchar(100) CHARACTER SET utf8 NOT NULL,
  `ELEKTRONSKI_NASLOV` varchar(30) NOT NULL,
  `GESLO` varchar(32) NOT NULL,
  `TELEFONSKA_STEVILKA` varchar(15) DEFAULT NULL,
  `NASLOV` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `STATUS` tinyint(1) NOT NULL,
  `CONFIRMED` varchar(45) DEFAULT NULL,
  `VALIDATED` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Odloži podatke za tabelo `UPORABNIK`
--

INSERT INTO `UPORABNIK` (`ID_UPORABNIK`, `TIP`, `IME`, `PRIIMEK`, `ELEKTRONSKI_NASLOV`, `GESLO`, `TELEFONSKA_STEVILKA`, `NASLOV`, `STATUS`, `CONFIRMED`, `VALIDATED`) VALUES
(1, 1, 'Jernej', 'Rejc', 'rejcjernej194@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '40404320', 'dasddas 43', 1, '', '1'),
(2, 2, 'Matevž', 'Šubic', 'matevz.subic@gmail.com', 'fbe46ae0ca687ab0267be5cca10a248b', '', '', 0, '', '1'),
(3, 3, 'Vitoo', 'Simič', 'vito.simic@gmail.com', '334c4a4c42fdb79d7ebc3e73b517e6f8', '071291888', 'Šmarješka ulica 22c', 1, '', '1'),
(8, 3, 'ijoh', 'dasda', 'ooo@oo.oo', 'e10adc3949ba59abbe56e057f20f883e', '0404040990', 'vdsa 15', 1, '1103840356', '1'),
(9, 3, 'fvvvvvvvvv', 'vvvvvvvv', 'vvvvv@vvvvv.vv', 'e10adc3949ba59abbe56e057f20f883e', '0404040040', 'vvvvv 54', 1, '', '1'),
(10, 3, 'aaaa', 'aaaa', 'fff@fff.fff', 'e10adc3949ba59abbe56e057f20f883e', '0404040404', 'ffff 16', 1, '', '1'),
(14, 3, 'aaaa', 'aaaa', 'aaaa@aaaa.aaaa', 'e10adc3949ba59abbe56e057f20f883e', '040404040', 'aaaa 4', 1, '891852', '1'),
(15, 3, 'llll', 'llll', 'llll@llll.llll', 'e10adc3949ba59abbe56e057f20f883e', '090909090', 'llll 16', 1, '328383', '1'),
(16, 3, 'astro', 'astro', 'aaaa@a.a', 'e10adc3949ba59abbe56e057f20f883e', '103290001', 'dsadasda 123', 1, '608389', '1'),
(17, 3, 'ko', 'ko', 'ko@ko.ko', '82bdf4f8a12ac13d84a23b0b2dfe13e7', '0404040404', 'koko 16', 1, '', '1'),
(18, 3, 'oooo', 'dsadas', 'adsadas@fds.cdsaomdsa', 'e10adc3949ba59abbe56e057f20f883e', '893929899', 'dasddas 433', 1, '', '1'),
(19, 3, 'dsadsa', 'dsa', 'dasddsaa@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '909090909', 'asdsa 12', 1, '', '1'),
(20, 3, 'pool', 'pool', 'astronomicproject@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '040404040', 'sad 12', 1, '', '1'),
(21, 3, 'abcde', 'abcde', 'abcde@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '090909090', 'abcde 14', 1, '519563', '1'),
(22, 3, 'qqqq', 'qqqq', 'qqqq@qqqq.qqqq', 'e10adc3949ba59abbe56e057f20f883e', '090909090', 'qqqq 12', 1, '957157', '1');

-- --------------------------------------------------------

--
-- Struktura tabele `VSEBUJE`
--

CREATE TABLE `VSEBUJE` (
  `ID_NAROCILA` int(11) NOT NULL,
  `SIFRA_ARTIKLA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Odloži podatke za tabelo `VSEBUJE`
--

INSERT INTO `VSEBUJE` (`ID_NAROCILA`, `SIFRA_ARTIKLA`) VALUES
(1, 122),
(2, 125),
(3, 127),
(7, 122),
(8, 125),
(9, 122),
(10, 125),
(11, 122),
(12, 125),
(13, 122),
(14, 125),
(15, 122),
(16, 122),
(17, 122),
(18, 127),
(19, 122),
(20, 125),
(21, 127),
(22, 122),
(23, 122),
(24, 122),
(25, 122),
(26, 127),
(27, 123),
(28, 123),
(29, 122),
(30, 123),
(31, 124),
(32, 122),
(33, 123),
(34, 124);

--
-- Indeksi zavrženih tabel
--

--
-- Indeksi tabele `ARTIKEL`
--
ALTER TABLE `ARTIKEL`
  ADD PRIMARY KEY (`SIFRA_ARTIKLA`),
  ADD KEY `FK_SPADA_POD` (`ID_SKUPINE`);

--
-- Indeksi tabele `DNEVNIK_PRIJAV`
--
ALTER TABLE `DNEVNIK_PRIJAV`
  ADD PRIMARY KEY (`ID_PRIJAVE`);

--
-- Indeksi tabele `KOMERCIALNA_SKUPINA`
--
ALTER TABLE `KOMERCIALNA_SKUPINA`
  ADD PRIMARY KEY (`ID_SKUPINE`);

--
-- Indeksi tabele `NAROCILO`
--
ALTER TABLE `NAROCILO`
  ADD PRIMARY KEY (`ID_NAROCILA`),
  ADD KEY `FK_RELATIONSHIP_3` (`ID_UPORABNIK`);

--
-- Indeksi tabele `SLIKA`
--
ALTER TABLE `SLIKA`
  ADD PRIMARY KEY (`ID_SLIKE`),
  ADD KEY `FK_RELATIONSHIP_5` (`SIFRA_ARTIKLA`);

--
-- Indeksi tabele `UPORABNIK`
--
ALTER TABLE `UPORABNIK`
  ADD PRIMARY KEY (`ID_UPORABNIK`);

--
-- Indeksi tabele `VSEBUJE`
--
ALTER TABLE `VSEBUJE`
  ADD PRIMARY KEY (`ID_NAROCILA`,`SIFRA_ARTIKLA`),
  ADD KEY `FK_RELATIONSHIP_7` (`SIFRA_ARTIKLA`);

--
-- AUTO_INCREMENT zavrženih tabel
--

--
-- AUTO_INCREMENT tabele `DNEVNIK_PRIJAV`
--
ALTER TABLE `DNEVNIK_PRIJAV`
  MODIFY `ID_PRIJAVE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- Omejitve tabel za povzetek stanja
--

--
-- Omejitve za tabelo `ARTIKEL`
--
ALTER TABLE `ARTIKEL`
  ADD CONSTRAINT `FK_SPADA_POD` FOREIGN KEY (`ID_SKUPINE`) REFERENCES `KOMERCIALNA_SKUPINA` (`ID_SKUPINE`);

--
-- Omejitve za tabelo `NAROCILO`
--
ALTER TABLE `NAROCILO`
  ADD CONSTRAINT `FK_RELATIONSHIP_3` FOREIGN KEY (`ID_UPORABNIK`) REFERENCES `UPORABNIK` (`ID_UPORABNIK`);

--
-- Omejitve za tabelo `SLIKA`
--
ALTER TABLE `SLIKA`
  ADD CONSTRAINT `FK_RELATIONSHIP_5` FOREIGN KEY (`SIFRA_ARTIKLA`) REFERENCES `ARTIKEL` (`SIFRA_ARTIKLA`);

--
-- Omejitve za tabelo `VSEBUJE`
--
ALTER TABLE `VSEBUJE`
  ADD CONSTRAINT `FK_RELATIONSHIP_6` FOREIGN KEY (`ID_NAROCILA`) REFERENCES `NAROCILO` (`ID_NAROCILA`),
  ADD CONSTRAINT `FK_RELATIONSHIP_7` FOREIGN KEY (`SIFRA_ARTIKLA`) REFERENCES `ARTIKEL` (`SIFRA_ARTIKLA`);
