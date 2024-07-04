-- ** Classement generale miaraka @ colonne additionnelle ny J4
CREATE OR REPLACE VIEW v_classement_generale AS
WITH temps_parcours AS (
SELECT c.id as coureur_id, (ec.arrivee-ecou.depart)+COALESCE(p.temps, '00:00:00') as temps_final, ecou.id as etape, e.id as equipe,
    (ec.arrivee-ecou.depart) as temps,
    DENSE_RANK() OVER (PARTITION BY ecou.id ORDER BY (ec.arrivee-ecou.depart)+COALESCE(p.temps, '00:00:00')) AS rang, p.temps as penalite_temps,
    c.genre
    FROM etape_coureur ec
    JOIN coureur c ON ec.coureur_id = c.id
    JOIN etape_course ecou ON ec.etape_course_id = ecou.id
    JOIN equipe e ON c.equipe_id = e.id
    LEFT JOIN penalite p ON e.id = p.equipe_id AND ecou.id = p.etape_course_id
)
SELECT tp.rang, tp.coureur_id, COALESCE(pr.point, 0) as point, tp.etape as etape, tp.genre,
    tp.equipe, tp.temps, tp.penalite_temps, tp.temps_final
    FROM temps_parcours tp
    LEFT JOIN point_rang pr ON tp.etape = pr.etape_course_id AND tp.rang = pr.rang
    ORDER BY tp.temps

INSERT INTO classement (id, coureur_id, etape_course_id, rang, point, genre, temps, penalite_temps, temps_final, equipe_id)
SELECT nextval('classement_id_seq'), vcg.coureur_id, vcg.etape, vcg.rang, vcg.point
    , vcg.genre, vcg.temps, vcg.penalite_temps, vcg.temps_final, vcg.equipe
    FROM v_classement_generale vcg

-- ** Classement categorisee miaraka @ colonne additionnelle ny J4
CREATE OR REPLACE VIEW v_classement_categorie AS
WITH temps_parcours AS (
SELECT c.id as coureur_id, (ec.arrivee-ecou.depart)+COALESCE(p.temps, '00:00:00') as temps_final, ecou.id as etape, c.nom_coureur,
    DENSE_RANK() OVER (PARTITION BY ecou.id, ccc.categorie_coureur_id ORDER BY (ec.arrivee-ecou.depart)+COALESCE(p.temps, '00:00:00')) AS rang, 
    ccc.categorie_coureur_id as categorie_coureur_id, p.temps as penalite_temps, (ec.arrivee-ecou.depart) as temps,
    c.genre
    FROM etape_coureur ec
    JOIN coureur c ON ec.coureur_id = c.id
    JOIN etape_course ecou ON ec.etape_course_id = ecou.id
    JOIN coureur_categorie_coureur ccc ON ccc.coureur_id = c.id
    JOIN equipe e ON c.equipe_id = e.id
    LEFT JOIN penalite p ON e.id = p.equipe_id AND ecou.id=p.etape_course_id
)
SELECT tp.rang, tp.coureur_id, COALESCE(pr.point, 0) as point, tp.etape as etape, tp.categorie_coureur_id
    , tp.nom_coureur, tp.temps, tp.penalite_temps, tp.temps_final, tp.genre
    FROM temps_parcours tp
    LEFT JOIN point_rang pr ON tp.etape = pr.etape_course_id AND tp.rang = pr.rang
    ORDER BY tp.temps, tp.categorie_coureur_id, point

INSERT INTO classement_categorie (id, coureur_id, etape_course_id, categorie_coureur_id, rang, point, genre, temps, penalite_temps, temps_final)
SELECT nextval('classement_categorie_id_seq'), vcc.coureur_id, vcc.etape, vcc.categorie_coureur_id, vcc.rang, vcc.point,
    vcc.genre, vcc.temps, vcc.penalite_temps, vcc.temps_final
    FROM v_classement_categorie vcc

-- ** Get classement categorise tena marina satria mila total ny penalite no alaina fa tsy iray fotsiny
CREATE OR REPLACE VIEW v_classement_categorie2 AS
WITH temps_parcours AS (
SELECT c.id as coureur_id, (ec.arrivee-ecou.depart)+COALESCE(sum(p.temps), '00:00:00') as temps_final, ecou.id as etape, c.nom_coureur,
    DENSE_RANK() OVER (PARTITION BY ecou.id, ccc.categorie_coureur_id ORDER BY (ec.arrivee-ecou.depart)+COALESCE(sum(p.temps), '00:00:00')) AS rang, 
    ccc.categorie_coureur_id as categorie_coureur_id, sum(p.temps) as penalite_temps, (ec.arrivee-ecou.depart) as temps,
    c.genre
    FROM etape_coureur ec
    JOIN coureur c ON ec.coureur_id = c.id
    JOIN etape_course ecou ON ec.etape_course_id = ecou.id
    JOIN coureur_categorie_coureur ccc ON ccc.coureur_id = c.id
    JOIN equipe e ON c.equipe_id = e.id
    LEFT JOIN penalite p ON e.id = p.equipe_id AND ecou.id=p.etape_course_id
    GROUP BY c.id, ecou.id, ccc.categorie_coureur_id, c.genre, ec.arrivee, ecou.depart
)
SELECT tp.rang, tp.coureur_id, COALESCE(pr.point, 0) as point, tp.etape as etape, tp.categorie_coureur_id
    , tp.nom_coureur, tp.temps, tp.penalite_temps, tp.temps_final, tp.genre
    FROM temps_parcours tp
    LEFT JOIN point_rang pr ON tp.etape = pr.etape_course_id AND tp.rang = pr.rang
    ORDER BY tp.temps, tp.categorie_coureur_id, point

-- ** Classement generle tena izy
CREATE OR REPLACE VIEW v_classement_generale2 AS
WITH temps_parcours AS (
SELECT c.id as coureur_id, (ec.arrivee-ecou.depart)+COALESCE(sum(p.temps), '00:00:00') as temps_final, ecou.id as etape,
    (ec.arrivee-ecou.depart) as temps,
    DENSE_RANK() OVER (PARTITION BY ecou.id ORDER BY (ec.arrivee-ecou.depart)+COALESCE(sum(p.temps), '00:00:00')) AS rang, sum(p.temps) as penalite_temps,
    c.genre
    FROM etape_coureur ec
    JOIN coureur c ON ec.coureur_id = c.id
    JOIN etape_course ecou ON ec.etape_course_id = ecou.id
    JOIN equipe e ON c.equipe_id = e.id
    LEFT JOIN penalite p ON e.id = p.equipe_id AND ecou.id = p.etape_course_id
    GROUP BY c.id, ecou.id, c.genre, ec.arrivee, ecou.depart
)
SELECT tp.rang, tp.coureur_id, COALESCE(pr.point, 0) as point, tp.etape as etape, tp.genre,
    tp.temps, tp.penalite_temps, tp.temps_final
    FROM temps_parcours tp
    LEFT JOIN point_rang pr ON tp.etape = pr.etape_course_id AND tp.rang = pr.rang
    ORDER BY tp.temps

-- ** Equipe resultat par etape
SELECT sum(cl.point) as score, c.equipe_id, e.nom_equipe,
    cl.etape_course_id, ec.nom_etape
    FROM classement cl, coureur c, equipe e, etape_course ec
    WHERE c.id = cl.coureur_id AND c.equipe_id = e.id AND cl.etape_course_id = ec.id
    AND  e.nom_equipe = 'A'
    GROUP BY e.id, e.nom_equipe, c.equipe_id, cl.etape_course_id, ec.id
    ORDER BY score DESC
