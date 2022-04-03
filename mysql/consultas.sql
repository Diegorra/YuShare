INSERT INTO Usuario (id, userName, passwd, email, image, enabled, role)
VALUES (100, 'gomez', 'patat@s', 'gomez@gmail.com', 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.contrareplica.mx%2Fnota-Inteligencia-artificial-da-la-posibilidad-de-ver-a-personas-que-no-existen201919220&psig=AOvVaw1IarMeF9Dwi7ZIDX-XV0vV&ust=1649069337287000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCJCdl5nc9_YCFQAAAAAdAAAAABAD', true, 'USER_ROLE');

INSERT INTO Usuario (id, userName, passwd, email, image, enabled, role)
VALUES (101, 'garcia', 'algodon', 'garcia@gmail.com', 'https://www.google.com/search?q=fotos+personas&source=lnms&tbm=isch&sa=X&ved=2ahUKEwiE9d2vyff2AhUG6RoKHXoUCn0Q_AUoAXoECAEQAw&biw=1280&bih=601&dpr=1.5#imgrc=rImC3JAHSU72HM', true, 'USER_ROLE');

ALTER TABLE Pelicula
ADD trailer VARCHAR(256) NOT NULL

INSERT INTO Pelicula (id, iduser, titulo, text, genero, año, src, numerototalLikes, trailer)
VALUES (1, 100, 'Clifford el gran perro rojo', 'El amor de una niña por su muñeco llamado Clifford hace que el perro crezca en tamaño.', 
	'Aventuras', '2021-12-03', 'https://pics.filmaffinity.com/Clifford_el_gran_perro_rojo-215673664-large.jpg', 100000, 
	'https://www.youtube.com/watch?v=GGpVvQiXIgI');
 
INSERT INTO Pelicula (id, iduser, titulo, text, genero, año, src, numerototalLikes, trailer)
VALUES (2, 101, 'los vengadores: era de Ultrón', 'Tony Stark quiere lanzar un nuevo programa de paz, pero algo sale mal y acaba creando a Ultrón, 
	un robot que quiere destruir a la humanidad. Thor, Hulk y el resto de los Vengadores deberán juntar sus fuerzas una vez más para luchar contra el robot.', 'Acción', '2015-04-29', 
	'https://pics.filmaffinity.com/Vengadores_La_era_de_Ultr_n-919656375-large.jpg', 23650, 'https://www.youtube.com/watch?v=NFNkK-gVms4');
 
INSERT INTO Pelicula (id, iduser, titulo, text, genero, año, src, numerototalLikes, trailer)
VALUES (3, 101, 'La vida es bella', 'Guido (Roberto Benigni) es un judío italiano que sueña con tener su propia librería. 
	Por eso, viaja a la ciudad de Arezzo, en la Toscana italiana y donde vive su tío, para instalarse allí. 
	Guido conoce a la maestra de escuela Dora (Nicoletta Braschi) y se enamora perdidamente de ella.', 
	'Drama', '1999-02-26', 'https://i.ytimg.com/vi/SXvRYwDgZjs/movieposter_en.jpg', 25698, 'https://www.youtube.com/watch?v=e-Z062tRdbQ');
 
INSERT INTO Pelicula (id, iduser, titulo, text, genero, año, src, numerototalLikes, trailer)
VALUES (4, 100, 'IT', 'Cuando empiezan a desaparecer niños en el pueblo de Derry (Maine), 
	un pandilla de amigos lidia con sus mayores miedos al enfrentarse a un malvado payaso llamado Pennywise, 
	cuya historia de asesinatos y violencia data de siglos. Adaptación cinematográfica de la conocida novela de Stephen King It.', 
	'Ciencia_Ficción', '2017-09-08', 'http://www.moviementarios.com/wp-content/uploads/2017/03/It-poster.jpg', 8563, 
	'https://www.youtube.com/watch?v=9jhtucvduSw');
 
INSERT INTO Pelicula (id, iduser, titulo, text, genero, año, src, numerototalLikes, trailer)
VALUES (5, 100, 'Way down', 'El brillante ingeniero Thom Johnson es reclutado para averiguar cómo acceder al interior del Banco de España. 
	El objetivo es robar un pequeño tesoro que va a estar depositado en el banco solo diez días.', 'Aventuras', '2021-11-12', 
	'https://pics.filmaffinity.com/Way_Down-682100158-large.jpg', 580, 'https://www.youtube.com/watch?v=MBkwxn1ogTI');
 
INSERT INTO Pelicula (id, iduser, titulo, text, genero, año, src, numerototalLikes, trailer)
VALUES (6, 100, 'Guardianes de la noche', 'Kimetsu no Yaiba, también conocida bajo su nombre en inglés Demon Slayer, 
	es una serie de manga escrita e ilustrada por Koyoharu Gotōge, cuya publicación comenzó el 15 de febrero de 2016 
	en la revista semanal Shūkan Shōnen Jump de la editorial Shūeisha.', 'Aventuras', '2020-10-16', 
	'https://ramenparados.com/wp-content/uploads/2021/04/guardianes-de-la-noche.jpg', 26425, 'https://www.youtube.com/watch?v=ATJYac_dORw');
 
INSERT INTO Pelicula (id, iduser, titulo, text, genero, año, src, numerototalLikes, trailer)
VALUES (7, 100, 'Campeones', 'Marco es un entrenador profesional de baloncesto que tiene la obligación de entrenar a 
	un equipo compuesto por personas con discapacidad intelectual. Lo que comienza como un reto difícil se acabará convirtiendo
	en una lección de vida.', 'Comedia', '2018-04-06', 'https://pics.filmaffinity.com/Campeones-981723931-large.jpg', 9865,
	'https://www.youtube.com/watch?v=C0p5-b3YwIM');
 
INSERT INTO Pelicula (id, iduser, titulo, text, genero, año, src, numerototalLikes, trailer)
VALUES (8, 100, 'Mamma Mia!', 'Versión cinematográfica del popular musical de ABBA. Una joven (Amanda Seyfried) que 
	ha crecido en una pequeña isla griega, ha sido educada por una madre rebelde y poco convencional (Streep), 
	que siempre se ha negado a revelarle la identidad de su padre.', 'Musical', '2008-08-13', 
	'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.filmaffinity.com%2Fes%2Ffilm336014.html&psig=AOvVaw0rlU8RrwkeGlaGxOTghGYq&ust=1649066347023000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKis5ILR9_YCFQAAAAAdAAAAABAD', 
	80002, 'https://www.youtube.com/watch?v=shS-jtFOuHw');
 
INSERT INTO Pelicula (id, iduser, titulo, text, genero, año, src, numerototalLikes, trailer)
VALUES (9, 100, 'La guerra de las galaxias', 'La nave en la que viaja la princesa Leia es capturada por las tropas 
	imperiales al mando del temible Darth Vader. Antes de ser atrapada, Leia consigue introducir un mensaje en su robot R2-D2, 
	quien acompañado de su inseparable C-3PO logran escapar.', 'Ciencia_Ficción', '1977-11-07',
	 'https://www.alohacriticon.com/wp-content/uploads/2003/07/star-wars-la-guerra-de-las-galaxias-cartel.jpg', 
	 25361, 'https://www.youtube.com/watch?v=sDK0ca4zy-s');

INSERT INTO Pelicula (id, iduser, titulo, text, genero, año, src, numerototalLikes, trailer)
VALUES (10, 101, 'Uncharted', 'Nathan Drake y su compañero Victor Sullivan se adentran en la peligrosa búsqueda
 	del "mayor tesoro jamás encontrado". Al mismo tiempo, rastrean pistas que puedan conducir al hermano perdido de Drake.', 
	'Acción', '2022-02-11','https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.filmaffinity.com%2Fes%2Ffilm748908.html&psig=AOvVaw3qd9DEApWoxEKv_e4P4fzW&ust=1649066710706000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCJj3m7DS9_YCFQAAAAAdAAAAABAD', 
	8652, 'https://www.youtube.com/watch?v=sDK0ca4zy-s');

INSERT INTO Pelicula (id, iduser, titulo, text, genero, año, src, numerototalLikes, trailer)
VALUES (11, 100, 'Frozen', ' Una profecía condena al reino de Arandelle a vivir en un invierno eterno. 
	La joven Anna, el temerario montañero Kristoff y el reno Sven deben emprender un viaje épico y lleno de aventuras 
	en busca de Elsa, la hermana de Anna y Reina de las Nieves. Ella es la única que puede poner fin al gélido hechizo.',
	'Musical', '2013-11-29','https://www.google.com/url?sa=i&url=https%3A%2F%2Fdisney.fandom.com%2Fes%2Fwiki%2FFrozen_2&psig=AOvVaw13e5GQIORvVnW9lF5ScSkc&ust=1649066524380000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCOi4xtfR9_YCFQAAAAAdAAAAABAD', 
	30441, 'https://www.youtube.com/watch?v=SRRRrCNTVJA');


INSERT INTO Pelicula (id, iduser, titulo, text, genero, año, src, numerototalLikes, trailer)
VALUES (12, 101, 'Luca', 'En un hermoso pueblo en la Riviera italiana, Luca y Alberto disfrutan 
	del verano mientras intentan ocultar su gran secreto: ambos son monstruos marinos que 
	se convierten en humanos cuando están secos.', 'Aventuras', '2021-06-18',' https://pics.filmaffinity.com/Luca-907827591-large.jpg', 
	6352, 'https://www.youtube.com/watch?v=mYfJxlgR2jw');