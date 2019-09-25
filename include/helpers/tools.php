<?php

// =============================================================================
// HERRAMIENTAS
// =============================================================================

/**
 * Objeto de metodos estaticos con funciones utiles para el plugin
 */
class IiccaGaleriaTools
{

    /**
     * devuelve la fecha actual segun la zona horaria 
     *
     * @return void
     */
    public static function fechaActual()
    {
        $timezone = "America/La_paz";
        $datetime = new datetime("now", new datetimezone($timezone));
        $actualdate = strtotime(gmdate("d-m-Y", (time() + $datetime->getOffset())));

        return $actualdate;
    }

    /**
     * Traduce la fecha en español
     *
     * @param [type] $fecha
     * @return void
     */
    public static function traducirFecha($fecha)
    {
        $fecha = substr($fecha, 0, 10);
        $numeroDia = date('j', strtotime($fecha));
        $dia = date('l', strtotime($fecha));
        $mes = date('F', strtotime($fecha));
        $anio = date('Y', strtotime($fecha));
        $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
        $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
        $nombredia = str_replace($dias_EN, $dias_ES, $dia);
        $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
        // return $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio;
        // $date_requested = array($numeroDia, $nombreMes, $anio);
        $date_requested['dia'] = $numeroDia;
        $date_requested['mes'] = $nombreMes;
        $date_requested['anio'] = $anio;
        return $date_requested;
    }

    /**
     * Devulve las categorias
     *
     * @param [type] $categorias
     * @return void
     */
    public static function categorias($categorias)
    {
        if(!empty($categorias) && !is_null($categorias)){
            $categorias = explode(',', $categorias);
            $ids = array();
            foreach ($categorias as $categoria) {
                if($categoria == 'todas'){
                    $ids[0] = 'todas';
                    // array_push($ids, 0);
                } else {
                    $categoria_data = get_term((int)$categoria);
                    $ids[ (int)$categoria ] = $categoria_data->name;
                    // array_push($ids, (int)$categoria);
                }
            }
            $categorias = $ids;
            unset($ids);
        } else {
            $categorias = get_terms( array( 'taxonomy' => 'iicca_gal_cat'));
            $ids[0] = 'todas';
            foreach ($categorias as $categoria ) {
                $ids[ $categoria->term_id ] = $categoria->name;
            }
            $categorias = $ids;
            unset($ids);
        }
        return $categorias;
    }

    public static function nombresGalerias($posts)
    {
        $nombres = array();
        foreach ($posts as $post) {
            $nombres[$post->ID] = $post->post_title;
        }
        return $nombres;
    }
}
