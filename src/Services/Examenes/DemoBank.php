<?php

declare(strict_types=1);

namespace App\Services\Examenes;

/**
 * Banco fijo de preguntas del simulador (sin IA). Se escribió con el mismo generador (gemini-2.5-flash) y se revisó a mano.
 * Materias: matemáticas, física, química, lengua castellana y ciencias sociales; dos variantes por pregunta.
 * Generado; para cambiarlo, edite este archivo.
 */
final class DemoBank
{
    /** @return array<string, array<int, array>> materia => preguntas del banco */
    public static function slots(): array
    {
        return array (
  'matematicas' => 
  array (
    0 => 
    array (
      'id' => 'd1',
      'type' => 'unica',
      'skill' => 'Determina la naturaleza de las soluciones de una ecuación cuadrática.',
      'points' => 1,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Dada la ecuación cuadrática $2x^2 - 5x + 3 = 0$, ¿cuál es la naturaleza de sus soluciones?',
          'options' => 
          array (
            0 => 'Tiene dos soluciones reales e iguales.',
            1 => 'Tiene dos soluciones reales y distintas.',
            2 => 'No tiene soluciones reales.',
            3 => 'Tiene una solución real y una imaginaria.',
          ),
          'correct' => 
          array (
            0 => 1,
          ),
          'solution' => 'El discriminante de la ecuación es $\\Delta = b^2 - 4ac = (-5)^2 - 4(2)(3) = 25 - 24 = 1$. Dado que $\\Delta > 0$, la ecuación tiene dos soluciones reales y distintas.',
        ),
        1 => 
        array (
          'stem' => 'Dada la ecuación cuadrática $3x^2 + 2x + 1 = 0$, ¿cuál es la naturaleza de sus soluciones?',
          'options' => 
          array (
            0 => 'Tiene dos soluciones reales e iguales.',
            1 => 'Tiene dos soluciones reales y distintas.',
            2 => 'No tiene soluciones reales.',
            3 => 'Tiene una solución real y una imaginaria.',
          ),
          'correct' => 
          array (
            0 => 2,
          ),
          'solution' => 'El discriminante de la ecuación es $\\Delta = b^2 - 4ac = (2)^2 - 4(3)(1) = 4 - 12 = -8$. Dado que $\\Delta < 0$, la ecuación no tiene soluciones reales.',
        ),
      ),
    ),
    1 => 
    array (
      'id' => 'd2',
      'type' => 'unica',
      'skill' => 'Calcula el valor máximo o mínimo de una función cuadrática en un contexto.',
      'points' => 1,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'La altura (en metros) de un balón de fútbol pateado se modela con la función $h(t) = -t^2 + 6t + 1$, donde $t$ es el tiempo en segundos. ¿Cuál es la altura máxima que alcanza el balón?',
          'options' => 
          array (
            0 => '$1\\,\\text{m}$',
            1 => '$6\\,\\text{m}$',
            2 => '$10\\,\\text{m}$',
            3 => '$12\\,\\text{m}$',
          ),
          'correct' => 
          array (
            0 => 2,
          ),
          'solution' => 'La coordenada $t$ del vértice de una parábola $at^2 + bt + c$ es $t = -b/(2a)$. Para $h(t) = -t^2 + 6t + 1$, $t = -6/(2(-1)) = 3$. Sustituyendo $t=3$ en la función, obtenemos $h(3) = -(3)^2 + 6(3) + 1 = -9 + 18 + 1 = 10\\,\\text{m}$.',
        ),
        1 => 
        array (
          'stem' => 'El beneficio semanal (en miles de pesos) de una pequeña empresa en Barranquilla se modela con la función $B(x) = -2x^2 + 20x - 10$, donde $x$ es la cantidad de productos vendidos. ¿Cuál es el beneficio máximo que puede obtener la empresa?',
          'options' => 
          array (
            0 => '\\$10.000',
            1 => '\\$20.000',
            2 => '\\$40.000',
            3 => '\\$50.000',
          ),
          'correct' => 
          array (
            0 => 2,
          ),
          'solution' => 'La coordenada $x$ del vértice de una parábola $ax^2 + bx + c$ es $x = -b/(2a)$. Para $B(x) = -2x^2 + 20x - 10$, $x = -20/(2(-2)) = 5$. Sustituyendo $x=5$ en la función, obtenemos $B(5) = -2(5)^2 + 20(5) - 10 = -2(25) + 100 - 10 = -50 + 100 - 10 = 40$. El beneficio máximo es \\$40.000.',
        ),
      ),
    ),
    2 => 
    array (
      'id' => 'd3',
      'type' => 'multiple',
      'skill' => 'Identifica las soluciones de una ecuación cuadrática usando la fórmula general.',
      'points' => 1,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Para la ecuación cuadrática $x^2 - 4x - 12 = 0$, seleccione todas las soluciones correctas.',
          'options' => 
          array (
            0 => '$x = -6$',
            1 => '$x = -2$',
            2 => '$x = 2$',
            3 => '$x = 6$',
          ),
          'correct' => 
          array (
            0 => 1,
            1 => 3,
          ),
          'solution' => 'Usando la fórmula general $x = \\frac{-b \\pm \\sqrt{b^2 - 4ac}}{2a}$ para $x^2 - 4x - 12 = 0$: $x = \\frac{-(-4) \\pm \\sqrt{(-4)^2 - 4(1)(-12)}}{2(1)} = \\frac{4 \\pm \\sqrt{16 + 48}}{2} = \\frac{4 \\pm \\sqrt{64}}{2} = \\frac{4 \\pm 8}{2}$. Las soluciones son $x_1 = \\frac{4 + 8}{2} = \\frac{12}{2} = 6$ y $x_2 = \\frac{4 - 8}{2} = \\frac{-4}{2} = -2$.',
        ),
        1 => 
        array (
          'stem' => 'Para la ecuación cuadrática $2x^2 + 2x - 12 = 0$, seleccione todas las soluciones correctas.',
          'options' => 
          array (
            0 => '$x = -3$',
            1 => '$x = -2$',
            2 => '$x = 1$',
            3 => '$x = 2$',
          ),
          'correct' => 
          array (
            0 => 0,
            1 => 3,
          ),
          'solution' => 'Dividiendo la ecuación por 2 obtenemos $x^2 + x - 6 = 0$. Usando la fórmula general $x = \\frac{-b \\pm \\sqrt{b^2 - 4ac}}{2a}$: $x = \\frac{-1 \\pm \\sqrt{1^2 - 4(1)(-6)}}{2(1)} = \\frac{-1 \\pm \\sqrt{1 + 24}}{2} = \\frac{-1 \\pm \\sqrt{25}}{2} = \\frac{-1 \\pm 5}{2}$. Las soluciones son $x_1 = \\frac{-1 + 5}{2} = \\frac{4}{2} = 2$ y $x_2 = \\frac{-1 - 5}{2} = \\frac{-6}{2} = -3$.',
        ),
      ),
    ),
    3 => 
    array (
      'id' => 'd4',
      'type' => 'vf',
      'skill' => 'Comprende la relación entre el discriminante y el número de raíces reales.',
      'points' => 1,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Si el discriminante de una ecuación cuadrática es $0$, la ecuación tiene exactamente una solución real.',
          'tf' => true,
          'solution' => 'Cuando el discriminante $\\Delta = b^2 - 4ac$ es igual a $0$, la fórmula general $x = \\frac{-b \\pm \\sqrt{0}}{2a}$ se reduce a $x = \\frac{-b}{2a}$, lo que significa que hay una única solución real, que a menudo se describe como dos soluciones reales iguales.',
        ),
        1 => 
        array (
          'stem' => 'Una función cuadrática siempre intersecta el eje $x$ en dos puntos diferentes.',
          'tf' => false,
          'solution' => 'Una función cuadrática puede intersectar el eje $x$ en dos puntos (si su discriminante es positivo), en un solo punto (si su discriminante es cero) o no intersectar el eje $x$ en ningún punto (si su discriminante es negativo).',
        ),
      ),
    ),
    4 => 
    array (
      'id' => 'd5',
      'type' => 'corta',
      'skill' => 'Calcula el eje de simetría de una función cuadrática.',
      'points' => 1,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => '¿Cuál es la ecuación del eje de simetría de la función cuadrática $f(x) = 3x^2 - 12x + 5$?',
          'answer' => '$x = 2$',
          'solution' => 'El eje de simetría de una función cuadrática $f(x) = ax^2 + bx + c$ se encuentra en $x = -b/(2a)$. Para $f(x) = 3x^2 - 12x + 5$, $x = -(-12)/(2 \\cdot 3) = 12/6 = 2$.',
        ),
        1 => 
        array (
          'stem' => '¿Cuál es la ecuación del eje de simetría de la función cuadrática $g(x) = -x^2 - 8x + 10$?',
          'answer' => '$x = -4$',
          'solution' => 'El eje de simetría de una función cuadrática $g(x) = ax^2 + bx + c$ se encuentra en $x = -b/(2a)$. Para $g(x) = -x^2 - 8x + 10$, $x = -(-8)/(2 \\cdot (-1)) = 8/(-2) = -4$.',
        ),
      ),
    ),
    5 => 
    array (
      'id' => 'd6',
      'type' => 'completar',
      'skill' => 'Asocia los coeficientes de una ecuación cuadrática con los términos correctos.',
      'points' => 1,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'En la ecuación cuadrática $ax^2 + bx + c = 0$, el término {{1}} es el término cuadrático, el término {{2}} es el término lineal y el término {{3}} es el término independiente.',
          'blanks' => 
          array (
            0 => '$ax^2$',
            1 => '$bx$',
            2 => '$c$',
          ),
          'solution' => 'Los términos de una ecuación cuadrática estándar son el término cuadrático ($ax^2$), el término lineal ($bx$) y el término independiente ($c$). El coeficiente $a$ no puede ser cero en una ecuación cuadrática.',
        ),
        1 => 
        array (
          'stem' => 'El vértice de una parábola representa el punto {{1}} o {{2}} de la función cuadrática. Su coordenada $x$ se calcula con la fórmula {{3}}.',
          'blanks' => 
          array (
            0 => 'máximo',
            1 => 'mínimo',
            2 => '$x = -b/(2a)$',
          ),
          'solution' => 'El vértice es el punto más alto (máximo) o más bajo (mínimo) de la parábola. Su coordenada $x$ se calcula con la fórmula del eje de simetría, $x = -b/(2a)$.',
        ),
      ),
    ),
    6 => 
    array (
      'id' => 'd7',
      'type' => 'problema',
      'skill' => 'Resuelve un problema de maximización de área utilizando funciones cuadráticas.',
      'points' => 3,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Don Pedro quiere cercar un jardín rectangular usando $60\\,\\text{m}$ de malla. Uno de los lados del jardín ya está cubierto por una pared de su casa, por lo que solo necesita cercar los otros tres lados. ¿Cuáles deben ser las dimensiones del jardín para que su área sea máxima?',
          'answer' => 'Las dimensiones deben ser $15\\,\\text{m}$ (ancho) por $30\\,\\text{m}$ (largo).',
          'solution' => '1. Sea $x$ el ancho del jardín (los dos lados iguales) y $y$ el largo (el lado opuesto a la pared).
2. La cantidad de malla disponible es $2x + y = 60\\,\\text{m}$.
3. De la ecuación de perímetro, despejamos $y$: $y = 60 - 2x$.
4. El área del jardín es $A = x \\cdot y$.
5. Sustituimos $y$ en la fórmula del área: $A(x) = x(60 - 2x) = 60x - 2x^2$.
6. Esta es una función cuadrática $A(x) = -2x^2 + 60x$. El valor máximo se encuentra en el vértice, donde $x = -b/(2a)$.
7. $x = -60/(2(-2)) = -60/(-4) = 15$. Así, el ancho es $15\\,\\text{m}$.
8. Calculamos el largo: $y = 60 - 2(15) = 60 - 30 = 30\\,\\text{m}$.',
          'rubric' => 
          array (
            0 => 'Plantea correctamente las ecuaciones de perímetro y área.',
            1 => 'Forma la función cuadrática para el área.',
            2 => 'Calcula el vértice de la función para encontrar las dimensiones.',
          ),
        ),
        1 => 
        array (
          'stem' => 'Una granja avícola en Cundinamarca desea construir un corral rectangular para gallinas junto a un granero existente. Solo necesita cercar tres lados del corral, ya que el granero formará el cuarto lado. Si dispone de $80\\,\\text{m}$ de cerca, ¿qué dimensiones maximizarán el área del corral?',
          'answer' => 'Las dimensiones deben ser $20\\,\\text{m}$ (ancho) por $40\\,\\text{m}$ (largo).',
          'solution' => '1. Sea $x$ el ancho del corral (los dos lados perpendiculares al granero) y $y$ el largo (el lado paralelo al granero).
2. La cantidad de cerca disponible es $2x + y = 80\\,\\text{m}$.
3. De la ecuación de perímetro, despejamos $y$: $y = 80 - 2x$.
4. El área del corral es $A = x \\cdot y$.
5. Sustituimos $y$ en la fórmula del área: $A(x) = x(80 - 2x) = 80x - 2x^2$.
6. Esta es una función cuadrática $A(x) = -2x^2 + 80x$. El valor máximo se encuentra en el vértice, donde $x = -b/(2a)$.
7. $x = -80/(2(-2)) = -80/(-4) = 20$. Así, el ancho es $20\\,\\text{m}$.
8. Calculamos el largo: $y = 80 - 2(20) = 80 - 40 = 40\\,\\text{m}$.',
          'rubric' => 
          array (
            0 => 'Plantea correctamente las ecuaciones de perímetro y área.',
            1 => 'Forma la función cuadrática para el área.',
            2 => 'Calcula el vértice de la función para encontrar las dimensiones.',
          ),
        ),
      ),
    ),
    7 => 
    array (
      'id' => 'd8',
      'type' => 'problema',
      'skill' => 'Resuelve ecuaciones cuadráticas aplicadas a problemas de movimiento parabólico.',
      'points' => 3,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Un cohete de juguete es lanzado verticalmente desde el suelo. Su altura $h$ (en metros) en función del tiempo $t$ (en segundos) está dada por la ecuación $h(t) = -5t^2 + 40t$. ¿Cuánto tiempo tarda el cohete en volver a tocar el suelo?',
          'answer' => '$8\\,\\text{s}$.',
          'solution' => '1. El cohete toca el suelo cuando su altura $h(t)$ es $0$.
2. Planteamos la ecuación: $-5t^2 + 40t = 0$.
3. Factorizamos el término común $5t$: $5t(-t + 8) = 0$.
4. Esto nos da dos posibles soluciones para $t$: $5t = 0 \\implies t = 0$ (momento del lanzamiento) o $-t + 8 = 0 \\implies t = 8$.
5. Por lo tanto, el cohete vuelve a tocar el suelo después de $8\\,\\text{s}$.',
          'rubric' => 
          array (
            0 => 'Establece la ecuación correcta para encontrar el tiempo de regreso al suelo.',
            1 => 'Resuelve la ecuación cuadrática por factorización o fórmula general.',
            2 => 'Interpreta la solución en el contexto del problema.',
          ),
        ),
        1 => 
        array (
          'stem' => 'Desde lo alto de una torre de $15\\,\\text{m}$ de altura, se lanza una piedra hacia arriba con una velocidad inicial de $10\\,\\text{m/s}$. La altura $h$ de la piedra sobre el suelo en función del tiempo $t$ (en segundos) está dada por la ecuación $h(t) = -5t^2 + 10t + 15$. ¿Cuánto tiempo tarda la piedra en llegar al suelo?',
          'answer' => '$3\\,\\text{s}$.',
          'solution' => '1. La piedra llega al suelo cuando su altura $h(t)$ es $0$.
2. Planteamos la ecuación: $-5t^2 + 10t + 15 = 0$.
3. Dividimos toda la ecuación por $-5$ para simplificar: $t^2 - 2t - 3 = 0$.
4. Factorizamos la ecuación cuadrática: $(t - 3)(t + 1) = 0$.
5. Esto nos da dos posibles soluciones para $t$: $t - 3 = 0 \\implies t = 3$ o $t + 1 = 0 \\implies t = -1$.
6. El tiempo no puede ser negativo, por lo tanto, la solución válida es $t = 3\\,\\text{s}$.',
          'rubric' => 
          array (
            0 => 'Establece la ecuación correcta para encontrar el tiempo de regreso al suelo.',
            1 => 'Resuelve la ecuación cuadrática por factorización o fórmula general.',
            2 => 'Interpreta la solución en el contexto del problema.',
          ),
        ),
      ),
    ),
    8 => 
    array (
      'id' => 'd9',
      'type' => 'abierta',
      'skill' => 'Explica el significado del discriminante y su aplicación en problemas.',
      'points' => 2,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Explica con tus propias palabras qué representa el discriminante de una ecuación cuadrática y cómo nos ayuda a entender las soluciones de un problema aplicado, como la trayectoria de un objeto.',
          'answer' => 'El discriminante ($\\Delta = b^2 - 4ac$) es una parte de la fórmula general que nos indica la naturaleza de las soluciones de una ecuación cuadrática. Si es positivo, hay dos soluciones reales distintas (ej. el objeto pasa dos veces por una altura). Si es cero, hay una solución real única (ej. el objeto alcanza su altura máxima o toca el suelo una vez). Si es negativo, no hay soluciones reales (ej. el objeto nunca alcanza una cierta altura).',
          'rubric' => 
          array (
            0 => 'Define el discriminante y su fórmula.',
            1 => 'Explica cada caso ($\\Delta > 0, \\Delta = 0, \\Delta < 0$) y el tipo de soluciones.',
            2 => 'Relaciona los casos con ejemplos de problemas aplicados (trayectoria, altura, etc.).',
          ),
        ),
        1 => 
        array (
          'stem' => 'Describe la importancia del vértice de una parábola en el contexto de un problema de optimización, como maximizar un área o minimizar un costo. ¿Cómo se calcula y qué información nos proporciona?',
          'answer' => 'El vértice de una parábola representa el punto máximo o mínimo de una función cuadrática, lo cual es crucial en problemas de optimización. Se calcula usando la fórmula $x = -b/(2a)$ para la coordenada $x$ (o la variable independiente), y luego se sustituye este valor en la función para obtener la coordenada $y$ (o el valor óptimo). Nos proporciona el valor de la variable que optimiza la situación y el valor máximo o mínimo que se puede alcanzar.',
          'rubric' => 
          array (
            0 => 'Define el vértice como punto máximo/mínimo de una función cuadrática.',
            1 => 'Explica cómo se calcula la coordenada $x$ del vértice.',
            2 => 'Explica qué información útil proporciona el vértice en problemas de optimización.',
          ),
        ),
      ),
    ),
    9 => 
    array (
      'id' => 'd10',
      'type' => 'relacionar',
      'skill' => 'Relaciona ecuaciones cuadráticas con sus soluciones o características.',
      'points' => 2,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Relacione cada ecuación cuadrática con la característica de sus soluciones.',
          'pairs' => 
          array (
            0 => 
            array (
              'l' => '$x^2 - 6x + 9 = 0$',
              'r' => 'Una solución real (doble)',
            ),
            1 => 
            array (
              'l' => '$x^2 + 4x + 5 = 0$',
              'r' => 'No tiene soluciones reales',
            ),
            2 => 
            array (
              'l' => '$x^2 - 5x + 6 = 0$',
              'r' => 'Dos soluciones reales distintas',
            ),
            3 => 
            array (
              'l' => '$x^2 = 16$',
              'r' => 'Dos soluciones reales opuestas',
            ),
          ),
          'solution' => '',
        ),
        1 => 
        array (
          'stem' => 'Relacione cada función cuadrática con la característica de su gráfica.',
          'pairs' => 
          array (
            0 => 
            array (
              'l' => '$f(x) = x^2 + 2x + 1$',
              'r' => 'Vértice en el eje x',
            ),
            1 => 
            array (
              'l' => '$f(x) = -x^2 + 4x - 1$',
              'r' => 'Abre hacia abajo',
            ),
            2 => 
            array (
              'l' => '$f(x) = 2x^2 - 8x + 3$',
              'r' => 'Abre hacia arriba',
            ),
            3 => 
            array (
              'l' => '$f(x) = x^2 + 1$',
              'r' => 'No corta el eje x',
            ),
          ),
          'solution' => '',
        ),
      ),
    ),
    10 => 
    array (
      'id' => 'd11',
      'type' => 'ordenar',
      'skill' => 'Ordena los pasos para resolver una ecuación cuadrática usando la fórmula general.',
      'points' => 2,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Ordene los siguientes pasos para resolver una ecuación cuadrática de la forma $ax^2 + bx + c = 0$ usando la fórmula general, desde el primero hasta el último.',
          'items' => 
          array (
            0 => 'Identificar los coeficientes $a$, $b$ y $c$.',
            1 => 'Sustituir los valores de $a$, $b$ y $c$ en la fórmula $x = \\frac{-b \\pm \\sqrt{b^2 - 4ac}}{2a}$.',
            2 => 'Calcular el valor del discriminante ($b^2 - 4ac$).',
            3 => 'Realizar las operaciones para obtener las soluciones $x_1$ y $x_2$ (si existen).',
          ),
          'solution' => 'El proceso estándar para resolver una ecuación cuadrática con la fórmula general implica primero identificar los coeficientes, luego sustituirlos en la fórmula, calcular el discriminante y finalmente resolver para las raíces.',
        ),
        1 => 
        array (
          'stem' => 'Ordene los siguientes pasos para encontrar el vértice de una función cuadrática $f(x) = ax^2 + bx + c$, desde el primero hasta el último.',
          'items' => 
          array (
            0 => 'Identificar los coeficientes $a$ y $b$ de la función.',
            1 => 'Calcular la coordenada $x$ del vértice usando la fórmula $x = -b/(2a)$.',
            2 => 'Sustituir el valor de la coordenada $x$ en la función original.',
            3 => 'Calcular la coordenada $y$ (o $f(x)$) del vértice.',
          ),
          'solution' => 'Para encontrar el vértice, primero se identifican los coeficientes, se calcula la coordenada $x$ con la fórmula del eje de simetría, y luego se usa ese valor para encontrar la coordenada $y$ correspondiente.',
        ),
      ),
    ),
    11 => 
    array (
      'id' => 'd12',
      'type' => 'crucigrama',
      'skill' => 'Identifica conceptos clave relacionados con ecuaciones y funciones cuadráticas.',
      'points' => 4,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Complete el siguiente crucigrama con términos relacionados con las ecuaciones y funciones cuadráticas.',
          'words' => 
          array (
            0 => 
            array (
              'w' => 'VERTICE',
              'c' => 'Punto máximo o mínimo de una parábola.',
            ),
            1 => 
            array (
              'w' => 'PARABOLA',
              'c' => 'Gráfica de una función cuadrática.',
            ),
            2 => 
            array (
              'w' => 'DISCRIMINANTE',
              'c' => 'Expresión que determina la naturaleza de las raíces.',
            ),
            3 => 
            array (
              'w' => 'RAICES',
              'c' => 'Soluciones de una ecuación cuadrática.',
            ),
            4 => 
            array (
              'w' => 'LINEAL',
              'c' => 'Tipo de término que acompaña a la $x$ con exponente 1.',
            ),
            5 => 
            array (
              'w' => 'CUADRATICA',
              'c' => 'Tipo de ecuación o función cuyo mayor exponente es 2.',
            ),
            6 => 
            array (
              'w' => 'FORMULA',
              'c' => 'Método general para resolver cualquier ecuación de segundo grado.',
            ),
            7 => 
            array (
              'w' => 'EJE',
              'c' => 'Línea imaginaria que divide la parábola en dos partes simétricas.',
            ),
          ),
        ),
        1 => 
        array (
          'stem' => 'Complete el siguiente crucigrama con términos importantes de las ecuaciones cuadráticas.',
          'words' => 
          array (
            0 => 
            array (
              'w' => 'COEFICIENTE',
              'c' => 'Número que multiplica a una variable en un término.',
            ),
            1 => 
            array (
              'w' => 'INDEPENDIENTE',
              'c' => 'Término sin variable en una ecuación cuadrática.',
            ),
            2 => 
            array (
              'w' => 'SOLUCIONES',
              'c' => 'Valores de $x$ que satisfacen la ecuación cuadrática.',
            ),
            3 => 
            array (
              'w' => 'SIMETRIA',
              'c' => 'Propiedad del eje de una parábola.',
            ),
            4 => 
            array (
              'w' => 'GRAFICA',
              'c' => 'Representación visual de una función.',
            ),
            5 => 
            array (
              'w' => 'INTERSECCION',
              'c' => 'Punto donde la parábola corta el eje x o y.',
            ),
            6 => 
            array (
              'w' => 'MAXIMO',
              'c' => 'Valor más alto que puede tomar una función que abre hacia abajo.',
            ),
            7 => 
            array (
              'w' => 'MINIMO',
              'c' => 'Valor más bajo que puede tomar una función que abre hacia arriba.',
            ),
          ),
        ),
      ),
    ),
  ),
  'fisica' => 
  array (
    0 => 
    array (
      'id' => 'd13',
      'type' => 'unica',
      'skill' => 'Calcula la velocidad final de un objeto en MRUA.',
      'points' => 1,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Un carro de Rappi parte del reposo y acelera uniformemente a $2{,}5\\,\\text{m/s}^2$ durante $8\\,\\text{s}$. ¿Cuál es la velocidad final del carro?',
          'options' => 
          array (
            0 => '$10\\,\\text{m/s}$',
            1 => '$15\\,\\text{m/s}$',
            2 => '$20\\,\\text{m/s}$',
            3 => '$25\\,\\text{m/s}$',
          ),
          'correct' => 
          array (
            0 => 2,
          ),
          'solution' => 'Utilizando la ecuación $v_f = v_i + a \\times t$, con $v_i = 0\\,\\text{m/s}$, $a = 2{,}5\\,\\text{m/s}^2$ y $t = 8\\,\\text{s}$, obtenemos $v_f = 0 + 2{,}5 \\times 8 = 20\\,\\text{m/s}$.',
        ),
        1 => 
        array (
          'stem' => 'Una moto de domicilios que inicialmente se mueve a $5\\,\\text{m/s}$ acelera uniformemente a $1{,}5\\,\\text{m/s}^2$ durante $10\\,\\text{s}$. ¿Cuál es la velocidad final de la moto?',
          'options' => 
          array (
            0 => '$15\\,\\text{m/s}$',
            1 => '$20\\,\\text{m/s}$',
            2 => '$25\\,\\text{m/s}$',
            3 => '$30\\,\\text{m/s}$',
          ),
          'correct' => 
          array (
            0 => 2,
          ),
          'solution' => 'Utilizando la ecuación $v_f = v_i + a \\times t$, con $v_i = 5\\,\\text{m/s}$, $a = 1{,}5\\,\\text{m/s}^2$ y $t = 10\\,\\text{s}$, obtenemos $v_f = 5 + 1{,}5 \\times 10 = 5 + 15 = 20\\,\\text{m/s}$.',
        ),
      ),
    ),
    1 => 
    array (
      'id' => 'd14',
      'type' => 'unica',
      'skill' => 'Interpreta gráficas de velocidad vs. tiempo para calcular la aceleración.',
      'points' => 1,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'La gráfica de velocidad contra tiempo de un bus intermunicipal muestra que su velocidad cambia de $10\\,\\text{m/s}$ a $30\\,\\text{m/s}$ en $5\\,\\text{s}$ con aceleración constante. ¿Cuál es la aceleración del bus?',
          'options' => 
          array (
            0 => '$2\\,\\text{m/s}^2$',
            1 => '$4\\,\\text{m/s}^2$',
            2 => '$6\\,\\text{m/s}^2$',
            3 => '$8\\,\\text{m/s}^2$',
          ),
          'correct' => 
          array (
            0 => 1,
          ),
          'solution' => 'La aceleración se calcula como el cambio de velocidad dividido por el cambio de tiempo: $a = \\frac{\\Delta v}{\\Delta t} = \\frac{v_f - v_i}{t} = \\frac{30\\,\\text{m/s} - 10\\,\\text{m/s}}{5\\,\\text{s}} = \\frac{20\\,\\text{m/s}}{5\\,\\text{s}} = 4\\,\\text{m/s}^2$.',
        ),
        1 => 
        array (
          'stem' => 'Un ciclista que entrena en las vías de Cundinamarca aumenta su velocidad de $8\\,\\text{m/s}$ a $20\\,\\text{m/s}$ en $6\\,\\text{s}$ manteniendo una aceleración constante. ¿Cuál es la aceleración del ciclista?',
          'options' => 
          array (
            0 => '$1\\,\\text{m/s}^2$',
            1 => '$2\\,\\text{m/s}^2$',
            2 => '$3\\,\\text{m/s}^2$',
            3 => '$4\\,\\text{m/s}^2$',
          ),
          'correct' => 
          array (
            0 => 1,
          ),
          'solution' => 'La aceleración se calcula como el cambio de velocidad dividido por el cambio de tiempo: $a = \\frac{\\Delta v}{\\Delta t} = \\frac{v_f - v_i}{t} = \\frac{20\\,\\text{m/s} - 8\\,\\text{m/s}}{6\\,\\text{s}} = \\frac{12\\,\\text{m/s}}{6\\,\\text{s}} = 2\\,\\text{m/s}^2$.',
        ),
      ),
    ),
    2 => 
    array (
      'id' => 'd15',
      'type' => 'multiple',
      'skill' => 'Identifica las características correctas del movimiento rectilíneo uniformemente acelerado (MRUA).',
      'points' => 1,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Seleccione todas las afirmaciones correctas sobre el Movimiento Rectilíneo Uniformemente Acelerado (MRUA):',
          'options' => 
          array (
            0 => 'La velocidad del objeto cambia linealmente con el tiempo.',
            1 => 'La aceleración del objeto es constante y diferente de cero.',
            2 => 'La distancia recorrida es directamente proporcional al tiempo.',
            3 => 'La gráfica de velocidad contra tiempo es una línea recta.',
          ),
          'correct' => 
          array (
            0 => 0,
            1 => 1,
            2 => 3,
          ),
          'solution' => 'En el MRUA, la aceleración es constante, lo que implica que la velocidad cambia linealmente con el tiempo. Por lo tanto, la gráfica de velocidad contra tiempo es una línea recta. La distancia recorrida no es directamente proporcional al tiempo, sino al cuadrado del tiempo si parte del reposo.',
        ),
        1 => 
        array (
          'stem' => 'Seleccione todas las afirmaciones correctas sobre las gráficas de MRUA:',
          'options' => 
          array (
            0 => 'La pendiente de la gráfica de velocidad contra tiempo representa la aceleración.',
            1 => 'El área bajo la gráfica de aceleración contra tiempo representa el cambio de velocidad.',
            2 => 'La gráfica de posición contra tiempo es una parábola.',
            3 => 'La gráfica de aceleración contra tiempo es una línea horizontal.',
          ),
          'correct' => 
          array (
            0 => 0,
            1 => 1,
            2 => 2,
            3 => 3,
          ),
          'solution' => 'En el MRUA, la aceleración es constante, por lo que su gráfica es una línea horizontal. La pendiente de v-t es la aceleración. El área bajo a-t es el cambio de velocidad. La posición cambia cuadráticamente con el tiempo, por lo que su gráfica es una parábola.',
        ),
      ),
    ),
    3 => 
    array (
      'id' => 'd16',
      'type' => 'vf',
      'skill' => 'Diferencia entre MRU y MRUA a partir de la aceleración.',
      'points' => 1,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Si un objeto se mueve con velocidad constante, su aceleración es cero y se considera un caso particular de MRUA.',
          'tf' => false,
          'solution' => 'Si un objeto se mueve con velocidad constante, su aceleración es cero, lo que corresponde a un Movimiento Rectilíneo Uniforme (MRU). El MRUA implica una aceleración constante y diferente de cero.',
        ),
        1 => 
        array (
          'stem' => 'La aceleración en caída libre en la Tierra (despreciando la resistencia del aire) es constante e igual a $9{,}8\\,\\text{m/s}^2$, lo que la clasifica como MRUA.',
          'tf' => true,
          'solution' => 'La aceleración debida a la gravedad es constante (aproximadamente $9{,}8\\,\\text{m/s}^2$) y actúa uniformemente sobre los objetos en caída libre, lo que la define como un tipo de MRUA.',
        ),
      ),
    ),
    4 => 
    array (
      'id' => 'd17',
      'type' => 'corta',
      'skill' => 'Identifica el tipo de movimiento a partir de una característica clave.',
      'points' => 1,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => '¿Qué tipo de movimiento experimenta un objeto si su velocidad cambia a una tasa constante?',
          'answer' => 'MRUA',
          'solution' => 'Cuando la velocidad cambia a una tasa constante, significa que la aceleración es constante y diferente de cero, lo que define el Movimiento Rectilíneo Uniformemente Acelerado (MRUA).',
        ),
        1 => 
        array (
          'stem' => '¿Cómo se llama el movimiento de un objeto lanzado verticalmente hacia arriba, despreciando la resistencia del aire?',
          'answer' => 'Caída libre',
          'solution' => 'El movimiento de un objeto bajo la única influencia de la gravedad se conoce como caída libre, el cual es un caso particular de MRUA.',
        ),
      ),
    ),
    5 => 
    array (
      'id' => 'd18',
      'type' => 'completar',
      'skill' => 'Completa enunciados sobre las características del MRUA.',
      'points' => 1,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'En el Movimiento Rectilíneo Uniformemente Acelerado (MRUA), la aceleración es {{1}} y su trayectoria es una línea {{2}}.',
          'blanks' => 
          array (
            0 => 'constante',
            1 => 'recta',
          ),
          'solution' => 'En el MRUA, la aceleración se mantiene constante y la trayectoria es siempre una línea recta.',
        ),
        1 => 
        array (
          'stem' => 'Si un objeto parte del reposo en MRUA, su velocidad inicial es {{1}} y el desplazamiento es proporcional al {{2}} del tiempo.',
          'blanks' => 
          array (
            0 => 'cero',
            1 => 'cuadrado',
          ),
          'solution' => 'Partir del reposo significa que la velocidad inicial es cero. En MRUA, el desplazamiento es proporcional al cuadrado del tiempo ($\\Delta x = \\frac{1}{2}at^2$) si la velocidad inicial es cero.',
        ),
      ),
    ),
    6 => 
    array (
      'id' => 'd19',
      'type' => 'problema',
      'skill' => 'Calcula la altura máxima y el tiempo en caída libre.',
      'points' => 3,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Un balín es lanzado verticalmente hacia arriba con una velocidad inicial de $29{,}4\\,\\text{m/s}$ desde el suelo. Considerando $g = 9{,}8\\,\\text{m/s}^2$ y despreciando la resistencia del aire, ¿cuál es la altura máxima que alcanza y cuánto tiempo tarda en llegar a esa altura?',
          'answer' => 'Altura máxima: $44{,}1\\,\\text{m}$, Tiempo: $3\\,\\text{s}$',
          'solution' => 'Para la altura máxima, la velocidad final es $0\\,\\text{m/s}$.
1. Usamos $v_f^2 = v_i^2 + 2gy$.
2. $0^2 = (29{,}4)^2 + 2(-9{,}8)y \\implies 0 = 864{,}36 - 19{,}6y$.
3. $19{,}6y = 864{,}36 \\implies y = \\frac{864{,}36}{19{,}6} = 44{,}1\\,\\text{m}$.
Para el tiempo:
1. Usamos $v_f = v_i + gt$.
2. $0 = 29{,}4 + (-9{,}8)t$.
3. $9{,}8t = 29{,}4 \\implies t = \\frac{29{,}4}{9{,}8} = 3\\,\\text{s}$.',
          'rubric' => 
          array (
            0 => 'Calcula correctamente la altura máxima usando la ecuación de MRUA sin tiempo.',
            1 => 'Calcula correctamente el tiempo para alcanzar la altura máxima usando la ecuación de velocidad final.',
            2 => 'Usa el valor de la gravedad y signos correctos.',
          ),
        ),
        1 => 
        array (
          'stem' => 'Desde el balcón de un edificio en Barranquilla, se lanza una piedra verticalmente hacia arriba con una velocidad de $19{,}6\\,\\text{m/s}$. Si la resistencia del aire es despreciable y $g = 9{,}8\\,\\text{m/s}^2$, ¿cuál es la altura máxima que alcanza la piedra desde el punto de lanzamiento y cuánto tiempo tarda en subir hasta ese punto?',
          'answer' => 'Altura máxima: $19{,}6\\,\\text{m}$, Tiempo: $2\\,\\text{s}$',
          'solution' => 'Para la altura máxima, la velocidad final es $0\\,\\text{m/s}$.
1. Usamos $v_f^2 = v_i^2 + 2gy$.
2. $0^2 = (19{,}6)^2 + 2(-9{,}8)y \\implies 0 = 384{,}16 - 19{,}6y$.
3. $19{,}6y = 384{,}16 \\implies y = \\frac{384{,}16}{19{,}6} = 19{,}6\\,\\text{m}$.
Para el tiempo:
1. Usamos $v_f = v_i + gt$.
2. $0 = 19{,}6 + (-9{,}8)t$.
3. $9{,}8t = 19{,}6 \\implies t = \\frac{19{,}6}{9{,}8} = 2\\,\\text{s}$.',
          'rubric' => 
          array (
            0 => 'Calcula correctamente la altura máxima desde el punto de lanzamiento.',
            1 => 'Calcula correctamente el tiempo de subida.',
            2 => 'Aplica correctamente la aceleración de la gravedad y las ecuaciones de MRUA.',
          ),
        ),
      ),
    ),
    7 => 
    array (
      'id' => 'd20',
      'type' => 'problema',
      'skill' => 'Calcula el desplazamiento y la aceleración a partir de una gráfica v-t.',
      'points' => 3,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Un tren de cercanías que va hacia Zipaquirá tiene la siguiente gráfica de velocidad contra tiempo. Calcula el desplazamiento total del tren en los primeros $10\\,\\text{s}$ y la aceleración entre $0\\,\\text{s}$ y $5\\,\\text{s}$.

Gráfica: La velocidad aumenta linealmente de $0\\,\\text{m/s}$ a $20\\,\\text{m/s}$ en los primeros $5\\,\\text{s}$, y luego se mantiene constante en $20\\,\\text{m/s}$ hasta los $10\\,\\text{s}$.',
          'answer' => 'Desplazamiento total: $150\\,\\text{m}$, Aceleración ($0-5\\,\\text{s}$): $4\\,\\text{m/s}^2$',
          'solution' => 'Desplazamiento total:
1. De $0\\,\\text{s}$ a $5\\,\\text{s}$ (triángulo): $\\text{Área}_1 = \\frac{1}{2} \\times \\text{base} \\times \\text{altura} = \\frac{1}{2} \\times 5\\,\\text{s} \\times 20\\,\\text{m/s} = 50\\,\\text{m}$.
2. De $5\\,\\text{s}$ a $10\\,\\text{s}$ (rectángulo): $\\text{Área}_2 = \\text{base} \\times \\text{altura} = (10\\,\\text{s} - 5\\,\\text{s}) \\times 20\\,\\text{m/s} = 5\\,\\text{s} \\times 20\\,\\text{m/s} = 100\\,\\text{m}$.
3. Desplazamiento total = $\\text{Área}_1 + \\text{Área}_2 = 50\\,\\text{m} + 100\\,\\text{m} = 150\\,\\text{m}$.
Aceleración entre $0\\,\\text{s}$ y $5\\,\\text{s}$:
1. $a = \\frac{\\Delta v}{\\Delta t} = \\frac{v_f - v_i}{t} = \\frac{20\\,\\text{m/s} - 0\\,\\text{m/s}}{5\\,\\text{s}} = \\frac{20\\,\\text{m/s}}{5\\,\\text{s}} = 4\\,\\text{m/s}^2$.',
          'rubric' => 
          array (
            0 => 'Calcula correctamente el desplazamiento total dividiendo la gráfica en secciones y sumando las áreas.',
            1 => 'Determina la aceleración en el primer tramo a partir de la pendiente de la gráfica v-t.',
            2 => 'Muestra los cálculos de área y pendiente de forma organizada.',
          ),
        ),
        1 => 
        array (
          'stem' => 'Un carro de carga que transita por la Vía 40 en Barranquilla presenta el siguiente perfil de velocidad. Calcula el desplazamiento total del carro en los primeros $12\\,\\text{s}$ y la aceleración entre $0\\,\\text{s}$ y $6\\,\\text{s}$.

Gráfica: La velocidad aumenta linealmente de $0\\,\\text{m/s}$ a $18\\,\\text{m/s}$ en los primeros $6\\,\\text{s}$, y luego se mantiene constante en $18\\,\\text{m/s}$ hasta los $12\\,\\text{s}$.',
          'answer' => 'Desplazamiento total: $162\\,\\text{m}$, Aceleración ($0-6\\,\\text{s}$): $3\\,\\text{m/s}^2$',
          'solution' => 'Desplazamiento total:
1. De $0\\,\\text{s}$ a $6\\,\\text{s}$ (triángulo): $\\text{Área}_1 = \\frac{1}{2} \\times \\text{base} \\times \\text{altura} = \\frac{1}{2} \\times 6\\,\\text{s} \\times 18\\,\\text{m/s} = 54\\,\\text{m}$.
2. De $6\\,\\text{s}$ a $12\\,\\text{s}$ (rectángulo): $\\text{Área}_2 = \\text{base} \\times \\text{altura} = (12\\,\\text{s} - 6\\,\\text{s}) \\times 18\\,\\text{m/s} = 6\\,\\text{s} \\times 18\\,\\text{m/s} = 108\\,\\text{m}$.
3. Desplazamiento total = $\\text{Área}_1 + \\text{Área}_2 = 54\\,\\text{m} + 108\\,\\text{m} = 162\\,\\text{m}$.
Aceleración entre $0\\,\\text{s}$ y $6\\,\\text{s}$:
1. $a = \\frac{\\Delta v}{\\Delta t} = \\frac{v_f - v_i}{t} = \\frac{18\\,\\text{m/s} - 0\\,\\text{m/s}}{6\\,\\text{s}} = \\frac{18\\,\\text{m/s}}{6\\,\\text{s}} = 3\\,\\text{m/s}^2$.',
          'rubric' => 
          array (
            0 => 'Calcula correctamente el desplazamiento total como la suma de las áreas bajo la curva v-t.',
            1 => 'Determina la aceleración en el primer segmento de la gráfica v-t.',
            2 => 'Presenta los cálculos de forma clara y coherente.',
          ),
        ),
      ),
    ),
    8 => 
    array (
      'id' => 'd21',
      'type' => 'abierta',
      'skill' => 'Explica la importancia de la aceleración en situaciones cotidianas.',
      'points' => 2,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Explique con sus propias palabras la importancia de entender el concepto de aceleración en la vida cotidiana. Mencione un ejemplo diferente a los vistos en clase.',
          'answer' => 'Entender la aceleración es crucial para prever cómo cambia la velocidad de los objetos, lo cual es vital para la seguridad y el diseño. Por ejemplo, al conducir un carro en la vía Bogotá-Medellín, conocer la capacidad de aceleración y frenado es fundamental para adelantar con seguridad o evitar colisiones. También es útil para diseñar montañas rusas, donde la aceleración determina la emoción y seguridad de la experiencia.',
          'rubric' => 
          array (
            0 => 'Define o explica el concepto de aceleración de forma clara.',
            1 => 'Argumenta la importancia del concepto en la vida cotidiana.',
            2 => 'Proporciona un ejemplo pertinente y original.',
          ),
        ),
        1 => 
        array (
          'stem' => 'Describa qué información se puede obtener de la pendiente y del área bajo la curva en una gráfica de velocidad contra tiempo para un objeto en MRUA. Proporcione un ejemplo práctico.',
          'answer' => 'En una gráfica de velocidad contra tiempo (v-t) para MRUA, la pendiente de la línea recta representa la aceleración del objeto. Si la pendiente es positiva, el objeto acelera; si es negativa, desacelera. El área bajo la curva v-t representa el desplazamiento total del objeto. Por ejemplo, si un motociclista acelera desde el semáforo (pendiente positiva) y luego mantiene una velocidad constante, el área bajo la gráfica indicará cuántos metros ha avanzado en total.',
          'rubric' => 
          array (
            0 => 'Explica correctamente qué representa la pendiente de la gráfica v-t.',
            1 => 'Explica correctamente qué representa el área bajo la curva v-t.',
            2 => 'Ofrece un ejemplo práctico que ilustre ambos conceptos.',
          ),
        ),
      ),
    ),
    9 => 
    array (
      'id' => 'd22',
      'type' => 'relacionar',
      'skill' => 'Relaciona ecuaciones del MRUA con las variables que las componen.',
      'points' => 2,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Relacione cada ecuación del MRUA con la variable que permite calcular directamente si se conocen las demás:',
          'pairs' => 
          array (
            0 => 
            array (
              'l' => '$v_f = v_i + a \\cdot t$',
              'r' => 'Velocidad final',
            ),
            1 => 
            array (
              'l' => '$\\Delta x = v_i \\cdot t + \\frac{1}{2} a \\cdot t^2$',
              'r' => 'Desplazamiento',
            ),
            2 => 
            array (
              'l' => '$v_f^2 = v_i^2 + 2 a \\cdot \\Delta x$',
              'r' => 'Velocidad final sin tiempo',
            ),
            3 => 
            array (
              'l' => '$\\Delta x = \\frac{(v_i + v_f)}{2} \\cdot t$',
              'r' => 'Desplazamiento sin aceleración',
            ),
          ),
          'solution' => '',
        ),
        1 => 
        array (
          'stem' => 'Relacione cada característica con el tipo de movimiento o concepto físico correspondiente:',
          'pairs' => 
          array (
            0 => 
            array (
              'l' => 'Aceleración constante y diferente de cero',
              'r' => 'MRUA',
            ),
            1 => 
            array (
              'l' => 'Velocidad constante',
              'r' => 'MRU',
            ),
            2 => 
            array (
              'l' => 'Aceleración debida a la gravedad',
              'r' => 'Caída libre',
            ),
            3 => 
            array (
              'l' => 'Pendiente de gráfica v-t',
              'r' => 'Aceleración',
            ),
          ),
          'solution' => '',
        ),
      ),
    ),
    10 => 
    array (
      'id' => 'd23',
      'type' => 'sopa',
      'skill' => 'Identifica términos clave relacionados con el MRUA.',
      'points' => 3,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Encuentra en la sopa de letras palabras clave relacionadas con el Movimiento Rectilíneo Uniformemente Acelerado:',
          'words' => 
          array (
            0 => 
            array (
              'w' => 'ACELERACION',
              'c' => 'Cambio de velocidad por unidad de tiempo.',
            ),
            1 => 
            array (
              'w' => 'VELOCIDAD',
              'c' => 'Magnitud vectorial que indica la rapidez y dirección.',
            ),
            2 => 
            array (
              'w' => 'DESPLAZAMIENTO',
              'c' => 'Cambio de posición de un objeto.',
            ),
            3 => 
            array (
              'w' => 'TIEMPO',
              'c' => 'Duración de un evento o proceso.',
            ),
            4 => 
            array (
              'w' => 'GRAVEDAD',
              'c' => 'Aceleración en caída libre.',
            ),
            5 => 
            array (
              'w' => 'CONSTANTE',
              'c' => 'Valor que no cambia en el MRUA para la aceleración.',
            ),
            6 => 
            array (
              'w' => 'REPOSO',
              'c' => 'Estado inicial con velocidad cero.',
            ),
            7 => 
            array (
              'w' => 'LINEAL',
              'c' => 'Forma de la gráfica de velocidad vs. tiempo.',
            ),
          ),
        ),
        1 => 
        array (
          'stem' => 'Encuentra en la sopa de letras términos fundamentales del estudio del MRUA y la caída libre:',
          'words' => 
          array (
            0 => 
            array (
              'w' => 'MOVIMIENTO',
              'c' => 'Cambio de posición de un cuerpo.',
            ),
            1 => 
            array (
              'w' => 'RECTILINEO',
              'c' => 'Tipo de trayectoria en línea recta.',
            ),
            2 => 
            array (
              'w' => 'UNIFORME',
              'c' => 'Característica de la aceleración en MRUA.',
            ),
            3 => 
            array (
              'w' => 'ACELERADO',
              'c' => 'Tipo de movimiento con velocidad cambiante.',
            ),
            4 => 
            array (
              'w' => 'CAIDALIBRE',
              'c' => 'Movimiento bajo la única influencia de la gravedad.',
            ),
            5 => 
            array (
              'w' => 'DISTANCIA',
              'c' => 'Longitud de la trayectoria recorrida.',
            ),
            6 => 
            array (
              'w' => 'INICIAL',
              'c' => 'Referente a la velocidad o posición al inicio.',
            ),
            7 => 
            array (
              'w' => 'FINAL',
              'c' => 'Referente a la velocidad o posición al término.',
            ),
          ),
        ),
      ),
    ),
  ),
  'quimica' => 
  array (
    0 => 
    array (
      'id' => 'd24',
      'type' => 'unica',
      'skill' => 'Identifica el tipo de reacción química a partir de su ecuación balanceada.',
      'points' => 1,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'En un laboratorio de química en Medellín, se realizó un experimento donde se observó la siguiente reacción:
$$\\ce{2H2O -> 2H2 + O2}$$
Según lo aprendido en clase sobre los tipos de reacciones, ¿a qué categoría corresponde esta transformación?',
          'options' => 
          array (
            0 => 'Reacción de síntesis',
            1 => 'Reacción de combustión',
            2 => 'Reacción de descomposición',
            3 => 'Reacción de desplazamiento simple',
          ),
          'correct' => 
          array (
            0 => 2,
          ),
          'solution' => 'La reacción de descomposición es aquella en la que una sustancia compleja se descompone en dos o más sustancias más simples. En este caso, el agua se descompone en hidrógeno y oxígeno.',
        ),
        1 => 
        array (
          'stem' => 'Un estudiante en Cali mezcló dos soluciones y observó una reacción que se puede representar como:
$$\\ce{2K + 2H2O -> 2KOH + H2}$$
Considerando la información proporcionada, ¿qué tipo de reacción química ocurrió?',
          'options' => 
          array (
            0 => 'Reacción de síntesis',
            1 => 'Reacción de descomposición',
            2 => 'Reacción de desplazamiento doble',
            3 => 'Reacción de desplazamiento simple',
          ),
          'correct' => 
          array (
            0 => 3,
          ),
          'solution' => 'La reacción de desplazamiento simple ocurre cuando un elemento reacciona con un compuesto y desplaza a otro elemento en el compuesto. Aquí, el potasio (K) desplaza al hidrógeno (H) del agua.',
        ),
      ),
    ),
    1 => 
    array (
      'id' => 'd25',
      'type' => 'unica',
      'skill' => 'Interpreta una ecuación química balanceada para determinar relaciones molares.',
      'points' => 1,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'En un experimento realizado en Bogotá para producir amoníaco, la reacción balanceada es:
$$\\ce{N2(g) + 3H2(g) -> 2NH3(g)}$$
Si se tienen $2$ moles de nitrógeno ($\\ce{N2}$), ¿cuántas moles de hidrógeno ($\\ce{H2}$) se necesitan para que reaccionen completamente?',
          'options' => 
          array (
            0 => '$2$ moles de $\\ce{H2}$',
            1 => '$3$ moles de $\\ce{H2}$',
            2 => '$4$ moles de $\\ce{H2}$',
            3 => '$6$ moles de $\\ce{H2}$',
          ),
          'correct' => 
          array (
            0 => 3,
          ),
          'solution' => 'Según la estequiometría de la reacción, $1$ mol de $\\ce{N2}$ reacciona con $3$ moles de $\\ce{H2}$. Por lo tanto, $2$ moles de $\\ce{N2}$ reaccionarán con $2 \\times 3 = 6$ moles de $\\ce{H2}$.',
        ),
        1 => 
        array (
          'stem' => 'Para la combustión completa del propano, la ecuación balanceada es:
$$\\ce{C3H8(g) + 5O2(g) -> 3CO2(g) + 4H2O(g)}$$
Si en un proceso industrial en Cartagena se producen $9$ moles de dióxido de carbono ($\\ce{CO2}$), ¿cuántas moles de propano ($\\ce{C3H8}$) se consumieron?',
          'options' => 
          array (
            0 => '$1$ mol de $\\ce{C3H8}$',
            1 => '$3$ moles de $\\ce{C3H8}$',
            2 => '$9$ moles de $\\ce{C3H8}$',
            3 => '$12$ moles de $\\ce{C3H8}$',
          ),
          'correct' => 
          array (
            0 => 1,
          ),
          'solution' => 'La ecuación balanceada muestra que $1$ mol de $\\ce{C3H8}$ produce $3$ moles de $\\ce{CO2}$. Si se producen $9$ moles de $\\ce{CO2}$, se necesitaron $9 \\div 3 = 3$ moles de $\\ce{C3H8}$.',
        ),
      ),
    ),
    2 => 
    array (
      'id' => 'd26',
      'type' => 'multiple',
      'skill' => 'Selecciona las características correctas de las reacciones de combustión.',
      'points' => 1,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Las reacciones de combustión son fundamentales en muchos procesos industriales y cotidianos en Colombia. Seleccione todas las correctas que describan una reacción de combustión:',
          'options' => 
          array (
            0 => 'Siempre involucran la reacción con oxígeno.',
            1 => 'Son reacciones exotérmicas, liberando energía en forma de calor y luz.',
            2 => 'Producen $\\ce{CO2}$ y $\\ce{H2O}$ cuando el combustible contiene carbono e hidrógeno.',
            3 => 'Requieren un aporte constante de energía para mantenerse.',
          ),
          'correct' => 
          array (
            0 => 0,
            1 => 1,
            2 => 2,
          ),
          'solution' => 'Las reacciones de combustión son procesos de oxidación rápida, generalmente exotérmicos, que involucran un combustible (con carbono e hidrógeno) y un comburente (usualmente oxígeno), produciendo dióxido de carbono y agua. No requieren un aporte constante de energía para mantenerse una vez iniciadas, sino que liberan su propia energía.',
        ),
        1 => 
        array (
          'stem' => 'En el contexto de las reacciones químicas, las reacciones de descomposición son lo opuesto a las reacciones de síntesis. Seleccione todas las correctas sobre las reacciones de descomposición:',
          'options' => 
          array (
            0 => 'Una sustancia compleja se divide en dos o más sustancias más simples.',
            1 => 'Generalmente requieren un aporte de energía (calor, luz, electricidad) para ocurrir.',
            2 => 'Son siempre reacciones de combustión.',
            3 => 'Pueden ser utilizadas para obtener elementos puros a partir de compuestos.',
          ),
          'correct' => 
          array (
            0 => 0,
            1 => 1,
            2 => 3,
          ),
          'solution' => 'Las reacciones de descomposición implican la ruptura de una sustancia compleja en componentes más simples y a menudo requieren energía para iniciarse y mantenerse. No son siempre reacciones de combustión, ya que estas últimas involucran oxígeno y son exotérmicas. Pueden ser útiles para obtener elementos puros.',
        ),
      ),
    ),
    3 => 
    array (
      'id' => 'd27',
      'type' => 'vf',
      'skill' => 'Comprende el principio de conservación de la masa en las reacciones químicas.',
      'points' => 1,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'En toda reacción química, la masa total de los reactivos es igual a la masa total de los productos, lo que se conoce como la Ley de Conservación de la Masa.',
          'tf' => true,
          'solution' => 'La Ley de Conservación de la Masa, postulada por Lavoisier, establece que la materia no se crea ni se destruye, solo se transforma. Esto significa que la masa total se mantiene constante en una reacción química.',
        ),
        1 => 
        array (
          'stem' => 'Cuando una reacción química ocurre, los átomos de los reactivos se destruyen para formar nuevos átomos en los productos, lo que explica el cambio de propiedades.',
          'tf' => false,
          'solution' => 'En una reacción química, los átomos no se destruyen; solo se reordenan para formar nuevas moléculas o compuestos. La identidad de los átomos (tipo de elemento) se conserva, lo que explica que la masa total también se conserve.',
        ),
      ),
    ),
    4 => 
    array (
      'id' => 'd28',
      'type' => 'corta',
      'skill' => 'Nombra el proceso químico que iguala el número de átomos en reactivos y productos.',
      'points' => 1,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Para cumplir con la Ley de Conservación de la Masa en una ecuación química, es indispensable ajustar los coeficientes estequiométricos de manera que el número de átomos de cada elemento sea el mismo en ambos lados de la flecha. ¿Cómo se llama este proceso?',
          'answer' => 'Balanceo por tanteo',
          'solution' => 'El balanceo por tanteo es el método más simple para ajustar los coeficientes estequiométricos y asegurar que la Ley de Conservación de la Masa se cumpla.',
        ),
        1 => 
        array (
          'stem' => 'Cuando se escribe una ecuación química, es crucial que la cantidad de cada tipo de átomo sea idéntica tanto en los reactivos como en los productos. ¿Cuál es el término que describe esta acción de igualar las cantidades de átomos?',
          'answer' => 'Balanceo de ecuaciones',
          'solution' => 'El balanceo de ecuaciones es el proceso de ajustar los coeficientes estequiométricos para asegurar la conservación de la masa y los átomos en una reacción química.',
        ),
      ),
    ),
    5 => 
    array (
      'id' => 'd29',
      'type' => 'completar',
      'skill' => 'Completa una descripción de reacción química con los términos adecuados.',
      'points' => 1,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'En la electrólisis del agua, una reacción de {{1}} se lleva a cabo. El agua ($\\ce{H2O}$) se descompone en sus elementos constituyentes: hidrógeno gaseoso ($\\ce{H2}$) y {{2}} gaseoso ($\\ce{O2}$). Para {{3}} la ecuación, se necesitan $2$ moléculas de agua para producir $2$ moléculas de hidrógeno y $1$ molécula de oxígeno.',
          'blanks' => 
          array (
            0 => 'descomposición',
            1 => 'oxígeno',
            2 => 'balancear',
          ),
          'solution' => 'La electrólisis es un proceso de descomposición donde el agua se divide en hidrógeno y oxígeno. Balancear la ecuación asegura la conservación de los átomos.',
        ),
        1 => 
        array (
          'stem' => 'Cuando el metano ($\\ce{CH4}$) reacciona con el {{1}} ($\\ce{O2}$) en presencia de una chispa, ocurre una reacción de {{2}}. Los productos principales de esta reacción son dióxido de carbono ($\\ce{CO2}$) y {{3}} ($\\ce{H2O}$).',
          'blanks' => 
          array (
            0 => 'oxígeno',
            1 => 'combustión',
            2 => 'agua',
          ),
          'solution' => 'Las reacciones de combustión involucran un combustible (metano) y un comburente (oxígeno), produciendo dióxido de carbono y agua.',
        ),
      ),
    ),
    6 => 
    array (
      'id' => 'd30',
      'type' => 'relacionar',
      'skill' => 'Relaciona los tipos de reacciones químicas con sus ejemplos representativos.',
      'points' => 2,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Relacione cada tipo de reacción química con su ejemplo correspondiente:',
          'pairs' => 
          array (
            0 => 
            array (
              'l' => 'Síntesis',
              'r' => '\\$ \\ce{N2 + 3H2 -> 2NH3} \\$',
            ),
            1 => 
            array (
              'l' => 'Descomposición',
              'r' => '\\$ \\ce{CaCO3 -> CaO + CO2} \\$',
            ),
            2 => 
            array (
              'l' => 'Desplazamiento simple',
              'r' => '\\$ \\ce{Zn + 2HCl -> ZnCl2 + H2} \\$',
            ),
            3 => 
            array (
              'l' => 'Combustión',
              'r' => '\\$ \\ce{CH4 + 2O2 -> CO2 + 2H2O} \\$',
            ),
          ),
          'solution' => 'Cada ejemplo ilustra la definición de su tipo de reacción: síntesis (unión), descomposición (separación), desplazamiento simple (sustitución de un elemento por otro), combustión (reacción con oxígeno produciendo calor y luz).',
        ),
        1 => 
        array (
          'stem' => 'Relacione cada tipo de reacción química con su ejemplo representativo:',
          'pairs' => 
          array (
            0 => 
            array (
              'l' => 'Combustión',
              'r' => '\\$ \\ce{C6H12O6 + 6O2 -> 6CO2 + 6H2O} \\$',
            ),
            1 => 
            array (
              'l' => 'Desplazamiento doble',
              'r' => '\\$ \\ce{AgNO3 + NaCl -> AgCl + NaNO3} \\$',
            ),
            2 => 
            array (
              'l' => 'Descomposición',
              'r' => '\\$ \\ce{2HgO -> 2Hg + O2} \\$',
            ),
            3 => 
            array (
              'l' => 'Síntesis',
              'r' => '\\$ \\ce{SO2 + H2O -> H2SO3} \\$',
            ),
          ),
          'solution' => 'Cada ejemplo corresponde a la definición de su tipo de reacción: combustión (con oxígeno), desplazamiento doble (intercambio de iones), descomposición (una sustancia se separa), síntesis (dos o más sustancias forman una nueva).',
        ),
      ),
    ),
    7 => 
    array (
      'id' => 'd31',
      'type' => 'ordenar',
      'skill' => 'Ordena los pasos para balancear una ecuación química por el método de tanteo.',
      'points' => 2,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Un estudiante en Pasto necesita balancear la ecuación de la reacción de combustión del butano. Ordene los pasos correctos para balancear una ecuación química por el método de tanteo, desde el primero hasta el último.',
          'items' => 
          array (
            0 => 'Identificar los elementos que aparecen solo una vez en cada lado y balancearlos primero.',
            1 => 'Balancear los metales, si los hay.',
            2 => 'Balancear los no metales (excepto H y O).',
            3 => 'Balancear el hidrógeno (H).',
            4 => 'Balancear el oxígeno (O).',
            5 => 'Verificar que el número de átomos de cada elemento sea el mismo en ambos lados.',
          ),
          'solution' => 'El orden tradicional para el balanceo por tanteo es: elementos que aparecen una vez, metales, no metales, hidrógeno, oxígeno, y finalmente la verificación. Este orden ayuda a simplificar el proceso.',
        ),
        1 => 
        array (
          'stem' => 'Para balancear una ecuación química por el método de tanteo, es importante seguir una secuencia lógica. Ordene los pasos para balancear una ecuación química de forma efectiva, empezando por el primero.',
          'items' => 
          array (
            0 => 'Contar el número de átomos de cada elemento en los reactivos y en los productos.',
            1 => 'Ajustar los coeficientes estequiométricos de los elementos que aparecen solo una vez en cada lado.',
            2 => 'Balancear los átomos de carbono e hidrógeno.',
            3 => 'Balancear los átomos de oxígeno.',
            4 => 'Revisar que todos los átomos estén balanceados y que los coeficientes sean los números enteros más pequeños posibles.',
          ),
          'solution' => 'El balanceo por tanteo implica un conteo inicial, ajuste de elementos menos complejos primero (generalmente C y H en reacciones orgánicas, o los que aparecen una vez), luego O, y una verificación final para asegurar la conservación de la masa.',
        ),
      ),
    ),
    8 => 
    array (
      'id' => 'd32',
      'type' => 'problema',
      'skill' => 'Calcula la masa molar de un compuesto y la cantidad de sustancia en gramos.',
      'points' => 3,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'En un laboratorio de química en Barranquilla, se necesitan $3$ moles de cloruro de sodio ($\\ce{NaCl}$) para preparar una solución. Utilizando la tabla periódica, calcule la masa molar del $\\ce{NaCl}$ y determine cuántos gramos de $\\ce{NaCl}$ se necesitan para obtener las $3$ moles requeridas.
Datos: Masas atómicas (aproximadas): $\\text{Na} = 23{,}0 \\text{ g/mol}$, $\\text{Cl} = 35{,}5 \\text{ g/mol}$.',
          'answer' => '$175{,}5 \\text{ g}$ de $\\ce{NaCl}$',
          'solution' => '1. Calcular la masa molar del $\\ce{NaCl}$:
   $\\text{Masa molar de Na} = 23{,}0 \\text{ g/mol}$
   $\\text{Masa molar de Cl} = 35{,}5 \\text{ g/mol}$
   $\\text{Masa molar de NaCl} = 23{,}0 + 35{,}5 = 58{,}5 \\text{ g/mol}$
2. Calcular la masa de $3$ moles de $\\ce{NaCl}$:
   $\\text{Masa} = \\text{Moles} \\times \\text{Masa molar}$
   $\\text{Masa} = 3 \\text{ mol} \\times 58{,}5 \\text{ g/mol} = 175{,}5 \\text{ g}$
Se necesitan $175{,}5 \\text{ g}$ de $\\ce{NaCl}$.',
          'rubric' => 
          array (
            0 => 'Cálculo correcto de la masa molar del $\\ce{NaCl}$.',
            1 => 'Uso correcto de la relación moles-masa para calcular la masa requerida.',
          ),
        ),
        1 => 
        array (
          'stem' => 'Un químico en Bucaramanga necesita pesar $0{,}5$ moles de ácido sulfúrico ($\\ce{H2SO4}$) para un experimento. Utilizando la tabla periódica, calcule la masa molar del $\\ce{H2SO4}$ y determine cuántos gramos de ácido sulfúrico debe pesar.
Datos: Masas atómicas (aproximadas): $\\text{H} = 1{,}0 \\text{ g/mol}$, $\\text{S} = 32{,}1 \\text{ g/mol}$, $\\text{O} = 16{,}0 \\text{ g/mol}$.',
          'answer' => '$49{,}05 \\text{ g}$ de $\\ce{H2SO4}$',
          'solution' => '1. Calcular la masa molar del $\\ce{H2SO4}$:
   $\\text{Masa molar de H} = 1{,}0 \\text{ g/mol}$
   $\\text{Masa molar de S} = 32{,}1 \\text{ g/mol}$
   $\\text{Masa molar de O} = 16{,}0 \\text{ g/mol}$
   $\\text{Masa molar de H2SO4} = (2 \\times 1{,}0) + (1 \\times 32{,}1) + (4 \\times 16{,}0) = 2{,}0 + 32{,}1 + 64{,}0 = 98{,}1 \\text{ g/mol}$
2. Calcular la masa de $0{,}5$ moles de $\\ce{H2SO4}$:
   $\\text{Masa} = \\text{Moles} \\times \\text{Masa molar}$
   $\\text{Masa} = 0{,}5 \\text{ mol} \\times 98{,}1 \\text{ g/mol} = 49{,}05 \\text{ g}$
Se necesitan $49{,}05 \\text{ g}$ de $\\ce{H2SO4}$.',
          'rubric' => 
          array (
            0 => 'Cálculo correcto de la masa molar del $\\ce{H2SO4}$.',
            1 => 'Uso correcto de la relación moles-masa para determinar la masa en gramos.',
          ),
        ),
      ),
    ),
    9 => 
    array (
      'id' => 'd33',
      'type' => 'problema',
      'skill' => 'Aplica relaciones estequiométricas mol-mol para calcular la cantidad de producto.',
      'points' => 3,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'En un laboratorio de química en Manizales, se realiza la síntesis de agua a partir de hidrógeno y oxígeno, según la ecuación balanceada:
$$\\ce{2H2(g) + O2(g) -> 2H2O(l)}$$
Si se utilizan $4$ moles de hidrógeno ($\\ce{H2}$), ¿cuántas moles de agua ($\\ce{H2O}$) se pueden producir teóricamente?',
          'answer' => '$4$ moles de $\\ce{H2O}$',
          'solution' => '1. Analizar la relación molar de la ecuación balanceada:
   Según la ecuación, $2$ moles de $\\ce{H2}$ producen $2$ moles de $\\ce{H2O}$.
2. Establecer la proporción:
   $\\frac{2 \\text{ mol H2}}{2 \\text{ mol H2O}}$
3. Calcular las moles de $\\ce{H2O}$ producidas a partir de $4$ moles de $\\ce{H2}$:
   Moles de $\\ce{H2O} = 4 \\text{ mol H2} \\times \\frac{2 \\text{ mol H2O}}{2 \\text{ mol H2}} = 4 \\text{ mol H2O}$
Se pueden producir $4$ moles de agua.',
          'rubric' => 
          array (
            0 => 'Identificación correcta de la relación molar entre reactivo y producto.',
            1 => 'Cálculo exacto de las moles del producto.',
          ),
        ),
        1 => 
        array (
          'stem' => 'En un proceso industrial en Yumbo, se produce trióxido de azufre mediante la siguiente reacción balanceada:
$$\\ce{2S(s) + 3O2(g) -> 2SO3(g)}$$
Si se hacen reaccionar $6$ moles de azufre ($\\ce{S}$), ¿cuántas moles de trióxido de azufre ($\\ce{SO3}$) se pueden formar?',
          'answer' => '$6$ moles de $\\ce{SO3}$',
          'solution' => '1. Analizar la relación molar de la ecuación balanceada:
   Según la ecuación, $2$ moles de $\\ce{S}$ producen $2$ moles de $\\ce{SO3}$.
2. Establecer la proporción:
   $\\frac{2 \\text{ mol S}}{2 \\text{ mol SO3}}$
3. Calcular las moles de $\\ce{SO3}$ producidas a partir de $6$ moles de $\\ce{S}$:
   Moles de $\\ce{SO3} = 6 \\text{ mol S} \\times \\frac{2 \\text{ mol SO3}}{2 \\text{ mol S}} = 6 \\text{ mol SO3}$
Se pueden formar $6$ moles de trióxido de azufre.',
          'rubric' => 
          array (
            0 => 'Identificación correcta de la relación estequiométrica entre el reactivo y el producto.',
            1 => 'Cálculo preciso de las moles del producto esperado.',
          ),
        ),
      ),
    ),
    10 => 
    array (
      'id' => 'd34',
      'type' => 'abierta',
      'skill' => 'Explica la importancia del balanceo de ecuaciones químicas.',
      'points' => 2,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Explique brevemente por qué es fundamental balancear una ecuación química antes de realizar cualquier cálculo estequiométrico.',
          'answer' => 'Es fundamental balancear una ecuación química para cumplir con la Ley de Conservación de la Masa, asegurando que el número de átomos de cada elemento sea el mismo en los reactivos y en los productos. Sin una ecuación balanceada, los cálculos estequiométricos (relaciones mol-mol, masa-masa) serían incorrectos, llevando a resultados erróneos en la predicción de cantidades de reactivos o productos.',
          'rubric' => 
          array (
            0 => 'Menciona la Ley de Conservación de la Masa.',
            1 => 'Explica que el balanceo asegura el mismo número de átomos de cada elemento.',
            2 => 'Relaciona el balanceo con la exactitud de los cálculos estequiométricos.',
          ),
        ),
        1 => 
        array (
          'stem' => 'Describa la importancia de balancear una ecuación química en el contexto de un experimento de laboratorio donde se busca predecir la cantidad de producto a obtener.',
          'answer' => 'Balancear una ecuación química es crucial en un laboratorio porque permite establecer las proporciones exactas (molares y de masa) entre reactivos y productos. Esto es esencial para aplicar la estequiometría y predecir con precisión la cantidad de producto que se puede obtener o la cantidad de reactivos necesarios, evitando desperdicios o resultados inesperados. Sin el balanceo, las proporciones serían incorrectas y las predicciones erróneas.',
          'rubric' => 
          array (
            0 => 'Señala que el balanceo establece proporciones exactas.',
            1 => 'Conecta el balanceo con la predicción precisa de cantidades de reactivos/productos.',
            2 => 'Destaca las consecuencias de no balancear (errores en predicciones, desperdicio).',
          ),
        ),
      ),
    ),
    11 => 
    array (
      'id' => 'd35',
      'type' => 'larga',
      'skill' => 'Describe un tipo de reacción química, incluyendo un ejemplo y su balanceo.',
      'points' => 4,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Elija uno de los tipos de reacciones químicas estudiados (síntesis, descomposición, desplazamiento simple o combustión). Describa en detalle este tipo de reacción, incluyendo una definición clara, las características principales que la identifican, y escriba un ejemplo de una ecuación química que represente este tipo de reacción. Finalmente, explique cómo se balancearía esa ecuación por el método de tanteo. (Extensión esperada: 100-150 palabras)',
          'answer' => 'Las reacciones de síntesis, también conocidas como reacciones de combinación, ocurren cuando dos o más sustancias (elementos o compuestos) se unen para formar una sustancia nueva y más compleja. Su característica principal es que se parte de varios reactivos y se obtiene un único producto. Un ejemplo es la formación de amoníaco a partir de nitrógeno e hidrógeno: $\\ce{N2(g) + H2(g) -> NH3(g)}$.

Para balancear esta ecuación por tanteo:
1. Balancear el nitrógeno: Hay $2$ átomos de $\\ce{N}$ en los reactivos ($\\ce{N2}$), por lo que se coloca un coeficiente $2$ delante del $\\ce{NH3}$ en los productos: $\\ce{N2(g) + H2(g) -> 2NH3(g)}$.
2. Balancear el hidrógeno: Ahora hay $2 \\times 3 = 6$ átomos de $\\ce{H}$ en los productos. Para tener $6$ átomos de $\\ce{H}$ en los reactivos, se coloca un coeficiente $3$ delante del $\\ce{H2}$: $\\ce{N2(g) + 3H2(g) -> 2NH3(g)}$.
3. Verificar: $2$ $\\ce{N}$ y $6$ $\\ce{H}$ en reactivos; $2$ $\\ce{N}$ y $6$ $\\ce{H}$ en productos. La ecuación está balanceada.',
          'rubric' => 
          array (
            0 => 'Define el tipo de reacción elegido y describe sus características.',
            1 => 'Proporciona un ejemplo de ecuación química correcta para el tipo de reacción.',
            2 => 'Explica el proceso de balanceo por tanteo para la ecuación de ejemplo paso a paso.',
            3 => 'La ecuación de ejemplo está correctamente balanceada y la explicación es clara.',
          ),
        ),
        1 => 
        array (
          'stem' => 'Seleccione una de las reacciones de desplazamiento simple o doble que hemos visto en clase. Describa en detalle este tipo de reacción, incluyendo una definición clara, las características que la distinguen, y escriba un ejemplo de una ecuación química que represente este tipo. Luego, explique cómo se balancearía esa ecuación por el método de tanteo. (Extensión esperada: 100-150 palabras)',
          'answer' => 'Las reacciones de desplazamiento simple, también conocidas como reacciones de sustitución simple, ocurren cuando un elemento más reactivo desplaza a otro elemento menos reactivo de un compuesto. Un elemento libre reacciona con un compuesto, formando un nuevo compuesto y liberando el elemento desplazado. Un ejemplo es la reacción del zinc con ácido clorhídrico: $\\ce{Zn(s) + HCl(aq) -> ZnCl2(aq) + H2(g)}$.

Para balancear esta ecuación por tanteo:
1. Balancear el zinc: Hay $1$ átomo de $\\ce{Zn}$ en reactivos y $1$ en productos. Está balanceado.
2. Balancear el cloro: Hay $1$ átomo de $\\ce{Cl}$ en reactivos y $2$ en productos ($\\ce{ZnCl2}$). Se coloca un coeficiente $2$ delante del $\\ce{HCl}$: $\\ce{Zn(s) + 2HCl(aq) -> ZnCl2(aq) + H2(g)}$.
3. Balancear el hidrógeno: Ahora hay $2$ átomos de $\\ce{H}$ en los reactivos ($2\\ce{HCl}$) y $2$ en los productos ($\\ce{H2}$). Está balanceado.
4. Verificar: $1$ $\\ce{Zn}$, $2$ $\\ce{H}$ y $2$ $\\ce{Cl}$ en reactivos; $1$ $\\ce{Zn}$, $2$ $\\ce{H}$ y $2$ $\\ce{Cl}$ en productos. La ecuación está balanceada.',
          'rubric' => 
          array (
            0 => 'Define el tipo de reacción elegido y describe sus características distintivas.',
            1 => 'Proporciona un ejemplo de ecuación química correcta para el tipo de reacción.',
            2 => 'Explica el proceso de balanceo por tanteo para la ecuación de ejemplo paso a paso.',
            3 => 'La ecuación de ejemplo está correctamente balanceada y la explicación es clara.',
          ),
        ),
      ),
    ),
    12 => 
    array (
      'id' => 'd36',
      'type' => 'crucigrama',
      'skill' => 'Identifica términos clave relacionados con reacciones químicas y estequiometría.',
      'points' => 4,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Resuelva el siguiente crucigrama con términos relacionados con las reacciones químicas y la estequiometría básica.',
          'words' => 
          array (
            0 => 
            array (
              'w' => 'COMBUSTION',
              'c' => 'Reacción con oxígeno que libera energía en forma de calor y luz.',
            ),
            1 => 
            array (
              'w' => 'SINTESIS',
              'c' => 'Tipo de reacción donde dos o más sustancias forman una sola.',
            ),
            2 => 
            array (
              'w' => 'PRODUCTOS',
              'c' => 'Sustancias que se forman al final de una reacción química.',
            ),
            3 => 
            array (
              'w' => 'BALANCEO',
              'c' => 'Proceso para igualar el número de átomos en ambos lados de una ecuación.',
            ),
            4 => 
            array (
              'w' => 'MOLAR',
              'c' => 'Relacionado con la masa de un mol de sustancia.',
            ),
            5 => 
            array (
              'w' => 'REACTIVOS',
              'c' => 'Sustancias iniciales en una reacción química.',
            ),
            6 => 
            array (
              'w' => 'MOL',
              'c' => 'Unidad de cantidad de sustancia en química.',
            ),
            7 => 
            array (
              'w' => 'ESTEQUIOMETRIA',
              'c' => 'Cálculo de las relaciones cuantitativas entre reactivos y productos.',
            ),
          ),
        ),
        1 => 
        array (
          'stem' => 'Complete el crucigrama con conceptos fundamentales de reacciones químicas y balanceo.',
          'words' => 
          array (
            0 => 
            array (
              'w' => 'DESCOMPOSICION',
              'c' => 'Reacción en que una sustancia se divide en dos o más simples.',
            ),
            1 => 
            array (
              'w' => 'DESPLAZAMIENTO',
              'c' => 'Tipo de reacción donde un elemento sustituye a otro en un compuesto.',
            ),
            2 => 
            array (
              'w' => 'COEFICIENTE',
              'c' => 'Número que precede a una fórmula química en una ecuación balanceada.',
            ),
            3 => 
            array (
              'w' => 'ATOMICAS',
              'c' => 'Masas de los átomos de los elementos.',
            ),
            4 => 
            array (
              'w' => 'MASA',
              'c' => 'Propiedad que se conserva en una reacción química.',
            ),
            5 => 
            array (
              'w' => 'EXOTERMICA',
              'c' => 'Reacción que libera calor al entorno.',
            ),
            6 => 
            array (
              'w' => 'OXIGENO',
              'c' => 'Elemento esencial en las reacciones de combustión.',
            ),
            7 => 
            array (
              'w' => 'ECUACION',
              'c' => 'Representación simbólica de una reacción química.',
            ),
          ),
        ),
      ),
    ),
    13 => 
    array (
      'id' => 'd37',
      'type' => 'sopa',
      'skill' => 'Identifica términos clave de reacciones químicas en una sopa de letras.',
      'points' => 3,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Encuentre en la sopa de letras los siguientes términos relacionados con las reacciones químicas:',
          'words' => 
          array (
            0 => 
            array (
              'w' => 'REACCION',
              'c' => 'Proceso de transformación de sustancias.',
            ),
            1 => 
            array (
              'w' => 'SINTESIS',
              'c' => 'Unión de sustancias para formar una nueva.',
            ),
            2 => 
            array (
              'w' => 'BALANCEO',
              'c' => 'Igualar átomos en una ecuación.',
            ),
            3 => 
            array (
              'w' => 'MOL',
              'c' => 'Unidad de cantidad de sustancia.',
            ),
            4 => 
            array (
              'w' => 'ATOMO',
              'c' => 'Partícula fundamental de la materia.',
            ),
            5 => 
            array (
              'w' => 'PRODUCTO',
              'c' => 'Sustancia resultante de una reacción.',
            ),
            6 => 
            array (
              'w' => 'OXIDO',
              'c' => 'Compuesto de un elemento con oxígeno.',
            ),
            7 => 
            array (
              'w' => 'MASA',
              'c' => 'Cantidad de materia de un cuerpo.',
            ),
            8 => 
            array (
              'w' => 'QUIMICA',
              'c' => 'Ciencia que estudia la materia y sus cambios.',
            ),
            9 => 
            array (
              'w' => 'ENERGIA',
              'c' => 'Capacidad de realizar un trabajo.',
            ),
          ),
        ),
        1 => 
        array (
          'stem' => 'Localice en la sopa de letras los conceptos clave sobre estequiometría y tipos de reacciones:',
          'words' => 
          array (
            0 => 
            array (
              'w' => 'REACTIVO',
              'c' => 'Sustancia inicial en una reacción.',
            ),
            1 => 
            array (
              'w' => 'COMBUSTION',
              'c' => 'Reacción con oxígeno y liberación de calor.',
            ),
            2 => 
            array (
              'w' => 'DESCOMPOSICION',
              'c' => 'División de una sustancia en otras más simples.',
            ),
            3 => 
            array (
              'w' => 'COEFICIENTE',
              'c' => 'Número en una ecuación balanceada.',
            ),
            4 => 
            array (
              'w' => 'AVOGADRO',
              'c' => 'Número de partículas en un mol.',
            ),
            5 => 
            array (
              'w' => 'ESTEQUIOMETRIA',
              'c' => 'Cálculo de relaciones cuantitativas.',
            ),
            6 => 
            array (
              'w' => 'ELEMENTO',
              'c' => 'Sustancia pura con un solo tipo de átomo.',
            ),
            7 => 
            array (
              'w' => 'COMPUESTO',
              'c' => 'Sustancia formada por dos o más elementos.',
            ),
            8 => 
            array (
              'w' => 'DESPLAZAMIENTO',
              'c' => 'Sustitución de un elemento por otro.',
            ),
            9 => 
            array (
              'w' => 'FORMULA',
              'c' => 'Representación de un compuesto.',
            ),
          ),
        ),
      ),
    ),
  ),
  'lenguaje' => 
  array (
    0 => 
    array (
      'id' => 'd38',
      'type' => 'unica',
      'skill' => 'Identifica la moraleja de una fábula.',
      'points' => 1,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Después de leer la fábula \'El colibrí y el incendio\', ¿cuál de estas enseñanzas nos deja la historia?',
          'options' => 
          array (
            0 => 'Es mejor huir de los problemas antes que enfrentarlos.',
            1 => 'Solo los animales grandes pueden hacer grandes cambios.',
            2 => 'La unión hace la fuerza y todos podemos aportar, sin importar nuestro tamaño.',
            3 => 'Los colibríes son los únicos animales valientes en el bosque.',
          ),
          'correct' => 
          array (
            0 => 2,
          ),
          'solution' => 'La fábula muestra cómo la acción del colibrí, aunque pequeña, inspiró a otros y juntos lograron apagar el fuego, resaltando la importancia de la colaboración.',
        ),
        1 => 
        array (
          'stem' => 'En \'El colibrí y el incendio\', ¿cuál es la lección principal que el autor quiere que aprendamos?',
          'options' => 
          array (
            0 => 'Los leones siempre se burlan de los demás.',
            1 => 'Es inútil intentar ayudar si eres pequeño.',
            2 => 'Hasta la acción más pequeña puede inspirar a otros y contribuir a un bien mayor.',
            3 => 'El fuego se apaga solo si llueve muy fuerte.',
          ),
          'correct' => 
          array (
            0 => 2,
          ),
          'solution' => 'La fábula enseña que no hay que subestimar el poder de las pequeñas acciones y cómo estas pueden motivar a la comunidad para lograr un objetivo común.',
        ),
      ),
    ),
    1 => 
    array (
      'id' => 'd39',
      'type' => 'unica',
      'skill' => 'Identifica el personaje principal en una fábula.',
      'points' => 1,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => '¿Quién es el personaje principal en la fábula \'El colibrí y el incendio\'?',
          'options' => 
          array (
            0 => 'El león',
            1 => 'El elefante',
            2 => 'El colibrí',
            3 => 'Los monos',
          ),
          'correct' => 
          array (
            0 => 2,
          ),
          'solution' => 'El colibrí es el personaje central de la historia, ya que sus acciones inician la trama y su persistencia motiva a los demás.',
        ),
        1 => 
        array (
          'stem' => 'En \'El colibrí y el incendio\', ¿cuál de los siguientes animales es el protagonista de la historia?',
          'options' => 
          array (
            0 => 'El león, por ser el más fuerte.',
            1 => 'El colibrí, por ser quien inicia la acción.',
            2 => 'El elefante, por traer mucha agua.',
            3 => 'Los monos, por trabajar en equipo.',
          ),
          'correct' => 
          array (
            0 => 1,
          ),
          'solution' => 'El colibrí es el protagonista porque su decisión de actuar, a pesar de su tamaño, es el motor de la fábula y de la eventual solución al problema.',
        ),
      ),
    ),
    2 => 
    array (
      'id' => 'd40',
      'type' => 'unica',
      'skill' => 'Reconoce el inicio de una fábula.',
      'points' => 1,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => '¿Cuál de las siguientes oraciones describe el inicio de la fábula \'El colibrí y el incendio\'?',
          'options' => 
          array (
            0 => 'El elefante llenó su trompa de agua.',
            1 => 'Todos los animales huían asustados.',
            2 => 'El colibrí respondió: \'Sé que no puedo solo, pero estoy haciendo mi parte\'.',
            3 => 'Desde entonces, los animales del bosque recuerdan que nadie es demasiado pequeño para ayudar.',
          ),
          'correct' => 
          array (
            0 => 1,
          ),
          'solution' => 'El inicio presenta la situación problemática: el incendio y la reacción inicial de los animales.',
        ),
        1 => 
        array (
          'stem' => 'Si dividimos la fábula \'El colibrí y el incendio\' en sus partes, ¿qué ocurre al principio de la historia?',
          'options' => 
          array (
            0 => 'El león se burla del colibrí.',
            1 => 'El bosque se incendia y los animales huyen.',
            2 => 'Los monos forman una cadena para ayudar.',
            3 => 'Los animales aprenden una valiosa lección.',
          ),
          'correct' => 
          array (
            0 => 1,
          ),
          'solution' => 'El inicio de la fábula es la presentación del problema principal: el incendio en el bosque.',
        ),
      ),
    ),
    3 => 
    array (
      'id' => 'd41',
      'type' => 'multiple',
      'skill' => 'Identifica las acciones del nudo de la fábula.',
      'points' => 1,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'En la fábula \'El colibrí y el incendio\', ¿cuáles de estas acciones forman parte del nudo o desarrollo de la historia? Seleccione todas las correctas.',
          'options' => 
          array (
            0 => 'El bosque se incendia.',
            1 => 'El colibrí lleva gotas de agua en su pico.',
            2 => 'El león se burla del colibrí.',
            3 => 'El elefante y los monos ayudan a apagar el fuego.',
          ),
          'correct' => 
          array (
            0 => 1,
            1 => 2,
            2 => 3,
          ),
          'solution' => 'El nudo de la fábula incluye las acciones del colibrí para apagar el fuego, la burla del león y la posterior colaboración de otros animales.',
        ),
        1 => 
        array (
          'stem' => 'Según la estructura de la fábula \'El colibrí y el incendio\', ¿qué eventos suceden durante el nudo? Seleccione todas las correctas.',
          'options' => 
          array (
            0 => 'Un día se incendió el bosque.',
            1 => 'El colibrí va y viene del río con agua.',
            2 => 'El león le pregunta al colibrí si cree que puede apagar el fuego solo.',
            3 => 'El elefante y los monos se unen para combatir el fuego.',
          ),
          'correct' => 
          array (
            0 => 1,
            1 => 2,
            2 => 3,
          ),
          'solution' => 'El nudo es donde se desarrolla la acción principal: el colibrí intentando apagar el fuego, el diálogo con el león y la suma de esfuerzos de otros animales.',
        ),
      ),
    ),
    4 => 
    array (
      'id' => 'd42',
      'type' => 'vf',
      'skill' => 'Reconoce el desenlace de la fábula.',
      'points' => 1,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'La afirmación \'Desde entonces, los animales del bosque recuerdan que nadie es demasiado pequeño para ayudar\' corresponde al desenlace de la fábula.',
          'tf' => false,
          'solution' => 'Esta afirmación es la moraleja, no el desenlace. El desenlace es cuando el fuego se apaga.',
        ),
        1 => 
        array (
          'stem' => 'El momento en que \'poco a poco, el fuego se apagó\' es el desenlace de la fábula \'El colibrí y el incendio\'.',
          'tf' => true,
          'solution' => 'El desenlace es la resolución del conflicto principal, que en este caso es la extinción del incendio.',
        ),
      ),
    ),
    5 => 
    array (
      'id' => 'd43',
      'type' => 'vf',
      'skill' => 'Identifica la intención comunicativa del autor de una fábula.',
      'points' => 1,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'La intención del autor al escribir \'El colibrí y el incendio\' es solo entretener al lector con una historia de animales.',
          'tf' => false,
          'solution' => 'Además de entretener, las fábulas siempre buscan dejar una enseñanza o moraleja, como la importancia de la colaboración.',
        ),
        1 => 
        array (
          'stem' => 'El propósito principal de la fábula \'El colibrí y el incendio\' es enseñar una lección sobre la importancia de la ayuda mutua.',
          'tf' => true,
          'solution' => 'Las fábulas son textos narrativos con una intención didáctica, es decir, buscan transmitir una enseñanza moral.',
        ),
      ),
    ),
    6 => 
    array (
      'id' => 'd44',
      'type' => 'corta',
      'skill' => 'Identifica el lugar donde ocurre la fábula.',
      'points' => 1,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => '¿Dónde ocurre la historia de \'El colibrí y el incendio\'?',
          'answer' => 'El bosque',
          'solution' => 'La fábula menciona explícitamente que el incendio ocurrió en el bosque.',
        ),
        1 => 
        array (
          'stem' => '¿Cuál es el escenario principal de la fábula \'El colibrí y el incendio\'?',
          'answer' => 'Un bosque',
          'solution' => 'La historia se desarrolla en un bosque que se incendia.',
        ),
      ),
    ),
    7 => 
    array (
      'id' => 'd45',
      'type' => 'completar',
      'skill' => 'Reconoce las partes de la fábula.',
      'points' => 1,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'La fábula \'El colibrí y el incendio\' tiene un {{1}} donde se presenta el problema, un {{2}} donde el colibrí y otros animales intentan apagar el fuego, y un {{3}} donde el fuego se apaga y se deja una {{4}}.',
          'blanks' => 
          array (
            0 => 'inicio',
            1 => 'nudo',
            2 => 'desenlace',
            3 => 'moraleja',
          ),
          'solution' => 'Estas son las cuatro partes fundamentales de una fábula: inicio, nudo, desenlace y moraleja.',
        ),
        1 => 
        array (
          'stem' => 'En la fábula, el {{1}} describe cuando el bosque se incendia, el {{2}} es la lucha por apagarlo, el {{3}} es la extinción del fuego, y la {{4}} es la enseñanza final.',
          'blanks' => 
          array (
            0 => 'inicio',
            1 => 'nudo',
            2 => 'desenlace',
            3 => 'moraleja',
          ),
          'solution' => 'La respuesta sigue el orden cronológico de las partes de una fábula y su función.',
        ),
      ),
    ),
    8 => 
    array (
      'id' => 'd46',
      'type' => 'relacionar',
      'skill' => 'Relaciona personajes con sus acciones en la fábula.',
      'points' => 2,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Relaciona cada personaje de la fábula \'El colibrí y el incendio\' con su acción principal.',
          'pairs' => 
          array (
            0 => 
            array (
              'l' => 'Colibrí',
              'r' => 'Llevaba gotas de agua en el pico.',
            ),
            1 => 
            array (
              'l' => 'León',
              'r' => 'Se burló de la acción del colibrí.',
            ),
            2 => 
            array (
              'l' => 'Elefante',
              'r' => 'Llenó su trompa de agua para ayudar.',
            ),
            3 => 
            array (
              'l' => 'Monos',
              'r' => 'Formaron una cadena con hojas llenas de agua.',
            ),
          ),
          'solution' => 'Cada relación corresponde a la acción específica de cada personaje en la fábula.',
        ),
        1 => 
        array (
          'stem' => 'Une cada personaje de la fábula con lo que hizo para apagar el incendio o su reacción.',
          'pairs' => 
          array (
            0 => 
            array (
              'l' => 'Colibrí',
              'r' => 'Actuó llevando agua a pesar de ser pequeño.',
            ),
            1 => 
            array (
              'l' => 'León',
              'r' => 'Cuestionó la eficacia de la ayuda del colibrí.',
            ),
            2 => 
            array (
              'l' => 'Elefante',
              'r' => 'Se unió a la causa usando su gran trompa.',
            ),
            3 => 
            array (
              'l' => 'Monos',
              'r' => 'Colaboraron organizándose en una cadena.',
            ),
          ),
          'solution' => 'Las parejas reflejan las contribuciones o actitudes de los personajes durante el incendio.',
        ),
      ),
    ),
    9 => 
    array (
      'id' => 'd47',
      'type' => 'ordenar',
      'skill' => 'Ordena los eventos de la fábula cronológicamente.',
      'points' => 2,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Ordena los siguientes eventos de la fábula \'El colibrí y el incendio\' de principio a fin.',
          'items' => 
          array (
            0 => 'Se incendió el bosque y los animales huían.',
            1 => 'El colibrí llevaba gotas de agua al fuego.',
            2 => 'El león se burló del colibrí.',
            3 => 'Otros animales, como el elefante y los monos, se unieron para apagar el fuego.',
            4 => 'El fuego se apagó y todos recordaron la lección.',
          ),
          'solution' => 'Este es el orden cronológico de los acontecimientos de la fábula, desde el problema inicial hasta la resolución y la moraleja.',
        ),
        1 => 
        array (
          'stem' => 'Organiza los hechos de la fábula \'El colibrí y el incendio\' en el orden en que sucedieron.',
          'items' => 
          array (
            0 => 'El incendio del bosque asusta a los animales.',
            1 => 'El colibrí decide aportar con gotas de agua.',
            2 => 'El león le hace una pregunta burlona al colibrí.',
            3 => 'El elefante y los monos imitan la acción del colibrí.',
            4 => 'El fuego es extinguido gracias al trabajo en equipo.',
          ),
          'solution' => 'Los eventos están organizados según la secuencia narrativa de la fábula, desde el inicio del conflicto hasta su resolución.',
        ),
      ),
    ),
    10 => 
    array (
      'id' => 'd48',
      'type' => 'abierta',
      'skill' => 'Explica la importancia de la acción del colibrí.',
      'points' => 2,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => '¿Por qué crees que la acción del colibrí fue tan importante, incluso si al principio parecía muy pequeña?',
          'answer' => 'La acción del colibrí fue importante porque, aunque parecía pequeña, demostró valentía y compromiso. Además, inspiró a los otros animales, como el elefante y los monos, a unirse y hacer su parte, lo que finalmente logró apagar el fuego. Su ejemplo mostró que no hay que rendirse y que todos pueden contribuir.',
          'rubric' => 
          array (
            0 => 'Menciona la valentía o el compromiso del colibrí.',
            1 => 'Explica que la acción del colibrí inspiró a otros animales.',
            2 => 'Relaciona la inspiración con el éxito de apagar el fuego.',
          ),
        ),
        1 => 
        array (
          'stem' => 'Si el colibrí no hubiera decidido llevar agua, ¿qué crees que habría pasado con el incendio y con los demás animales?',
          'answer' => 'Si el colibrí no hubiera actuado, es probable que el incendio hubiera seguido creciendo, ya que los demás animales solo estaban huyendo y no pensaban en una solución. La acción del colibrí fue un catalizador, un ejemplo que movió a los otros. Sin él, el bosque se habría quemado por completo o el daño habría sido mucho mayor, y los animales no habrían aprendido la lección de la colaboración.',
          'rubric' => 
          array (
            0 => 'Predice que el incendio habría empeorado sin la acción del colibrí.',
            1 => 'Señala que los demás animales no habrían actuado sin el ejemplo.',
            2 => 'Concluye que se habría perdido la oportunidad de aprender la lección de cooperación.',
          ),
        ),
      ),
    ),
    11 => 
    array (
      'id' => 'd49',
      'type' => 'larga',
      'skill' => 'Reflexiona sobre la moraleja y su aplicación en la vida real.',
      'points' => 4,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'La fábula \'El colibrí y el incendio\' nos enseña que \'nadie es demasiado pequeño para ayudar\'. Piensa en esta moraleja y escribe un párrafo (entre 5 y 8 líneas) explicando cómo puedes aplicar esta enseñanza en tu colegio o en tu casa.',
          'answer' => 'La moraleja de que \'nadie es demasiado pequeño para ayudar\' es muy importante. En mi colegio, puedo aplicarla de muchas maneras. Por ejemplo, si veo que un compañero tiene dificultades con una tarea, puedo ofrecerle mi ayuda, aunque yo no sea el mejor en esa materia. También puedo ayudar a mantener el salón limpio recogiendo un papel del suelo, aunque no lo haya tirado yo. En casa, puedo ayudar a mis papás con las tareas del hogar, como poner la mesa o recoger mis juguetes, sin que me lo pidan. Pequeñas acciones como estas demuestran que, como el colibrí, mi esfuerzo, por mínimo que parezca, contribuye a un ambiente mejor para todos.',
          'rubric' => 
          array (
            0 => 'Identifica correctamente la moraleja de la fábula.',
            1 => 'Propone al menos dos ejemplos claros de cómo aplicar la moraleja en el colegio.',
            2 => 'Propone al menos dos ejemplos claros de cómo aplicar la moraleja en casa.',
            3 => 'Redacta el párrafo con coherencia y sin errores ortográficos graves, cumpliendo la extensión.',
          ),
        ),
        1 => 
        array (
          'stem' => 'La fábula \'El colibrí y el incendio\' nos muestra cómo la colaboración puede resolver grandes problemas. Escribe un párrafo (entre 5 y 8 líneas) sobre alguna situación en tu vida donde hayas visto o participado en una colaboración similar, y qué resultado tuvo.',
          'answer' => 'Recuerdo una vez en el colegio que estábamos organizando una feria de ciencias. Al principio, parecía una tarea enorme y muchos estábamos un poco desanimados. Yo me encargué de hacer los carteles para mi grupo, y un amigo se ofreció a buscar los materiales. Otros compañeros trajeron ideas para el experimento. Al principio, cada uno pensaba que su parte era muy pequeña, pero cuando juntamos todos los esfuerzos, los carteles quedaron muy bonitos, los materiales estaban completos y el experimento funcionó perfectamente. Al final, logramos presentar un proyecto increíble y ganamos un reconocimiento. Aprendí que, al igual que en la fábula, cuando todos hacemos nuestra parte, por pequeña que sea, el resultado final es mucho mejor y se alcanzan metas que parecían imposibles.',
          'rubric' => 
          array (
            0 => 'Relaciona la fábula con el concepto de colaboración.',
            1 => 'Describe una situación personal o escolar donde hubo colaboración.',
            2 => 'Detalla al menos tres acciones de colaboración dentro de esa situación.',
            3 => 'Explica el resultado positivo de la colaboración y la enseñanza obtenida, cumpliendo la extensión.',
          ),
        ),
      ),
    ),
    12 => 
    array (
      'id' => 'd50',
      'type' => 'sopa',
      'skill' => 'Identifica elementos clave de la fábula en una sopa de letras.',
      'points' => 3,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Encuentra en la sopa de letras palabras relacionadas con la fábula \'El colibrí y el incendio\'.',
          'words' => 
          array (
            0 => 
            array (
              'w' => 'COLIBRI',
              'c' => 'El personaje principal que lleva el agua.',
            ),
            1 => 
            array (
              'w' => 'INCENDIO',
              'c' => 'El problema principal que afecta el bosque.',
            ),
            2 => 
            array (
              'w' => 'BOSQUE',
              'c' => 'El lugar donde ocurre la historia.',
            ),
            3 => 
            array (
              'w' => 'LEON',
              'c' => 'Animal que se burló del colibrí.',
            ),
            4 => 
            array (
              'w' => 'AGUA',
              'c' => 'Lo que el colibrí llevaba en su pico.',
            ),
            5 => 
            array (
              'w' => 'AYUDAR',
              'c' => 'Lo que el colibrí estaba haciendo.',
            ),
            6 => 
            array (
              'w' => 'MORALEJA',
              'c' => 'La enseñanza de la fábula.',
            ),
            7 => 
            array (
              'w' => 'ELEFANTE',
              'c' => 'Animal grande que se unió a la causa.',
            ),
          ),
        ),
        1 => 
        array (
          'stem' => 'Busca en la sopa de letras palabras clave de la fábula \'El colibrí y el incendio\'.',
          'words' => 
          array (
            0 => 
            array (
              'w' => 'FUEGO',
              'c' => 'Lo que amenazaba el bosque.',
            ),
            1 => 
            array (
              'w' => 'PICO',
              'c' => 'Parte del colibrí que usaba para el agua.',
            ),
            2 => 
            array (
              'w' => 'ASUSTADOS',
              'c' => 'Cómo estaban los animales al inicio.',
            ),
            3 => 
            array (
              'w' => 'GOTA',
              'c' => 'Cantidad de agua que llevaba el colibrí.',
            ),
            4 => 
            array (
              'w' => 'UNIR',
              'c' => 'Lo que hicieron los animales para apagar el fuego.',
            ),
            5 => 
            array (
              'w' => 'PARTE',
              'c' => 'Lo que el colibrí dijo que estaba haciendo.',
            ),
            6 => 
            array (
              'w' => 'ENSENANZA',
              'c' => 'Lo que nos deja la fábula.',
            ),
            7 => 
            array (
              'w' => 'MONOS',
              'c' => 'Animales que formaron una cadena.',
            ),
          ),
        ),
      ),
    ),
    13 => 
    array (
      'id' => 'd51',
      'type' => 'crucigrama',
      'skill' => 'Identifica conceptos de la fábula en un crucigrama.',
      'points' => 4,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Completa el crucigrama con palabras relacionadas con la fábula \'El colibrí y el incendio\'.',
          'words' => 
          array (
            0 => 
            array (
              'w' => 'COLIBRI',
              'c' => 'Protagonista de la historia.',
            ),
            1 => 
            array (
              'w' => 'BOSQUE',
              'c' => 'Lugar donde ocurre el incendio.',
            ),
            2 => 
            array (
              'w' => 'LEON',
              'c' => 'Animal que se burló al principio.',
            ),
            3 => 
            array (
              'w' => 'MORALEJA',
              'c' => 'La enseñanza que deja la fábula.',
            ),
            4 => 
            array (
              'w' => 'AGUA',
              'c' => 'Elemento que el colibrí usaba para apagar el fuego.',
            ),
            5 => 
            array (
              'w' => 'AYUDA',
              'c' => 'Lo que el colibrí ofreció.',
            ),
            6 => 
            array (
              'w' => 'FUEGO',
              'c' => 'El problema que enfrentaron los animales.',
            ),
            7 => 
            array (
              'w' => 'ELEFANTE',
              'c' => 'Animal grande que se unió a la labor.',
            ),
          ),
        ),
        1 => 
        array (
          'stem' => 'Resuelve el crucigrama con términos de la fábula \'El colibrí y el incendio\'.',
          'words' => 
          array (
            0 => 
            array (
              'w' => 'INCENDIO',
              'c' => 'Evento desastroso que ocurre en el bosque.',
            ),
            1 => 
            array (
              'w' => 'PICO',
              'c' => 'Parte del colibrí que transporta las gotas.',
            ),
            2 => 
            array (
              'w' => 'VALIENTE',
              'c' => 'Cualidad del colibrí al enfrentar el fuego.',
            ),
            3 => 
            array (
              'w' => 'MONOS',
              'c' => 'Animales que formaron una cadena para colaborar.',
            ),
            4 => 
            array (
              'w' => 'UNION',
              'c' => 'Lo que demostraron los animales al trabajar juntos.',
            ),
            5 => 
            array (
              'w' => 'PROBLEMA',
              'c' => 'Sinónimo de conflicto en la historia.',
            ),
            6 => 
            array (
              'w' => 'GOTA',
              'c' => 'Cantidad mínima de agua que llevaba el colibrí.',
            ),
            7 => 
            array (
              'w' => 'ENSEÑANZA',
              'c' => 'La lección final de la fábula.',
            ),
          ),
        ),
      ),
    ),
  ),
  'sociales' => 
  array (
    0 => 
    array (
      'id' => 'd52',
      'type' => 'unica',
      'skill' => 'Identifica características del feudalismo y su impacto social.',
      'points' => 1,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'En el barrio La Candelaria, un grupo de comerciantes de artesanías se organiza para proteger sus productos y garantizar precios justos, pagando un porcentaje de sus ganancias a una junta directiva que les asegura un puesto fijo en el mercado. Esta situación es similar a una característica del feudalismo medieval en Europa, donde:',
          'options' => 
          array (
            0 => 'los campesinos tenían libertad para vender sus tierras a quien quisieran.',
            1 => 'los reyes ejercían un control absoluto sobre todas las tierras y sus habitantes.',
            2 => 'los siervos trabajaban la tierra a cambio de protección y un lugar para vivir.',
            3 => 'las ciudades eran centros económicos independientes del poder nobiliario.',
          ),
          'correct' => 
          array (
            0 => 2,
          ),
          'solution' => 'En el feudalismo, los siervos trabajaban la tierra de un señor a cambio de protección y la posibilidad de vivir en ella, similar a cómo los comerciantes pagan por protección y un puesto fijo.',
        ),
        1 => 
        array (
          'stem' => 'En un conjunto residencial de Bogotá, los habitantes contribuyen con una cuota mensual para el mantenimiento de las zonas comunes y la seguridad, que es administrada por una junta. Si no pagan, pueden perder el acceso a ciertos servicios. Esta situación se asemeja a una práctica común durante el feudalismo en Europa, donde:',
          'options' => 
          array (
            0 => 'los burgueses pagaban impuestos directamente al rey para obtener privilegios.',
            1 => 'los caballeros eran propietarios de grandes extensiones de tierra que cultivaban ellos mismos.',
            2 => 'los vasallos juraban lealtad y servicio militar a un señor a cambio de tierras y protección.',
            3 => 'los monjes vivían en monasterios aislados sin ninguna obligación social o económica.',
          ),
          'correct' => 
          array (
            0 => 2,
          ),
          'solution' => 'En el feudalismo, los vasallos ofrecían lealtad y servicios militares a un señor a cambio de un feudo (tierras) y protección, similar a cómo los residentes pagan cuotas por servicios y seguridad.',
        ),
      ),
    ),
    1 => 
    array (
      'id' => 'd53',
      'type' => 'unica',
      'skill' => 'Reconoce el rol de la Iglesia Católica en la sociedad medieval.',
      'points' => 1,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'En un pueblo de Cundinamarca, la parroquia local no solo organiza las misas, sino que también gestiona un comedor comunitario, una escuela y un centro de formación para jóvenes, siendo un referente moral y social para toda la comunidad. Esta situación es comparable con el papel de la Iglesia Católica durante la Edad Media, ya que:',
          'options' => 
          array (
            0 => 'su influencia se limitaba a los asuntos puramente espirituales de las personas.',
            1 => 'solo los nobles y reyes podían acceder a la educación impartida por la Iglesia.',
            2 => 'era la única institución que ofrecía servicios educativos, asistenciales y culturales.',
            3 => 'se encargaba exclusivamente de la administración de justicia y del cobro de impuestos.',
          ),
          'correct' => 
          array (
            0 => 2,
          ),
          'solution' => 'Durante la Edad Media, la Iglesia Católica no solo tenía un rol espiritual, sino que también era la principal institución en educación, asistencia social y cultura, similar al ejemplo de la parroquia.',
        ),
        1 => 
        array (
          'stem' => 'En un barrio de Medellín, la junta de acción comunal, además de organizar eventos para los vecinos, también media en conflictos, promueve proyectos de mejora y sirve como un punto de encuentro para resolver problemas del sector. Este tipo de organización se puede comparar con la función que tuvo la Iglesia Católica en la Edad Media, porque:',
          'options' => 
          array (
            0 => 'su poder se limitaba a las zonas rurales, sin influencia en las ciudades.',
            1 => 'era la única que podía coronar a los reyes y emperadores de Europa.',
            2 => 'tenía una gran autoridad moral y social, influyendo en la vida diaria de las personas.',
            3 => 'se dedicaba a la creación de nuevas tecnologías y el avance científico.',
          ),
          'correct' => 
          array (
            0 => 2,
          ),
          'solution' => 'La Iglesia Católica en la Edad Media poseía una vasta autoridad moral, social y política, influenciando en gran medida la vida cotidiana de las personas, similar a la junta de acción comunal en el ejemplo.',
        ),
      ),
    ),
    2 => 
    array (
      'id' => 'd54',
      'type' => 'vf',
      'skill' => 'Diferencia las motivaciones de las Cruzadas.',
      'points' => 1,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Las Cruzadas fueron expediciones militares organizadas por la Iglesia Católica con el único objetivo de expandir el comercio europeo hacia Oriente.',
          'tf' => false,
          'solution' => 'Las Cruzadas tuvieron como principal objetivo la recuperación de Tierra Santa (Jerusalén) del control musulmán, aunque también tuvieron motivaciones económicas y políticas.',
        ),
        1 => 
        array (
          'stem' => 'Las Cruzadas fueron principalmente viajes de exploración geográfica financiados por los reinos europeos para descubrir nuevas rutas comerciales.',
          'tf' => false,
          'solution' => 'Las Cruzadas fueron expediciones militares y religiosas para recuperar Tierra Santa, no viajes de exploración geográfica.',
        ),
      ),
    ),
    3 => 
    array (
      'id' => 'd55',
      'type' => 'corta',
      'skill' => 'Define el concepto de Renacimiento urbano.',
      'points' => 1,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => '¿Cómo se le llamó al proceso de crecimiento y desarrollo de las ciudades en Europa durante la Baja Edad Media?',
          'answer' => 'Renacimiento urbano',
          'solution' => 'El crecimiento de las ciudades y la revitalización de la vida urbana en la Baja Edad Media se conoce como Renacimiento urbano.',
        ),
        1 => 
        array (
          'stem' => '¿Qué término describe el resurgimiento de la vida en las ciudades y el aumento de su importancia económica y social en la Europa medieval tardía?',
          'answer' => 'Renacimiento urbano',
          'solution' => 'El término \'Renacimiento urbano\' se refiere al proceso de revitalización y crecimiento de las ciudades en la Baja Edad Media.',
        ),
      ),
    ),
    4 => 
    array (
      'id' => 'd56',
      'type' => 'completar',
      'skill' => 'Comprende la estructura social feudal.',
      'points' => 1,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'En el sistema feudal, la sociedad estaba dividida en estamentos: la {{1}}, la {{2}} y los {{3}} que trabajaban la tierra.',
          'blanks' => 
          array (
            0 => 'nobleza',
            1 => 'clero',
            2 => 'campesinos',
          ),
          'solution' => 'La sociedad feudal se estructuraba en tres estamentos principales: la nobleza (guerreros), el clero (rezaban) y los campesinos (trabajaban).',
        ),
        1 => 
        array (
          'stem' => 'La sociedad feudal se organizaba en una jerarquía rígida, donde el {{1}} se encargaba de la defensa, el {{2}} de la vida espiritual y los {{3}} de la producción agrícola.',
          'blanks' => 
          array (
            0 => 'nobleza',
            1 => 'clero',
            2 => 'campesinos',
          ),
          'solution' => 'La estructura social feudal estaba compuesta por la nobleza (defensa), el clero (espiritualidad) y los campesinos (producción).',
        ),
      ),
    ),
    5 => 
    array (
      'id' => 'd57',
      'type' => 'relacionar',
      'skill' => 'Relaciona eventos y características con periodos de la Edad Media.',
      'points' => 2,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Relaciona cada concepto con el periodo de la Edad Media al que corresponde.',
          'pairs' => 
          array (
            0 => 
            array (
              'l' => 'Feudalismo consolidado',
              'r' => 'Alta Edad Media',
            ),
            1 => 
            array (
              'l' => 'Cruzadas',
              'r' => 'Baja Edad Media',
            ),
            2 => 
            array (
              'l' => 'Renacimiento de las ciudades',
              'r' => 'Baja Edad Media',
            ),
            3 => 
            array (
              'l' => 'Invasiones bárbaras',
              'r' => 'Alta Edad Media',
            ),
          ),
          'solution' => '',
        ),
        1 => 
        array (
          'stem' => 'Asocia cada evento o característica con la etapa de la Edad Media en la que ocurrió.',
          'pairs' => 
          array (
            0 => 
            array (
              'l' => 'Desarrollo del comercio',
              'r' => 'Baja Edad Media',
            ),
            1 => 
            array (
              'l' => 'Poder de la Iglesia',
              'r' => 'Alta Edad Media',
            ),
            2 => 
            array (
              'l' => 'Crecimiento demográfico',
              'r' => 'Baja Edad Media',
            ),
            3 => 
            array (
              'l' => 'Poca centralización del poder',
              'r' => 'Alta Edad Media',
            ),
          ),
          'solution' => '',
        ),
      ),
    ),
    6 => 
    array (
      'id' => 'd58',
      'type' => 'ordenar',
      'skill' => 'Ordena cronológicamente eventos de la Edad Media.',
      'points' => 2,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Ordena cronológicamente los siguientes eventos de la Edad Media, del más antiguo al más reciente.',
          'items' => 
          array (
            0 => 'Caída del Imperio Romano de Occidente',
            1 => 'Consolidación del sistema feudal',
            2 => 'Inicio de las Cruzadas',
            3 => 'Expansión de las ciudades y el comercio',
          ),
          'solution' => 'El orden cronológico correcto es: Caída del Imperio Romano de Occidente (476 d.C.), Consolidación del sistema feudal (siglos IX-X), Inicio de las Cruzadas (finales del siglo XI), Expansión de las ciudades y el comercio (Baja Edad Media).',
        ),
        1 => 
        array (
          'stem' => 'Organiza los siguientes acontecimientos de la Edad Media en orden cronológico, del que ocurrió primero al que ocurrió después.',
          'items' => 
          array (
            0 => 'Establecimiento de los reinos germánicos',
            1 => 'Apogeo del poder de la Iglesia',
            2 => 'Surgimiento de la burguesía',
            3 => 'Grandes epidemias (Peste Negra)',
          ),
          'solution' => 'El orden cronológico es: Establecimiento de los reinos germánicos (siglo V), Apogeo del poder de la Iglesia (Alta Edad Media), Surgimiento de la burguesía (Baja Edad Media), Grandes epidemias (siglo XIV).',
        ),
      ),
    ),
    7 => 
    array (
      'id' => 'd59',
      'type' => 'abierta',
      'skill' => 'Explica la relación entre las Cruzadas y el renacimiento de las ciudades.',
      'points' => 2,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => '¿Cómo las Cruzadas contribuyeron al renacimiento de las ciudades en Europa?',
          'answer' => 'Las Cruzadas reactivaron las rutas comerciales entre Europa y Oriente, lo que impulsó el intercambio de bienes y el crecimiento económico. Esto llevó al surgimiento de nuevas ciudades y al desarrollo de las existentes, que se convirtieron en centros de comercio y producción, atrayendo a más población.',
          'rubric' => 
          array (
            0 => 'Menciona la reactivación de rutas comerciales y el intercambio de bienes.',
            1 => 'Explica cómo esto impulsó el crecimiento económico y la riqueza.',
            2 => 'Relaciona este crecimiento con el desarrollo y la atracción de población a las ciudades.',
          ),
        ),
        1 => 
        array (
          'stem' => 'Describe de qué manera las Cruzadas influyeron en el desarrollo y expansión de los centros urbanos europeos.',
          'answer' => 'Las Cruzadas fomentaron el comercio al abrir y asegurar rutas hacia Oriente, lo que trajo nuevas mercancías y riquezas a Europa. Este aumento del comercio incentivó la creación de ferias y mercados, y el establecimiento de comerciantes y artesanos en puntos estratégicos, lo que hizo que las ciudades crecieran en tamaño y población, convirtiéndose en polos económicos.',
          'rubric' => 
          array (
            0 => 'Identifica el fomento del comercio y la apertura de nuevas rutas.',
            1 => 'Explica cómo esto generó riqueza y el surgimiento de actividades económicas urbanas.',
            2 => 'Conecta estas actividades con el crecimiento físico y demográfico de las ciudades.',
          ),
        ),
      ),
    ),
    8 => 
    array (
      'id' => 'd60',
      'type' => 'larga',
      'skill' => 'Analiza las causas y consecuencias del feudalismo en Europa.',
      'points' => 4,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Explica en un párrafo de al menos 100 palabras las causas que llevaron al surgimiento del feudalismo en Europa y sus principales consecuencias sociales y políticas.',
          'answer' => 'El feudalismo surgió en Europa debido a la desintegración del Imperio Romano y las constantes invasiones bárbaras que generaron inseguridad y la necesidad de protección. Los reyes, con poco poder centralizado, no podían garantizar la seguridad de sus territorios, lo que llevó a que los nobles locales asumieran la defensa a cambio de la lealtad y el servicio de los campesinos y otros nobles menores. Esto resultó en una sociedad altamente jerarquizada, con una fragmentación del poder político y una economía agraria de subsistencia. Las consecuencias sociales incluyeron la servidumbre, donde los campesinos estaban atados a la tierra, y una división estamental rígida. Políticamente, el poder se descentralizó, con los señores feudales ejerciendo autoridad casi absoluta en sus feudos, lo que debilitó a las monarquías y dio lugar a conflictos constantes entre nobles.',
          'rubric' => 
          array (
            0 => 'Identifica correctamente al menos dos causas del surgimiento del feudalismo (ej. invasiones, debilidad real).',
            1 => 'Describe las características clave del sistema feudal (ej. protección a cambio de servicio, descentralización del poder).',
            2 => 'Menciona al menos dos consecuencias sociales (ej. servidumbre, sociedad estamental).',
            3 => 'Menciona al menos dos consecuencias políticas (ej. fragmentación del poder, debilitamiento de la monarquía).',
          ),
        ),
        1 => 
        array (
          'stem' => 'Redacta un ensayo corto (mínimo 100 palabras) sobre los factores que propiciaron el desarrollo del sistema feudal en la Edad Media y cómo este sistema transformó la vida económica y social de la época.',
          'answer' => 'El sistema feudal se desarrolló en la Edad Media principalmente por la inestabilidad política y la falta de un poder central fuerte tras la caída del Imperio Romano y las sucesivas invasiones de vikingos, magiares y musulmanes. Ante la incapacidad de los reyes para defender sus territorios, la gente buscó protección en los señores locales, quienes ofrecían seguridad a cambio de tierras y servicios. Económicamente, el feudalismo se basó en una agricultura de subsistencia, con el feudo como unidad productiva autosuficiente, lo que llevó a una disminución del comercio y la vida urbana. Socialmente, se estableció una estructura rígida de tres estamentos: la nobleza (guerreros), el clero (rezaban) y los campesinos (trabajaban y eran siervos). Esta organización generó una dependencia personal generalizada, donde la tierra era la base de la riqueza y el poder, y las relaciones de vasallaje y servidumbre definían la vida de la mayoría de la población, limitando la movilidad social y el desarrollo de otras actividades económicas.',
          'rubric' => 
          array (
            0 => 'Identifica correctamente al menos dos factores que propiciaron el feudalismo (ej. invasiones, debilidad central).',
            1 => 'Describe la base económica del feudalismo (ej. agricultura de subsistencia, feudo).',
            2 => 'Menciona al menos dos transformaciones sociales (ej. estamentos, servidumbre).',
            3 => 'Explica la relación entre la tierra, el poder y la dependencia personal en el sistema feudal.',
          ),
        ),
      ),
    ),
    9 => 
    array (
      'id' => 'd61',
      'type' => 'sopa',
      'skill' => 'Identifica vocabulario clave de la Edad Media.',
      'points' => 3,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Encuentra en la sopa de letras las siguientes palabras relacionadas con la Edad Media.',
          'words' => 
          array (
            0 => 
            array (
              'w' => 'FEUDO',
              'c' => 'Tierra concedida por un señor a un vasallo.',
            ),
            1 => 
            array (
              'w' => 'SIERVO',
              'c' => 'Campesino atado a la tierra del señor.',
            ),
            2 => 
            array (
              'w' => 'CRUZADA',
              'c' => 'Expedición militar religiosa.',
            ),
            3 => 
            array (
              'w' => 'CLERO',
              'c' => 'Conjunto de religiosos.',
            ),
            4 => 
            array (
              'w' => 'NOBLEZA',
              'c' => 'Clase social privilegiada.',
            ),
            5 => 
            array (
              'w' => 'BURGUESIA',
              'c' => 'Clase social de comerciantes urbanos.',
            ),
            6 => 
            array (
              'w' => 'MONASTERIO',
              'c' => 'Lugar donde viven los monjes.',
            ),
            7 => 
            array (
              'w' => 'CASTILLO',
              'c' => 'Fortaleza medieval.',
            ),
          ),
        ),
        1 => 
        array (
          'stem' => 'Busca en la sopa de letras estos términos importantes de la Edad Media.',
          'words' => 
          array (
            0 => 
            array (
              'w' => 'VASALLO',
              'c' => 'Persona que juraba fidelidad a un señor.',
            ),
            1 => 
            array (
              'w' => 'CABALLERO',
              'c' => 'Guerrero a caballo.',
            ),
            2 => 
            array (
              'w' => 'GREMIO',
              'c' => 'Asociación de artesanos.',
            ),
            3 => 
            array (
              'w' => 'CATEDRAL',
              'c' => 'Iglesia principal de una diócesis.',
            ),
            4 => 
            array (
              'w' => 'REY',
              'c' => 'Máxima autoridad en un reino.',
            ),
            5 => 
            array (
              'w' => 'CAMPESINO',
              'c' => 'Persona que trabaja la tierra.',
            ),
            6 => 
            array (
              'w' => 'COMERCIO',
              'c' => 'Intercambio de bienes.',
            ),
            7 => 
            array (
              'w' => 'SEÑOR',
              'c' => 'Propietario de un feudo.',
            ),
          ),
        ),
      ),
    ),
    10 => 
    array (
      'id' => 'd62',
      'type' => 'crucigrama',
      'skill' => 'Identifica conceptos clave de la Edad Media.',
      'points' => 4,
      'variants' => 
      array (
        0 => 
        array (
          'stem' => 'Resuelve el siguiente crucigrama con conceptos de la Edad Media.',
          'words' => 
          array (
            0 => 
            array (
              'w' => 'FEUDALISMO',
              'c' => 'Sistema político y social predominante en la Edad Media.',
            ),
            1 => 
            array (
              'w' => 'IGLESIA',
              'c' => 'Institución religiosa de gran poder durante la Edad Media.',
            ),
            2 => 
            array (
              'w' => 'CIUDAD',
              'c' => 'Centro de comercio y vida urbana que resurgió en la Baja Edad Media.',
            ),
            3 => 
            array (
              'w' => 'BURGO',
              'c' => 'Nombre dado a las ciudades medievales.',
            ),
            4 => 
            array (
              'w' => 'MONARQUIA',
              'c' => 'Forma de gobierno donde el poder recae en un rey.',
            ),
            5 => 
            array (
              'w' => 'ARTEGOTICO',
              'c' => 'Estilo artístico de las catedrales medievales.',
            ),
            6 => 
            array (
              'w' => 'CASTILLO',
              'c' => 'Fortificación militar y residencia de la nobleza.',
            ),
            7 => 
            array (
              'w' => 'CRUZADAS',
              'c' => 'Guerras religiosas para recuperar Tierra Santa.',
            ),
          ),
        ),
        1 => 
        array (
          'stem' => 'Completa el crucigrama con las palabras relacionadas con la Edad Media.',
          'words' => 
          array (
            0 => 
            array (
              'w' => 'GREMIOS',
              'c' => 'Asociaciones de artesanos de un mismo oficio.',
            ),
            1 => 
            array (
              'w' => 'SIERVOS',
              'c' => 'Campesinos atados a la tierra del señor feudal.',
            ),
            2 => 
            array (
              'w' => 'FEUDO',
              'c' => 'Tierra o beneficio concedido por un señor a su vasallo.',
            ),
            3 => 
            array (
              'w' => 'NOBLEZA',
              'c' => 'Clase social privilegiada que poseía tierras y poder militar.',
            ),
            4 => 
            array (
              'w' => 'BURGUESIA',
              'c' => 'Clase social compuesta por comerciantes y artesanos de las ciudades.',
            ),
            5 => 
            array (
              'w' => 'CATEDRAL',
              'c' => 'Gran iglesia gótica, símbolo del poder eclesiástico.',
            ),
            6 => 
            array (
              'w' => 'VASALLO',
              'c' => 'Hombre libre que juraba fidelidad y servicio a un señor.',
            ),
            7 => 
            array (
              'w' => 'EPIDEMIA',
              'c' => 'Enfermedad que afectó gravemente a la población medieval, como la Peste Negra.',
            ),
          ),
        ),
      ),
    ),
  ),
);
    }
}
