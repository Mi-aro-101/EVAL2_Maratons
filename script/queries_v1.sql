-- SELECT (arrivee-ecs.depart) as temps, c.nom_coureur
--     FROM etape_coureur ecr, etape_course ecs, coureur c
--     WHERE ecr.etape_course_id=ecs.id AND ecr.coureur_id=c.id
--     AND ecs.id = 1
--     ORDER BY temps;

-- ** Obtenir classement % temps de parcours de chaque coureur
CREATE OR REPLACE VIEW v_classement AS
SELECT ROW_NUMBER() OVER (ORDER BY arrivee-ecs.depart) as rang_result, (arrivee-ecs.depart) as temps, c.nom_coureur, ecs.id as id_etape
    FROM etape_coureur ecr, etape_course ecs, coureur c
    WHERE ecr.etape_course_id=ecs.id AND ecr.coureur_id=c.id
    ORDER BY temps;

-- ** Obtenir le classement et leur point
SELECT vc.*, pr.rang, COALESCE(pr.point,0) as point
    FROM v_classement vc, point_rang pr
    WHERE vc.rang_result=pr.rang AND pr.etape_course_id=vc.id_etape
    AND id_etape = 103