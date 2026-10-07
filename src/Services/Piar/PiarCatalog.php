<?php

declare(strict_types=1);

namespace App\Services\Piar;

/**
 * Catálogos de dominio para el asistente de elaboración del PIAR
 * (Plan Individual de Ajustes Razonables, Decreto 1421 de 2017, compilado en el
 * Decreto 1075 de 2015, arts. 2.3.3.5.2.3.4 a 2.3.3.5.2.3.7).
 *
 * Todo devuelve arreglos planos con etiquetas en español formal (Colombia),
 * listos para pintar el formulario y para traducir claves a etiquetas en el prompt.
 */
final class PiarCatalog
{
    /**
     * Condiciones agrupadas. Las categorías de discapacidad siguen las orientaciones
     * técnicas del MEN y las categorías del SIMAT.
     *
     * @return list<array{group: string, items: list<array{key: string, label: string, hint: string}>}>
     */
    public static function conditions(): array
    {
        return [
            [
                'group' => 'Discapacidad',
                'items' => [
                    ['key' => 'fisica', 'label' => 'Discapacidad física', 'hint' => 'Barreras en la movilidad, el desplazamiento, la manipulación de objetos o el control postural (p. ej., parálisis cerebral, lesión medular, amputaciones).'],
                    ['key' => 'auditiva_lsc', 'label' => 'Discapacidad auditiva: usuario de Lengua de Señas Colombiana (LSC)', 'hint' => 'Se comunica principalmente en LSC; el castellano escrito funciona como segunda lengua y requiere intérprete o modelo lingüístico.'],
                    ['key' => 'auditiva_oral', 'label' => 'Discapacidad auditiva: usuario del castellano oral', 'hint' => 'Pérdida auditiva con comunicación en castellano oral, con o sin audífonos o implante coclear; se apoya en la lectura labiofacial y en lo escrito.'],
                    ['key' => 'visual_baja_vision', 'label' => 'Discapacidad visual: baja visión', 'hint' => 'Conserva un remanente visual que no se corrige del todo con lentes; requiere ampliación, contraste, buena iluminación o ayudas ópticas.'],
                    ['key' => 'visual_ceguera', 'label' => 'Discapacidad visual: ceguera', 'hint' => 'Sin visión funcional; accede a la información por vía táctil y auditiva (Braille, lector de pantalla, material en relieve).'],
                    ['key' => 'sordoceguera', 'label' => 'Sordoceguera', 'hint' => 'Combinación de pérdida auditiva y visual que exige formas de comunicación específicas (a menudo táctiles) y, con frecuencia, guía-intérprete o mediador.'],
                    ['key' => 'intelectual', 'label' => 'Discapacidad intelectual', 'hint' => 'Limitaciones significativas en el funcionamiento intelectual y en la conducta adaptativa (conceptual, social y práctica) que se originan durante el desarrollo.'],
                    ['key' => 'psicosocial', 'label' => 'Discapacidad psicosocial', 'hint' => 'Barreras que surgen de la interacción entre una condición de salud mental de larga duración (p. ej., del estado de ánimo, de ansiedad o psicótica) y el entorno.'],
                    ['key' => 'tea', 'label' => 'Trastorno del espectro autista (TEA)', 'hint' => 'Diferencias persistentes en la comunicación y la interacción social, con intereses o conductas restringidos y, a menudo, particularidades sensoriales.'],
                    ['key' => 'sistemica', 'label' => 'Discapacidad sistémica', 'hint' => 'Condición de salud de larga duración (p. ej., cardiopatía, enfermedad renal u oncológica, epilepsia de difícil control) que produce ausentismo, fatiga o restricciones.'],
                    ['key' => 'voz_habla', 'label' => 'Trastorno permanente de voz y habla', 'hint' => 'Alteración permanente en la producción de la voz o del habla (p. ej., disartria, tartamudez severa) que limita la comunicación oral.'],
                    ['key' => 'multiple', 'label' => 'Discapacidad múltiple', 'hint' => 'Presencia de dos o más discapacidades que interactúan entre sí y requieren apoyos combinados.'],
                ],
            ],
            [
                'group' => 'Capacidades o talentos excepcionales',
                'items' => [
                    ['key' => 'capacidades_excepcionales', 'label' => 'Capacidades excepcionales', 'hint' => 'Desempeño o potencial muy superior en varias áreas a la vez, con alta creatividad y compromiso con la tarea.'],
                    ['key' => 'talento_cientifico', 'label' => 'Talento excepcional científico', 'hint' => 'Desempeño sobresaliente y persistente en ciencias naturales, matemáticas o en la indagación científica.'],
                    ['key' => 'talento_tecnologico', 'label' => 'Talento excepcional tecnológico', 'hint' => 'Facilidad notable para diseñar, construir, programar o resolver problemas con tecnología.'],
                    ['key' => 'talento_artistico', 'label' => 'Talento excepcional artístico o literario', 'hint' => 'Producción sobresaliente en música, artes plásticas, escénicas o escritura creativa.'],
                    ['key' => 'talento_deportivo', 'label' => 'Talento excepcional deportivo', 'hint' => 'Rendimiento físico y técnico muy superior al esperado para su edad en una o varias disciplinas.'],
                    ['key' => 'talento_liderazgo', 'label' => 'Talento excepcional en liderazgo social', 'hint' => 'Capacidad sobresaliente para movilizar a otros, mediar conflictos o emprender iniciativas comunitarias.'],
                    ['key' => 'doble_excepcionalidad', 'label' => 'Doble excepcionalidad', 'hint' => 'Capacidad o talento excepcional que coexiste con una discapacidad o una dificultad específica de aprendizaje.'],
                ],
            ],
            [
                'group' => 'Otras barreras (flexibilización y DUA, no requieren diagnóstico de discapacidad)',
                'items' => [
                    ['key' => 'tdah', 'label' => 'Trastorno por déficit de atención e hiperactividad (TDAH)', 'hint' => 'Patrón persistente de inatención, hiperactividad o impulsividad. Si genera barreras significativas y permanentes, el equipo puede valorar si corresponde a discapacidad psicosocial.'],
                    ['key' => 'dislexia', 'label' => 'Dificultad específica en la lectura (dislexia)', 'hint' => 'Dificultad persistente para decodificar y leer con fluidez y precisión, pese a una enseñanza adecuada.'],
                    ['key' => 'disgrafia', 'label' => 'Dificultad específica en la escritura (disgrafía o disortografía)', 'hint' => 'Dificultad persistente en el trazo, la ortografía o la organización de textos escritos.'],
                    ['key' => 'discalculia', 'label' => 'Dificultad específica en el cálculo (discalculia)', 'hint' => 'Dificultad persistente con el sentido numérico, los hechos aritméticos o el cálculo.'],
                    ['key' => 'lenguaje', 'label' => 'Trastorno del desarrollo del lenguaje', 'hint' => 'Dificultad persistente para comprender o expresar el lenguaje oral (vocabulario, gramática, narración) que no se explica por otra condición.'],
                    ['key' => 'coordinacion', 'label' => 'Trastorno del desarrollo de la coordinación (dispraxia)', 'hint' => 'Torpeza motora que afecta la escritura, el uso de herramientas, el deporte y las tareas de autocuidado.'],
                    ['key' => 'funcionamiento_limite', 'label' => 'Funcionamiento intelectual limítrofe', 'hint' => 'Desempeño intelectual por debajo del promedio sin cumplir los criterios de discapacidad intelectual; suele requerir más tiempo y apoyos concretos.'],
                    ['key' => 'emocional_conductual', 'label' => 'Dificultades emocionales o de comportamiento', 'hint' => 'Ansiedad, tristeza persistente, conductas desafiantes o dificultades de autorregulación que afectan el aprendizaje, sin diagnóstico de discapacidad psicosocial.'],
                    ['key' => 'rezago_extraedad', 'label' => 'Rezago escolar o extraedad', 'hint' => 'Desfase entre la edad y el grado, o vacíos de aprendizajes previos por interrupciones de la escolaridad, migración o desplazamiento.'],
                    ['key' => 'salud_transitoria', 'label' => 'Situación de salud transitoria u hospitalización', 'hint' => 'Enfermedad o tratamiento temporal que interrumpe la asistencia y puede requerir pedagogía hospitalaria o domiciliaria.'],
                    ['key' => 'en_estudio', 'label' => 'Dificultades de aprendizaje en estudio (sin diagnóstico)', 'hint' => 'Barreras observadas en el aula que aún no han sido valoradas por profesionales; describa lo que observa sin rotular.'],
                ],
            ],
        ];
    }

