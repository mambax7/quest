-- phpMyAdmin SQL Dump
-- version 2.8.2
-- http://www.phpmyadmin.net
-- 
-- Serveur: localhost
-- Généré le : Samedi 22 Juillet 2006 à 10:39
-- Version du serveur: 4.1.20
-- Version de PHP: 4.4.2
-- 
-- Base de données: `netconceptorg11`
-- 

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_quest_cac`
-- 

CREATE TABLE `xoops_quest_cac` (
  `IdCAC`           INT(8)      NOT NULL AUTO_INCREMENT,
  `LibelleCAC`      VARCHAR(50) NOT NULL DEFAULT ''
  COMMENT 'Libellé long pour faire la légende',
  `LibelleCourtCac` CHAR(3)     NOT NULL DEFAULT ''
  COMMENT 'Libellé court qui apparait avec la question',
  PRIMARY KEY (`IdCAC`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = latin1
  COMMENT ='Contient la liste de toutes les CAC'
  AUTO_INCREMENT = 47;

-- 
-- Contenu de la table `xoops_quest_cac`
-- 

INSERT INTO `xoops_quest_cac` (`IdCAC`, `LibelleCAC`, `LibelleCourtCac`) VALUES (1, 'G1 long', 'G1'),
  (2, 'G2 long', 'G2'),
  (3, 'G3 long', 'G3'),
  (4, 'G4 long', 'G4'),
  (5, 'G5 long', 'G5'),
  (6, 'G6 long', 'G6'),
  (7, 'G7 long', 'G7'),
  (8, 'G8 long', 'G8'),
  (9, 'G9 long', 'G9'),
  (10, 'Not at all', 'N'),
  (11, 'Little', 'L'),
  (12, 'Somewhat', 'SW'),
  (13, 'Much', 'M'),
  (14, 'Great deal', 'GD'),
  (15, 'No information', 'NI'),
  (16, 'D6 long', 'D6'),
  (17, 'D7 long', 'D7'),
  (18, 'D8 long', 'D8'),
  (19, 'D9 long', 'D9'),
  (20, 'D10 long', 'D10'),
  (21, 'Potential problem : Somes issues, laps in behaviou', '1'),
  (22, 'Neutral : Not contibutive positively', '2'),
  (23, 'Acceptable : Strong, good role model', '3'),
  (24, 'Exceptionnal : Truly distinctive, infectious to ot', '4'),
  (25, 'Très souvent', 'TS'),
  (26, 'Souvent', 'S'),
  (27, 'Parfois', 'P'),
  (28, 'Jamais', 'J'),
  (29, 'Déjà faite', 'DF'),
  (30, 'Prévue', 'P'),
  (31, 'Pas prévue', 'PP'),
  (32, 'Je ne sais pas', 'NSP'),
  (33, 'Excellent', 'E'),
  (34, 'Bon', 'B'),
  (35, 'Moyen', 'M'),
  (36, 'Satisfaisant', 'S'),
  (37, '1 (note la plus basse)', '1'),
  (38, '2', '2'),
  (39, '3', '3'),
  (40, '4', '4'),
  (41, '5', '5'),
  (42, '6', '6'),
  (43, '7', '7'),
  (44, '8', '8'),
  (45, '9', '9'),
  (46, '10 (note la plus forte)', '10');

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_quest_cac_categories`
-- 

