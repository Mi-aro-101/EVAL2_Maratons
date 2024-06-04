-- ** Get coureur along their age
SELECT (2024 - extract(year from c.date_de_naissance)) as age, c.nom_coureur, c.id, c.genre
    FROM Coureur c
    WHERE (2024 - extract(year from c.date_de_naissance)) < 18


-- ** Classement par categorie / etape
CREATE OR REPLACE VIEW v_classement_categorie AS
WITH temps_parcours AS (
SELECT c.id as coureur_id, (ec.arrivee-ecou.depart) as temps, ecou.id as etape, c.nom_coureur,
    DENSE_RANK() OVER (PARTITION BY ecou.id, ccc.categorie_coureur_id ORDER BY (ec.arrivee - ecou.depart)) AS rang, ccc.categorie_coureur_id as categorie_coureur_id
    FROM etape_coureur ec, coureur c, etape_course ecou, coureur_categorie_coureur ccc
    WHERE ec.coureur_id = c.id AND ec.etape_course_id = ecou.id AND ccc.coureur_id = c.id
)
SELECT tp.rang, tp.coureur_id, tp.temps, COALESCE(pr.point, 0) as point, tp.etape as etape, tp.categorie_coureur_id
    , tp.nom_coureur
    FROM temps_parcours tp
    LEFT JOIN point_rang pr ON tp.etape = pr.etape_course_id AND tp.rang = pr.rang
    ORDER BY tp.temps, tp.categorie_coureur_id, point

SELECT *
    FROM v_classement_categorie vcc
    WHERE categorie_coureur_id=6

INSERT INTO classement_categorie (id, coureur_id, etape_course_id, categorie_coureur_id, rang, point)
SELECT nextval('classement_categorie_id_seq'), vcc.coureur_id, vcc.etape, vcc.categorie_coureur_id, vcc.rang, vcc.point
    FROM v_classement_categorie vcc

-- ** Get classement par categorie, general ou perso
SELECT DENSE_RANK() OVER (ORDER BY (sum(point)) DESC) AS rang, sum(cl.point) as score, c.equipe_id, e.nom_equipe, cl.categorie_coureur_id
    FROM classement_categorie cl, coureur c, equipe e
    WHERE c.id = cl.coureur_id AND c.equipe_id = e.id
    GROUP BY e.id, e.nom_equipe, c.equipe_id, cl.categorie_coureur_id
    ORDER BY rang, score DESC

-- ** Get winner general
WITH classement_winnner AS (
SELECT DENSE_RANK() OVER (ORDER BY (sum(point)) DESC) AS rang, sum(cl.point) as score, c.equipe_id, e.nom_equipe
    FROM classement cl, coureur c, equipe e
    WHERE c.id = cl.coureur_id AND c.equipe_id = e.id
    GROUP BY e.id, e.nom_equipe, c.equipe_id
    ORDER BY score DESC
)
SELECT *
    FROM classement_winnner WHERE rang=1

-- ** Get winner by category
WITH classement_cat_winner AS (
SELECT DENSE_RANK() OVER (ORDER BY (sum(point)) DESC) AS rang, sum(cl.point) as score, c.equipe_id, e.nom_equipe, cl.categorie_coureur_id
            FROM classement_categorie cl, coureur c, equipe e
            WHERE c.id = cl.coureur_id AND c.equipe_id = e.id
            GROUP BY e.id, e.nom_equipe, c.equipe_id, cl.categorie_coureur_id
            ORDER BY rang, score DESC
)
SELECT *
    FROM classement_cat_winner WHERE rang = 1

INSERT INTO penalite (id, etape_course_id, temps, equipe_id) VALUES
    (nextval('penalite_id_seq'), 103, '25:00:00', 14)

-- ** Reclassement generale en tenant compte des penalites
CREATE OR REPLACE VIEW v_classement_generale as
WITH temps_parcours AS (
SELECT c.id as coureur_id, (ec.arrivee-ecou.depart)+COALESCE(p.temps, '00:00:00') as temps, ecou.id as etape, e.id as equipe,
    DENSE_RANK() OVER (PARTITION BY ecou.id ORDER BY (ec.arrivee-ecou.depart)+COALESCE(p.temps, '00:00:00')) AS rang, p.temps as penalite_temps
    FROM etape_coureur ec
    JOIN coureur c ON ec.coureur_id = c.id
    JOIN etape_course ecou ON ec.etape_course_id = ecou.id
    JOIN equipe e ON c.equipe_id = e.id
    LEFT JOIN penalite p ON e.id = p.equipe_id AND ecou.id = p.etape_course_id
)
SELECT tp.rang, tp.coureur_id, tp.temps, COALESCE(pr.point, 0) as point, tp.etape as etape,
    tp.equipe, tp.penalite_temps
    FROM temps_parcours tp
    LEFT JOIN point_rang pr ON tp.etape = pr.etape_course_id AND tp.rang = pr.rang
    ORDER BY tp.temps

-- ** Reclassement par categorie en tenant compte des penalites
CREATE OR REPLACE VIEW v_classement_categorie AS
WITH temps_parcours AS (
SELECT c.id as coureur_id, (ec.arrivee-ecou.depart)+COALESCE(p.temps, '00:00:00') as temps, ecou.id as etape, c.nom_coureur,
    DENSE_RANK() OVER (PARTITION BY ecou.id, ccc.categorie_coureur_id ORDER BY (ec.arrivee-ecou.depart)+COALESCE(p.temps, '00:00:00')) AS rang, 
    ccc.categorie_coureur_id as categorie_coureur_id, p.temps as penalite_temps
    FROM etape_coureur ec
    JOIN coureur c ON ec.coureur_id = c.id
    JOIN etape_course ecou ON ec.etape_course_id = ecou.id
    JOIN coureur_categorie_coureur ccc ON ccc.coureur_id = c.id
    JOIN equipe e ON c.equipe_id = e.id
    LEFT JOIN penalite p ON e.id = p.equipe_id AND ecou.id=p.etape_course_id
)
SELECT tp.rang, tp.coureur_id, tp.temps, COALESCE(pr.point, 0) as point, tp.etape as etape, tp.categorie_coureur_id
    , tp.nom_coureur, tp.penalite_temps
    FROM temps_parcours tp
    LEFT JOIN point_rang pr ON tp.etape = pr.etape_course_id AND tp.rang = pr.rang
    ORDER BY tp.temps, tp.categorie_coureur_id, point

SELECT *
    FROM v_classement_categorie vcc WHERE categorie_coureur_id = 6