    /**
     * Nota orientadora por grupo de condiciones (para mostrar bajo el título del grupo).
     *
     * @return array<string, string>
     */
    public static function groupNotes(): array
    {
        return [
            'Discapacidad' => 'Para estudiantes con discapacidad el PIAR es obligatorio (Decreto 1421 de 2017). La ausencia de diagnóstico o certificado no impide elaborarlo ni prestar los apoyos.',
            'Capacidades o talentos excepcionales' => 'El MEN orienta su atención mediante flexibilización, enriquecimiento, profundización o aceleración; un plan con la estructura del PIAR es una buena práctica para organizar esos ajustes.',
            'Otras barreras (flexibilización y DUA, no requieren diagnóstico de discapacidad)' => 'Estas situaciones no constituyen por sí mismas una discapacidad. El documento resultante se plantea como plan de apoyos y flexibilización con enfoque DUA, de acuerdo con el SIEE de la institución; si las barreras son significativas y permanentes, el equipo puede valorar si corresponde un PIAR.',
        ];
    }

    /**
     * Índice plano clave => etiqueta de todas las condiciones.
     *
     * @return array<string, string>
     */
    public static function conditionLabels(): array
    {
        $out = [];
        foreach (self::conditions() as $group) {
            foreach ($group['items'] as $item) {
                $out[$item['key']] = $item['label'];
            }
        }
        return $out;
    }

