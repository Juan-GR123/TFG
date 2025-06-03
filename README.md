# 🎬 Roll&Play - Videoclub Online

Proyecto de desarrollo web para un videoclub con funcionalidades de gestión, compra y alquiler de películas. Este proyecto ha sido realizado como parte de un Trabajo de Fin de Grado (TFG), sin ánimo de lucro.

---

## Índice

- 0.[Documentación](#documentacion)
- 1.[Tecnologías utilizadas](#tecnologías-utilizadas)
- 2.[Requisitos hardware y software](#requisitos-hardware-y-software)
- 3.[Implementación](#implementación)
- 4.[Evaluación y pruebas](#evaluación-y-pruebas)
- 5.[Dispositivos y vistas](#dispositivos-y-vistas)
- 6.[Mapa de colores](#mapa-de-colores)
- 7.[Accesibilidad y usabilidad](#accesibilidad-y-usabilidad)
- 8.[Licencias y Copyright](#licencias-y-copyright)

---
## Documentacion
- [Documentacion extensa](https://github.com/Juan-GR123/TFG/blob/main/Documentacion/Documentaci%C3%B3n%20del%20Proyecto.pdf)

1. Instalación
    - Para ejecutar el proyecto localmente, es necesario tener instalado PHP, XAMPP y Composer. A continuación se detallan los pasos para la instalación y configuración del entorno de desarrollo:

        - Descargar e instalar XAMPP en el sistema operativo.
        - Descargar el proyecto y descomprimirlo dentro de la carpeta htdocs de XAMPP para poder visualizarlo bien.
        - Descargar e instalar Composer en el sistema operativo.
        - Abrir una terminal y navegar hasta la carpeta del proyecto descomprimido en htdocs.
        - Ejecutar el siguiente comando para instalar las dependencias del proyecto:
            - composer install
        - Crear una base de datos en MySQL con el nombre roll_play e importar el script roll_play.sql que se encuentra en la carpeta database del proyecto. Este script crea las tablas necesarias para el funcionamiento del proyecto.
        - Configurar el archivo .env con los datos de conexión a la base de datos, las credenciales de correo electrónico y las credenciales de PayPal. Lo unico que tendrias que hacer sería copiar el archivo .env-example en tu archivo .env.
        - Iniciar el servidor Apache y MySQL desde el panel de control de XAMPP.
        -  Ejecutar en la terminal de la raiz del proyecto los siguientes comandos:
            - Bash: npm run dev
            - powershell: php artisan serve
        - Abrir un navegador web y pulsar en el enlace que debede aparecer despues de ejecutar el comando de php artisan serve.

2. Uso remoto:  Servidor Web
    - La aplicación web está alojada en un servidor remoto. Para acceder a la aplicación, se puede utilizar el siguiente enlace:
        - [Roll&Play](https://rollplay.infinityfreeapp.com/)


## Tecnologías utilizadas

- **Backend:** Laravel (PHP), MySQL
- **Frontend:** Blade, React, TailwindCSS, JavaScript
- **Iconografía:** React Icons
- **Animaciones:** Framer Motion
- **Gestión de fechas:** Carbon

---

## Requisitos Hardware y Software

**Cliente:**

- Navegador moderno compatible con JavaScript ES6
- Resolución mínima: 320px (responsive)

**Servidor:**

- PHP 8.x
- Composer
- MySQL/MariaDB
- Node.js y npm (para assets frontend)
- Servidor Apache

---

## Implementación

- **Estilos:** TailwindCSS
- **Plantillas:** Blade + componentes React integrados
- **Envío de datos:** uso de estados en React con `useState`, y paso de datos desde Blade mediante `window.appData`
- **Conexión y consultas:** ORM Eloquent de Laravel para la manipulación de base de datos
- **Ficheros de configuración:** `.env` para variables de entorno (DB, rutas, etc.)

---

## Evaluación y pruebas

- Pruebas manuales realizadas en diferentes navegadores y dispositivos
- Comprobación de validaciones en formularios
- Feedback al usuario ante errores o acciones correctas
- Verificación de rutas, autenticación y persistencia de sesiones
- Se ha utilizado un conjunto variado de pruebas funcionales para cubrir los principales casos de uso

---

## Dispositivos y vistas

El proyecto ha sido diseñado con un enfoque **responsive**:

- **Ordenadores de escritorio**
- **Tablets**
- **Dispositivos móviles**

Gracias a TailwindCSS y eventos, se ajustan las vistas automáticamente.

---

## Mapa de colores

| Elemento             | Color HEX | RGB              | Nombre Aproximado |
|----------------------|-----------|------------------|-------------------|
| Fondo general        | `#000000` | `rgb(0, 0, 0)`    | Negro             |
| Texto principal      | `#FFFFFF` | `rgb(255, 255, 255)` | Blanco         |
| Párrafos destacados  | `#B89676` | `rgb(184, 150, 118)` | Arena clara    |
| Tarjetas             | `#707070` | `rgb(112, 112, 112)` | Gris medio     |
| Botón de búsqueda    | `#2563EB` | `rgb(37, 99, 235)` | Azul (Tailwind Blue 600) |
| Tarjetas aterrizaje   | `#6540E9` | `rgb(100, 80, 233) `| Morado        |

---

## Accesibilidad y usabilidad

- Uso de contrastes adecuados en los textos
- Navegación por teclado posible
- Botones e iconos con títulos y estados visibles
- Diseño intuitivo, minimalista y adaptado a usuarios finales
- Feedback inmediato en acciones importantes (mensajes, redirecciones, errores)

---

## Licencias y Copyright

Este proyecto se ha desarrollado exclusivamente con fines educativos como parte de un **Trabajo de Fin de Grado**, sin fines comerciales.

- **Contenido multimedia:** Las imágenes, vídeos y películas utilizadas pertenecen a sus respectivos autores. Se han incluido únicamente para ilustración y pruebas.
- **Software:** Todas las herramientas y librerías utilizadas (Laravel, React, TailwindCSS, etc.) se han empleado respetando sus licencias de uso.
- **Código propio:** Bajo licencia libre para uso académico o demostrativo.

---

