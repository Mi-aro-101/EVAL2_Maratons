-- From csv, test
INSERT INTO Course (id, nom_course) VALUES
    (nextval('course_id_seq'), 'Madagasikara');

-- ** Insertion etape de course
INSERT INTO etape_course (id, course_id, nbr_coureur, nom_etape, rang_etape, longueur, depart)
SELECT nextval('etape_course_id_seq'), 3, cast(ecm.nbr_coureur as integer)
        , ecm.etape, cast(ecm.rang as integer), cast(ecm.longueur as double precision)
        , TO_TIMESTAMP(CONCAT_WS(' ', ecm.date_depart, ecm.heure_depart), 'dd/MM/YYYY HH24:MI:ss')::timestamp
    FROM etape_course_mirror ecm;

-- ** Insertion rang point
INSERT INTO point_rang (id, etape_course_id, point, rang)
SELECT nextval('point_rang_id_seq'), 90, cast(rpm.points as double precision), cast(rpm.classement as integer)
    FROM point_rang_mirror rpm

-- ** Insertion Utilisateur via Resultat
-- Alaina mitokana satria mila hashena ny mot de passe
SELECT distinct r.equipe
    FROM Resultat r

-- ** Insertion ana equipe
INSERT INTO equipe (nom_equipe, id, utilisateur_id)
WITH equipe AS ( SELECT DISTINCT r.equipe as eq FROM Resultat r)
SELECT eq, nextval('equipe_id_seq'), u.id
    FROM equipe e, Utilisateur u WHERE u.email=e.eq;

-- ** Insert ana coureur
INSERT INTO coureur (id, nom_coureur, numero_dossard, date_de_naissance, equipe_id, genre)
WITH Resultat_m AS (
    SELECT distinct r.nom, r.numero_dossard,
            TO_DATE(r.date_naissance, 'dd/MM/yyyy') datedenaissance, r.equipe, r.genre
        FROM Resultat r
)
SELECT nextval('coureur_id_seq'), rm.nom, rm.numero_dossard, rm.datedenaissance, e.id, rm.genre
    FROM Resultat_m rm, equipe e WHERE e.nom_equipe = rm.equipe

-- ** Insertion arrivee
INSERT INTO etape_coureur (id, coureur_id, etape_course_id, arrivee)
SELECT nextval('etape_coureur_id_seq'), c.id, ec.id,
    TO_TIMESTAMP(r.arrivee, 'dd/MM/yyyy HH24:MI:ss')::timestamp
    FROM Resultat r, coureur c, etape_course ec
    WHERE r.nom=c.nom_coureur AND cast(r.etape_rang as integer)=ec.rang_etape

-- ** Get the classement generale par etape aloha
CREATE OR REPLACE VIEW v_classement_generale as
WITH temps_parcours AS (
SELECT c.id as coureur_id, (ec.arrivee-ecou.depart) as temps, ecou.id as etape,
    DENSE_RANK() OVER (PARTITION BY ecou.id ORDER BY (ec.arrivee - ecou.depart)) AS rang
    FROM etape_coureur ec, coureur c, etape_course ecou
    WHERE ec.coureur_id = c.id AND ec.etape_course_id = ecou.id
)
SELECT tp.rang, tp.coureur_id, tp.temps, COALESCE(pr.point, 0) as point, tp.etape as etape, tp.temps
    FROM temps_parcours tp
    LEFT JOIN point_rang pr ON tp.etape = pr.etape_course_id AND tp.rang = pr.rang
    WHERE tp.etape = 103
    ORDER BY tp.temps

SELECT * FROM v_classement_generale WHERE etape=103

-- ** insert classement
INSERT INTO classement (id, coureur_id, etape_course_id, rang, point)
SELECT nextval('classement_id_seq'), vcg.coureur_id, vcg.etape, vcg.rang, vcg.point
    FROM v_classement_generale vcg

-- ** Get Classement par equipe
SELECT DENSE_RANK() OVER (ORDER BY (sum(point)) DESC) AS rang, sum(cl.point) as score, c.equipe_id, e.nom_equipe
    FROM classement cl, coureur c, equipe e
    WHERE c.id = cl.coureur_id AND c.equipe_id = e.id
    GROUP BY e.id, e.nom_equipe, c.equipe_id
    ORDER BY score DESC