    /**
     * Índice plano clave => nombre del grupo al que pertenece la condición.
     *
     * @return array<string, string>
     */
    public static function conditionGroups(): array
    {
        $out = [];
        foreach (self::conditions() as $group) {
            foreach ($group['items'] as $item) {
                $out[$item['key']] = $group['group'];
            }
        }
        return $out;
    }

    /** @return array<string, string> */
    public static function grades(): array
    {
        return [
            'prejardin' => 'Prejardín',
            'jardin' => 'Jardín',
            'transicion' => 'Transición',
            '1' => 'Primero',
            '2' => 'Segundo',
            '3' => 'Tercero',
            '4' => 'Cuarto',
            '5' => 'Quinto',
            '6' => 'Sexto',
            '7' => 'Séptimo',
            '8' => 'Octavo',
            '9' => 'Noveno',
            '10' => 'Décimo',
            '11' => 'Undécimo',
        ];
    }

    /**
     * Nivel educativo al que pertenece un grado (Ley 115 de 1994).
     */
    public static function levelOf(string $grade): string
    {
        if (in_array($grade, ['prejardin', 'jardin', 'transicion'], true)) {
            return 'Preescolar';
        }
        $n = (int) $grade;
        if ($n >= 1 && $n <= 5) {
            return 'Básica primaria';
        }
        if ($n >= 6 && $n <= 9) {
            return 'Básica secundaria';
        }
        if ($n >= 10 && $n <= 11) {
            return 'Media';
        }
        return '';
    }

    /**
     * Áreas obligatorias y fundamentales (Ley 115 de 1994, arts. 23 y 31) y
     * ámbitos transversales útiles para el PIAR.
     *
     * @return array<string, string>
     */
    public static function areas(): array
    {
        return [
            'matematicas' => 'Matemáticas',
            'lenguaje' => 'Humanidades: Lengua Castellana',
            'ingles' => 'Humanidades: Inglés',
            'naturales' => 'Ciencias Naturales y Educación Ambiental',
            'sociales' => 'Ciencias Sociales, Historia, Geografía, Constitución Política y Democracia',
            'artistica' => 'Educación Artística y Cultural',
            'etica' => 'Educación Ética y en Valores Humanos',
            'religion' => 'Educación Religiosa',
            'educacion_fisica' => 'Educación Física, Recreación y Deportes',
            'tecnologia' => 'Tecnología e Informática',
            'filosofia' => 'Filosofía (media)',
            'economia_politica' => 'Ciencias Económicas y Políticas (media)',
            'dimensiones_preescolar' => 'Preescolar: dimensiones del desarrollo (de forma integrada)',
            'convivencia' => 'Convivencia y participación',
            'autonomia' => 'Autonomía y vida diaria',
        ];
    }

