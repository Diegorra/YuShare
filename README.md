# README #

La aplicación consiste en una red social para los amantes del cine. En esta red social los usuarios podrán publicar películas y cortometrajes. Dichas películas podrán ser vistas por los demás usuarios los cuales podrán comentarlas y valorarlas. Los usuarios además de ver películas, poder comentar y valorar podrán hacer amigos para ver sus perfiles y tendrán un sistema de búsquedas para descubrir nuevos amigos o nuevas películas.


Para poder utilizar el proyecto, debes:

1. Crear una base de datos y un usuario con privilegios sobre la BD. A través de phpmyadmin es posible crear un usuario
y una base de datos con el mismo nombre y donde el usuario tiene todos los privilegios.

2. Importar los archivos sql ```estructura.sql``` que creará la BD y las tablas
vacías y ```datos.sql``` que importará unos datos de ejemplo. Consulta este último .sql para averiguar los usuarios que
están definidos en la aplicación y los roles que tienen. Recuerda que *debes deshabilitar la opción "Enable foreign key
checks"* para evitar problemas a la hora de importar los archivos.

3. Si colocas la carpeta del proyecto directamente dentro del directorio htdocs de Apache (o el que apunte la directiva
DocumentRoot) no tienes que hacer nada más. *Si colocas el proyecto en otras carpeta* tendrás que cambiar la constante
```RUTA_APP``` para que apunte a la URL donde está colgada la aplicación. Por ejemplo si la URL con la que accedes a la
aplicación es ```http://localhost/ejemplos/estructura-proyecto/``` la constante debe tomar el valor
```define('RUTA_APP', '/ejemplos/estructura-proyecto/');```
