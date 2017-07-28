-- phpMyAdmin SQL Dump
-- version 2.8.0.3
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Samedi 03 Juin 2006 à 18:31
-- Version du serveur: 4.1.19
-- Version de PHP: 5.1.4
--
-- Base de données: `xoops3`
--

--
-- Contenu de la table `xoops_quest_cac`
--

INSERT INTO `xoops_quest_cac` (`IdCAC`, `LibelleCAC`, `LibelleCourtCac`) VALUES (1, 'G1 long', 'G1');
INSERT INTO `xoops_quest_cac` (`IdCAC`, `LibelleCAC`, `LibelleCourtCac`) VALUES (2, 'G2 long', 'G2');
INSERT INTO `xoops_quest_cac` (`IdCAC`, `LibelleCAC`, `LibelleCourtCac`) VALUES (3, 'G3 long', 'G3');
INSERT INTO `xoops_quest_cac` (`IdCAC`, `LibelleCAC`, `LibelleCourtCac`) VALUES (4, 'G4 long', 'G4');
INSERT INTO `xoops_quest_cac` (`IdCAC`, `LibelleCAC`, `LibelleCourtCac`) VALUES (5, 'G5 long', 'G5');
INSERT INTO `xoops_quest_cac` (`IdCAC`, `LibelleCAC`, `LibelleCourtCac`) VALUES (6, 'G6 long', 'G6');
INSERT INTO `xoops_quest_cac` (`IdCAC`, `LibelleCAC`, `LibelleCourtCac`) VALUES (7, 'G7 long', 'G7');
INSERT INTO `xoops_quest_cac` (`IdCAC`, `LibelleCAC`, `LibelleCourtCac`) VALUES (8, 'G8 long', 'G8');
INSERT INTO `xoops_quest_cac` (`IdCAC`, `LibelleCAC`, `LibelleCourtCac`) VALUES (9, 'G9 long', 'G9');
INSERT INTO `xoops_quest_cac` (`IdCAC`, `LibelleCAC`, `LibelleCourtCac`) VALUES (10, 'Not at all', 'N');
INSERT INTO `xoops_quest_cac` (`IdCAC`, `LibelleCAC`, `LibelleCourtCac`) VALUES (11, 'Little', 'L');
INSERT INTO `xoops_quest_cac` (`IdCAC`, `LibelleCAC`, `LibelleCourtCac`) VALUES (12, 'Somewhat', 'SW');
INSERT INTO `xoops_quest_cac` (`IdCAC`, `LibelleCAC`, `LibelleCourtCac`) VALUES (13, 'Much', 'M');
INSERT INTO `xoops_quest_cac` (`IdCAC`, `LibelleCAC`, `LibelleCourtCac`) VALUES (14, 'Great deal', 'GD');
INSERT INTO `xoops_quest_cac` (`IdCAC`, `LibelleCAC`, `LibelleCourtCac`) VALUES (15, 'No information', 'NI');
INSERT INTO `xoops_quest_cac` (`IdCAC`, `LibelleCAC`, `LibelleCourtCac`) VALUES (16, 'D6 long', 'D6');
INSERT INTO `xoops_quest_cac` (`IdCAC`, `LibelleCAC`, `LibelleCourtCac`) VALUES (17, 'D7 long', 'D7');
INSERT INTO `xoops_quest_cac` (`IdCAC`, `LibelleCAC`, `LibelleCourtCac`) VALUES (18, 'D8 long', 'D8');
INSERT INTO `xoops_quest_cac` (`IdCAC`, `LibelleCAC`, `LibelleCourtCac`) VALUES (19, 'D9 long', 'D9');
INSERT INTO `xoops_quest_cac` (`IdCAC`, `LibelleCAC`, `LibelleCourtCac`) VALUES (20, 'D10 long', 'D10');
INSERT INTO `xoops_quest_cac` (`IdCAC`, `LibelleCAC`, `LibelleCourtCac`) VALUES (21, 'Potential problem : Somes issues, laps in behaviou', '1');
INSERT INTO `xoops_quest_cac` (`IdCAC`, `LibelleCAC`, `LibelleCourtCac`) VALUES (22, 'Neutral : Not contibutive positively', '2');
INSERT INTO `xoops_quest_cac` (`IdCAC`, `LibelleCAC`, `LibelleCourtCac`) VALUES (23, 'Acceptable : Strong, good role model', '3');
INSERT INTO `xoops_quest_cac` (`IdCAC`, `LibelleCAC`, `LibelleCourtCac`) VALUES (24, 'Exceptionnal : Truly distinctive, infectious to ot', '4');