    /**
     * Áreas que se cubren por defecto cuando el docente no selecciona ninguna.
     *
     * @return list<string>
     */
    public static function defaultAreas(string $grade): array
    {
        return match (self::levelOf($grade)) {
            'Preescolar' => ['dimensiones_preescolar', 'convivencia', 'autonomia'],
            'Básica primaria' => ['lenguaje', 'matematicas', 'naturales', 'sociales', 'convivencia'],
            'Básica secundaria', 'Media' => ['lenguaje', 'matematicas', 'naturales', 'sociales', 'ingles', 'convivencia'],
            default => ['lenguaje', 'matematicas', 'convivencia'],
        };
    }

    /**
     * Intensidad de los apoyos (clasificación de la AAIDD).
     *
     * @return array<string, array{label: string, hint: string}>
     */
    public static function supportLevels(): array
    {
        return [
            'intermitente' => ['label' => 'Intermitente', 'hint' => 'Apoyos ocasionales, solo en momentos o tareas puntuales (transiciones, evaluaciones, situaciones nuevas).'],
            'limitado' => ['label' => 'Limitado', 'hint' => 'Apoyos regulares durante un tiempo definido o en algunas áreas, con retiro progresivo a medida que gana autonomía.'],
            'extenso' => ['label' => 'Extenso', 'hint' => 'Apoyos diarios y continuos en varios entornos o áreas, sin límite de tiempo previsto.'],
            'generalizado' => ['label' => 'Generalizado', 'hint' => 'Apoyos constantes, de alta intensidad y en todos los entornos, con participación de varias personas.'],
        ];
    }

    /**
     * Dimensiones de la valoración pedagógica.
     *
     * @return array<string, string>
     */
    public static function dimensions(): array
    {
        return [
            'cognitiva' => 'Dimensión cognitiva',
            'comunicativa' => 'Dimensión comunicativa',
            'socioafectiva' => 'Dimensión socioafectiva',
            'corporal' => 'Dimensión corporal',
            'participacion' => 'Participación',
        ];
    }

    /**
     * Texto de ayuda para cada dimensión de la valoración pedagógica.
     *
     * @return array<string, string>
     */
    public static function dimensionHints(): array
    {
        return [
            'cognitiva' => 'Cómo aprende: atención, memoria, comprensión, razonamiento, solución de problemas y desempeño actual en lectura, escritura y matemáticas.',
            'comunicativa' => 'Cómo comprende y se expresa: lengua que usa (castellano, LSC, otra), lenguaje oral, gestual o escrito, comprensión de instrucciones y uso de sistemas alternativos.',
            'socioafectiva' => 'Cómo se relaciona y maneja sus emociones: vínculos con pares y adultos, autorregulación, tolerancia a la frustración y autoestima.',
            'corporal' => 'Cómo se mueve y percibe: motricidad gruesa y fina, desplazamiento, postura, respuesta sensorial, fatiga y autocuidado.',
            'participacion' => 'En qué actividades participa y en cuáles no: trabajo en grupo, descansos, actos escolares, salidas y vida institucional.',
        ];
    }

    /**
     * Focos de ajuste que el docente puede priorizar.
     *
     * @return array<string, string>
     */
    public static function priorities(): array
    {
        return [
            'evaluacion' => 'Evaluación',
            'metodologia' => 'Metodología y estrategias de enseñanza',
            'tiempos' => 'Tiempos y ritmos de trabajo',
            'materiales' => 'Materiales y accesibilidad',
            'comunicacion' => 'Comunicación',
            'convivencia' => 'Convivencia y regulación emocional',
            'autonomia' => 'Autonomía',
            'familia' => 'Trabajo con la familia',
            'tecnologia' => 'Uso de tecnología',
            'entorno' => 'Entorno físico',
        ];
    }

    /** @return array<string, string> */
    public static function periods(): array
    {
        return [
            'anual' => 'Año escolar completo',
            'p1' => 'Periodo 1',
            'p2' => 'Periodo 2',
            'p3' => 'Periodo 3',
            'p4' => 'Periodo 4',
        ];
    }

