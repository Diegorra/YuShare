-- Contraseña: 12345
INSERT INTO Usuario (id, userName, passwd, email, image, enabled, role)
VALUES (100, 'diego', '$2y$10$seKspBx5eZ32ThdWk5/PFuEZ3TvuoTxcjnJBvNnVHcO.qN3RXdDFW', 'die@ucm.es', 'images/defaultProfile.jpg', true, 'ADMIN_ROLE');

-- Contraseña: rafita
INSERT INTO Usuario (id, userName, passwd, email, image, enabled, role)
VALUES (101, 'rafa123', '$2y$10$bzXdIlWw4DxDwI3XD5U8beZ0pRGUuU99ig42VuJ.cHukDp./iad.q', 'rafa@ucm.es', 'images/defaultProfile.jpg', true, 'USER_ROLE');

--1 es no agregado (false), 0 es agregado (true)
INSERT INTO Amigo (idAmigo, nombreAmigo, agregado, idUsuario)
VALUES (101, 'rafa123', 1, 100);

INSERT INTO Pelicula (id, iduser, titulo, text, genero, src, numerototalLikes, trailer)
VALUES (1, 100, 'Clifford el gran perro rojo', 'El amor de una niña por su muñeco llamado Clifford hace que el perro crezca en tamaño.', 
	'Aventuras', 'images/peliculas/clifford.jpg', 100000, 
	'https://www.youtube.com/embed/GGpVvQiXIgI');
 
INSERT INTO Pelicula (id, iduser, titulo, text, genero, src, numerototalLikes, trailer)
VALUES (2, 101, 'Los vengadores: Era de Ultrón', 'Tony Stark quiere lanzar un nuevo programa de paz, pero algo sale mal y acaba creando a Ultrón, 
	un robot que quiere destruir a la humanidad. Thor, Hulk y el resto de los Vengadores deberán juntar sus fuerzas una vez más para luchar contra el robot.', 'Aventuras', 
	'images/peliculas/avengers.jpg', 23650, 'https://www.youtube.com/embed/NFNkK-gVms4');
 
INSERT INTO Pelicula (id, iduser, titulo, text, genero, src, numerototalLikes, trailer)
VALUES (3, 101, 'La vida es bella', 'Guido (Roberto Benigni) es un judío italiano que sueña con tener su propia librería. 
	Por eso, viaja a la ciudad de Arezzo, en la Toscana italiana y donde vive su tío, para instalarse allí. 
	Guido conoce a la maestra de escuela Dora (Nicoletta Braschi) y se enamora perdidamente de ella.', 
	'Drama', 'images/peliculas/vida.jpg', 25698, 'https://www.youtube.com/embed/e-Z062tRdbQ');
 
INSERT INTO Pelicula (id, iduser, titulo, text, genero, src, numerototalLikes, trailer)
VALUES (4, 100, 'IT', 'Cuando empiezan a desaparecer niños en el pueblo de Derry (Maine), 
	un pandilla de amigos lidia con sus mayores miedos al enfrentarse a un malvado payaso llamado Pennywise, 
	cuya historia de asesinatos y violencia data de siglos. Adaptación cinematográfica de la conocida novela de Stephen King It.', 
	'Terror', 'images/peliculas/it.jpg', 8563, 
	'https://www.youtube.com/embed/9jhtucvduSw');
 
INSERT INTO Pelicula (id, iduser, titulo, text, genero, src, numerototalLikes, trailer)
VALUES (5, 100, 'Way down', 'El brillante ingeniero Thom Johnson es reclutado para averiguar cómo acceder al interior del Banco de España. 
	El objetivo es robar un pequeño tesoro que va a estar depositado en el banco solo diez días.', 'Aventuras', 
	'images/peliculas/wayDown.jpg', 580, 'https://www.youtube.com/embed/MBkwxn1ogTI');
 