--
-- Contenu de la table `xoops_quest_cac_categories`
--

INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (1, 10, 1, 2, 1);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (2, 11, 1, 1, 2);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (3, 12, 1, 1, 3);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (4, 13, 1, 1, 4);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (5, 14, 1, 1, 5);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (6, 15, 1, 1, 6);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (7, 10, 2, 1, 1);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (8, 11, 2, 1, 2);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (9, 12, 2, 1, 3);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (10, 13, 2, 1, 4);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (11, 14, 2, 1, 5);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (12, 15, 2, 1, 6);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (13, 10, 3, 1, 1);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (14, 11, 3, 1, 2);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (15, 12, 3, 1, 3);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (16, 13, 3, 1, 4);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (17, 14, 3, 1, 5);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (18, 15, 3, 1, 6);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (19, 10, 4, 1, 1);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (20, 11, 4, 1, 2);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (21, 12, 4, 1, 3);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (22, 13, 4, 1, 4);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (23, 14, 4, 1, 5);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (24, 15, 4, 1, 6);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (25, 10, 5, 1, 1);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (26, 11, 5, 1, 2);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (27, 12, 5, 1, 3);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (28, 13, 5, 1, 4);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (29, 14, 5, 1, 5);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (30, 15, 5, 1, 6);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (31, 10, 6, 1, 1);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (32, 11, 6, 1, 2);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (33, 12, 6, 1, 3);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (34, 13, 6, 1, 4);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (35, 14, 6, 1, 5);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (36, 15, 6, 1, 6);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (37, 10, 7, 1, 1);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (38, 11, 7, 1, 2);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (39, 12, 7, 1, 3);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (40, 13, 7, 1, 4);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (41, 14, 7, 1, 5);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (42, 15, 7, 1, 6);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (43, 10, 8, 1, 1);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (44, 11, 8, 1, 2);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (45, 12, 8, 1, 3);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (46, 13, 8, 1, 4);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (47, 14, 8, 1, 5);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (48, 15, 8, 1, 6);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (49, 10, 9, 1, 1);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (50, 11, 9, 1, 2);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (51, 12, 9, 1, 3);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (52, 13, 9, 1, 4);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (53, 14, 9, 1, 5);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (54, 15, 9, 1, 6);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (55, 10, 10, 1, 1);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (56, 11, 10, 1, 2);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (57, 12, 10, 1, 3);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (58, 13, 10, 1, 4);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (59, 14, 10, 1, 5);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (60, 15, 10, 1, 6);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (61, 10, 11, 1, 1);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (62, 11, 11, 1, 2);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (63, 12, 11, 1, 3);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (64, 13, 11, 1, 4);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (65, 14, 11, 1, 5);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (66, 15, 11, 1, 6);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (67, 10, 12, 1, 1);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (68, 11, 12, 1, 2);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (69, 12, 12, 1, 3);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (70, 13, 12, 1, 4);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (71, 14, 12, 1, 5);
INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (72, 15, 12, 1, 6);

--
-- Contenu de la table `xoops_quest_categories`
--