    /**
     * Ayudas cortas para cada campo del formulario (claves con punto para los anidados).
     *
     * @return array<string, string>
     */
    public static function formHelp(): array
    {
        return [
            'estudiante.nombre' => 'Escriba solo las iniciales o un alias (p. ej., «J. D. M.»). Así protege los datos personales del estudiante (Ley 1581 de 2012); el nombre completo puede agregarlo después en el documento impreso.',
            'estudiante.edad' => 'Edad cumplida en años.',
            'estudiante.grado' => 'Grado en el que está matriculado este año.',
            'estudiante.sede' => 'Sede de la institución (opcional).',
            'estudiante.jornada' => 'Mañana, tarde, única, nocturna o fin de semana (opcional).',
            'institucion' => 'Nombre de la institución o centro educativo, tal como debe aparecer en el documento.',
            'docente' => 'Docente que lidera la elaboración del PIAR (docente de aula o director de grupo).',
            'anio' => 'Año lectivo del plan. El PIAR se elabora durante el primer trimestre y se actualiza cada año.',
            'periodo' => 'Lapso que cubren los objetivos y ajustes; lo habitual es el año escolar completo con seguimiento por periodo.',
            'condiciones' => 'Seleccione la o las condiciones reportadas o en estudio. No es necesario contar con diagnóstico para describir barreras y proponer ajustes.',
            'otra_condicion' => 'Si la situación no aparece en la lista, descríbala brevemente con términos respetuosos.',
            'soporte_clinico' => 'Indique si la familia o el sector salud han entregado informes o certificados. Son opcionales: su ausencia no justifica dejar de elaborar el PIAR.',
            'soporte_detalle' => 'Qué informes existen (especialidad y año) y qué recomiendan para el contexto escolar. Transcriba solo lo pertinente; no incluya historia clínica completa.',
            'nivel_apoyo' => 'Intensidad de los apoyos que, según su observación, requiere hoy el estudiante para participar y aprender.',
            'areas' => 'Áreas que debe cubrir el plan. Si no marca ninguna, se proponen las áreas centrales del grado.',
            'prioridades' => 'Tipos de ajuste en los que desea mayor detalle. Puede marcar varios.',
            'contexto_familiar' => 'Con quién vive, quién acompaña el proceso escolar, disponibilidad de tiempo y expectativas de la familia. Evite juicios y datos sensibles innecesarios.',
            'contexto_social' => 'Actividades fuera del colegio (deporte, cultura, iglesia, terapias), redes de apoyo, acceso a servicios y condiciones del entorno (rural o urbano, desplazamiento).',
            'contexto_escolar' => 'Trayectoria escolar, número de estudiantes del grupo, apoyos que ya existen (docente de apoyo, orientación), ajustes previos y su resultado.',
            'fortalezas' => 'Lo que el estudiante hace bien o con facilidad. Toda planeación parte de sus fortalezas: sea específico.',
            'intereses' => 'Gustos, temas favoritos, actividades que lo motivan y refuerzos que funcionan. Servirán para diseñar actividades.',
            'barreras' => 'Describa situaciones observables del entorno que limitan su aprendizaje o participación (actitudinales, comunicativas, físicas, didácticas, tecnológicas u organizativas). Ejemplo: «las instrucciones se dan solo de forma oral y no las retiene» en lugar de «es distraído».',
            'valoracion.cognitiva' => 'Describa lo que observa: qué logra leer, escribir y calcular; cuánto tiempo sostiene la atención; cómo resuelve problemas. Evite rótulos como «lento» o «no aprende».',
            'valoracion.comunicativa' => 'Lengua en la que se comunica, cómo comprende instrucciones, cómo expresa necesidades, ideas y emociones, y si usa apoyos (señas, pictogramas, comunicadores).',
            'valoracion.socioafectiva' => 'Cómo se relaciona con compañeros y adultos, cómo reacciona ante la frustración o los cambios, qué lo tranquiliza.',
            'valoracion.corporal' => 'Desplazamiento, postura, motricidad fina (agarre, trazo, recorte), respuesta a ruidos, luces o texturas, fatiga y autocuidado.',
            'valoracion.participacion' => 'En qué momentos y actividades participa con gusto y en cuáles se retira o se le excluye (descanso, trabajo en grupo, actos, salidas).',
            'recursos_disponibles' => 'Apoyos con los que realmente cuenta la institución: docente de apoyo, orientador, tabletas, internet, biblioteca, espacios. Así los ajustes serán viables.',
            'observaciones' => 'Acuerdos previos, solicitudes de la familia o cualquier otra información relevante para el plan.',
        ];
    }

