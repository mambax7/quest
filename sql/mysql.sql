CREATE TABLE `quest_cac` (
  `IdCAC`           INT(8)      NOT NULL AUTO_INCREMENT,
  `LibelleCAC`      VARCHAR(50) NOT NULL DEFAULT ''
  COMMENT 'Libell� long pour faire la l�gende',
  `LibelleCourtCac` CHAR(3)     NOT NULL DEFAULT ''
  COMMENT 'Libell� court qui apparait avec la question',
  PRIMARY KEY (`IdCAC`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = latin1
  COMMENT ='Contient la liste de toutes les CAC';


CREATE TABLE `quest_cac_categories` (
  `IdCac_categories` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `IdCAC`            INT(10) UNSIGNED NOT NULL DEFAULT '0',
  `IdCategorie`      INT(10) UNSIGNED NOT NULL DEFAULT '0',
  `DroiteGauche`     SMALLINT(2)      NOT NULL DEFAULT '0'
  COMMENT '1 = droite, 2=gauche',
  `Ordre`            INT(10) UNSIGNED NOT NULL DEFAULT '0'
  COMMENT 'de 1 � n',
  PRIMARY KEY (`IdCac_categories`),
  KEY `IdCategorie` (`IdCategorie`),
  KEY `Ordre` (`Ordre`),
  KEY `DroiteGauche` (`DroiteGauche`),
  KEY `DroiteGaucheOrdre` (`DroiteGauche`, `Ordre`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = latin1
  COMMENT ='Stocke les CAC par cat�gorie';


CREATE TABLE `quest_categories` (
  `IdCategorie`            INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `IdQuestionnaire`        INT(8) UNSIGNED NOT NULL DEFAULT '0',
  `LibelleCategorie`       VARCHAR(255)             DEFAULT NULL
  COMMENT 'Libell� court destin� � appara�tre dans les blocs',
  `LibelleCompltCategorie` VARCHAR(255)             DEFAULT NULL
  COMMENT 'Sorte de sous titre',
  `OrdreCategorie`         INT(10) UNSIGNED         DEFAULT '0'
  COMMENT 'De 1 � n',
  `AfficherDroite`         TINYINT(2)      NOT NULL DEFAULT '1'
  COMMENT 'Booleen, 0=non , 1=oui',
  `AfficherGauche`         TINYINT(2)      NOT NULL DEFAULT '1'
  COMMENT 'Booleen, 0=non , 1=oui',
  `comment1`               VARCHAR(255)    NOT NULL DEFAULT ''
  COMMENT 'Libell� de la zone, si vide alors pas de zone de saisie',
  `comment2`               VARCHAR(255)    NOT NULL DEFAULT ''
  COMMENT 'Libell� de la zone, si vide alors pas de zone de saisie',
  `comment3`               VARCHAR(255)    NOT NULL DEFAULT ''
  COMMENT 'Libell� de la zone, si vide alors pas de zone de saisie',
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
  COMMENT ='Liste de toutes les cat�gories';


CREATE TABLE `quest_enquetes` (
  `IdEnquete`     INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `NomEnquete`    VARCHAR(150)             DEFAULT NULL,
  `PrenomEnquete` VARCHAR(150)             DEFAULT NULL,
  `TypeEnquete`   TINYINT(1) UNSIGNED      DEFAULT NULL
  COMMENT 'Provient de la premi�re version, quelle utilit� ?',
  `login`         VARCHAR(255)    NOT NULL DEFAULT ''
  COMMENT 'pr�vu au cas o�',
  `password`      VARCHAR(40)     NOT NULL DEFAULT ''
  COMMENT 'format md5',
  PRIMARY KEY (`IdEnquete`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = latin1
  COMMENT ='Liste des enqu�tes';


CREATE TABLE `quest_questionnaires` (
  `IdQuestionnaire`      INT(8) UNSIGNED       NOT NULL AUTO_INCREMENT,
  `LibelleQuestionnaire` VARCHAR(255)          NOT NULL DEFAULT '',
  `IdEnquete`            MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  `DateOuverture`        INT(10)                        DEFAULT NULL,
  `DateFermeture`        INT(10)                        DEFAULT NULL,
  `NbSessions`           INT(8)                         DEFAULT '0'
  COMMENT 'Provient de la premi�re version, Quelle utilit� ?',
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
  COMMENT 'fr�quence en jours',
  `DerniereRelance`      INT(10) UNSIGNED      NOT NULL DEFAULT '0'
  COMMENT 'format timestamp',
  `NbRelances`           INT(10) UNSIGNED      NOT NULL DEFAULT '0',
  `ReplyTo`              VARCHAR(255)          NOT NULL DEFAULT ''
  COMMENT 'Adresse mail devant recevoir d''�ventuelles r�ponses',
  `Groupe`               INT(10) UNSIGNED      NOT NULL DEFAULT '0'
  COMMENT 'Groupe Xoops devant r�pondre au questionnaire',
  `PartnerGroup`         INT(10) UNSIGNED      NOT NULL DEFAULT '1'
  COMMENT 'Groupe auquel appartient le commanditaire du questionnaire',
  `RelancesOption`       INT(11)               NOT NULL DEFAULT '1'
  COMMENT 'Permet de savoir qui on doit relancer, 1=Tout le monde (pas r�pondu ou partiellement r�pondu), 2=uniquement ceux qui n''ont pas du tout r�pondu',
  `EmailFrom`            VARCHAR(255)          NOT NULL DEFAULT ''
  COMMENT 'Adresse email de l''exp�diteur',
  `EmailFromName`        VARCHAR(255)          NOT NULL DEFAULT ''
  COMMENT 'Nom de l''exp�diteur',
  `Introduction`         TEXT                  NOT NULL
  COMMENT 'Texte explicatif sur le questionnaire � destination du r�pondant',
  `GoOnAfterEnd`         TINYINT(2)            NOT NULL DEFAULT '0'
  COMMENT 'Peut on modifier ses r�ponses lorqu''on a termin� de r�pondre (0=non, 1=oui) ?',
  `ResetButton`          VARCHAR(255)          NOT NULL DEFAULT ''
  COMMENT 'Si renseign�, un bouton permettant de supprimer toutes ses r�ponses est affich�',
  PRIMARY KEY (`IdQuestionnaire`),
  KEY `IdEnquete` (`IdEnquete`),
  KEY `PartnerGroup` (`PartnerGroup`),
  KEY `Groupe` (`Groupe`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = latin1
  COMMENT ='Liste des tous les questionnaires d''un client';


CREATE TABLE `quest_questions` (
  `IdQuestion`         INT(8) UNSIGNED  NOT NULL AUTO_INCREMENT,
  `IdQuestionnaire`    INT(10) UNSIGNED NOT NULL DEFAULT '0',
  `IdCategorie`        INT(8) UNSIGNED  NOT NULL DEFAULT '0',
  `TexteQuestion`      VARCHAR(255)              DEFAULT NULL,
  `OrdreQuestion`      TINYINT(2) UNSIGNED       DEFAULT NULL
  COMMENT 'de 1 � n',
  `ComplementQuestion` TEXT             NOT NULL,
  PRIMARY KEY (`IdQuestion`),
  KEY `IdCategorie` (`IdCategorie`),
  KEY `OrdreQuestion` (`OrdreQuestion`),
  KEY `IdQuestionnaire` (`IdQuestionnaire`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = latin1
  COMMENT ='Liste de toutes les questions par cat�gorie';


CREATE TABLE `quest_reponses` (
  `IdReponse`       INT(8) UNSIGNED  NOT NULL AUTO_INCREMENT,
  `IdQuestionnaire` INT(10) UNSIGNED NOT NULL DEFAULT '0',
  `IdCategorie`     INT(10) UNSIGNED NOT NULL DEFAULT '0',
  `IdRespondant`    INT(10) UNSIGNED NOT NULL DEFAULT '0'
  COMMENT '�gal user Xoops',
  `IdQuestion`      INT(8)           NOT NULL DEFAULT '0',
  `Id_CAC1`         INT(11) UNSIGNED          DEFAULT '0'
  COMMENT 'Identifiant de la r�ponse coch�e � droite',
  `Id_CAC2`         INT(10) UNSIGNED NOT NULL DEFAULT '0'
  COMMENT 'Identifiant de la r�ponse coch�e � gauche',
  `DateReponse`     INT(10) UNSIGNED NOT NULL DEFAULT '0',
  `IP`              VARCHAR(32)      NOT NULL DEFAULT ''
  COMMENT 'Adresse IP de la personne qui a fait cette r�ponse',
  PRIMARY KEY (`IdReponse`),
  KEY `IdRespondant` (`IdRespondant`),
  KEY `IdQuestion` (`IdQuestion`),
  KEY `IdQuestionnaire` (`IdQuestionnaire`),
  KEY `IdCategorie` (`IdCategorie`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = latin1
  COMMENT ='R�ponses personne/questionnaire/categorie/question';


CREATE TABLE `quest_respondquestionn` (
  `IdRespondQuestion` INT(8)          NOT NULL AUTO_INCREMENT,
  `IdQuestionnaire`   INT(8) UNSIGNED NOT NULL DEFAULT '0',
  `IdRespondant`      INT(8) UNSIGNED NOT NULL DEFAULT '0',
  `DateDebut`         INT(10) UNSIGNED         DEFAULT NULL,
  `DateFin`           INT(10) UNSIGNED         DEFAULT NULL,
  `Statut`            TINYINT(1)               DEFAULT NULL
  COMMENT 'Provient de la premi�re version, Quelle utilit� ?',
  PRIMARY KEY (`IdRespondQuestion`),
  KEY `IdQuestionnaire` (`IdQuestionnaire`),
  KEY `IdRespondant` (`IdRespondant`),
  KEY `Statut` (`Statut`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = latin1
  COMMENT ='Liste des personnes qui ont tout r�pondu (pour gain de temp)';


CREATE TABLE `quest_rubrcomment` (
  `IdRubrComment`   INT(8) UNSIGNED  NOT NULL AUTO_INCREMENT,
  `IdRespondant`    INT(8) UNSIGNED  NOT NULL DEFAULT '0',
  `IdQuestionnaire` INT(10) UNSIGNED NOT NULL DEFAULT '0',
  `IdCategorie`     INT(8) UNSIGNED  NOT NULL DEFAULT '0',
  `Comment1`        TEXT,
  `Comment2`        TEXT,
  `Comment3`        TEXT,
  `DateReponse`     INT(10) UNSIGNED NOT NULL DEFAULT '0',
  `IP`              VARCHAR(32)      NOT NULL DEFAULT '',
  PRIMARY KEY (`IdRubrComment`),
  KEY `IdCategorie` (`IdCategorie`),
  KEY `IdQuestionnaire` (`IdQuestionnaire`),
  KEY `IdRespondant` (`IdRespondant`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = latin1
  COMMENT ='R�ponses aux commentaires des cat�gories par personne';