INSERT INTO `xoops_quest_categories` (`IdCategorie`, `IdQuestionnaire`, `LibelleCategorie`, `LibelleCompltCategorie`, `OrdreCategorie`, `AfficherDroite`, `AfficherGauche`, `comment1`, `comment2`, `comment3`, `comment1mandatory`, `comment2mandatory`, `comment3mandatory`)
VALUES (1, 1, '1. Client leadership', 'To what extent does this person build Client impact and ...', 1, 1, 0, 'This person is especially helpful in', 'This person could help more by', 'Other comments', 1, 1, 1);
INSERT INTO `xoops_quest_categories` (`IdCategorie`, `IdQuestionnaire`, `LibelleCategorie`, `LibelleCompltCategorie`, `OrdreCategorie`, `AfficherDroite`, `AfficherGauche`, `comment1`, `comment2`, `comment3`, `comment1mandatory`, `comment2mandatory`, `comment3mandatory`)
VALUES (2, 1, '2. Entrepreneurial leadership', 'To what extent does this person', 2, 0, 1, 'This person is especially helpful in', 'This person could help more by', 'Other comments', 1, 1, 1);
INSERT INTO `xoops_quest_categories` (`IdCategorie`, `IdQuestionnaire`, `LibelleCategorie`, `LibelleCompltCategorie`, `OrdreCategorie`, `AfficherDroite`, `AfficherGauche`, `comment1`, `comment2`, `comment3`, `comment1mandatory`, `comment2mandatory`, `comment3mandatory`)
VALUES (3, 1, '3. Problem solving leadership', 'To what extent does this person contribute to problem solving and help the team to ...', 3, 0, 1, 'This person is especially helpful in', 'This person could help more by', 'Other comments', 1, 1, 1);
INSERT INTO `xoops_quest_categories` (`IdCategorie`, `IdQuestionnaire`, `LibelleCategorie`, `LibelleCompltCategorie`, `OrdreCategorie`, `AfficherDroite`, `AfficherGauche`, `comment1`, `comment2`, `comment3`, `comment1mandatory`, `comment2mandatory`, `comment3mandatory`)
VALUES (4, 1, '4. People leadership', 'To what extend does this person ....', 4, 0, 1, 'This person is especially helpful in', 'This person could help more by', 'Other comments', 1, 1, 1);
INSERT INTO `xoops_quest_categories` (`IdCategorie`, `IdQuestionnaire`, `LibelleCategorie`, `LibelleCompltCategorie`, `OrdreCategorie`, `AfficherDroite`, `AfficherGauche`, `comment1`, `comment2`, `comment3`, `comment1mandatory`, `comment2mandatory`, `comment3mandatory`)
VALUES (5, 1, '5. General comment', 'To what extent.....', 7, 0, 1, 'Please describe the three best consulting skills employed by this person', 'Please describe the key consulting skills this person could work on and develop', 'Additional comments :', 1, 1, 1);
INSERT INTO `xoops_quest_categories` (`IdCategorie`, `IdQuestionnaire`, `LibelleCategorie`, `LibelleCompltCategorie`, `OrdreCategorie`, `AfficherDroite`, `AfficherGauche`, `comment1`, `comment2`, `comment3`, `comment1mandatory`, `comment2mandatory`, `comment3mandatory`)
VALUES (6, 2, '1. Client leadership', 'To what extent does this person build Client impact and ...', 1, 0, 1, 'This person is especially helpful in', 'This person could help more by', 'Other comments', 1, 1, 1);
INSERT INTO `xoops_quest_categories` (`IdCategorie`, `IdQuestionnaire`, `LibelleCategorie`, `LibelleCompltCategorie`, `OrdreCategorie`, `AfficherDroite`, `AfficherGauche`, `comment1`, `comment2`, `comment3`, `comment1mandatory`, `comment2mandatory`, `comment3mandatory`)
VALUES (7, 2, '2. Entrepreneurial leadership', 'To what extent does this person', 2, 0, 1, 'This person is especially helpful in', 'This person could help more by', 'Other comments', 1, 1, 1);
INSERT INTO `xoops_quest_categories` (`IdCategorie`, `IdQuestionnaire`, `LibelleCategorie`, `LibelleCompltCategorie`, `OrdreCategorie`, `AfficherDroite`, `AfficherGauche`, `comment1`, `comment2`, `comment3`, `comment1mandatory`, `comment2mandatory`, `comment3mandatory`)
VALUES (8, 2, '3. Problem solving leadership', 'To what extent does this person contribute to problem solving and help the team to ...', 3, 0, 1, 'This person is especially helpful in', 'This person could help more by', 'Other comments', 1, 1, 1);
INSERT INTO `xoops_quest_categories` (`IdCategorie`, `IdQuestionnaire`, `LibelleCategorie`, `LibelleCompltCategorie`, `OrdreCategorie`, `AfficherDroite`, `AfficherGauche`, `comment1`, `comment2`, `comment3`, `comment1mandatory`, `comment2mandatory`, `comment3mandatory`)
VALUES (9, 2, '4. People leadership', 'To what extend does this person ....', 4, 0, 1, 'This person is especially helpful in', 'This person could help more by', 'Other comments', 1, 1, 1);
INSERT INTO `xoops_quest_categories` (`IdCategorie`, `IdQuestionnaire`, `LibelleCategorie`, `LibelleCompltCategorie`, `OrdreCategorie`, `AfficherDroite`, `AfficherGauche`, `comment1`, `comment2`, `comment3`, `comment1mandatory`, `comment2mandatory`, `comment3mandatory`)
VALUES (10, 2, '5. Study management', 'To what extent does this person.....', 5, 0, 1, 'This person is especially helpful in', 'This person could help more by', 'Other comments', 1, 1, 1);
INSERT INTO `xoops_quest_categories` (`IdCategorie`, `IdQuestionnaire`, `LibelleCategorie`, `LibelleCompltCategorie`, `OrdreCategorie`, `AfficherDroite`, `AfficherGauche`, `comment1`, `comment2`, `comment3`, `comment1mandatory`, `comment2mandatory`, `comment3mandatory`)
VALUES (11, 2, '6. Personal impact', 'To what does this person....', 6, 0, 1, 'comments', '', '', 1, 1, 1);
INSERT INTO `xoops_quest_categories` (`IdCategorie`, `IdQuestionnaire`, `LibelleCategorie`, `LibelleCompltCategorie`, `OrdreCategorie`, `AfficherDroite`, `AfficherGauche`, `comment1`, `comment2`, `comment3`, `comment1mandatory`, `comment2mandatory`, `comment3mandatory`)
VALUES (12, 2, '7. General comment', 'To what extent.....', 7, 0, 1, 'Please describe the three best consulting skills employed by this person :', 'Please describe the key consulting skills this person could work on and develop :', 'Additional comments :', 1, 1, 1);

