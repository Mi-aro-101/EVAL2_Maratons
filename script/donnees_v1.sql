INSERT INTO Course (id, nom_course) VALUES
    (nextval('course_id_seq'), 'Betsizaraina'),
    (nextval('course_id_seq'), 'Ampasimbe');

INSERT INTO etape_course (id, course_id, nbr_coureur, nom_etape, longueur) VALUES
    (nextval('etape_course_id_seq'), 1, 1, 'Etape 1', 10),
    (nextval('etape_course_id_seq'), 1, 1, 'Etape 2', 5),
    (nextval('etape_course_id_seq'), 1, 2, 'Etape 3', 7),
    (nextval('etape_course_id_seq'), 2, 2, 'Etape 1', 8),
    (nextval('etape_course_id_seq'), 2, 1, 'Etape 2', 5);

    update etape_course set depart = TO_TIMESTAMP('2022-06-30 15:30:00', 'yyyy-MM-dd HH24:MI:ss') WHERE id = 1;
    update etape_course set depart = TO_TIMESTAMP('2022-07-28 09:20:00', 'yyyy-MM-dd HH24:MI:ss') WHERE id = 2;
    update etape_course set depart = TO_TIMESTAMP('2022-11-02 13:30:00', 'yyyy-MM-dd HH24:MI:ss') WHERE id = 3;
    update etape_course set depart = TO_TIMESTAMP('2024-01-31 15:15:00', 'yyyy-MM-dd HH24:MI:ss') WHERE id = 4;
    update etape_course set depart = TO_TIMESTAMP('2024-04-04 20:35:00', 'yyyy-MM-dd HH24:MI:ss') WHERE id = 5;

INSERT INTO point_rang (id, etape_course_id, point, rang) VALUES
    (nextval('point_rang_id_seq'), 1, 10, 1),
    (nextval('point_rang_id_seq'), 1, 8, 2),
    (nextval('point_rang_id_seq'), 1, 5, 3),
    (nextval('point_rang_id_seq'), 1, 3, 4),
    (nextval('point_rang_id_seq'), 1, 1, 5),

    (nextval('point_rang_id_seq'), 2, 15, 1),
    (nextval('point_rang_id_seq'), 2, 10, 2),
    (nextval('point_rang_id_seq'), 2, 6, 3),
    (nextval('point_rang_id_seq'), 2, 3, 4),
    (nextval('point_rang_id_seq'), 2, 1, 5),

    (nextval('point_rang_id_seq'), 3, 20, 1),
    (nextval('point_rang_id_seq'), 3, 15, 2),
    (nextval('point_rang_id_seq'), 3, 11, 3),
    (nextval('point_rang_id_seq'), 3, 8, 4),
    (nextval('point_rang_id_seq'), 3, 2, 5),

    (nextval('point_rang_id_seq'), 4, 10, 1),
    (nextval('point_rang_id_seq'), 4, 8, 2),
    (nextval('point_rang_id_seq'), 4, 6, 3),
    (nextval('point_rang_id_seq'), 4, 3, 4),
    (nextval('point_rang_id_seq'), 4, 1, 5),

    (nextval('point_rang_id_seq'), 5, 20, 1),
    (nextval('point_rang_id_seq'), 5, 10, 2),
    (nextval('point_rang_id_seq'), 5, 8, 3),
    (nextval('point_rang_id_seq'), 5, 4, 4),
    (nextval('point_rang_id_seq'), 5, 2, 5);

INSERT INTO categorie_coureur (id, nom_categorie) VALUES
    (nextval('categorie_coureur_id_seq'), 'femme'),
    (nextval('categorie_coureur_id_seq'), 'senior'),
    (nextval('categorie_coureur_id_seq'), 'homme'),
    (nextval('categorie_coureur_id_seq'), 'junior');

INSERT INTO equipe  (id, nom_equipe) VALUES
    (nextval('equipe_id_seq'), 'Equipe A'),
    (nextval('equipe_id_seq'), 'Equipe B'),
    (nextval('equipe_id_seq'), 'Equipe D');

UPDATE Equipe set utilisateur_id = 1 WHERE id=1;
UPDATE Equipe set utilisateur_id = 2 WHERE id=2;
UPDATE Equipe set utilisateur_id = 3 WHERE id=3;

INSERT INTO Coureur (id, nom_coureur, numero_dossard, date_de_naissance, equipe_id) VALUES
    (nextval('coureur_id_seq'), 'Celestine', '1', TO_DATE('2000-08-17', 'yyyy-MM-dd'), 1),
    (nextval('coureur_id_seq'), 'Louis', '2', TO_DATE('2007-07-09', 'yyyy-MM-dd'), 1),
    (nextval('coureur_id_seq'), 'Tafita', '3', TO_DATE('1991-12-12', 'yyyy-MM-dd'), 1),

    (nextval('coureur_id_seq'), 'Marcos', '4', TO_DATE('2001-05-30', 'yyyy-MM-dd'), 2),
    (nextval('coureur_id_seq'), 'Fanirisoa', '5', TO_DATE('2005-12-06', 'yyyy-MM-dd'), 2),
    (nextval('coureur_id_seq'), 'Manjaka', '6', TO_DATE('1998-02-20', 'yyyy-MM-dd'), 2),
    (nextval('coureur_id_seq'), 'Felana', '7', TO_DATE('2000-01-01', 'yyyy-MM-dd'), 2),

    (nextval('coureur_id_seq'), 'Finoana', '8', TO_DATE('2000-12-06', 'yyyy-MM-dd'), 3),
    (nextval('coureur_id_seq'), 'Fanantenana', '9', TO_DATE('2006-07-07', 'yyyy-MM-dd'), 3),
    (nextval('coureur_id_seq'), 'Fitiavana', '9', TO_DATE('2001-11-11', 'yyyy-MM-dd'), 3);

INSERT INTO coureur_categorie_coureur (coureur_id, categorie_coureur_id) VALUES
    (1, 1),
    (1, 2),
    (2, 4),
    (3, 2),
    (3, 3),
    (4, 2),
    (4, 4),
    (5, 4),
    (6, 2),
    (6, 3),
    (7, 1),
    (8, 3),
    (8, 2),
    (9, 4),
    (10, 1);

UPDATE Coureur SET genre = 0 WHERE id = 1 OR id = 5 OR id= 7 OR id = 9 OR id = 10;
UPDATE Coureur SET genre = 1 WHERE id = 2 OR id = 3 OR id= 4 OR id = 6 OR id = 8;