    /**
     * Ejemplo ficticio para el botón «Cargar ejemplo». Cualquier parecido con una
     * persona real es coincidencia.
     *
     * @return array<string, mixed>
     */
    public static function examples(): array
    {
        return [
            'estudiante' => [
                'nombre' => 'S. M. R.',
                'edad' => 9,
                'grado' => '3',
                'sede' => 'Sede principal',
                'jornada' => 'Mañana',
            ],
            'institucion' => 'Institución Educativa de Ejemplo',
            'docente' => 'Docente de aula (ejemplo)',
            'anio' => (int) date('Y'),
            'periodo' => 'anual',
            'condiciones' => ['tea'],
            'otra_condicion' => '',
            'soporte_clinico' => true,
            'soporte_detalle' => 'La familia entregó un informe de neuropediatría de 2025 que reporta trastorno del espectro autista, y un informe de fonoaudiología que recomienda apoyos visuales, anticipación de rutinas y fortalecimiento de la comunicación funcional. No se reporta medicación.',
            'nivel_apoyo' => 'limitado',
            'areas' => ['lenguaje', 'matematicas', 'naturales', 'convivencia'],
            'prioridades' => ['comunicacion', 'convivencia', 'evaluacion', 'tiempos'],
            'contexto_familiar' => 'Vive con su madre y su abuela materna en zona urbana. La madre trabaja en jornada continua; la abuela la recoge en la institución y acompaña las tareas en la tarde. La familia asiste a las citaciones y es receptiva, aunque manifiesta no saber cómo apoyar la lectura en casa.',
            'contexto_social' => 'Asiste los sábados a una escuela de formación en natación del municipio. Tiene pocas interacciones con pares fuera de la familia y prefiere los juegos individuales.',
            'contexto_escolar' => 'Es su segundo año en la institución. El grupo tiene 36 estudiantes. No hay docente de apoyo de planta; la orientadora escolar atiende tres sedes. El aula cuenta con televisor y conexión a internet intermitente. En el año anterior se le permitió terminar las evaluaciones en otro momento, con buen resultado.',
            'fortalezas' => 'Muy buena memoria visual; reconoce y escribe números hasta 1000; sigue las rutinas cuando se le anticipan; es puntual y cuida sus materiales; dibuja con gran detalle.',
            'intereses' => 'Los dinosaurios, los mapas y los trenes; los rompecabezas; la música instrumental; el agua y la natación.',
            'barreras' => 'Se desorganiza ante cambios de actividad o de espacio que no se anuncian (por ejemplo, actos cívicos). El ruido del descanso la lleva a taparse los oídos y a llorar. Las instrucciones se dan casi siempre de forma oral y extensa, y no pide ayuda cuando no las comprende. Las evaluaciones escritas con varias preguntas por página quedan incompletas.',
            'valoracion' => [
                'cognitiva' => 'Lee palabras y oraciones cortas con fluidez, pero le cuesta responder preguntas inferenciales. Resuelve sumas y restas con reagrupación; se le dificultan los problemas planteados de forma verbal. Mantiene la atención unos diez minutos en tareas que no son de su interés.',
                'comunicativa' => 'Se comunica oralmente con frases completas y en ocasiones repite frases de programas infantiles. Le cuesta iniciar y sostener conversaciones con sus compañeros e interpretar bromas o expresiones en sentido figurado.',
                'socioafectiva' => 'Busca a la docente cuando se siente insegura. Juega cerca de dos compañeras, aunque rara vez interactúa con ellas. Se frustra cuando pierde en juegos de grupo.',
                'corporal' => 'Buena motricidad gruesa. En motricidad fina presenta trazo con mucha presión y se fatiga al escribir textos largos. Muestra alta sensibilidad a los ruidos fuertes.',
                'participacion' => 'Participa cuando la actividad incluye apoyos visuales o se relaciona con sus intereses. Evita exponer frente al grupo y los trabajos en equipos de más de tres personas.',
            ],
            'recursos_disponibles' => 'Televisor en el aula, dos tabletas compartidas en la sede, biblioteca escolar con rincón de lectura y orientadora escolar un día a la semana.',
            'observaciones' => 'La familia solicita que se le permita usar protectores auditivos durante el descanso y los actos cívicos.',
        ];
    }
}
