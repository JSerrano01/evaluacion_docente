<?php
session_start();
ini_set('display_errors', 1);
$log_file = "./my-errors.log";
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);

Class Action {
	private $db;

	public function __construct() {
		ob_start();
	include '../bd/conexion.php';
	$objeto = new Conexion();
	$conexion = $objeto->Conectar();
    $this->db = $conexion;
	}

	function cargar_data($tipo){
		//se realiza un Truncate para eliminar la información previa
		//si es autoev. de docentes de cátedra (Tipo 1)
		if($tipo === 1){
			$save = $this->db->prepare("TRUNCATE TABLE ae_docente_catedra");
			$save->execute();
		}
		//si es autoev. de docentes sin cátedra (Tipo 2)
		if($tipo === 2){
			$save = $this->db->prepare("TRUNCATE TABLE ae_docente_sin_catedra");
			$save->execute();
		}
		//si es evaluación de decanos a docentes cátedra (Tipo 3)
		if($tipo === 3){
			$save = $this->db->prepare("TRUNCATE TABLE e_decano_catedra");
			$save->execute();
		}
		//si es evaluación de decanos a docentes planta (Tipo 4)
		if($tipo === 4){
			$save = $this->db->prepare("TRUNCATE TABLE e_decano_planta");
			$save->execute();
		}
		//si es evaluación de decanos a docentes planta (Tipo 4)
		if($tipo === 4){
			$save = $this->db->prepare("TRUNCATE TABLE e_decano_planta");
			$save->execute();
		}
		//si es evaluación de estudiantes a docentes (Tipo 5)
		if($tipo === 5){
			$save = $this->db->prepare("TRUNCATE TABLE e_estud");
			$save->execute();
		}
		$array=json_decode($_POST['datos'], true);
		foreach($array as $item)
        {
			try{
				//campos exactamente iguales para todos los tipos
				$ID_ENCUESTA_QUSUARIO = (isset($item['ID ENCUESTA QUSUARIO'])) ? $item['ID ENCUESTA QUSUARIO'] : '';
				$DOCUMENTO_DOCENTE = (isset($item['DOCUMENTO DOCENTE'])) ? $item['DOCUMENTO DOCENTE'] : '';
				$NOMBRE_DOCENTE = (isset($item['NOMBRE DOCENTE'])) ? $item['NOMBRE DOCENTE'] : '';
				$CARGO_DOCENTE = (isset($item['CARGO DOCENTE'])) ? $item['CARGO DOCENTE'] : '';
				$FECHA_DILIGENCIAMIENTO = (isset($item['FECHA DILIGENCIAMIENTO'])) ? $item['FECHA DILIGENCIAMIENTO'] : '';
				$FACULTAD = (isset($item['FACULTAD'])) ? $item['FACULTAD'] : '';
				$PROGRAMA = (isset($item['PROGRAMA'])) ? $item['PROGRAMA'] : '';
				$ENCUESTA = (isset($item['ENCUESTA'])) ? $item['ENCUESTA'] : '';

				//campos que se comparten pero con diferente nomenclatura

				//se declaran las variables tipo 1
				if($tipo === 1){
					$ID_DOCENTE = (isset($item['ID DOCENTE'])) ? $item['ID DOCENTE'] : '';
					$PREGUNTA1 = (isset($item['Presento los objetivos de la asignatura de forma clara'])) ? $item['Presento los objetivos de la asignatura de forma clara'] : '';
					$PREGUNTA2 = (isset($item['Explico de manera clara los contenidos de la asignatura.'])) ? $item['Explico de manera clara los contenidos de la asignatura.'] : '';
					$PREGUNTA3 = (isset($item['Relaciono los contenidos de la asignatura con los contenidos de otras.'])) ? $item['Relaciono los contenidos de la asignatura con los contenidos de otras.'] : '';
					$PREGUNTA4 = (isset($item['Resuelvo las dudas relacionadas con los contenidos de la asignatura.'])) ? $item['Resuelvo las dudas relacionadas con los contenidos de la asignatura.'] : '';
					$PREGUNTA5 = (isset($item['Propongo ejemplos o ejercicios que vinculan la asignatura con los perfiles ocupacionales del Programa.'])) ? $item['Propongo ejemplos o ejercicios que vinculan la asignatura con los perfiles ocupacionales del Programa.'] : '';
					$PREGUNTA6 = (isset($item['Explica la utilidad de los contenidos teóricos y prácticos para la actividad profesional.'])) ? $item['Explica la utilidad de los contenidos teóricos y prácticos para la actividad profesional.'] : '';
					$PREGUNTA7 = (isset($item['a. Cumplo con lo establecido en el Acuerdo Pedagógico al inicio de la asignatura.'])) ? $item['a. Cumplo con lo establecido en el Acuerdo Pedagógico al inicio de la asignatura.'] : '';
					$PREGUNTA8 = (isset($item['b. Durante la asignatura establezco estrategias adecuadas necesarias para lograr el aprendizaje deseado.'])) ? $item['b. Durante la asignatura establezco estrategias adecuadas necesarias para lograr el aprendizaje deseado.'] : '';
					$PREGUNTA9 = (isset($item['c. El Plan de Curso presentado al principio de la asignatura lo desarrollé totalmente.'])) ? $item['c. El Plan de Curso presentado al principio de la asignatura lo desarrollé totalmente.'] : '';
					$PREGUNTA10 = (isset($item['d. Inicio y termino la clase en los tiempos establecidos para la misma.'])) ? $item['d. Inicio y termino la clase en los tiempos establecidos para la misma.'] : '';
					$PREGUNTA11 = (isset($item['a. Incluyo experiencias de aprendizaje en lugares diferentes al aula (talleres, laboratorios, empresa, comunidad, biblioteca, etc.).'])) ? $item['a. Incluyo experiencias de aprendizaje en lugares diferentes al aula (talleres, laboratorios, empresa, comunidad, biblioteca, etc.).'] : '';
					$PREGUNTA12 = (isset($item['b. Utilizo para el aprendizaje las herramientas de interacción de las Tecnologías de la Información y las Comunicaciones (correo electrónico, chats, Moodle, plataformas electrónicas, etc.).'])) ? $item['b. Utilizo para el aprendizaje las herramientas de interacción de las Tecnologías de la Información y las Comunicaciones (correo electrónico, chats, Moodle, plataformas electrónicas, etc.).'] : '';
					$PREGUNTA13 = (isset($item['c. Promuevo el uso de diversas herramientas, particularmente las digitales, para gestionar (recabar, procesar, evaluar y usar) información.'])) ? $item['c. Promuevo el uso de diversas herramientas, particularmente las digitales, para gestionar (recabar, procesar, evaluar y usar) información.'] : '';
					$PREGUNTA14 = (isset($item['d. Promuevo el uso seguro, legal y ético de la información digital.'])) ? $item['d. Promuevo el uso seguro, legal y ético de la información digital.'] : '';
					$PREGUNTA15 = (isset($item['e. Relaciono los contenidos de la asignatura con la industria y la sociedad a nivel local, regional, nacional e internacional.'])) ? $item['e. Relaciono los contenidos de la asignatura con la industria y la sociedad a nivel local, regional, nacional e internacional.'] : '';
					$PREGUNTA16 = (isset($item['a. Muestro compromiso y entusiasmo en el desarrollo de la clase.'])) ? $item['a. Muestro compromiso y entusiasmo en el desarrollo de la clase.'] : '';
					$PREGUNTA17 = (isset($item['b. Tomo en cuenta las necesidades, intereses y expectativas del grupo.'])) ? $item['b. Tomo en cuenta las necesidades, intereses y expectativas del grupo.'] : '';
					$PREGUNTA18 = (isset($item['c. Propicio el desarrollo de un ambiente de respeto y confianza.'])) ? $item['c. Propicio el desarrollo de un ambiente de respeto y confianza.'] : '';
					$PREGUNTA19 = (isset($item['d. Propicio la curiosidad, el espíritu investigativo y el deseo de aprender.'])) ? $item['d. Propicio la curiosidad, el espíritu investigativo y el deseo de aprender.'] : '';
					$PREGUNTA20 = (isset($item['e. Reconozco los éxitos y logros de los estudiantes en las actividades de aprendizaje.'])) ? $item['e. Reconozco los éxitos y logros de los estudiantes en las actividades de aprendizaje.'] : '';
					$PREGUNTA21 = (isset($item['a. Proporciono información clara para realizar adecuadamente las actividades de evaluación.'])) ? $item['a. Proporciono información clara para realizar adecuadamente las actividades de evaluación.'] : '';
					$PREGUNTA22 = (isset($item['b. Tomo en cuenta las actividades realizadas y los productos como evidencias para la calificación y aprobación de la asignatura.'])) ? $item['b. Tomo en cuenta las actividades realizadas y los productos como evidencias para la calificación y aprobación de la asignatura.'] : '';
					$PREGUNTA23 = (isset($item['c. Doy a conocer las calificaciones en el plazo establecido.'])) ? $item['c. Doy a conocer las calificaciones en el plazo establecido.'] : '';
					$PREGUNTA24 = (isset($item['d. Doy oportunidad de mejorar los resultados de la evaluación del aprendizaje.'])) ? $item['d. Doy oportunidad de mejorar los resultados de la evaluación del aprendizaje.'] : '';
					$PREGUNTA25 = (isset($item['e. Otorgo calificaciones imparciales.'])) ? $item['e. Otorgo calificaciones imparciales.'] : '';
					$PREGUNTA26 = (isset($item['f. Hago realimentación de las evaluaciones y trabajos con fines de mejoramiento'])) ? $item['f. Hago realimentación de las evaluaciones y trabajos con fines de mejoramiento'] : '';
					$PREGUNTA27 = (isset($item['a. Desarrollo la clase en un clima de apertura y entendimiento.'])) ? $item['a. Desarrollo la clase en un clima de apertura y entendimiento.'] : '';
					$PREGUNTA28 = (isset($item['b. Escucho y tomo en cuenta las opiniones de los estudiantes.'])) ? $item['b. Escucho y tomo en cuenta las opiniones de los estudiantes.'] : '';
					$PREGUNTA29 = (isset($item['c. Muestro congruencia entre lo que digo y lo que hago.'])) ? $item['c. Muestro congruencia entre lo que digo y lo que hago.'] : '';
					$PREGUNTA30 = (isset($item['d. Soy accesible y estoy dispuesto a brindarle ayuda académica al estudiante.'])) ? $item['d. Soy accesible y estoy dispuesto a brindarle ayuda académica al estudiante.'] : '';
					$PREGUNTA31 = (isset($item['e. Trato los estudiantes con respeto'])) ? $item['e. Trato los estudiantes con respeto'] : '';
					$save = $this->db->prepare("INSERT INTO ae_docente_catedra (ID_ENCUESTA_QUSUARIO, ID_DOCENTE, FACULTAD, PROGRAMA, DOCUMENTO_DOCENTE, NOMBRE_DOCENTE, CARGO_DOCENTE, ENCUESTA, FECHA_DILIGENCIAMIENTO, PREGUNTA1, PREGUNTA2, PREGUNTA3, PREGUNTA4, PREGUNTA5, PREGUNTA6, PREGUNTA7, PREGUNTA8, PREGUNTA9, PREGUNTA10, PREGUNTA11, PREGUNTA12, PREGUNTA13, PREGUNTA14, PREGUNTA15, PREGUNTA16, PREGUNTA17, PREGUNTA18, PREGUNTA19, PREGUNTA20, PREGUNTA21, PREGUNTA22, PREGUNTA23, PREGUNTA24, PREGUNTA25, PREGUNTA26, PREGUNTA27, PREGUNTA28, PREGUNTA29, PREGUNTA30, PREGUNTA31) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
				}
				//se declaran variables tipo 2
				if($tipo === 2){
					$ID_DOCENTE = (isset($item['ID DOCENTE'])) ? $item['ID DOCENTE'] : '';
					$PREGUNTA1 = (isset($item['1.Asisto a las reuniones y aporto a la dinámica académica del grupo.'])) ? $item['1.Asisto a las reuniones y aporto a la dinámica académica del grupo.'] : '';
					$PREGUNTA2 = (isset($item['2. Aporto al mejoramiento del contenido curricular del programa del curso.'])) ? $item['2. Aporto al mejoramiento del contenido curricular del programa del curso.'] : '';
					$PREGUNTA3 = (isset($item['3. Doy a conocer oportunamente a los estudiantes los contenidos, la metodología y la evaluación del curso.'])) ? $item['3. Doy a conocer oportunamente a los estudiantes los contenidos, la metodología y la evaluación del curso.'] : '';
					$PREGUNTA4 = (isset($item['4. Actualizo e implemento recursos didácticos y TIC para la docencia.'])) ? $item['4. Actualizo e implemento recursos didácticos y TIC para la docencia.'] : '';
					$PREGUNTA5 = (isset($item['5. Soy puntual en el desarrollo de las actividades académicas.'])) ? $item['5. Soy puntual en el desarrollo de las actividades académicas.'] : '';
					$PREGUNTA6 = (isset($item['6. Soy puntual en la entrega, retroalimentación y reporte oportuno en el Sistema de las evaluaciones del curso.'])) ? $item['6. Soy puntual en la entrega, retroalimentación y reporte oportuno en el Sistema de las evaluaciones del curso.'] : '';
					$PREGUNTA7 = (isset($item['7. Soy ecuánime y respeto a los estudiantes, docentes y coordinadores.'])) ? $item['7. Soy ecuánime y respeto a los estudiantes, docentes y coordinadores.'] : '';
					$PREGUNTA8 = (isset($item['8. Cumplo a cabalidad con la entrega de informes.'])) ? $item['8. Cumplo a cabalidad con la entrega de informes.'] : '';
					$save = $this->db->prepare("INSERT INTO ae_docente_sin_catedra (ID_ENCUESTA_QUSUARIO, ID_DOCENTE, FACULTAD, PROGRAMA, DOCUMENTO_DOCENTE, NOMBRE_DOCENTE, CARGO_DOCENTE, ENCUESTA, FECHA_DILIGENCIAMIENTO, PREGUNTA1, PREGUNTA2, PREGUNTA3, PREGUNTA4, PREGUNTA5, PREGUNTA6, PREGUNTA7, PREGUNTA8) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
				}
				//se declaran las variables comunes entre tipo 3 y 4
				if($tipo == 3 || $tipo == 4){
					$ID_DOCENTE = (isset($item['ID DOCENTE'])) ? $item['ID DOCENTE'] : '';
					$DOCUMENTO_EVALUADOR = (isset($item['DOCUMENTO EVALUADOR'])) ? $item['DOCUMENTO EVALUADOR'] : '';
					$NOMBRE_EVALUADOR = (isset($item['NOMBRE EVALUADOR'])) ? $item['NOMBRE EVALUADOR'] : '';
				}

				//se declaran las variables que sólo tienen el tipo 3
				if($tipo == 3){
					$PREGUNTA1 = (isset($item['1. Asiste a las reuniones y aporta a la dinámica académica del grupo.'])) ? $item['1. Asiste a las reuniones y aporta a la dinámica académica del grupo.'] : '';
					$PREGUNTA2 = (isset($item['2. Aporta al mejoramiento del contenido curricular del programa del curso.'])) ? $item['2. Aporta al mejoramiento del contenido curricular del programa del curso.'] : '';
					$PREGUNTA3 = (isset($item['3. Da a conocer oportunamente a los estudiantes los contenidos, la metodología y la evaluación del curso.'])) ? $item['3. Da a conocer oportunamente a los estudiantes los contenidos, la metodología y la evaluación del curso.'] : '';
					$PREGUNTA4 = (isset($item['4. Actualiza e implementa recursos didácticos y TIC para la docencia.'])) ? $item['4. Actualiza e implementa recursos didácticos y TIC para la docencia.'] : '';
					$PREGUNTA5 = (isset($item['5. Es puntual en el desarrollo de sus actividades académicas'])) ? $item['5. Es puntual en el desarrollo de sus actividades académicas'] : '';
					$PREGUNTA6 = (isset($item['6. Es puntual en la entrega, retroalimentación y reporte oportuno en el Sistema de las evaluaciones del curso.'])) ? $item['6. Es puntual en la entrega, retroalimentación y reporte oportuno en el Sistema de las evaluaciones del curso.'] : '';
					$PREGUNTA7 = (isset($item['7. Es ecuánime y respeta a los estudiantes, docentes y coordinadores.'])) ? $item['7. Es ecuánime y respeta a los estudiantes, docentes y coordinadores.'] : '';
					$PREGUNTA8 = (isset($item['8. Cumple a cabalidad con la entrega de informes.'])) ? $item['8. Cumple a cabalidad con la entrega de informes.'] : '';
					$save = $this->db->prepare("INSERT INTO e_decano_catedra (ID_ENCUESTA_QUSUARIO, ID_DOCENTE, FACULTAD, PROGRAMA, DOCUMENTO_EVALUADOR, NOMBRE_EVALUADOR, DOCUMENTO_DOCENTE, NOMBRE_DOCENTE, CARGO_DOCENTE, ENCUESTA, FECHA_DILIGENCIAMIENTO, PREGUNTA1, PREGUNTA2, PREGUNTA3, PREGUNTA4, PREGUNTA5, PREGUNTA6, PREGUNTA7, PREGUNTA8) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
				}
				//se declaran las variables que sólo tienen el tipo 4
				if($tipo == 4){
					$PREGUNTA1 = (isset($item['Pertenece usted al proceso de Docencia?'])) ? $item['Pertenece usted al proceso de Docencia?'] : '';
					$PREGUNTA2 = (isset($item['1.1. Asigne el PESO (%) respectivo de este Proceso'])) ? $item['1.1. Asigne el PESO (%) respectivo de este Proceso'] : '';
					$PREGUNTA3 = (isset($item['1.2. Asigne el LOGRO que alcanzo el Docente en este proceso'])) ? $item['1.2. Asigne el LOGRO que alcanzo el Docente en este proceso'] : '';
					$PREGUNTA4 = (isset($item['Pertenece usted al proceso de Investigación?'])) ? $item['Pertenece usted al proceso de Investigación?'] : '';
					$PREGUNTA5 = (isset($item['2.1. Asigne el PESO (%) respectivo de este Proceso'])) ? $item['2.1. Asigne el PESO (%) respectivo de este Proceso'] : '';
					$PREGUNTA6 = (isset($item['2.2. Asigne el LOGRO que alcanzo el Docente en este proceso'])) ? $item['2.2. Asigne el LOGRO que alcanzo el Docente en este proceso'] : '';
					$PREGUNTA7 = (isset($item['Pertenece suted al proceso de Extensión?'])) ? $item['Pertenece suted al proceso de Extensión?'] : '';
					$PREGUNTA8 = (isset($item['3.1. Asigne el PESO (%) respectivo de este Proceso'])) ? $item['3.1. Asigne el PESO (%) respectivo de este Proceso'] : '';
					$PREGUNTA9 = (isset($item['3.2. Asigne el LOGRO que alcanzo el Docente en este proceso'])) ? $item['3.2. Asigne el LOGRO que alcanzo el Docente en este proceso'] : '';
					$PREGUNTA10 = (isset($item['Pertenece usted al proceso de Administrativos?'])) ? $item['Pertenece usted al proceso de Administrativos?'] : '';
					$PREGUNTA11 = (isset($item['4.1. Asigne el PESO (%) respectivo de este Proceso'])) ? $item['4.1. Asigne el PESO (%) respectivo de este Proceso'] : '';
					$PREGUNTA12 = (isset($item['4.2. Asigne el LOGRO que alcanzo el Docente en este proceso'])) ? $item['4.2. Asigne el LOGRO que alcanzo el Docente en este proceso'] : '';
					$PREGUNTA13 = (isset($item['Pertenece usted al proceso de Capacitación?'])) ? $item['Pertenece usted al proceso de Capacitación?'] : '';
					$PREGUNTA14 = (isset($item['5.1. Asigne el PESO (%) respectivo de este Proceso'])) ? $item['5.1. Asigne el PESO (%) respectivo de este Proceso'] : '';
					$PREGUNTA15 = (isset($item['5.2. Asigne el LOGRO que alcanzo el Docente en este proceso'])) ? $item['5.2. Asigne el LOGRO que alcanzo el Docente en este proceso'] : '';
					$PREGUNTA16 = (isset($item['6.1. FACTORES Y ASPECTOS QUE SE DEBEN MEJORAR:'])) ? $item['6.1. FACTORES Y ASPECTOS QUE SE DEBEN MEJORAR:'] : '';
					$PREGUNTA17 = (isset($item['6.2. FACTORES Y ASPECTOS EN LOS QUE SOBRESALE EL EVALUADO:'])) ? $item['6.2. FACTORES Y ASPECTOS EN LOS QUE SOBRESALE EL EVALUADO:'] : '';
					$PREGUNTA18 = (isset($item['6.3. LIMITACIONES PARA EL CUMPLIMIENTO DE LOS OBJETIVOS:'])) ? $item['6.3. LIMITACIONES PARA EL CUMPLIMIENTO DE LOS OBJETIVOS:'] : '';
					$PREGUNTA19 = (isset($item['6.4. OBSERVACIONES:'])) ? $item['6.4. OBSERVACIONES:'] : '';
					$save = $this->db->prepare("INSERT INTO e_decano_planta (ID_ENCUESTA_QUSUARIO, ID_DOCENTE, FACULTAD, PROGRAMA, DOCUMENTO_EVALUADOR, NOMBRE_EVALUADOR, DOCUMENTO_DOCENTE, NOMBRE_DOCENTE, CARGO_DOCENTE, ENCUESTA, FECHA_DILIGENCIAMIENTO, PREGUNTA1, PREGUNTA2, PREGUNTA3, PREGUNTA4, PREGUNTA5, PREGUNTA6, PREGUNTA7, PREGUNTA8, PREGUNTA9, PREGUNTA10, PREGUNTA11, PREGUNTA12, PREGUNTA13, PREGUNTA14, PREGUNTA15, PREGUNTA16, PREGUNTA17, PREGUNTA18, PREGUNTA19) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
				}
				if($tipo == 5){
					$ID_GRUPO_DOCENTE = (isset($item['ID GRUPO DOCENTE'])) ? $item['ID GRUPO DOCENTE'] : '';
					$GRUPO = (isset($item['GRUPO'])) ? $item['GRUPO'] : '';
					$ID_OPERARIO_U = (isset($item['ID OPERARIO U'])) ? $item['ID OPERARIO U'] : '';
					$PREGUNTA1 = (isset($item['Exprese su opinión con respecto a la siguiente afirmación: Asistí a las actividades regulares de esta asignatura.'])) ? $item['Exprese su opinión con respecto a la siguiente afirmación: Asistí a las actividades regulares de esta asignatura.'] : '';
					$PREGUNTA2 = (isset($item['Si su respuesta a la anterior pregunta fue la opción c, d o e, contesta la siguiente pregunta: No asistí regularmente a esta asignatura por alguno (s) de los siguientes motivos:'])) ? $item['Si su respuesta a la anterior pregunta fue la opción c, d o e, contesta la siguiente pregunta: No asistí regularmente a esta asignatura por alguno (s) de los siguientes motivos:'] : '';
					$PREGUNTA3 = (isset($item['Cuales'])) ? $item['Cuales'] : '';
					$PREGUNTA4 = (isset($item['Exprese su opinión con respecto a la siguiente afirmación: Estoy al día con las actividades desarrolladas en esta asignatura'])) ? $item['Exprese su opinión con respecto a la siguiente afirmación: Estoy al día con las actividades desarrolladas en esta asignatura'] : '';
					$PREGUNTA5 = (isset($item['Exprese su opinión con respecto a la siguiente afirmación Me siento satisfecho (a) con lo aprendido.'])) ? $item['Exprese su opinión con respecto a la siguiente afirmación Me siento satisfecho (a) con lo aprendido.'] : '';
					$PREGUNTA6 = (isset($item['a. Presenta los objetivos de la asignatura de forma clara'])) ? $item['a. Presenta los objetivos de la asignatura de forma clara'] : '';
					$PREGUNTA7 = (isset($item['b. Explica de manera clara los contenidos de la asignatura.'])) ? $item['b. Explica de manera clara los contenidos de la asignatura.'] : '';
					$PREGUNTA8 = (isset($item['c. Relaciona los contenidos de la asignatura con los contenidos de otras.'])) ? $item['c. Relaciona los contenidos de la asignatura con los contenidos de otras.'] : '';
					$PREGUNTA9 = (isset($item['d. Resuelve las dudas relacionadas con los contenidos de la asignatura.'])) ? $item['d. Resuelve las dudas relacionadas con los contenidos de la asignatura.'] : '';
					$PREGUNTA10 = (isset($item['e. Propone ejemplos o ejercicios que vinculan la asignatura con los perfiles ocupacionales del Programa.'])) ? $item['e. Propone ejemplos o ejercicios que vinculan la asignatura con los perfiles ocupacionales del Programa.'] : '';
					$PREGUNTA11 = (isset($item['f. Explica la utilidad de los contenidos teóricos y prácticos para la actividad profesional.'])) ? $item['f. Explica la utilidad de los contenidos teóricos y prácticos para la actividad profesional.'] : '';
					$PREGUNTA12 = (isset($item['a. Cumple con lo establecido en el Acuerdo Pedagógico al inicio de la asignatura.'])) ? $item['a. Cumple con lo establecido en el Acuerdo Pedagógico al inicio de la asignatura.'] : '';
					$PREGUNTA13 = (isset($item['b. Durante la asignatura establece las estrategias adecuadas necesarias para lograr el aprendizaje deseado.'])) ? $item['b. Durante la asignatura establece las estrategias adecuadas necesarias para lograr el aprendizaje deseado.'] : '';
					$PREGUNTA14 = (isset($item['c. El Plan de Curso presentado al principio de la asignatura se cubre totalmente.'])) ? $item['c. El Plan de Curso presentado al principio de la asignatura se cubre totalmente.'] : '';
					$PREGUNTA15 = (isset($item['d. Inicia y termina la clase en los tiempos establecidos para la misma.'])) ? $item['d. Inicia y termina la clase en los tiempos establecidos para la misma.'] : '';
					$PREGUNTA16 = (isset($item['a. Incluye experiencias de aprendizaje en lugares diferentes al aula (talleres, laboratorios, empresa, comunidad, biblioteca, etc.).'])) ? $item['a. Incluye experiencias de aprendizaje en lugares diferentes al aula (talleres, laboratorios, empresa, comunidad, biblioteca, etc.).'] : '';
					$PREGUNTA17 = (isset($item['b. Utiliza para el aprendizaje las herramientas de interacción de las Tecnologías de la Información y las Comunicaciones (correo electrónico, chats, Moodle, plataformas electrónicas, etc.).'])) ? $item['b. Utiliza para el aprendizaje las herramientas de interacción de las Tecnologías de la Información y las Comunicaciones (correo electrónico, chats, Moodle, plataformas electrónicas, etc.).'] : '';
					$PREGUNTA18 = (isset($item['c. Promueve el uso de diversas herramientas, particularmente las digitales, para gestionar (recabar, procesar, evaluar y usar) información.'])) ? $item['c. Promueve el uso de diversas herramientas, particularmente las digitales, para gestionar (recabar, procesar, evaluar y usar) información.'] : '';
					$PREGUNTA19 = (isset($item['d. Promueve el uso seguro, legal y ético de la información digital.'])) ? $item['d. Promueve el uso seguro, legal y ético de la información digital.'] : '';
					$PREGUNTA20 = (isset($item['e. Relaciona los contenidos de la asignatura con la industria y la sociedad a nivel local, regional, nacional e internacional.'])) ? $item['e. Relaciona los contenidos de la asignatura con la industria y la sociedad a nivel local, regional, nacional e internacional.'] : '';
					$PREGUNTA21 = (isset($item['a. Muestra compromiso y entusiasmo en sus actividades docentes.'])) ? $item['a. Muestra compromiso y entusiasmo en sus actividades docentes.'] : '';
					$PREGUNTA22 = (isset($item['b. Toma en cuenta las necesidades, intereses y expectativas del grupo.'])) ? $item['b. Toma en cuenta las necesidades, intereses y expectativas del grupo.'] : '';
					$PREGUNTA23 = (isset($item['c. Propicia el desarrollo de un ambiente de respeto y confianza.'])) ? $item['c. Propicia el desarrollo de un ambiente de respeto y confianza.'] : '';
					$PREGUNTA24 = (isset($item['d. Propicia la curiosidad, el espíritu investigativo y el deseo de aprender.'])) ? $item['d. Propicia la curiosidad, el espíritu investigativo y el deseo de aprender.'] : '';
					$PREGUNTA25 = (isset($item['e. Reconoce los éxitos y logros en las actividades de aprendizaje.'])) ? $item['e. Reconoce los éxitos y logros en las actividades de aprendizaje.'] : '';
					$PREGUNTA26 = (isset($item['a. Proporciona información clara para realizar adecuadamente las actividades de evaluación.'])) ? $item['a. Proporciona información clara para realizar adecuadamente las actividades de evaluación.'] : '';
					$PREGUNTA27 = (isset($item['b. Toma en cuenta las actividades realizadas y los productos como evidencias para la calificación y aprobación de la asignatura.'])) ? $item['b. Toma en cuenta las actividades realizadas y los productos como evidencias para la calificación y aprobación de la asignatura.'] : '';
					$PREGUNTA28 = (isset($item['c. Da a conocer las calificaciones en el plazo establecido.'])) ? $item['c. Da a conocer las calificaciones en el plazo establecido.'] : '';
					$PREGUNTA29 = (isset($item['d. Da oportunidad de mejorar los resultados de la evaluación del aprendizaje.'])) ? $item['d. Da oportunidad de mejorar los resultados de la evaluación del aprendizaje.'] : '';
					$PREGUNTA30 = (isset($item['e. Otorga calificaciones imparciales.'])) ? $item['e. Otorga calificaciones imparciales.'] : '';
					$PREGUNTA31 = (isset($item['f. Hace realimentación de las evaluaciones y trabajos con fines de mejoramiento'])) ? $item['f. Hace realimentación de las evaluaciones y trabajos con fines de mejoramiento'] : '';
					$PREGUNTA32 = (isset($item['a. Desarrolla la clase en un clima de apertura y entendimiento.'])) ? $item['a. Desarrolla la clase en un clima de apertura y entendimiento.'] : '';
					$PREGUNTA33 = (isset($item['b. Escucha y toma en cuenta las opiniones de los estudiantes.'])) ? $item['b. Escucha y toma en cuenta las opiniones de los estudiantes.'] : '';
					$PREGUNTA34 = (isset($item['c. Muestra congruencia entre lo que dice y lo que hace.'])) ? $item['c. Muestra congruencia entre lo que dice y lo que hace.'] : '';
					$PREGUNTA35 = (isset($item['d. Es accesible y está dispuesto a brindarle ayuda académica al estudiante.'])) ? $item['d. Es accesible y está dispuesto a brindarle ayuda académica al estudiante.'] : '';
					$PREGUNTA36 = (isset($item['e. El trato hacia los estudiantes es respetuoso'])) ? $item['e. El trato hacia los estudiantes es respetuoso'] : '';
					$PREGUNTA37 = (isset($item['a. En general, pienso que es un (a) buen docente.'])) ? $item['a. En general, pienso que es un (a) buen docente.'] : '';
					$PREGUNTA38 = (isset($item['b. Estoy satisfecho (a) por mi nivel de desempeño y aprendizaje logrado gracias a la labor del (a) docente.'])) ? $item['b. Estoy satisfecho (a) por mi nivel de desempeño y aprendizaje logrado gracias a la labor del (a) docente.'] : '';
					$PREGUNTA39 = (isset($item['c. Yo recomendaría a este docente'])) ? $item['c. Yo recomendaría a este docente'] : '';
					$PREGUNTA40 = (isset($item['¿Qué observaciones finales quieres hacer sobre el docente?'])) ? $item['¿Qué observaciones finales quieres hacer sobre el docente?'] : '';
					$save = $this->db->prepare("INSERT INTO e_estud (ID_ENCUESTA_QUSUARIO, ID_GRUPO_DOCENTE, FACULTAD, PROGRAMA, GRUPO, DOCUMENTO_DOCENTE, NOMBRE_DOCENTE, CARGO_DOCENTE, ENCUESTA, ID_OPERARIO_U, FECHA_DILIGENCIAMIENTO, PREGUNTA1, PREGUNTA2, PREGUNTA3, PREGUNTA4, PREGUNTA5, PREGUNTA6, PREGUNTA7, PREGUNTA8, PREGUNTA9, PREGUNTA10, PREGUNTA11, PREGUNTA12, PREGUNTA13, PREGUNTA14, PREGUNTA15, PREGUNTA16, PREGUNTA17, PREGUNTA18, PREGUNTA19, PREGUNTA20, PREGUNTA21, PREGUNTA22, PREGUNTA23, PREGUNTA24, PREGUNTA25, PREGUNTA26, PREGUNTA27, PREGUNTA28, PREGUNTA29, PREGUNTA30, PREGUNTA31, PREGUNTA32, PREGUNTA33, PREGUNTA34, PREGUNTA35, PREGUNTA36, PREGUNTA37, PREGUNTA38, PREGUNTA39, PREGUNTA40) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
				}
				$save->bindParam(1, $ID_ENCUESTA_QUSUARIO);
				if($tipo != 5){
					$save->bindParam(2, $ID_DOCENTE);
				}
				else{
					$save->bindParam(2, $ID_GRUPO_DOCENTE);
				}
				$save->bindParam(3, $FACULTAD);
				$save->bindParam(4, $PROGRAMA);
				if($tipo === 1 || $tipo === 2){
					$save->bindParam(5, $DOCUMENTO_DOCENTE);
					$save->bindParam(6, $NOMBRE_DOCENTE);
					$save->bindParam(7, $CARGO_DOCENTE);
					$save->bindParam(8, $ENCUESTA);
					$save->bindParam(9, $FECHA_DILIGENCIAMIENTO);
				}
				else if($tipo === 3 || $tipo === 4){
					$save->bindParam(5, $DOCUMENTO_EVALUADOR);
					$save->bindParam(6, $NOMBRE_EVALUADOR);
					$save->bindParam(7, $DOCUMENTO_DOCENTE);
					$save->bindParam(8, $NOMBRE_DOCENTE);
					$save->bindParam(9, $CARGO_DOCENTE);
					$save->bindParam(10, $ENCUESTA);
					$save->bindParam(11, $FECHA_DILIGENCIAMIENTO);
				}
				else{
					$save->bindParam(5, $GRUPO);
					$save->bindParam(6, $DOCUMENTO_DOCENTE);
					$save->bindParam(7, $NOMBRE_DOCENTE);
					$save->bindParam(8, $CARGO_DOCENTE);
					$save->bindParam(9, $ENCUESTA);
					$save->bindParam(10, $ID_OPERARIO_U);
					$save->bindParam(11, $FECHA_DILIGENCIAMIENTO);
				}
				if($tipo === 1){
					$save->bindParam(10, $PREGUNTA1);
					$save->bindParam(11, $PREGUNTA2);
					$save->bindParam(12, $PREGUNTA3);
					$save->bindParam(13, $PREGUNTA4);
					$save->bindParam(14, $PREGUNTA5);
					$save->bindParam(15, $PREGUNTA6);
					$save->bindParam(16, $PREGUNTA7);
					$save->bindParam(17, $PREGUNTA8);
					$save->bindParam(18, $PREGUNTA9);
					$save->bindParam(19, $PREGUNTA10);
					$save->bindParam(20, $PREGUNTA11);
					$save->bindParam(21, $PREGUNTA12);
					$save->bindParam(22, $PREGUNTA13);
					$save->bindParam(23, $PREGUNTA14);
					$save->bindParam(24, $PREGUNTA15);
					$save->bindParam(25, $PREGUNTA16);
					$save->bindParam(26, $PREGUNTA17);
					$save->bindParam(27, $PREGUNTA18);
					$save->bindParam(28, $PREGUNTA19);
					$save->bindParam(29, $PREGUNTA20);
					$save->bindParam(30, $PREGUNTA21);
					$save->bindParam(31, $PREGUNTA22);
					$save->bindParam(32, $PREGUNTA23);
					$save->bindParam(33, $PREGUNTA24);
					$save->bindParam(34, $PREGUNTA25);
					$save->bindParam(35, $PREGUNTA26);
					$save->bindParam(36, $PREGUNTA27);
					$save->bindParam(37, $PREGUNTA28);
					$save->bindParam(38, $PREGUNTA29);
					$save->bindParam(39, $PREGUNTA30);
					$save->bindParam(40, $PREGUNTA31);
				}
				if($tipo === 2){
					$save->bindParam(10, $PREGUNTA1);
					$save->bindParam(11, $PREGUNTA2);
					$save->bindParam(12, $PREGUNTA3);
					$save->bindParam(13, $PREGUNTA4);
					$save->bindParam(14, $PREGUNTA5);
					$save->bindParam(15, $PREGUNTA6);
					$save->bindParam(16, $PREGUNTA7);
					$save->bindParam(17, $PREGUNTA8);
				}
				if($tipo === 3){
					$save->bindParam(12, $PREGUNTA1);
					$save->bindParam(13, $PREGUNTA2);
					$save->bindParam(14, $PREGUNTA3);
					$save->bindParam(15, $PREGUNTA4);
					$save->bindParam(16, $PREGUNTA5);
					$save->bindParam(17, $PREGUNTA6);
					$save->bindParam(18, $PREGUNTA7);
					$save->bindParam(19, $PREGUNTA8);
				}
				if($tipo === 4){
					$save->bindParam(12, $PREGUNTA1);
					$save->bindParam(13, $PREGUNTA2);
					$save->bindParam(14, $PREGUNTA3);
					$save->bindParam(15, $PREGUNTA4);
					$save->bindParam(16, $PREGUNTA5);
					$save->bindParam(17, $PREGUNTA6);
					$save->bindParam(18, $PREGUNTA7);
					$save->bindParam(19, $PREGUNTA8);
					$save->bindParam(20, $PREGUNTA9);
					$save->bindParam(21, $PREGUNTA10);
					$save->bindParam(22, $PREGUNTA11);
					$save->bindParam(23, $PREGUNTA12);
					$save->bindParam(24, $PREGUNTA13);
					$save->bindParam(25, $PREGUNTA14);
					$save->bindParam(26, $PREGUNTA15);
					$save->bindParam(27, $PREGUNTA16);
					$save->bindParam(28, $PREGUNTA17);
					$save->bindParam(29, $PREGUNTA18);
					$save->bindParam(30, $PREGUNTA19);
				}
				if($tipo === 5){
					$save->bindParam(12, $PREGUNTA1);
					$save->bindParam(13, $PREGUNTA2);
					$save->bindParam(14, $PREGUNTA3);
					$save->bindParam(15, $PREGUNTA4);
					$save->bindParam(16, $PREGUNTA5);
					$save->bindParam(17, $PREGUNTA6);
					$save->bindParam(18, $PREGUNTA7);
					$save->bindParam(19, $PREGUNTA8);
					$save->bindParam(20, $PREGUNTA9);
					$save->bindParam(21, $PREGUNTA10);
					$save->bindParam(22, $PREGUNTA11);
					$save->bindParam(23, $PREGUNTA12);
					$save->bindParam(24, $PREGUNTA13);
					$save->bindParam(25, $PREGUNTA14);
					$save->bindParam(26, $PREGUNTA15);
					$save->bindParam(27, $PREGUNTA16);
					$save->bindParam(28, $PREGUNTA17);
					$save->bindParam(29, $PREGUNTA18);
					$save->bindParam(30, $PREGUNTA19);
					$save->bindParam(31, $PREGUNTA20);
					$save->bindParam(32, $PREGUNTA21);
					$save->bindParam(33, $PREGUNTA22);
					$save->bindParam(34, $PREGUNTA23);
					$save->bindParam(35, $PREGUNTA24);
					$save->bindParam(36, $PREGUNTA25);
					$save->bindParam(37, $PREGUNTA26);
					$save->bindParam(38, $PREGUNTA27);
					$save->bindParam(39, $PREGUNTA28);
					$save->bindParam(40, $PREGUNTA29);
					$save->bindParam(41, $PREGUNTA30);
					$save->bindParam(42, $PREGUNTA31);
					$save->bindParam(43, $PREGUNTA32);
					$save->bindParam(44, $PREGUNTA33);
					$save->bindParam(45, $PREGUNTA34);
					$save->bindParam(46, $PREGUNTA35);
					$save->bindParam(47, $PREGUNTA36);
					$save->bindParam(48, $PREGUNTA37);
					$save->bindParam(49, $PREGUNTA38);
					$save->bindParam(50, $PREGUNTA39);
					$save->bindParam(51, $PREGUNTA40);
				}
				$save->execute();
			}
            catch (Exception $e) {
				echo 'Excepción capturada: ',  $e->getMessage(), "\n";
				return 2;
			}
        }
		return 1;
	}
}