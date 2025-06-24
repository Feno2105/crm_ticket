CREATE TABLE ticket (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    sujet VARCHAR(255) NOT NULL,
    `desc` VARCHAR(255) NULL,
    priorite INT NOT NULL,
    file VARCHAR(255) NULL DEFAULT NULL,
    date_creation DATETIME NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE statut(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `desc` VARCHAR(255) NOT NULL
);

CREATE TABLE statut_ticket(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    ticket_id INT NOT NULL,
    statut_id INT NOT NULL,
    FOREIGN KEY (ticket_id) REFERENCES ticket(id),
    FOREIGN KEY (statut_id) REFERENCES statut(id)
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
