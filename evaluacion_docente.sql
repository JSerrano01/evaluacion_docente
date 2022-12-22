-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-12-2022 a las 22:37:07
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `evaluacion_docente`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ae_docente_catedra`
--

CREATE TABLE `ae_docente_catedra` (
  `id` int(11) NOT NULL,
  `ID_ENCUESTA_QUSUARIO` int(11) NOT NULL,
  `ID_DOCENTE` int(11) NOT NULL,
  `FACULTAD` varchar(255) NOT NULL,
  `PROGRAMA` varchar(255) NOT NULL,
  `DOCUMENTO_DOCENTE` int(11) NOT NULL,
  `NOMBRE_DOCENTE` varchar(255) NOT NULL,
  `CARGO_DOCENTE` varchar(255) NOT NULL,
  `ENCUESTA` varchar(255) NOT NULL,
  `FECHA_DILIGENCIAMIENTO` varchar(255) NOT NULL,
  `Presento_los_objetivos_de_la_asignatura_de_forma_clara` varchar(255) NOT NULL,
  `Explico_de_manera_clara_los_contenidos_de_la_asignatura.` varchar(255) NOT NULL,
  `Relaciono_los_contenidos_de_la_asignatura_con_los_contenidos_de_` varchar(255) NOT NULL,
  `Resuelvo_las_dudas_relacionadas_con_los_contenidos_de_la_asignat` varchar(255) NOT NULL,
  `Propongo_ejemplos_o_ejercicios_que_vinculan_la_asignatura_con_lo` varchar(255) NOT NULL,
  `Explica_la_utilidad_de_los_contenidos_teóricos_y_prácticos_para_` varchar(255) NOT NULL,
  `a._Cumplo_con_lo_establecido_en_el_Acuerdo_Pedagógico_al_inicio_` varchar(255) NOT NULL,
  `b._Durante_la_asignatura_establezco_estrategias_adecuadas_necesa` varchar(255) NOT NULL,
  `c._El_Plan_de_Curso_presentado_al_principio_de_la_asignatura_lo_` varchar(255) NOT NULL,
  `d._Inicio_y_termino_la_clase_en_los_tiempos_establecidos_para_la` varchar(255) NOT NULL,
  `a._Incluyo_experiencias_de_aprendizaje_en_lugares_diferentes_al_` varchar(255) NOT NULL,
  `b._Utilizo_para_el_aprendizaje_las_herramientas_de_interacción_d` varchar(255) NOT NULL,
  `c._Promuevo_el_uso_de_diversas_herramientas,_particularmente_las` varchar(255) NOT NULL,
  `d._Promuevo_el_uso_seguro,_legal_y_ético_de_la_información_digit` varchar(255) NOT NULL,
  `e._Relaciono_los_contenidos_de_la_asignatura_con_la_industria_y_` varchar(255) NOT NULL,
  `a._Muestro_compromiso_y_entusiasmo_en_el_desarrollo_de_la_clase.` varchar(255) NOT NULL,
  `b._Tomo_en_cuenta_las_necesidades,_intereses_y_expectativas_del_` varchar(255) NOT NULL,
  `c._Propicio_el_desarrollo_de_un_ambiente_de_respeto_y_confianza.` varchar(255) NOT NULL,
  `d._Propicio_la_curiosidad,_el_espíritu_investigativo_y_el_deseo_` varchar(255) NOT NULL,
  `e._Reconozco_los_éxitos_y_logros_de_los_estudiantes_en_las_activ` varchar(255) NOT NULL,
  `a._Proporciono_información_clara_para_realizar_adecuadamente_las` varchar(255) NOT NULL,
  `b._Tomo_en_cuenta_las_actividades_realizadas_y_los_productos_com` varchar(255) NOT NULL,
  `c._Doy_a_conocer_las_calificaciones_en_el_plazo_establecido.` varchar(255) NOT NULL,
  `d._Doy_oportunidad_de_mejorar_los_resultados_de_la_evaluación_de` varchar(255) NOT NULL,
  `e._Otorgo_calificaciones_imparciales.` varchar(255) NOT NULL,
  `f._Hago_realimentación_de_las_evaluaciones_y_trabajos_con_fines_` varchar(255) NOT NULL,
  `a._Desarrollo_la_clase_en_un_clima_de_apertura_y_entendimiento.` varchar(255) NOT NULL,
  `b._Escucho_y_tomo_en_cuenta_las_opiniones_de_los_estudiantes.` varchar(255) NOT NULL,
  `c._Muestro_congruencia_entre_lo_que_digo_y_lo_que_hago.` varchar(255) NOT NULL,
  `d._Soy_accesible_y_estoy_dispuesto_a_brindarle_ayuda_académica_a` varchar(255) NOT NULL,
  `e._Trato_los_estudiantes_con_respeto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `password`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3'),
(2, 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ae_docente_catedra`
--
ALTER TABLE `ae_docente_catedra`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ae_docente_catedra`
--
ALTER TABLE `ae_docente_catedra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
