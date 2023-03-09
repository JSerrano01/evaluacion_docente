<?php
class Functions_Aux
{

    public function promedio_valores_preguntas($array_valores, $indice_inicial, $indice_final, $tipo_evaluacion)
    {
        if ($tipo_evaluacion === 'aecatedra') {
            $dict = array(
                "Totalmente de acuerdo" => 5,
                "De acuerdo" => 4,
                "Ni de acuerdo ni en desacuerdo" => 3,
                "En desacuerdo" => 2,
                "Totalmente en desacuerdo" => 1
            );
        }
        $acum = 0;
        for ($i = $indice_inicial; $i < $indice_final + 1; $i++) {
            $acum += $dict[$array_valores['PREGUNTA' . +$i]];
        }
        return round($acum / ($indice_final - $indice_inicial + 1), 2);
    }


    
    public function promedio_valores_preguntas_estud($resultados_array,$resultado)
    {
                  
        // Crear un array multidimensional con los resultados
        $resultados_array = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        
        // Hacer un round a todos los valores numéricos del array
        foreach ($resultados_array as &$fila) {
            foreach ($fila as $clave => &$valor) {
                if (is_numeric($valor)) {
                    $valor = round($valor, 2);
                }
            }
        }
        
                           
      return ($resultados_array);  
    } 
    
}
?>