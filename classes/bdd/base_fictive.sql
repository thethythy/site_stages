-- Couleurs --

INSERT INTO `couleur` (`idcouleur`, `nomcouleur`, `codehexa`)
VALUES
('1', 'Cyan', '40A497'),
('2', 'Rouge', 'FD0000'),
('3', 'Vert', '00A421');

-- CRÉATION D'ÉTUDIANTS --

INSERT INTO `etudiant`
(`idetudiant`, `nometudiant`, `prenometudiant`, `email_institutionnel`, `email_personnel`, `codeetudiant`)
VALUES
('1', 'fernandes', 'simon', 'machin@gmail.com', NULL, '20121552'),
('2', 'combasteix', 'benoit', 'truc@gmail.com', NULL, '27112018'),
('3', 'larmignat', 'thomas', 'bidule@gmail.com', NULL, '81021172');

-- Création de filières --

INSERT INTO `filiere` (`idfiliere`, `nomfiliere`, `temps_soutenance`, `affDepot`)
VALUES
('1', 'Master informatique 1', '20', '1'),
('2', 'Master informatique 2', '20', '1');

-- Type entreprise --