INSERT INTO Pelicula (id, iduser, titulo, text, genero, src, numerototalLikes, trailer)
VALUES (6, 100, 'Guardianes de la noche', 'Kimetsu no Yaiba, también conocida bajo su nombre en inglés Demon Slayer, 
	es una serie de manga escrita e ilustrada por Koyoharu Gotōge, cuya publicación comenzó el 15 de febrero de 2016 
	en la revista semanal Shūkan Shōnen Jump de la editorial Shūeisha.', 'Aventuras', 
	'images/peliculas/kimetsu.jpg', 26425, 'https://www.youtube.com/embed/ATJYac_dORw');
 
INSERT INTO Pelicula (id, iduser, titulo, text, genero, src, numerototalLikes, trailer)
VALUES (7, 100, 'Campeones', 'Marco es un entrenador profesional de baloncesto que tiene la obligación de entrenar a 
	un equipo compuesto por personas con discapacidad intelectual. Lo que comienza como un reto difícil se acabará convirtiendo
	en una lección de vida.', 'Comedia', 'images/peliculas/campeones.jpg', 9865,
	'https://www.youtube.com/embed/C0p5-b3YwIM');
 
INSERT INTO Pelicula (id, iduser, titulo, text, genero, src, numerototalLikes, trailer)
VALUES (8, 100, 'Mamma Mia!', 'Versión cinematográfica del popular musical de ABBA. Una joven (Amanda Seyfried) que 
	ha crecido en una pequeña isla griega, ha sido educada por una madre rebelde y poco convencional (Streep), 
	que siempre se ha negado a revelarle la identidad de su padre.', 'Musical', 
	'images/peliculas/mammamia.jpg', 
	80002, 'https://www.youtube.com/embed/shS-jtFOuHw');
 
INSERT INTO Pelicula (id, iduser, titulo, text, genero, src, numerototalLikes, trailer)
VALUES (9, 100, 'La guerra de las galaxias', 'La nave en la que viaja la princesa Leia es capturada por las tropas 
	imperiales al mando del temible Darth Vader. Antes de ser atrapada, Leia consigue introducir un mensaje en su robot R2-D2, 
	quien acompañado de su inseparable C-3PO logran escapar.', 'Aventuras',
	'images/peliculas/star_wars.jpg', 
	25361, 'https://www.youtube.com/embed/sDK0ca4zy-s');

INSERT INTO Pelicula (id, iduser, titulo, text, genero, src, numerototalLikes, trailer)
VALUES (10, 101, 'Uncharted', 'Nathan Drake y su compañero Victor Sullivan se adentran en la peligrosa búsqueda
 	del "mayor tesoro jamás encontrado". Al mismo tiempo, rastrean pistas que puedan conducir al hermano perdido de Drake.', 
	'Aventuras', 'images/peliculas/uncharted.jpg', 
	8652, 'https://www.youtube.com/embed/62bKO3LP6HA');

INSERT INTO Pelicula (id, iduser, titulo, text, genero, src, numerototalLikes, trailer)
VALUES (11, 100, 'Frozen', ' Una profecía condena al reino de Arandelle a vivir en un invierno eterno. 
	La joven Anna, el temerario montañero Kristoff y el reno Sven deben emprender un viaje épico y lleno de aventuras 
	en busca de Elsa, la hermana de Anna y Reina de las Nieves. Ella es la única que puede poner fin al gélido hechizo.',
	'Musical', 'images/peliculas/frozen.jpg', 
	30441, 'https://www.youtube.com/embed/SRRRrCNTVJA');


INSERT INTO Pelicula (id, iduser, titulo, text, genero, src, numerototalLikes, trailer)
VALUES (12, 101, 'Luca', 'En un hermoso pueblo en la Riviera italiana, Luca y Alberto disfrutan 
	del verano mientras intentan ocultar su gran secreto: ambos son monstruos marinos que 
	se convierten en humanos cuando están secos.', 'Aventuras', 'images/peliculas/luca.jpg', 
	6352, 'https://www.youtube.com/embed/mYfJxlgR2jw');