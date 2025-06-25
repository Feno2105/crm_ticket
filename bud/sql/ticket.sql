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

CREATE TABLE ticket_Produits(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_ticket INT ,
    id_produit INT,
    id_client INT,
    FOREIGN KEY (id_ticket) REFERENCES ticket(id),
    FOREIGN KEY (id_produit) REFERENCES produit(id_produit),
    FOREIGN KEY (id_client )REFERENCES client(id_client)
);

CREATE TABLE commentaire_Ticket(
    id_commentaire INT PRIMARY KEY AUTO_INCREMENT,
    commentaire varchar(50),
    id_ticket_produit INT,
    FOREIGN KEY (id_ticket_produit) REFERENCES ticket_Produits(id)
  
);
CREATE TABLE note_Ticket(
    id_note INT ,
    note FLOAT(2,1),
    id_ticket_produit INT,
    FOREIGN KEY (id_ticket_produit) REFERENCES ticket_Produits(id)
  
);


CREATE TABLE statut(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `desc` VARCHAR(255) NOT NULL
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
) ;

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
) ;
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
) ;
