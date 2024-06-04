ALTER TABLE etape_course ADD rang_etape INT DEFAULT NULL
ALTER TABLE etape_course ALTER COLUMN rang_etape SET NOT NULL

CREATE SEQUENCE etape_course_mirror_id_seq INCREMENT BY 1 MINVALUE 1 START 1

CREATE TABLE etape_course_mirror (
    id INT NOT NULL, 
    etape VARCHAR(255) NOT NULL,
    longueur VARCHAR(255) NOT NULL, 
    nbr_coureur VARCHAR(2) NOT NULL, 
    rang VARCHAR(2) NOT NULL, 
    date_depart VARCHAR(30) NOT NULL, 
    heure_depart VARCHAR(30) NOT NULL, 
    PRIMARY KEY(id)
);

CREATE SEQUENCE point_rang_mirror_id_seq INCREMENT BY 1 MINVALUE 1 START 1
CREATE TABLE point_rang_mirror (
    id INT NOT NULL, 
    classement VARCHAR(4) NOT NULL, 
    points VARCHAR(10) NOT NULL, 
    PRIMARY KEY(id)
);

CREATE SEQUENCE resultat_id_seq INCREMENT BY 1 MINVALUE 1 START 1
CREATE TABLE resultat (
    id INT NOT NULL, 
    etape_rang VARCHAR(5) NOT NULL, 
    numero_dossard VARCHAR(5) NOT NULL, 
    nom VARCHAR(255) NOT NULL, 
    genre VARCHAR(1) NOT NULL, 
    date_naissance VARCHAR(50) NOT NULL, 
    equipe VARCHAR(100) NOT NULL, 
    arrivee VARCHAR(155) NOT NULL, 
    PRIMARY KEY(id)
);

ALTER TABLE Coureur ALTER COLUMN genre SET NOT NULL;

CREATE SEQUENCE classement_id_seq INCREMENT BY 1 MINVALUE 1 START 1
CREATE TABLE classement (
    id INT NOT NULL, 
    coureur_id INT NOT NULL, 
    etape_course_id INT NOT NULL, 
    rang INT NOT NULL, 
    point DOUBLE PRECISION NOT NULL, 
    PRIMARY KEY(id)
);
CREATE INDEX IDX_55EE9D6DF4FA42E5 ON classement (coureur_id)
CREATE INDEX IDX_55EE9D6D740F7C7D ON classement (etape_course_id)
ALTER TABLE classement ADD CONSTRAINT FK_55EE9D6DF4FA42E5 FOREIGN KEY (coureur_id) REFERENCES coureur (id) NOT DEFERRABLE INITIALLY IMMEDIATE
ALTER TABLE classement ADD CONSTRAINT FK_55EE9D6D740F7C7D FOREIGN KEY (etape_course_id) REFERENCES etape_course (id) NOT DEFERRABLE INITIALLY IMMEDIATE

ALTER TABLE coureur ADD UNIQUE (numero_dossard)