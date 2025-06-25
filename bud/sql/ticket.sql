CREATE TABLE priorite(
    id INT PRIMARY KEY NOT NULL,
    nom VARCHAR(250) NOT NULL
);

CREATE TABLE statut(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `desc` VARCHAR(255) NOT NULL
);

CREATE TABLE ticket (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    sujet VARCHAR(255) NOT NULL,
    `desc` VARCHAR(255) NULL,
    priorite INT NOT NULL,
    file VARCHAR(255) NULL DEFAULT NULL,
    id_statut INT NOT NULL,
    FOREIGN KEY (id_statut) REFERENCES statut(id),
    FOREIGN KEY (priorite) REFERENCES priorite(id),
    date_creation DATETIME NULL DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE assignement(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    ticket_id INT NOT NULL,
    agent_id INT NOT NULL,
    FOREIGN KEY (ticket_id) REFERENCES ticket(id),
    FOREIGN KEY (agent_id) REFERENCES EMPLOYER(id)
);

CREATE TABLE payement_ticket(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    ticket_id INT NOT NULL ,
    dure DOUBLE NOT NULL ,
    agent_id INT NOT NULL  ,
    FOREIGN KEY (ticket_id) REFERENCES ticket(id),
    FOREIGN KEY (agent_id) REFERENCES EMPLOYER(id)
);

CREATE TABLE `ecart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_dept` int(11) NOT NULL,
  `valeur` int(11) DEFAULT NULL,
  `id_prevision` int(11) DEFAULT NULL,
  `id_realisation` int(11) DEFAULT NULL,
  `mois` int(11) DEFAULT NULL,
  `annee` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_dept` (`id_dept`),
  KEY `id_prevision` (`id_prevision`),
  KEY `id_realisation` (`id_realisation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4

CREATE TABLE `prevision` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_dept` int(11) NOT NULL,
  `valeur` int(11) DEFAULT NULL,
  `id_type` int(11) DEFAULT NULL,
  `mois` int(11) DEFAULT NULL,
  `annee` int(11) DEFAULT NULL,
  `propos` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_dept` (`id_dept`),
  KEY `id_type` (`id_type`),
  CONSTRAINT `prevision_ibfk_1` FOREIGN KEY (`id_dept`) REFERENCES `DEPARTEMENT` (`id`),
  CONSTRAINT `prevision_ibfk_2` FOREIGN KEY (`id_type`) REFERENCES `TYPE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4

CREATE TABLE `realisation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_dept` int(11) NOT NULL,
  `valeur` int(11) DEFAULT NULL,
  `id_prevision` int(11) DEFAULT NULL,
  `mois` int(11) DEFAULT NULL,
  `annee` int(11) DEFAULT NULL,
  `propos` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_dept` (`id_dept`),
  KEY `id_prevision` (`id_prevision`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4