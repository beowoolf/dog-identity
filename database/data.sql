INSERT INTO `uzytkownicy` (`ID`, `LOGIN`, `HASLO`) VALUES
(1, 'user1', 'a49666432fda29600e3fb5951e91e4fea4d0a56066befae11ef0b84db20c6217aba1d7a085c9628d278822226b5d6de833557717c04ac7a1b018cc9bf22ec995'),
(2, 'user2', 'b61115d6d132684fe9c4432afff73a15c8f05ce9c01ac7f933e9c782a54c663d3ad8f2f21c5b34a7ca782261e090326d1d3ce582fec43b77fb3e2ddc02340912');

INSERT INTO `oddzial` (`ID`, `NAZWA`, `NUMER`, `TATUAZ`, `ADRES`, `TELEFON`) VALUES
(1, 'Białystok', 'VI', '000A', 'ul.Jurowiecka 33, 15-101 Białystok', '85-675-22-46'),
(2, 'Bielsko-Biała', 'V', 'B000', 'ul.Sobieskiego 132, 43-300 Bielsko-Biała', '33-812-63-89');

INSERT INTO `u_o` (`U_ID`, `O_ID`) VALUES
(1, 2),
(2, 1);

INSERT INTO `hodowca` (`ID`, `IMIE`, `NAZWISKO`, `TELEFON`, `ADRES`) VALUES
(1, 'imie1', 'nazwisko1', '123456', 'adres1'),
(2, NULL, 'nazwisko2', '657476476', 'adres2');

INSERT INTO `hodowla` (`ID`, `NAZWA`, `O_ID`, `H_ID`) VALUES
(1, 'hodowla1', 1, 2),
(2, 'hodowla2', 1, 1);

INSERT INTO `miot` (`ID`, `URODZONY`, `ZNAKOWANY`, `POZYCJA`, `H_ID`) VALUES
(1, '2015-12-03', '2015-12-04', 'lewa strona szyi', 1),
(2, '2015-09-01', '2015-09-20', 'lewa strona szyi', 2);

INSERT INTO `fci` (`ID`, `NAZWA`) VALUES
(101, 'fci1'),
(201, 'fci2'),
(301, 'fci3'),
(401, 'fci4'),
(501, 'fci5');

INSERT INTO `rasa` (`ID`, `NAZWA`, `FCI_ID`) VALUES
(6, 'rasa1', 101),
(7, 'rasa2', 301),
(8, 'rasa3', 501),
(9, 'rasa4', 101),
(10, 'rasa5', 101);

INSERT INTO `pies` (`ID`, `SUKA`, `IMIE`, `OZNACZENIE`, `OJCIEC`, `MATKA`, `M_ID`, `R_ID`) VALUES
(1, 0, 'pies1', '123456789', 'pies ojciec', 'pies matka', 1, 7),
(2, 0, 'pies2', '123454322', 'pies ojciec', 'pies matka', 1, 7),
(3, 1, 'pies3', '423432423', 'ojciec2', 'matka2', 2, 8),
(4, 1, 'pies4', '6546546', 'ojciec2', 'matka2', 2, 8);
