CREATE TABLE `quest_cac` (
  `IdCAC` int(8) NOT NULL auto_increment,
  `LibelleCAC` varchar(50) NOT NULL default '' COMMENT 'Libell� long pour faire la l�gende',
  `LibelleCourtCac` char(3) NOT NULL default '' COMMENT 'Libell� court qui apparait avec la question',
  PRIMARY KEY  (`IdCAC`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Contient la liste de toutes les CAC';


CREATE TABLE `quest_cac_categories` (
  `IdCac_categories` int(10) unsigned NOT NULL auto_increment,
  `IdCAC` int(10) unsigned NOT NULL default '0',
  `IdCategorie` int(10) unsigned NOT NULL default '0',
  `DroiteGauche` smallint(2) NOT NULL default '0' COMMENT '1 = droite, 2=gauche',
  `Ordre` int(10) unsigned NOT NULL default '0' COMMENT 'de 1 � n',
  PRIMARY KEY  (`IdCac_categories`),
  KEY `IdCategorie` (`IdCategorie`),
  KEY `Ordre` (`Ordre`),
  KEY `DroiteGauche` (`DroiteGauche`),
  KEY `DroiteGaucheOrdre` (`DroiteGauche`,`Ordre`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Stocke les CAC par cat�gorie';


CREATE TABLE `quest_categories` (
  `IdCategorie` int(8) unsigned NOT NULL auto_increment,
  `IdQuestionnaire` int(8) unsigned NOT NULL default '0',
  `LibelleCategorie` varchar(255) default NULL COMMENT 'Libell� court destin� � appara�tre dans les blocs',
  `LibelleCompltCategorie` varchar(255) default NULL COMMENT 'Sorte de sous titre',
  `OrdreCategorie` int(10) unsigned default '0' COMMENT 'De 1 � n',
  `AfficherDroite` tinyint(2) NOT NULL default '1' COMMENT 'Booleen, 0=non , 1=oui',
  `AfficherGauche` tinyint(2) NOT NULL default '1' COMMENT 'Booleen, 0=non , 1=oui',
  `comment1` varchar(255) NOT NULL default '' COMMENT 'Libell� de la zone, si vide alors pas de zone de saisie',
  `comment2` varchar(255) NOT NULL default '' COMMENT 'Libell� de la zone, si vide alors pas de zone de saisie',
  `comment3` varchar(255) NOT NULL default '' COMMENT 'Libell� de la zone, si vide alors pas de zone de saisie',
  `comment1mandatory` tinyint(1) NOT NULL default '1' COMMENT 'Indique si la saisie du commentaire est obligatoire',
  `comment2mandatory` tinyint(1) NOT NULL default '1' COMMENT 'Indique si la saisie du commentaire est obligatoire',
  `comment3mandatory` tinyint(1) NOT NULL default '1' COMMENT 'Indique si la saisie du commentaire est obligatoire',
  PRIMARY KEY  (`IdCategorie`),
  KEY `IdQuestionnaire` (`IdQuestionnaire`),
  KEY `OrdreCategorie` (`OrdreCategorie`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Liste de toutes les cat�gories';


CREATE TABLE `quest_enquetes` (
  `IdEnquete` int(8) unsigned NOT NULL auto_increment,
  `NomEnquete` varchar(150) default NULL,
  `PrenomEnquete` varchar(150) default NULL,
  `TypeEnquete` tinyint(1) unsigned default NULL COMMENT 'Provient de la premi�re version, quelle utilit� ?',
  `login` varchar(255) NOT NULL default '' COMMENT 'pr�vu au cas o�',
  `password` varchar(40) NOT NULL default '' COMMENT 'format md5',
  PRIMARY KEY  (`IdEnquete`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Liste des enqu�tes';


CREATE TABLE `quest_questionnaires` (
  `IdQuestionnaire` int(8) unsigned NOT NULL auto_increment,
  `LibelleQuestionnaire` varchar(255) NOT NULL default '',
  `IdEnquete` mediumint(8) unsigned NOT NULL default '0',
  `DateOuverture` int(10) default NULL,
  `DateFermeture` int(10) default NULL,
  `NbSessions` int(8) default '0' COMMENT 'Provient de la premi�re version, Quelle utilit� ?',
  `Etat` tinyint(1) default '0' COMMENT '0=actif, 1=suspendu',
  `ltor` tinyint(2) NOT NULL default '0' COMMENT 'Pour les langues arabes 0=faux, 1=vrai',
  `SujetRelance` varchar(255) NOT NULL default '' COMMENT 'Pour les mails',
  `CorpsRelance` text NOT NULL COMMENT 'Pour les mails',
  `SujetOuverture` varchar(255) NOT NULL default '' COMMENT 'Pour les mails',
  `CorpsOuverture` text NOT NULL COMMENT 'Pour les mails',
  `FrequenceRelances` int(11) NOT NULL default '0' COMMENT 'fr�quence en jours',
  `DerniereRelance` int(10) unsigned NOT NULL default '0' COMMENT 'format timestamp',
  `NbRelances` int(10) unsigned NOT NULL default '0',
  `ReplyTo` varchar(255) NOT NULL default '' COMMENT 'Adresse mail devant recevoir d''�ventuelles r�ponses',
  `Groupe` int(10) unsigned NOT NULL default '0' COMMENT 'Groupe Xoops devant r�pondre au questionnaire',
  `PartnerGroup` int(10) unsigned NOT NULL default '1' COMMENT 'Groupe auquel appartient le commanditaire du questionnaire',
  `RelancesOption` int(11) NOT NULL default '1' COMMENT 'Permet de savoir qui on doit relancer, 1=Tout le monde (pas r�pondu ou partiellement r�pondu), 2=uniquement ceux qui n''ont pas du tout r�pondu',
  `EmailFrom` varchar(255) NOT NULL default '' COMMENT 'Adresse email de l''exp�diteur',
  `EmailFromName` varchar(255) NOT NULL default '' COMMENT 'Nom de l''exp�diteur',
  `Introduction` text NOT NULL COMMENT 'Texte explicatif sur le questionnaire � destination du r�pondant',
  `GoOnAfterEnd` tinyint(2) NOT NULL default '0' COMMENT 'Peut on modifier ses r�ponses lorqu''on a termin� de r�pondre (0=non, 1=oui) ?',
  `ResetButton` varchar(255) NOT NULL default '' COMMENT 'Si renseign�, un bouton permettant de supprimer toutes ses r�ponses est affich�',
  PRIMARY KEY  (`IdQuestionnaire`),
  KEY `IdEnquete` (`IdEnquete`),
  KEY `PartnerGroup` (`PartnerGroup`),
  KEY `Groupe` (`Groupe`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Liste des tous les questionnaires d''un client';


CREATE TABLE `quest_questions` (
  `IdQuestion` int(8) unsigned NOT NULL auto_increment,
  `IdQuestionnaire` int(10) unsigned NOT NULL default '0',
  `IdCategorie` int(8) unsigned NOT NULL default '0',
  `TexteQuestion` varchar(255) default NULL,
  `OrdreQuestion` tinyint(2) unsigned default NULL COMMENT 'de 1 � n',
  `ComplementQuestion` text NOT NULL,
  PRIMARY KEY  (`IdQuestion`),
  KEY `IdCategorie` (`IdCategorie`),
  KEY `OrdreQuestion` (`OrdreQuestion`),
  KEY `IdQuestionnaire` (`IdQuestionnaire`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Liste de toutes les questions par cat�gorie';


CREATE TABLE `quest_reponses` (
  `IdReponse` int(8) unsigned NOT NULL auto_increment,
  `IdQuestionnaire` int(10) unsigned NOT NULL default '0',
  `IdCategorie` int(10) unsigned NOT NULL default '0',
  `IdRespondant` int(10) unsigned NOT NULL default '0' COMMENT '�gal user Xoops',
  `IdQuestion` int(8) NOT NULL default '0',
  `Id_CAC1` int(11) unsigned default '0' COMMENT 'Identifiant de la r�ponse coch�e � droite',
  `Id_CAC2` int(10) unsigned NOT NULL default '0' COMMENT 'Identifiant de la r�ponse coch�e � gauche',
  `DateReponse` int(10) unsigned NOT NULL default '0',
  `IP` varchar(32) NOT NULL default '' COMMENT 'Adresse IP de la personne qui a fait cette r�ponse',
  PRIMARY KEY  (`IdReponse`),
  KEY `IdRespondant` (`IdRespondant`),
  KEY `IdQuestion` (`IdQuestion`),
  KEY `IdQuestionnaire` (`IdQuestionnaire`),
  KEY `IdCategorie` (`IdCategorie`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='R�ponses personne/questionnaire/categorie/question';


CREATE TABLE `quest_respondquestionn` (
  `IdRespondQuestion` int(8) NOT NULL auto_increment,
  `IdQuestionnaire` int(8) unsigned NOT NULL default '0',
  `IdRespondant` int(8) unsigned NOT NULL default '0',
  `DateDebut` int(10) unsigned default NULL,
  `DateFin` int(10) unsigned default NULL,
  `Statut` tinyint(1) default NULL COMMENT 'Provient de la premi�re version, Quelle utilit� ?',
  PRIMARY KEY  (`IdRespondQuestion`),
  KEY `IdQuestionnaire` (`IdQuestionnaire`),
  KEY `IdRespondant` (`IdRespondant`),
  KEY `Statut` (`Statut`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Liste des personnes qui ont tout r�pondu (pour gain de temp)';


CREATE TABLE `quest_rubrcomment` (
  `IdRubrComment` int(8) unsigned NOT NULL auto_increment,
  `IdRespondant` int(8) unsigned NOT NULL default '0',
  `IdQuestionnaire` int(10) unsigned NOT NULL default '0',
  `IdCategorie` int(8) unsigned NOT NULL default '0',
  `Comment1` text,
  `Comment2` text,
  `Comment3` text,
  `DateReponse` int(10) unsigned NOT NULL default '0',
  `IP` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`IdRubrComment`),
  KEY `IdCategorie` (`IdCategorie`),
  KEY `IdQuestionnaire` (`IdQuestionnaire`),
  KEY `IdRespondant` (`IdRespondant`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='R�ponses aux commentaires des cat�gories par personne';
