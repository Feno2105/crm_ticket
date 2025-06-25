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

CREATE TABLE priorite(
    id INT PRIMARY KEY NOT NULL,
    nom VARCHAR(250) NOT NULL
);