--
-- Contenu de la table `xoops_quest_enquetes`
--

INSERT INTO `xoops_quest_enquetes` (`IdEnquete`, `NomEnquete`, `PrenomEnquete`, `TypeEnquete`, `login`, `password`) VALUES (1, 'Blanc Mont', '(Asc)', 1, 'hthouzard', '4efc486b1380fbfcfafa7930f64e1d83');
INSERT INTO `xoops_quest_enquetes` (`IdEnquete`, `NomEnquete`, `PrenomEnquete`, `TypeEnquete`, `login`, `password`) VALUES (2, 'Grasshopper', 'Zurich', 1, 'hthouzard', '4efc486b1380fbfcfafa7930f64e1d83');

--
-- Contenu de la table `xoops_quest_questionnaires`
--

INSERT INTO `xoops_quest_questionnaires` (`IdQuestionnaire`, `LibelleQuestionnaire`, `IdEnquete`, `DateOuverture`, `DateFermeture`, `NbSessions`, `Etat`, `ltor`, `SujetRelance`, `CorpsRelance`, `SujetOuverture`, `CorpsOuverture`, `FrequenceRelances`, `DerniereRelance`, `ReplyTo`, `Groupe`) VALUES
  (1, 'Les conséquences du Nutella sur la créativité', 1, 1146921837, 1179183661, 1, 1, 0, 'Vous n''avez pas répondu',
      'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.\r\n\r\n',
      'L''analyse nutritionnelle de Nutella réserve bien des surprises ! ...',
   'Il fut longtemps difficile de croire que le délicieux mélange de beurre de cacao, de sucre et de lait, qui fond dans la bouche et stimule tellement nos sens, puisse également nous être bénéfique.\r\nEt pourtant, de récentes recherches démontrent que, contrairement à l’opinion trop longtemps répandue selon laquelle tout ce qui a bon goût doit forcément être mauvais pour la santé, le chocolat est un cocktail de substances potentiellement protectrices pour l’organisme.\r\nLes scientifiques ont, par exemple, démontré le rôle positif des nombreux antioxydants présents dans le cacao.\r\nCeux-ci contribuent à protéger contre l’oxydation du cholestérol\r\nOn a décelé un groupe de “polyphénols” (antioxydants) dans le chocolat noir comme dans le chocolat au lait.\r\nIl apparaît qu’ils joueraient un rôle dans la prévention des maladies cardio-vasculaires, amélioreraient le système immunitaire, voire participeraient à la diminution des risques de certaines maladies. Affaire à suivre.',
   5, 1146921837, 'herve@herve-thouzard.com', 1);