CREATE TABLE `xoops_quest_cac_categories` (
  `IdCac_categories` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `IdCAC`            INT(10) UNSIGNED NOT NULL DEFAULT '0',
  `IdCategorie`      INT(10) UNSIGNED NOT NULL DEFAULT '0',
  `DroiteGauche`     SMALLINT(2)      NOT NULL DEFAULT '0'
  COMMENT '1 = droite, 2=gauche',
  `Ordre`            INT(10) UNSIGNED NOT NULL DEFAULT '0'
  COMMENT 'de 1 à n',
  PRIMARY KEY (`IdCac_categories`),
  KEY `IdCategorie` (`IdCategorie`),
  KEY `Ordre` (`Ordre`),
  KEY `DroiteGauche` (`DroiteGauche`),
  KEY `DroiteGaucheOrdre` (`DroiteGauche`, `Ordre`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = latin1
  COMMENT ='Stocke les CAC par catégorie'
  AUTO_INCREMENT = 129;

-- 
-- Contenu de la table `xoops_quest_cac_categories`
-- 

INSERT INTO `xoops_quest_cac_categories` (`IdCac_categories`, `IdCAC`, `IdCategorie`, `DroiteGauche`, `Ordre`) VALUES (1, 10, 1, 1, 1),
  (2, 11, 1, 1, 2),
  (3, 12, 1, 1, 3),
  (4, 13, 1, 1, 4),
  (5, 14, 1, 1, 5),
  (6, 15, 1, 1, 6),
  (7, 10, 2, 1, 1),
  (8, 11, 2, 1, 2),
  (9, 12, 2, 1, 3),
  (10, 13, 2, 1, 4),
  (11, 14, 2, 1, 5),
  (12, 15, 2, 1, 6),
  (13, 10, 3, 1, 1),
  (14, 11, 3, 1, 2),
  (15, 12, 3, 1, 3),
  (16, 13, 3, 1, 4),
  (17, 14, 3, 1, 5),
  (18, 15, 3, 1, 6),
  (19, 10, 4, 1, 1),
  (20, 11, 4, 1, 2),
  (21, 12, 4, 1, 3),
  (22, 13, 4, 1, 4),
  (23, 14, 4, 1, 5),
  (24, 15, 4, 1, 6),
  (25, 10, 5, 1, 1),
  (26, 11, 5, 1, 2),
  (27, 12, 5, 1, 3),
  (28, 13, 5, 1, 4),
  (29, 14, 5, 1, 5),
  (30, 15, 5, 1, 6),
  (31, 10, 6, 1, 1),
  (32, 11, 6, 1, 2),
  (33, 12, 6, 1, 3),
  (34, 13, 6, 1, 4),
  (35, 14, 6, 1, 5),
  (36, 15, 6, 1, 6),
  (37, 10, 7, 1, 1),
  (38, 11, 7, 1, 2),
  (39, 12, 7, 1, 3),
  (40, 13, 7, 1, 4),
  (41, 14, 7, 1, 5),
  (42, 15, 7, 1, 6),
  (43, 10, 8, 1, 1),
  (44, 11, 8, 1, 2),
  (45, 12, 8, 1, 3),
  (46, 13, 8, 1, 4),
  (47, 14, 8, 1, 5),
  (48, 15, 8, 1, 6),
  (49, 10, 9, 1, 1),
  (50, 11, 9, 1, 2),
  (51, 12, 9, 1, 3),
  (52, 13, 9, 1, 4),
  (53, 14, 9, 1, 5),
  (54, 15, 9, 1, 6),
  (55, 10, 10, 1, 1),
  (56, 11, 10, 1, 2),
  (57, 12, 10, 1, 3),
  (58, 13, 10, 1, 4),
  (59, 14, 10, 1, 5),
  (60, 15, 10, 1, 6),
  (61, 10, 11, 1, 1),
  (62, 11, 11, 1, 2),
  (63, 12, 11, 1, 3),
  (64, 13, 11, 1, 4),
  (65, 14, 11, 1, 5),
  (66, 15, 11, 1, 6),
  (67, 10, 12, 1, 1),
  (68, 11, 12, 1, 2),
  (69, 12, 12, 1, 3),
  (70, 13, 12, 1, 4),
  (71, 14, 12, 1, 5),
  (72, 15, 12, 1, 6),
  (73, 21, 6, 2, 1),
  (74, 22, 6, 2, 2),
  (75, 23, 6, 2, 3),
  (76, 24, 6, 2, 4),
  (77, 21, 7, 2, 1),
  (78, 22, 7, 2, 2),
  (79, 23, 7, 2, 3),
  (80, 24, 7, 2, 4),
  (81, 21, 8, 2, 1),
  (82, 22, 8, 2, 2),
  (83, 23, 8, 2, 3),
  (84, 24, 8, 2, 4),
  (85, 21, 9, 2, 1),
  (86, 22, 9, 2, 2),
  (87, 23, 9, 2, 3),
  (88, 24, 9, 2, 4),
  (89, 21, 10, 2, 1),
  (90, 22, 10, 2, 2),
  (91, 23, 10, 2, 3),
  (92, 24, 10, 2, 4),
  (93, 21, 11, 2, 1),
  (94, 22, 11, 2, 2),
  (95, 23, 11, 2, 3),
  (96, 24, 11, 2, 4),
  (97, 21, 12, 2, 1),
  (98, 22, 12, 2, 2),
  (99, 23, 12, 2, 3),
  (100, 24, 12, 2, 4),
  (101, 25, 13, 1, 1),
  (102, 26, 13, 1, 2),
  (103, 27, 13, 1, 3),
  (104, 28, 13, 1, 4),
  (105, 21, 14, 2, 1),
  (106, 22, 14, 2, 2),
  (107, 23, 14, 2, 3),
  (108, 24, 14, 2, 4),
  (109, 10, 14, 1, 5),
  (110, 11, 14, 1, 6),
  (111, 12, 14, 1, 7),
  (112, 13, 14, 1, 8),
  (113, 14, 14, 1, 9),
  (114, 15, 14, 1, 10),
  (115, 29, 15, 1, 11),
  (116, 30, 15, 1, 12),
  (117, 31, 15, 1, 13),
  (118, 32, 15, 1, 14),
  (119, 37, 16, 1, 1),
  (120, 38, 16, 1, 2),
  (121, 39, 16, 1, 3),
  (122, 40, 16, 1, 4),
  (123, 41, 16, 1, 5),
  (124, 42, 16, 1, 6),
  (125, 43, 16, 1, 7),
  (126, 44, 16, 1, 8),
  (127, 45, 16, 1, 9),
  (128, 46, 16, 1, 10);

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_quest_categories`
-- 

CREATE TABLE `xoops_quest_categories` (
  `IdCategorie`            INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `IdQuestionnaire`        INT(8) UNSIGNED NOT NULL DEFAULT '0',
  `LibelleCategorie`       VARCHAR(255)             DEFAULT NULL
  COMMENT 'Libellé court destiné à apparaître dans les blocs',
  `LibelleCompltCategorie` VARCHAR(255)             DEFAULT NULL
  COMMENT 'Sorte de sous titre',
  `OrdreCategorie`         INT(10) UNSIGNED         DEFAULT '0'
  COMMENT 'De 1 à n',
  `AfficherDroite`         TINYINT(2)      NOT NULL DEFAULT '1'
  COMMENT 'Booleen, 0=non , 1=oui',
  `AfficherGauche`         TINYINT(2)      NOT NULL DEFAULT '1'
  COMMENT 'Booleen, 0=non , 1=oui',
  `comment1`               VARCHAR(255)    NOT NULL DEFAULT ''
  COMMENT 'Libellé de la zone, si vide alors pas de zone de saisie',
  `comment2`               VARCHAR(255)    NOT NULL DEFAULT ''
  COMMENT 'Libellé de la zone, si vide alors pas de zone de saisie',
  `comment3`               VARCHAR(255)    NOT NULL DEFAULT ''
  COMMENT 'Libellé de la zone, si vide alors pas de zone de saisie',
  `comment1mandatory`      TINYINT(1)      NOT NULL DEFAULT '1'
  COMMENT 'Indique si la saisie du commentaire est obligatoire',
  `comment2mandatory`      TINYINT(1)      NOT NULL DEFAULT '1'
  COMMENT 'Indique si la saisie du commentaire est obligatoire',
  `comment3mandatory`      TINYINT(1)      NOT NULL DEFAULT '1'
  COMMENT 'Indique si la saisie du commentaire est obligatoire',
  PRIMARY KEY (`IdCategorie`),
  KEY `IdQuestionnaire` (`IdQuestionnaire`),
  KEY `OrdreCategorie` (`OrdreCategorie`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = latin1
  COMMENT ='Liste de toutes les catégories'
  AUTO_INCREMENT = 17;

-- 
-- Contenu de la table `xoops_quest_categories`
-- 

INSERT INTO `xoops_quest_categories` (`IdCategorie`, `IdQuestionnaire`, `LibelleCategorie`, `LibelleCompltCategorie`, `OrdreCategorie`, `AfficherDroite`, `AfficherGauche`, `comment1`, `comment2`, `comment3`, `comment1mandatory`, `comment2mandatory`, `comment3mandatory`)
VALUES (1, 1, '1. Client leadership', 'To what extent does this person build Client impact and ...', 1, 1, 0, 'This person is especially helpful in', 'This person could help more by', 'Other comments', 1, 1, 1),
  (2, 1, '2. Entrepreneurial leadership', 'To what extent does this person', 2, 1, 0, 'This person is especially helpful in', 'This person could help more by', 'Other comments', 1, 1, 1),
  (3, 1, '3. Problem solving leadership', 'To what extent does this person contribute to problem solving and help the team to ...', 3, 1, 0, 'This person is especially helpful in', 'This person could help more by', 'Other comments', 1, 1, 1),
  (4, 1, '4. People leadership', 'To what extend does this person ....', 4, 1, 0, 'This person is especially helpful in', 'This person could help more by', 'Other comments', 1, 1, 1),
  (5, 1, '5. General comment', 'To what extent.....', 7, 1, 0, 'Please describe the three best consulting skills employed by this person', 'Please describe the key consulting skills this person could work on and develop', 'Additional comments :', 1, 1, 1),
  (6, 2, '1. Client leadership', 'To what extent does this person build Client impact and ...', 1, 1, 1, 'This person is especially helpful in', 'This person could help more by', 'Other comments', 1, 1, 1),
  (7, 2, '2. Entrepreneurial leadership', 'To what extent does this person', 2, 1, 1, 'This person is especially helpful in', 'This person could help more by', 'Other comments', 1, 1, 1),
  (8, 2, '3. Problem solving leadership', 'To what extent does this person contribute to problem solving and help the team to ...', 3, 1, 1, 'This person is especially helpful in', 'This person could help more by', 'Other comments', 1, 1, 1),
  (9, 2, '4. People leadership', 'To what extend does this person ....', 4, 1, 1, 'This person is especially helpful in', 'This person could help more by', 'Other comments', 1, 1, 1),
  (10, 2, '5. Study management', 'To what extent does this person.....', 5, 1, 1, 'This person is especially helpful in', 'This person could help more by', 'Other comments', 1, 1, 1),
  (11, 2, '6. Personal impact', 'To what does this person....', 6, 1, 1, 'comments', '', '', 1, 1, 1),
  (12, 2, '7. General comment', 'To what extent.....', 7, 1, 1, 'Please describe the three best consulting skills employed by this person :', 'Please describe the key consulting skills this person could work on and develop :', 'Additional comments :', 1, 1, 1),
  (13, 3, '1. Assiduité aux activités', 'Au cours de la présente année universitaire dans votre établissement, combien de fois environ avez-vous pratiqué les activités ou vécu les situations suivantes?', 1, 1, 0, 'Commentaire libre', '', '', 1, 1, 1),
  (14, 3, '2. Appronfondissement du savoir', 'Dans quelle mesure vos études dans cet établissement ont-elles contribué à l''approfondissement de votre savoir', 2, 1, 1, '', '', '', 1, 1, 1),
  (15, 3, '3. Projets à court terme', 'Parmi les activités suivantes, lesquelles avez-vous faites ou comptez-vous faire d''ici l''obtention de votre diplôme ?', 3, 1, 1, 'Commentaire libre :', '', '', 1, 1, 1),
  (16, 3, '4. Site internet', 'Quelles améliorations...', 4, 1, 1, '', '', 'Additional comments :', 1, 1, 1);

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_quest_enquetes`
-- 

CREATE TABLE `xoops_quest_enquetes` (
  `IdEnquete`     INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `NomEnquete`    VARCHAR(150)             DEFAULT NULL,
  `PrenomEnquete` VARCHAR(150)             DEFAULT NULL,
  `TypeEnquete`   TINYINT(1) UNSIGNED      DEFAULT NULL
  COMMENT 'Provient de la première version, quelle utilité ?',
  `login`         VARCHAR(255)    NOT NULL DEFAULT ''
  COMMENT 'prévu au cas où',
  `password`      VARCHAR(40)     NOT NULL DEFAULT ''
  COMMENT 'format md5',
  PRIMARY KEY (`IdEnquete`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = latin1
  COMMENT ='Liste des enquêtes'
  AUTO_INCREMENT = 4;

-- 
-- Contenu de la table `xoops_quest_enquetes`
-- 

INSERT INTO `xoops_quest_enquetes` (`IdEnquete`, `NomEnquete`, `PrenomEnquete`, `TypeEnquete`, `login`, `password`) VALUES (1, 'Blanc Mont', '(Asc)', 1, 'hthouzard', '4efc486b1380fbfcfafa7930f64e1d83'),
  (2, 'Grasshopper', 'Zurich', 1, 'hthouzard', '4efc486b1380fbfcfafa7930f64e1d83'),
  (3, 'Participation', 'étudiante', 1, '', '');

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_quest_questionnaires`
-- 

CREATE TABLE `xoops_quest_questionnaires` (
  `IdQuestionnaire`      INT(8) UNSIGNED       NOT NULL AUTO_INCREMENT,
  `LibelleQuestionnaire` VARCHAR(255)          NOT NULL DEFAULT '',
  `IdEnquete`            MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  `DateOuverture`        INT(10)                        DEFAULT NULL,
  `DateFermeture`        INT(10)                        DEFAULT NULL,
  `NbSessions`           INT(8)                         DEFAULT '0'
  COMMENT 'Provient de la première version, Quelle utilité ?',
  `Etat`                 TINYINT(1)                     DEFAULT '0'
  COMMENT '0=actif, 1=suspendu',
  `ltor`                 TINYINT(2)            NOT NULL DEFAULT '0'
  COMMENT 'Pour les langues arabes 0=faux, 1=vrai',
  `SujetRelance`         VARCHAR(255)          NOT NULL DEFAULT ''
  COMMENT 'Pour les mails',
  `CorpsRelance`         TEXT                  NOT NULL
  COMMENT 'Pour les mails',
  `SujetOuverture`       VARCHAR(255)          NOT NULL DEFAULT ''
  COMMENT 'Pour les mails',
  `CorpsOuverture`       TEXT                  NOT NULL
  COMMENT 'Pour les mails',
  `FrequenceRelances`    INT(11)               NOT NULL DEFAULT '0'
  COMMENT 'fréquence en jours',
  `DerniereRelance`      INT(10) UNSIGNED      NOT NULL DEFAULT '0'
  COMMENT 'format timestamp',
  `ReplyTo`              VARCHAR(255)          NOT NULL DEFAULT ''
  COMMENT 'Adresse mail devant recevoir d''éventuelles réponses',
  `Groupe`               INT(10) UNSIGNED      NOT NULL DEFAULT '0'
  COMMENT 'Groupe Xoops devant répondre au questionnaire',
  `PartnerGroup`         INT(10) UNSIGNED      NOT NULL DEFAULT '1'
  COMMENT 'Groupe auquel appartient le commanditaire du questionnaire',
  `RelancesOption`       INT(11)               NOT NULL DEFAULT '1'
  COMMENT 'Permet de savoir qui on doit relancer, 1=Tout le monde (pas répondu ou partiellement répondu), 2=uniquement ceux qui n''ont pas du tout répondu',
  `EmailFrom`            VARCHAR(255)          NOT NULL DEFAULT ''
  COMMENT 'Adresse email de l''expéditeur',
  `EmailFromName`        VARCHAR(255)          NOT NULL DEFAULT ''
  COMMENT 'Nom de l''expéditeur',
  PRIMARY KEY (`IdQuestionnaire`),
  KEY `IdEnquete` (`IdEnquete`),
  KEY `PartnerGroup` (`PartnerGroup`),
  KEY `Groupe` (`Groupe`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = latin1
  COMMENT ='Liste des tous les questionnaires d''un client'
  AUTO_INCREMENT = 4;

-- 
-- Contenu de la table `xoops_quest_questionnaires`
-- 

INSERT INTO `xoops_quest_questionnaires` (`IdQuestionnaire`, `LibelleQuestionnaire`, `IdEnquete`, `DateOuverture`, `DateFermeture`, `NbSessions`, `Etat`, `ltor`, `SujetRelance`, `CorpsRelance`, `SujetOuverture`, `CorpsOuverture`, `FrequenceRelances`, `DerniereRelance`, `ReplyTo`, `Groupe`, `PartnerGroup`, `RelancesOption`, `EmailFrom`, `EmailFromName`)
VALUES (1, 'Mont Blanc (ASC)', 1, 1146921837, 1179183661, 1, 1, 0, 'Vous n''avez pas répondu',
           'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.\r\n\r\n',
           'L''analyse nutritionnelle de Nutella réserve bien des surprises ! ...',
        'Il fut longtemps difficile de croire que le délicieux mélange de beurre de cacao, de sucre et de lait, qui fond dans la bouche et stimule tellement nos sens, puisse également nous être bénéfique.\r\nEt pourtant, de récentes recherches démontrent que, contrairement à l’opinion trop longtemps répandue selon laquelle tout ce qui a bon goût doit forcément être mauvais pour la santé, le chocolat est un cocktail de substances potentiellement protectrices pour l’organisme.\r\nLes scientifiques ont, par exemple, démontré le rôle positif des nombreux antioxydants présents dans le cacao.\r\nCeux-ci contribuent à protéger contre l’oxydation du cholestérol\r\nOn a décelé un groupe de “polyphénols” (antioxydants) dans le chocolat noir comme dans le chocolat au lait.\r\nIl apparaît qu’ils joueraient un rôle dans la prévention des maladies cardio-vasculaires, amélioreraient le système immunitaire, voire participeraient à la diminution des risques de certaines maladies. Affaire à suivre.',
        5, 1146921837, 'herve@herve-thouzard.com', 4, 5, 1, '', ''),
  (2, 'Grasshopper Zurich', 2, 1149072469, 1179183661, 3, 1, 0, 'sujet relance questionnaire', 'Merci de bien vouloir répondre dans les délais au questionnaire .......', 'Est-il meilleur qu''en France', 'Il semblerait que ......lorem ipsum et consorts', 0, 0, '', 4, 5, 1, '', ''),
  (3, 'Participation étudiante', 3, 1149072469, 1179183661, 3, 1, 0, 'sujet relance questionnaire', 'Merci de bien vouloir répondre dans les délais au questionnaire .......', 'Est-il meilleur qu''en France', 'Il semblerait que ......lorem ipsum et consorts', 0, 0, '', 6, 7, 1, '', '');

-- --------------------------------------------------------

-- 
-- Structure de la table `xoops_quest_questions`
-- 

CREATE TABLE `xoops_quest_questions` (
  `IdQuestion`         INT(8) UNSIGNED  NOT NULL AUTO_INCREMENT,
  `IdQuestionnaire`    INT(10) UNSIGNED NOT NULL DEFAULT '0',
  `IdCategorie`        INT(8) UNSIGNED  NOT NULL DEFAULT '0',
  `TexteQuestion`      VARCHAR(255)              DEFAULT NULL,
  `OrdreQuestion`      TINYINT(2) UNSIGNED       DEFAULT NULL
  COMMENT 'de 1 à n',
  `ComplementQuestion` TEXT             NOT NULL,
  PRIMARY KEY (`IdQuestion`),
  KEY `IdCategorie` (`IdCategorie`),
  KEY `OrdreQuestion` (`OrdreQuestion`),
  KEY `IdQuestionnaire` (`IdQuestionnaire`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = latin1
  COMMENT ='Liste de toutes les questions par catégorie'
  AUTO_INCREMENT = 104;

-- 
-- Contenu de la table `xoops_quest_questions`
-- 

INSERT INTO `xoops_quest_questions` (`IdQuestion`, `IdQuestionnaire`, `IdCategorie`, `TexteQuestion`, `OrdreQuestion`, `ComplementQuestion`) VALUES (1, 1, 1, 'Strive to bring maximum value to the Client', 1, 'Show deep personal commitment to achieving Client impact'),
  (2, 1, 1, 'Challenge the Client''s views on critical issues', 2, ''),
  (3, 1, 1, 'Be objective and candid with the Client', 3, ' be willing to deliver bad news if necessary'),
  (4, 1, 1, 'Build relationships with key members of the Client management', 4, ''),
  (5, 1, 1, 'Gain the Client''s confidence and establish the Firm''s credibility', 5, ''),
  (6, 1, 1, 'Achieve broad buy-in from the Client organization to ensure implementation', 6, ''),
  (7, 1, 2, 'Discover or create opportunities before others are aware of them', 7, ''),
  (8, 1, 2, 'Act decisively when faced with opportunity or challenge and be quick to take the initiative', 8, ''),
  (9, 1, 3, 'Quickly identify and monitor core issues and maintain focus on important issues throughout the study', 9, ''),
  (10, 1, 3, 'Structure and disaggregate problems in an effective way', 10, ''),
  (11, 1, 3, 'Develop outstanding insights and frameworks to address core issues', 11, ''),
  (12, 1, 3, 'Reach out for the best Firm know-how and bring it to bear at the Client', 12, ''),
  (13, 1, 3, 'Develop and communicate actionable recommendations by balancing conceptual skills with good judgement on real-world constraints', 13, ''),
  (14, 1, 3, 'Promote a climate of continuous learning - seek to learn, not to blame when mistakes or failures occur', 14, ''),
  (15, 1, 3, 'Effectively resolve conflicts', 15, ''),
  (16, 1, 4, 'Show respect for each individual''s intellectual contribution', 16, ''),
  (17, 1, 4, 'Build your confidence and encourage people in taking initiatives/risks', 17, ''),
  (18, 1, 4, 'Give immediate and specific feedback when possible', 18, ''),
  (19, 1, 4, 'Commit sufficient time to help team members achieve their objectives', 19, ''),
  (20, 1, 4, 'Disclose his/her personal views and feelings', 20, ''),
  (21, 1, 4, 'Demonstrate excellent listening skills', 21, ''),
  (22, 1, 4, 'Admit mistakes and react constructively', 22, ''),
  (23, 1, 5, 'Were you impressed by the consulting skills of this person', 23, ''),
  (24, 1, 5, 'Would you like to work with this person again', 24, ''),
  (25, 1, 5, 'Do you consider this person a role model for yourself', 25, ''),
  (26, 1, 5, 'Does this person radiate a sense of fun and excitement', 26, ''),
  (27, 2, 6, 'Strive to bring maximum value to the Client (Show deep personal commitment to achieving Client impact)', 1, ''),
  (28, 2, 6, 'Challenge the Client''s views on critical issues', 2, ''),
  (29, 2, 6, 'Manage realistic Client expectations of the study', 3, ''),
  (30, 2, 6, 'Be objective and candid with the Client - be willing to deliver bad news if necessary', 4, ''),
  (31, 2, 6, 'Build relationships with key members of the Client management', 5, ''),
  (32, 2, 6, 'Alert the Client to important issues outside the study scope', 6, ''),
  (33, 2, 6, 'Gain the Client''s confidence and establish the Firm''s credibility', 7, ''),
  (34, 2, 6, 'Achieve broad buy-in from the Client organization to ensure implementation', 8, ''),
  (35, 2, 7, 'Discover or create opportunities before others are aware of them', 9, ''),
  (36, 2, 7, 'Act decisively when faced with opportunity or challenge and be quick to take the initiative', 10, ''),
  (37, 2, 7, 'Search out challenging and ground-breaking studies', 11, ''),
  (38, 2, 8, 'Quickly identify and monitor core issues and maintain focus on important issues throughout the study', 12, ''),
  (39, 2, 8, 'Structure and disaggregate problems in an effective way', 13, ''),
  (40, 2, 8, 'Develop outstanding insights and frameworks to address core issues', 14, ''),
  (41, 2, 8, 'Reach out for the best Firm know-how and bring it to bear at the Client', 15, ''),
  (42, 2, 8, 'Develop and communicate actionable recommendations by balancing conceptual skills with good judgement on real-world constraints', 16, ''),
  (43, 2, 9, 'Promote a climate of continuous learning - seek to learn, not to blame when mistakes or failures occur', 17, ''),
  (44, 2, 9, 'Effectively resolve conflicts', 18, ''),
  (45, 2, 9, 'Show respect for each individual''s intellectual contribution', 19, ''),
  (46, 2, 9, 'Build your confidence and encourage people in taking initiatives/risks', 20, ''),
  (47, 2, 9, 'Give immediate and specific feedback when possible', 21, ''),
  (48, 2, 9, 'Commit sufficient time to help team members achieve their objectives', 22, ''),
  (49, 2, 9, 'Disclose his/her personal views and feelings', 23, ''),
  (50, 2, 9, 'Show sensitivity to the balance between the study and people''s private life', 24, ''),
  (51, 2, 9, 'Demonstrate excellent listening skills', 25, ''),
  (52, 2, 9, 'Admit mistakes and react constructively', 26, ''),
  (53, 2, 10, 'Ensure study objectives are clearly understood', 27, ''),
  (54, 2, 10, 'Ensure each team member is clear about his/her role and responsibility', 28, ''),
  (55, 2, 10, 'Quickly establish effective working practices (structured team meetings, interview guides, etc.)', 29, ''),
  (56, 2, 10, 'Discuss and help clarify the Client''s problems for the team early in the project', 30, ''),
  (57, 2, 10, 'Manage MGMs effectively', 31, ''),
  (58, 2, 10, 'Ensure that team meetings are held with appropriate frequency', 32, ''),
  (59, 2, 10, 'Set realistic deadlines', 33, ''),
  (60, 2, 10, 'Avoid unnecessary work', 34, ''),
  (61, 2, 10, 'Effectively leverage Firm resources', 35, ''),
  (62, 2, 10, 'Effectively manage Client team members', 36, ''),
  (63, 2, 11, 'Behave in a Partnerlike manner', 37, 'Interacts with others to create a team and Office atmosphere which encourages collaboration and collegiality (Not : Displays individualist, ''lone wolf'' behaviour with little Office impact)'),
  (64, 2, 11, 'Show genuine concern and work to develop people', 38, 'Helps people grow, is always available to assist, communicates high expectations of individuals(Not : regards people primarily as resources to be used)'),
  (65, 2, 11, 'Inspire others', 39, 'Stimulates people to be their best, is a role model and demonstrates leadership and creates followers (Not: Settles for just getting the job done)'),
  (66, 2, 11, 'Do what is right', 40, 'Emphasizes the importance of doing what is right and is prepared to take an uncompromising stance in support of it(Not : Is careerist, overly concerned with personal ambitions)'),
  (67, 2, 11, 'Make work fun', 41, 'Creates excitement at work and generates a positive image of McKinsey both internally and externally(Not : Creates anxiety and stress)'),
  (68, 2, 11, 'Reinforce Firm Values', 42, 'Lives the Firm''s values and demonstrates their importance and enhances our reputation with Clients and opinion formers (Not : Behaves close to the ''line'' and cuts corners)'),
  (69, 2, 11, 'Look after our Future', 43, 'Enhances the reputation of Swiss Office. Stands for an exciting future for the Office/Firm (Not : Fails to provide personal leadership beyond immediate engagements, is not Firm citizen)'),
  (70, 2, 12, 'Were you impressed by the consulting skills of this person', 44, ''),
  (71, 2, 12, 'Would you like to work with this person again', 45, ''),
  (72, 2, 12, 'Do you consider this person a role model for yourself', 46, ''),
  (73, 2, 12, 'Does this person show you that a long-term McKinsey career is both achievable and desirable', 47, ''),
  (74, 2, 12, 'Does this person radiate a sense of fun and excitement', 48, ''),
  (75, 2, 12, 'Is this person a real mentor to you', 49, ''),
  (76, 3, 13, 'Solliciter et obtenir une rétroaction de la part d''un membre du corps professoral sur votre rendement scolaire (à l''écrit et à l''oral)', 1, ''),
  (77, 3, 13, 'Travailler davantage que vous auriez pensé en être capable pour satisfaire les exigences d''un membre du corps professoral', 2, ''),
  (78, 3, 13, 'Travailler avec des professeurs à des activités extérieures au cours (comités, orientation,vie étudiante, etc.)', 3, ''),
  (79, 3, 13, 'Discuter de vos lectures ou de la matière du cours avec des personnes de l''extérieur (étudiants d''autres cours, membres de la famille, collègues, etc.)', 4, ''),
  (80, 3, 13, 'Entretenir des conversations sérieuses avec des étudiants d''une autre race ou d''une autre origine ethnique que la vôtre', 5, ''),
  (81, 3, 13, 'Entretenir des conversations sérieuses avec des étudiants ayant des croyances religieuses, des opinions politiques ou des valeurs très différentes des vôtres', 6, ''),
  (82, 3, 14, 'Préparation aux élections municipales, provinciales, territoriales ou fédérales', 7, ''),
  (83, 3, 14, 'Perfectionnement de l''autonomie dans le travail', 8, ''),
  (84, 3, 14, 'Approfondissement de la connaissance de soi', 9, ''),
  (85, 3, 14, 'Compréhension des personnes d''autres races ou d''autres origines ethniques', 10, ''),
  (86, 3, 14, 'Résolution des problèmes complexes de la vie quotidienne', 11, ''),
  (87, 3, 14, 'Élaboration d''un code personnel de valeurs et d''éthique', 12, ''),
  (88, 3, 14, 'Contribution au mieux-être de la collectivité', 13, ''),
  (89, 3, 14, 'Approfondissement de la vie spirituelle', 14, ''),
  (90, 3, 15, 'Stage, internat, expérience pratique, stage coop ou stage clinique', 15, ''),
  (91, 3, 15, 'Service communautaire ou bénévolat', 16, 'Vous pouvez donner plus de détails en commentaire libre'),
  (92, 3, 15, 'Participation à une collectivité d''apprentissage ou à un autre programme structuré dans lequel des groupes d''étudiants suivent un ou plusieurs cours ensemble', 17, ''),
  (93, 3, 15, 'Participation à un projet de recherche avec un ou une membre du corps professoral en dehors du cours ou du programme', 18, ''),
  (94, 3, 15, 'Apprentissage d''une langue additionnelle', 19, ''),
  (95, 3, 15, 'Études à l''étranger', 20, ''),
  (96, 3, 15, 'Études indépendantes ou majeure autodéterminée', 21, ''),
  (97, 3, 15, 'Activité de fin de programme déterminante', 22, '(cours clé, thèse, projet, examen récapitulatif, etc.)'),
  (98, 3, 16, 'Augmenter le nombre de bases de données contenant des ressources  photographiques', 23, ''),
  (99, 3, 16, 'Augmenter le nombre de bases de données contenant des ressources généalogiques', 24, ''),
  (100, 3, 16, 'Augmenter le nombre de documents numérisés (textes, photographies)', 25, ''),
  (101, 3, 16, 'Augmenter le nombre de descriptions de fonds et de collections d''archives', 26, ''),
  (102, 3, 16, 'Fournir davantage d''explications', 27, 'Favoriser une meilleure compréhension des dossiers ou documents décrits'),
  (103, 3, 16, 'Aucune amélioration nécessaire', 28, '');
