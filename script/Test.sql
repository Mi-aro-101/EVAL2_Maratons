-- Get duree de construction de maison (Base non update J2)
SELECT sum(tm.duree)
    FROM travaux_maison tm, travaux t WHERE tm.travaux_id = t.id
    AND tm.type_maison_id=3
    GROUP BY tm.type_maison_id

-- Get devis along paiement pourcentage effectue
SELECT d.*, (sum(p.montant)*100)/d.prix pourcentage_paye
    FROM paiement p, devis d WHERE p.devis_id = d.id
    group by d.id

-- 1 => Get all devis from a year (ref : date de demande)
-- @param 'year' = 2024
SELECT d.*
    FROM devis d
    WHERE extract('year' from d.date_devis) = 2024

-- 2 => Select mois (Group by), somme(d.prix) 
SELECT extract('month' from d.date_devis) as mois, sum(d.prix) as total_devis
    FROM devis d
    WHERE extract('year' from d.date_devis) = 2024
    group by extract('month' from d.date_devis)