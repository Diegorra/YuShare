-- informacion usuario a partir del email intoducido
SELECT * FROM usuario WHERE email = $email

--Busqueda pelis por titulo
SELECT * FROM pelicula WHERE titulo LIKE $titulo

--Busqueda avanzada de peliculas (Nomrbre autor, genero, año)
SELECT * FROM pelicula WHERE titulo LIKE $titulo OR nombe LIKE $nombre OR genero LIKE $genero OR año LIKE $año

--Busqueda de usuario (filtrar por amigos)
SELECT * FROM usuario A JOIN amigo B WHERE A.name LIKE $name AND B.iduser1 = $id

--comentarios de una pelicula
SELECT * FROM comentario WHERE idpubli = $idpelicula

--Peliculas con mas likes (por semana, mes, año)
SELECT * FROM pelicula ORDER BY numerototalLikes

--Msgs mas recientes del user Ordenados
--{AÑADIR FECHA y hora}
SELECT * FROM chat WHERE id1 = $id ORDER BY tiempo
SELECT * FROM mensaje WHERE $idChat = idChat ORDER BY tiempo

-- Lista de amigos
SELECT * FROM amigo WHERE idUser1 = $id

--Peliculas likeadas y comentadas
SELECT * FROM likes WHERE idUser = $id
SELECT * FROM comentario WHERE idUser = $id
--{CREAR TABLA LIKES: idUser - idpelicula}