INSERT INTO `xoops_quest_questionnaires` (`IdQuestionnaire`, `LibelleQuestionnaire`, `IdEnquete`, `DateOuverture`, `DateFermeture`, `NbSessions`, `Etat`, `ltor`, `SujetRelance`, `CorpsRelance`, `SujetOuverture`, `CorpsOuverture`, `FrequenceRelances`, `DerniereRelance`, `ReplyTo`, `Groupe`)
VALUES (2, 'Ils font du chocolat en Suisse', 2, 1149072469, 1179183661, 3, 0, 0, 'sujet relance questionnaire', 'Merci de bien vouloir répondre dans les délais au questionnaire .......', 'Est-il meilleur qu''en France', 'Il semblerait que ......lorem ipsum et consorts', 0, 0, '', 2);

--
-- Contenu de la table `xoops_quest_questions`
--

INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (1, 1, 1, 'Strive to bring maximum value to the Client', 1, 'Show deep personal commitment to achieving Client impact');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (2, 1, 1, 'Challenge the Client''s views on critical issues', 2, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (3, 1, 1, 'Be objective and candid with the Client', 3, ' be willing to deliver bad news if necessary');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (4, 1, 1, 'Build relationships with key members of the Client management', 4, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (5, 1, 1, 'Gain the Client''s confidence and establish the Firm''s credibility', 5, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (6, 1, 1, 'Achieve broad buy-in from the Client organization to ensure implementation', 6, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (7, 1, 2, 'Discover or create opportunities before others are aware of them', 7, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (8, 1, 2, 'Act decisively when faced with opportunity or challenge and be quick to take the initiative', 8, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (9, 1, 3, 'Quickly identify and monitor core issues and maintain focus on important issues throughout the study', 9, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (10, 1, 3, 'Structure and disaggregate problems in an effective way', 10, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (11, 1, 3, 'Develop outstanding insights and frameworks to address core issues', 11, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (12, 1, 3, 'Reach out for the best Firm know-how and bring it to bear at the Client', 12, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (13, 1, 3, 'Develop and communicate actionable recommendations by balancing conceptual skills with good judgement on real-world constraints', 13, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (14, 1, 3, 'Promote a climate of continuous learning - seek to learn, not to blame when mistakes or failures occur', 14, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (15, 1, 3, 'Effectively resolve conflicts', 15, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (16, 1, 4, 'Show respect for each individual''s intellectual contribution', 16, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (17, 1, 4, 'Build your confidence and encourage people in taking initiatives/risks', 17, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (18, 1, 4, 'Give immediate and specific feedback when possible', 18, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (19, 1, 4, 'Commit sufficient time to help team members achieve their objectives', 19, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (20, 1, 4, 'Disclose his/her personal views and feelings', 20, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (21, 1, 4, 'Demonstrate excellent listening skills', 21, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (22, 1, 4, 'Admit mistakes and react constructively', 22, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (23, 1, 5, 'Were you impressed by the consulting skills of this person', 23, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (24, 1, 5, 'Would you like to work with this person again', 24, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (25, 1, 5, 'Do you consider this person a role model for yourself', 25, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (26, 1, 6, 'Does this person radiate a sense of fun and excitement', 26, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (27, 2, 1, 'Strive to bring maximum value to the Client (Show deep personal commitment to achieving Client impact)', 1, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (28, 2, 1, 'Challenge the Client''s views on critical issues', 2, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (29, 2, 1, 'Manage realistic Client expectations of the study', 3, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (30, 2, 1, 'Be objective and candid with the Client - be willing to deliver bad news if necessary', 4, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (31, 2, 1, 'Build relationships with key members of the Client management', 5, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (32, 2, 1, 'Alert the Client to important issues outside the study scope', 6, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (33, 2, 1, 'Gain the Client''s confidence and establish the Firm''s credibility', 7, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (34, 2, 1, 'Achieve broad buy-in from the Client organization to ensure implementation', 8, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (35, 2, 2, 'Discover or create opportunities before others are aware of them', 9, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (36, 2, 2, 'Act decisively when faced with opportunity or challenge and be quick to take the initiative', 10, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (37, 2, 3, 'Quickly identify and monitor core issues and maintain focus on important issues throughout the study', 12, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (38, 2, 3, 'Structure and disaggregate problems in an effective way', 13, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (39, 2, 3, 'Develop outstanding insights and frameworks to address core issues', 14, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (40, 2, 3, 'Reach out for the best Firm know-how and bring it to bear at the Client', 15, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (41, 2, 3, 'Develop and communicate actionable recommendations by balancing conceptual skills with good judgement on real-world constraints', 16, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (42, 2, 4, 'Promote a climate of continuous learning - seek to learn, not to blame when mistakes or failures occur', 17, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (43, 2, 4, 'Effectively resolve conflicts', 18, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (44, 2, 4, 'Show respect for each individual''s intellectual contribution', 19, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (45, 2, 4, 'Build your confidence and encourage people in taking initiatives/risks', 20, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (46, 2, 4, 'Give immediate and specific feedback when possible', 21, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (47, 2, 4, 'Commit sufficient time to help team members achieve their objectives', 22, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (48, 2, 4, 'Disclose his/her personal views and feelings', 23, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (49, 2, 4, 'Show sensitivity to the balance between the study and people''s private life', 24, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (50, 2, 4, 'Demonstrate excellent listening skills', 25, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (51, 2, 4, 'Admit mistakes and react constructively', 26, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (52, 2, 5, 'Ensure study objectives are clearly understood', 27, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (53, 2, 5, 'Ensure each team member is clear about his/her role and responsibility', 28, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (54, 2, 5, 'Quickly establish effective working practices (structured team meetings, interview guides, etc.)', 29, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (55, 2, 5, 'Discuss and help clarify the Client''s problems for the team early in the project', 30, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (56, 2, 5, 'Manage MGMs effectively', 31, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (57, 2, 5, 'Ensure that team meetings are held with appropriate frequency', 32, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (58, 2, 5, 'Set realistic deadlines', 33, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (59, 2, 5, 'Avoid unnecessary work', 34, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (60, 2, 5, 'Effectively leverage Firm resources', 35, '');
INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (61, 2, 5, 'Effectively manage Client team members', 36, '');
