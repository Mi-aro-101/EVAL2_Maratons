INSERT INTO client (id, telephone, roles) values(nextval('client_id_seq'), '0345555555', '["ROLE_CLIENT"]');
INSERT INTO client (id, telephone, roles) values(nextval('client_id_seq'), '0387777777', '["ROLE_CLIENT"]');

INSERT INTO type_maison (id, designation) values
    (nextval('type_maison_id_seq'), 'Contemporaine', 'T5 : 3 chambres + 2 living + 2 salles de bain + 1 terasse'),
    (nextval('type_maison_id_seq'), 'Traditionnelle', 'T3: 2 chambres + 1 living + 1 salle de bain'),
    (nextval('type_maison_id_seq'), 'Moderne', 'T4: 3 chambres + 1 living + 1 salle de bain + 1 jardin + 1 garage');

INSERT INTO type_finition (id, designation, pourcentage) values
    (nextval('type_finition_id_seq'), 'Gold', 15.00),
    (nextval('type_finition_id_seq'), 'Premium', 20.00),
    (nextval('type_finition_id_seq'), 'VIP', 35.50);

INSERT INTO type_travaux (id, designation, code) values
    (nextval('type_travaux_id_seq'), 'Travaux preparatoire', '000'),
    (nextval('type_travaux_id_seq'), 'Travaux de terrassement', '100'),
    (nextval('type_travaux_id_seq'), 'Travaux en infrastructure', '200');

INSERT INTO unite (id, designation, abreviation) values
    (nextval('unite_id_seq'), 'Metre carre','m2'),
    (nextval('unite_id_seq'), 'Mettre cube','m3'),
    (nextval('unite_id_seq'), 'Hauteur d''Étage à Étage','fft');

INSERT INTO travaux (id, type_travaux_id, unite_id, description, prix_unitaire, code) values
    (nextval('travaux_id_seq'), 1, 2, 'Mur de soutennement et demi clouture', 190000.00, '000'),
    (nextval('travaux_id_seq'), 2, 1, 'Dressage du plateforme', 3736.26, '102'),
    (nextval('travaux_id_seq'), 2, 2, 'Fouille d''ouvrage terrain ferme', 9390.93, '103'),
    (nextval('travaux_id_seq'), 2, 2, 'Rembai d''ouvrage', 37363.26, '104'),
    (nextval('travaux_id_seq'), 2, 3, 'Travaux d''implatation', 152656.00, '105'),
    (nextval('travaux_id_seq'), 2, 1, 'Decapage des terrains meubles', 3072.87, '101'),
    (nextval('travaux_id_seq'), 3, 2, 'Remblai technique', 37363.26, '203'),
    (nextval('travaux_id_seq'), 3, 2, 'Chape de 2cm', 33566.54, '206'),
    (nextval('travaux_id_seq'), 3, 2, 'herissonage', 73245.40, '204'),
    (nextval('travaux_id_seq'), 3, 2, 'Remblai technique', 37363.26, '203');

INSERT INTO travaux_maison (id, type_maison_id, travaux_id, quantite, duree) values
    (nextval('travaux_maison_id_seq'), 1, 1, 26.98, 14),
    (nextval('travaux_maison_id_seq'), 1, 2, 101.36, 22),
    (nextval('travaux_maison_id_seq'), 1, 3, 24.44, 7),
    (nextval('travaux_maison_id_seq'), 1, 4, 15.59, 25),
    (nextval('travaux_maison_id_seq'), 1, 7, 15.59, 19),
    (nextval('travaux_maison_id_seq'), 1, 8, 77.97, 15),
    (nextval('travaux_maison_id_seq'), 2, 1, 20.98, 11),
    (nextval('travaux_maison_id_seq'), 2, 6, 101.36, 5),
    (nextval('travaux_maison_id_seq'), 2, 5, 1, 15),
    (nextval('travaux_maison_id_seq'), 2, 9, 7.8, 1),
    (nextval('travaux_maison_id_seq'), 2, 9, 7.8, 1),
    (nextval('travaux_maison_id_seq'), 3, 1, 35.33, 20),
    (nextval('travaux_maison_id_seq'), 3, 3, 24.44, 7),
    (nextval('travaux_maison_id_seq'), 3, 4, 15.59, 25),
    (nextval('travaux_maison_id_seq'), 3, 5, 2, 21),
    (nextval('travaux_maison_id_seq'), 3, 7, 15.59, 19),
    (nextval('travaux_maison_id_seq'), 3, 8, 100, 20);
