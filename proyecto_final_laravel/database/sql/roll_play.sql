-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-06-2025 a las 19:59:05
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `roll_play`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Fantasia', NULL, NULL),
(2, 'Misterio', NULL, NULL),
(3, 'Ciencia Ficción', NULL, NULL),
(4, 'Super Heroes', NULL, NULL),
(5, 'Comedia', NULL, NULL),
(6, 'Drama', NULL, NULL),
(7, 'Acción', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas_pedidos`
--

CREATE TABLE `lineas_pedidos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pedido_id` bigint(20) UNSIGNED NOT NULL,
  `producto_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `lineas_pedidos`
--

INSERT INTO `lineas_pedidos` (`id`, `pedido_id`, `producto_id`, `created_at`, `updated_at`) VALUES
(34, 31, 4, NULL, NULL),
(35, 32, 6, NULL, NULL),
(36, 32, 2, NULL, NULL),
(37, 33, 3, NULL, NULL),
(44, 40, 4, NULL, NULL),
(46, 42, 7, NULL, NULL),
(51, 45, 2, NULL, NULL),
(64, 56, 20, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(33, '0001_01_01_000000_create_users_table', 1),
(34, '0001_01_01_000001_create_cache_table', 1),
(35, '0001_01_01_000002_create_jobs_table', 1),
(36, '2025_04_08_150450_create_usuarios_table', 1),
(37, '2025_04_08_150453_create_categorias_table', 1),
(38, '2025_04_08_150454_create_productos_table', 1),
(39, '2025_04_08_150548_create_pedidos_table', 1),
(40, '2025_04_08_150549_create_lineas_pedidos_table', 1),
(41, '2025_04_17_113635_add_trailer_to_productos_table', 1),
(42, '2025_04_17_113926_add_pelicula_to_productos_table', 1),
(43, '2025_04_25_172941_add_reparto_to_productos_table', 2),
(44, '2025_04_30_142456_create_opiniones_table', 3),
(45, '2025_04_30_142658_add_valoracion_comentario_to_productos', 4),
(46, '2025_05_05_110621_add_token_confirmacion_to_usuarios_table', 5),
(47, '2025_05_19_175902_add_confirmation_fields_to_usuarios_table', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `provincia` varchar(100) NOT NULL,
  `localidad` varchar(100) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `coste` double NOT NULL,
  `estado` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `tiempo_alquiler` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `usuario_id`, `provincia`, `localidad`, `direccion`, `coste`, `estado`, `fecha`, `hora`, `tiempo_alquiler`, `created_at`, `updated_at`) VALUES
(31, 11, 'Madrid', 'Madrid', 'Gran via', 10, 'pagado', '2025-04-29', '13:02:40', '1', NULL, NULL),
(32, 2, 'Malaga', 'Malaga', 'Caminito del rey', 40, 'pagado', '2025-04-29', '13:13:49', '2', NULL, NULL),
(33, 1, 'Granada', 'Granada', 'Gran via', 10, 'pagado', '2025-05-05', '06:58:27', '1', NULL, NULL),
(40, 21, 'Castilla', 'La mancha', 'En algun pueblo', 10, 'pagado', '2025-05-05', '13:07:56', '1', NULL, NULL),
(42, 10, 'Granada', 'Granada', 'algun sitio', 10, 'pagado', '2025-05-06', '11:42:49', '1', NULL, NULL),
(45, 1, 'pep', 'pep', 'fdasasd', 20, 'pagado', '2025-05-16', '19:07:24', '1', NULL, NULL),
(56, 1, 'prueba', 'prueba', 'Caminito del rey', 10, 'pagado', '2025-05-25', '17:49:06', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `categoria_id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha` date NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `trailer` varchar(255) DEFAULT NULL,
  `pelicula` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `reparto` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `categoria_id`, `nombre`, `descripcion`, `fecha`, `imagen`, `trailer`, `pelicula`, `created_at`, `updated_at`, `reparto`) VALUES
(1, 4, 'Spiderman Homecoming', 'Peter Parker comienza a experimentar su recién descubierta identidad como Spiderman. Tras su experiencia con los Vengadores, regresa a vivir con su tía. Pero su rutina se ve interrumpida al surgir un nuevo y despiadado villano, el Buitre, que amenaza lo más importante en la vida de Peter.', '2017-06-03', 'spiderman.jpg', 'https://www.youtube.com/watch?v=rk-dF1lIbIg', 'https://www.youtube.com/watch?v=rk-dF1lIbIg', NULL, NULL, 'Dirección: Jon Watts\r\nProducción: Kevin Feige, Amy Pascal\r\nGuion: Jonathan Goldstein, John Francis Daley, Jon Watts, Christopher Ford, Chris McKenna, Erik Sommers\r\nHistoria: Jonathan Goldstein, John Francis Daley\r\nBasada en: Spider-Man de Stan Lee, Steve Ditko\r\nMúsica: Michael Giacchino\r\nFotografía: Salvatore Totino\r\nMontaje: Dan Lebental\r\nVestuario: Louise Frogley\r\nProtagonistas: Tom Holland, Michael Keaton, Jacob Batalon, Laura Harrier, Zendaya, Bokeem Woodbine, Donald Glover, Logan Marshall-Green, Martin Starr, Tony Revolori, Jon Favreau, Marisa Tomei, Robert Downey Jr.'),
(2, 4, 'Hellboy (2004)', 'Finales de la Segunda Guerra Mundial. Por medio de la magia negra, los nazis conjuran al demonio Hellboy, que crece entre los aliados hasta convertirse en adulto, actuando como agente de la oficina de defensa e investigación paranormal.', '2004-10-01', 'gLgsIcpWu3i7XHKVZGjGRQTEVwEYumSiTuAOepDg.jpg', 'https://www.youtube.com/watch?v=kA9vtXbbhVs', 'https://www.youtube.com/watch?v=kA9vtXbbhVs', NULL, NULL, 'Dirección: Guillermo del Toro\r\nAyudante de dirección: J. Michael Haynie\r\nDirección artística: Simon Lamont\r\nProducción: Lawrence Gordon, Lloyd Levin, Mike Richardson\r\nDiseño de producción: Stephen Scott\r\nGuion: Guillermo del Toro\r\nHistoria: Guillermo del Toro, Peter Briggs\r\nBasada en: Hellboy: Seed of Destruction de Mike Mignola\r\nMúsica: Marco Beltrami\r\nSonido: Steve Boeddeker, Frank E. Eulner, Michael Semanick, Robert Shoup\r\nMaquillaje: Roland Blancaflor, Mike Elizalde, Jeanette Freeman, Matt Rose, Bill Sturgeon\r\nFotografía: Guillermo Navarro\r\nMontaje: Peter Amundson\r\nEscenografía: Hilton Rosemarin\r\nVestuario: Wendy Partridge\r\nEfectos especiales: Everett Burrell, Blair Clark, Kent Demaine, John F. Gross, Kevin Kutchaver\r\nProtagonistas: Ron Perlman, John Hurt, Selma Blair, Doug Jones, Rupert Evans'),
(3, 3, 'Star wars iv', 'La nave en la que viaja la princesa Leia es capturada por las tropas imperiales al mando del temible Darth Vader. Antes de ser atrapada, Leia consigue introducir un mensaje en su robot R2-D2, quien acompañado de su inseparable C-3PO logran escapar. Tras aterrizar en el planeta Tattooine son capturados y vendidos al joven Luke Skywalker, quien descubrirá el mensaje oculto que va destinado a Obi Wan Kenobi, maestro Jedi a quien Luke debe encontrar para salvar a la princesa.', '1977-05-25', '32gADWx2r07MybceFBJSgktzfI8H3Q64CYukaV4J.jpg', 'https://www.youtube.com/watch?v=beAH5vea99k', 'https://www.youtube.com/watch?v=beAH5vea99k', NULL, NULL, 'Dirección: George Lucas\r\nProducción: Gary Kurtz, George Lucas, Rick McCallum (edición especial)\r\nGuion: George Lucas\r\nMúsica	: John Williams\r\nFotografía: Gilbert Taylor\r\nMontaje: Richard Chew, T.M. Christopher (edición especial), Paul Hirsch, Marcia Lucas\r\nVestuario: John Mollo\r\nProtagonistas: Mark Hamill, Harrison Ford, Carrie Fisher †, Peter Cushing †, Alec Guinness †, Anthony Daniels, Kenny Baker †, Peter Mayhew †, David Prowse †, Jack Purvis †, Eddie Byrne †, James Earl Jones †'),
(4, 5, 'La vida de brian', 'Durante la época bíblica, un hombre parece ser el Mesías y se ve puesto como líder de un movimiento religioso. Su vida estará marcada por su castrante madre, sus nuevos amigos del Frente Popular de Judea y su novia feminista.', '1980-10-10', 'la_vide_de_brian.jpg', 'https://www.youtube.com/watch?v=tAJNdyC5n14', 'https://www.youtube.com/watch?v=tAJNdyC5n14', NULL, NULL, 'Dirección: Terry Jones\r\nProducción: John Goldstone, George Harrison (productor ejecutivo)\r\nGuion: Graham Chapman, John Cleese, Terry Gilliam, Eric Idle, Terry Jones, Michael Palin\r\nMúsica: Geoffrey Burgon\r\nFotografía: Peter Biziou\r\nMontaje: Julian Doyle\r\nProtagonistas: John Cleese, Graham Chapman, Terry Gilliam, Terry Jones, Michael Palin, Eric Idle, Terence Bayler, Sue Jones-Davies'),
(5, 6, 'Anyone but you', 'A pesar de una primera cita increíble, la atracción inicial de Bea y Ben se agria rápidamente. Sin embargo, cuando inesperadamente se encuentran en una boda de destino en Australia, fingen ser la pareja perfecta para mantener las apariencias.', '2023-12-25', 'anyone-but-you.jpg', 'https://www.youtube.com/watch?v=UtjH6Sk7Gxs', 'https://www.youtube.com/watch?v=UtjH6Sk7Gxs', NULL, NULL, 'Dirección: Will Gluck\r\nProducción: Jeff Kirschenbaum, Joe Roth\r\nGuion: Will Gluck\r\nBasada en: Mucho ruido y pocas nueces de William Shakespeare\r\nMúsica: Este Haim, Bag Raiders\r\nMontaje: Tia Nolan\r\nProtagonistas: Sydney Sweeney, Glen Powell, Alexandra Shipp, Michelle Hurd, Bryan Brown, Darren Barnet, Hadley Robinson, Dermot Mulroney, Rachel Griffiths, GaTa, Charlee Fraser'),
(6, 4, 'Batman Begins', 'Bruce Wayne vive obsesionado con el recuerdo de la muerte de sus padres. Atormentado, se va de Gotham y encuentra a un extraño personaje que lo entrena en todas las disciplinas físicas y mentales que le servirán para combatir el Mal.', '2005-06-17', 'Batman-Begins.jpg', 'https://www.youtube.com/watch?v=FiL1_5DWV7Y', 'https://www.youtube.com/watch?v=FiL1_5DWV7Y', NULL, NULL, 'Dirección: Christopher Nolan\r\nAyudante de dirección: Ben Lanning, Cliff Lanning\r\nDirección artística: Peter Francis, Paul Kirby, Dominic Masters, Su Withaker\r\nProducción: Emma Thomas, Charles Roven, Larry Franco\r\nDiseño de producción: Nathan Crowley\r\nGuion: Christopher Nolan, David S. Goyer\r\nHistoria: David S. Goyer\r\nBasada en: Batman de Bob Kane y Bill Finger\r\nMúsica: Hans Zimmer, James Newton Howard\r\nSonido: Rodney Berling\r\nMaquillaje: Laura McIntosh\r\nFotografía: Wally Pfister\r\nMontaje: Lee Smith\r\nEscenografía: Andrew Eric Hodgson\r\nVestuario: Lindy Hemming\r\nEfectos especiales: Bruce Armstrong\r\nProtagonistas: Christian Bale, Michael Caine, Liam Neeson, Katie Holmes, Gary Oldman, Cillian Murphy, Tom Wilkinson, Rutger Hauer, Ken Watanabe, Mark Boone Junior, Linus Roache, Morgan Freeman'),
(7, 4, 'Thunderbolts', 'Thunderbolts*​ es una película de superhéroes estadounidense basada en el equipo de Marvel Comics los Thunderbolts. Producida por Marvel Studios y distribuida por Walt Disney Studios Motion Pictures, esta es la película número 36 del Universo cinematográfico de Marvel.', '2025-05-02', 'thunder.jpg', 'https://www.youtube.com/watch?v=M37eYEL8I5M', 'https://www.youtube.com/watch?v=M37eYEL8I5M', NULL, NULL, 'Dirección	Jake Schreier\r\nProducción	Kevin Feige\r\nGuion	Eric Pearson, Lee Sung Jin, Joanna Calo\r\nBasada en Thunderbolts  de Kurt Busiek, Mark Bagley\r\nMúsica	 Son Lux\r\nFotografía	Andrew Droz Palermo\r\nMontaje Harry Yoon, Angela M. Catanzaro\r\nProtagonistas	Florence Pugh, Sebastian Stan, Wyatt Russell, Olga Kurylenko, Lewis Pullman, Geraldine Viswanathan, David Harbour, Hannah John-Kamen y Julia Louis-Dreyfus'),
(11, 3, 'Interestellar', 'Un grupo de científicos y exploradores, encabezados por Cooper, se embarcan en un viaje espacial para encontrar un lugar con las condiciones necesarias para reemplazar a la Tierra y comenzar una nueva vida allí. La Tierra está llegando a su fin y este grupo necesita encontrar un planeta más allá de nuestra galaxia que garantice el futuro de la raza humana.', '2025-05-15', 'interestellar.jpg', 'https://www.youtube.com/watch?v=UoSSbmD9vqc', 'https://www.youtube.com/watch?v=UoSSbmD9vqc', NULL, NULL, NULL),
(20, 7, 'Spirit', 'En el lejano Oeste, Spirit es un mustang salvaje que cabalga por las praderas. Pero todo cambia cuando los hombres se cruzan en su camino.', '2002-07-17', 'spirit.jpg', 'https://www.youtube.com/watch?v=P5UPFnGW384', 'Spirit nueva.mp4', NULL, NULL, 'Dirección: Kelly Asbury, Lorna Cook\r\nProducción: Mireille Soria, Jeffrey Katzenberg\r\nGuion: John Fusco\r\nMúsica: Hans Zimmer\r\nMontaje: Nick Fletcher, Clare De Chenu\r\nNarrador: Matt Damon\r\nProtagonistas: Matt Damon (Spirit), James Cromwell (Coronel), Daniel Studi (Pequeño Arroyo), Chopper Bernet (Sargento Adams), Jeff LeBeau (Murphy / Railroad Foreman), John Rubano (Soldado), Rihard McGonagle (Bill), Matt Levin (Joe), Adam Paul (Pete), Robert Cait (Jake), Charles Napier (Roy), Meredith Wells (Niña lakota)'),
(21, 5, 'corto animado de pixar', 'Esto es un corto animado de pixar', '2025-05-31', 'Day_and_Night_poster.jpg', 'día y noche (corto pixar).mp4', 'día y noche (corto pixar).mp4', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('zwfqfbtmSSUmcYpKdinfbsSitwp92gBsxEQV7eCv', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWUhCZ3RqZW5KVnFJNkNQYko1ckpuU1lPdXJiRXhlaEIwMzV2b0ZHYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9kdWN0by9pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1748800694);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `rol` varchar(20) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `token_confirmacion` varchar(60) DEFAULT NULL,
  `email_confirmado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `email`, `password`, `rol`, `imagen`, `created_at`, `updated_at`, `token_confirmacion`, `email_confirmado`) VALUES
(1, 'Nuevo2', 'algo', 'nuevo@nuevo.com', '$2y$12$JgEC5pgtfVV2zJpEQflsEOhw5JT3KYSXqmQHT7GNsI1L3aCZ5lwjG', 'admin', 'UCvCpS7wx4yNkqxirAdHY5WuM2vaSd3I73eXdz6Z.jpg', '2025-04-21 05:06:54', '2025-05-19 01:21:45', NULL, 1),
(2, 'Pedro', 'calavera carrasco', 'algo2@algo.com', '$2y$12$Wil6508wdQ0OpbtFYuPaRul6PhOo3MIztb/wLATQhJQxI7t1.AKEy', 'user', NULL, '2025-04-21 06:01:46', '2025-05-19 01:44:56', '3V3Z4i04QAaoHLgz2vbxy65NlNuwQXT8XtUpYSffBmfeUmNHl8NLI36hf6Q0', 1),
(10, 'Repetido', 'algo', 'algo4@algo.com', '$2y$12$AJDoSISDfZaWe1fO3oJ6VukXuGcRHG04/RFkfdRRYeFuSg2OojAFq', 'user', NULL, '2025-04-29 05:41:58', '2025-05-06 09:23:23', NULL, 1),
(11, 'NuevoUsuario', 'algo2', 'algo5@algo.com', '$2y$12$6GOp4tc9.fLrtVHRtSD40OfZ1x/xQbtd0Ioyk/n5KdJtAW7wqbkkC', 'user', NULL, '2025-04-29 11:02:02', '2025-05-07 09:35:42', NULL, 1),
(21, 'Don Alonso', 'Quijano', 'nuevo2@nuevo.com', '$2y$12$vdLtXTO0.wNAfvB5NKnsIumcuzqjikIDRK5Z26vv3jdUbl4tGyRny', 'user', NULL, '2025-05-05 11:06:22', '2025-05-19 01:23:53', 'G2H2zScymLS2Vb9pmybC3toANARRh6VlemPD9kE1GnV4RDyQGqXAcx8mnjxN', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lineas_pedidos`
--
ALTER TABLE `lineas_pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lineas_pedidos_pedido_id_foreign` (`pedido_id`),
  ADD KEY `lineas_pedidos_producto_id_foreign` (`producto_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedidos_usuario_id_foreign` (`usuario_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productos_categoria_id_foreign` (`categoria_id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuarios_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lineas_pedidos`
--
ALTER TABLE `lineas_pedidos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `lineas_pedidos`
--
ALTER TABLE `lineas_pedidos`
  ADD CONSTRAINT `lineas_pedidos_pedido_id_foreign` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lineas_pedidos_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
