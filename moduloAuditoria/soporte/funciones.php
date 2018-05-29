<?php
    require_once("../configuracion/clsBD.php");
    #no muestra los errores del sistema
    #error_reporting(0);
  
    /*
     * Validación de usuario
     * @param   string      $user       nombre de usuario
     *          string      $pass       contraseña del usuario sin codificar
     * @return  string      $mensaje    mensajes para el usuario, si este es valido no se muestra ningun mensaje
     */
    function validarUsuario($user, $pass){
        session_start();
        $mensaje = "";
        $objDatos = new clsDatos();
        if($user == null || $pass == null){
            $mensaje = "El usuario y la clave son obligatorios";
        }else{
            $sql = "SELECT id_usuario, nombre, apellido, id_rol_usu FROM usuario u 
                    WHERE u.nombre_usuario='$user' AND u.contrasenia=MD5('$pass')";
            $arreglo_datos = $objDatos->consultarUnRegistro($sql);
            $usuario = $arreglo_datos["id_usuario"];
            $nombUsuario= $arreglo_datos["nombre"]." ".$arreglo_datos["apellido"];
            $idRol= $arreglo_datos["id_rol_usu"];
            if($usuario > 0) { 
                if($idRol==1){
                    $_SESSION['idUsu'] = $usuario;
                    $_SESSION['nombreUsuario'] = $nombUsuario;
                    $_SESSION['perfil'] = $idRol;
                    header("Location: menu.php");
                }else{ $mensaje="Usuario no valido para esta aplicación"; }
            }else{ $mensaje = "Usuario o clave invalidos"; }
        }
        return $mensaje;
    }
    
    /*
     * Listar estaciones
     * @param   null
     * @return  array   $listaEstaciones    id, nombre, municipio, tipo
     */
    
    function listEstaciones($red, $origne){
        $objDatos = new clsDatos();
        $sql = "SELECT DISTINCT estacion_sk as id, estacion as nombre, municipio as municipio, tipologia as tipo 
                FROM station_dim s WHERE red='$red' ";
        if($origne!==null){
            $sql .= "AND tipologia<>'Calidad del aire' AND estacion_sk<>60 ";
        }
        $sql .= "ORDER BY 1";
        return $objDatos->executeQuery($sql);
    }
    /*function listEstaciones(){
        $objDatos = new clsDatos();
        $sql = "SELECT DISTINCT estacion_sk as id, estacion as nombre, municipio as municipio, tipologia as tipo 
                FROM station_dim s ORDER BY 1";
        return $objDatos->executeQuery($sql);
    }*/
    /*
     * Listar redes
     * @param   null
     * @return  array   $listaRed    red
     */
    
    function listRed(){
        $objDatos = new clsDatos();
        $sql = "SELECT DISTINCT red FROM station_dim;";
        return $objDatos->executeQuery($sql);
    }
    
    /*
     * Listar estaciones
     * @param   null
     * @return  array   $listaEstaciones    id, nombre, municipio, tipo
     */
    
    function listRiesgo(){
        $objDatos = new clsDatos();
        $sql = "SELECT DISTINCT id, descripcion FROM riesgo ORDER BY 1";
        return $objDatos->executeQuery($sql);
    }
    
    /*
     * Listar variables auditables de una estacion específica
     * @param   null
     * @return  array   $listaVariables     
     */
    function listarVariables(){
        $objDatos = new clsDatos();
        $sql = "SELECT DISTINCT nombre as nombre, variable_fact as atributo, tipologia as tipo FROM variable ";
        return $objDatos->executeQuery($sql);
    }
    
    /*
     * Listar variables auditables de una estacion específica
     * @param   null
     * @return  array   $listaVariables     
     */
    function listarVariable($idEstacion){
        $objDatos = new clsDatos(); $variable=array();
        $sql = "SELECT tipologia FROM station_dim WHERE estacion_sk=$idEstacion";
        $tipo = $objDatos->consultarUnRegistro($sql)['tipologia'];
        $sql = "SELECT DISTINCT nombre as nombre, variable_fact as atributo FROM variable WHERE tipologia=";
        if($tipo=="Calidad del aire"){ $sql .= "'Aire'"; }else{ $sql .= "'Clima'"; }
        $variables = $objDatos->executeQuery($sql);
        foreach ($variables as $key){
            $sql = "SELECT COUNT(estacion_sk) AS cant FROM ";
            if($tipo=="Calidad del aire"){ $sql .= "fact_aire"; }else{ $sql .= "fact_table"; }
            $sql .= " WHERE estacion_sk=$idEstacion AND ".$key['nombre']." IS NOT NULL ";
            $cantidad = $objDatos->consultarUnRegistro($sql)['cant'];
            if($cantidad>0){ array_push($variable, $key['nombre']); }
        }
        return $variable;
    }
    
    /*
     * Listar riesgos validos segun la estacion y la variable
     * @param   int     $idEstacion     identificacion de la estacion
     *          string  $idVariable     nombre del atributo
     * @return  array   $listaRiesgos   id, codigo, descripcion
     */
    function listarRiesgos($idEstacion, $idVariable){
        $objDatos = new clsDatos();
        $sql = "SELECT r.id as id, descripcion  
                FROM riesgo r, auditoria a, variable_auditoria v
                WHERE r.id=a.riesgo AND a.variable_auditoria=v.id AND 
                    nombre_variable='".$idVariable."' AND estacion_sk=$idEstacion";
        return $objDatos->executeQuery($sql);
    }
    
    /*
     * Datos de la variable para auditar
     * @param   int     $idEstacion     Identificacion de la estacion
     *          string  $idVariable     nobmre del atributo
     * @return  array   $datosVariable  id, nombre_variable, estacion_sk, nombre_tabla, 
     *                                  valor_maximo, valor_minimo, diferencia_anterior, 
     *                                  variable_activa
     */
    function datosVariableAuditoria($idEstacion, $idVariable){
        $objDatos = new clsDatos();
        $sql = "SELECT id, nombre_variable, estacion_sk, nombre_tabla, valor_maximo, 
                    valor_minimo, diferencia_anterior, variable_activa 
                FROM variable_auditoria 
                WHERE nombre_variable='".$idVariable."' AND estacion_sk=$idEstacion ";
        return $objDatos->consultarUnRegistro($sql);
    }
    
    /*
     * Datos resultantes
     * @param   int     $idEstacion     Identificacion de la estacion
     *          string  $idVariable     nobmre del atributo
     *          int     $idRegistro     identificador del riesgo tabla riesgo
     * @return  int   $cantidadErrores
     */
    function auditar($idEstacion, $idVariable, $idRiesgo){
        $objDatos = new clsDatos(); $datosProcesados=array();
        $datosVariable = datosVariableAuditoria($idEstacion, $idVariable);
        $sql = "SELECT fecha, tiempo, $idVariable as dato
                FROM ".$datosVariable['nombre_tabla']." f, date_dim d, time_dim t 
                WHERE f.fecha_sk=d.fecha_sk AND f.tiempo_sk=t.tiempo_sk AND f.estacion_sk=$idEstacion ";
        // 1 negativo "para R1-R10", 2 rangos "para R11-R20", 3 valor no reportado "para R21-R30", 4 diferencia "para R31-R33", 5 exista un valor "para R34-R41", 6 erróneos consecutivos "para R42-R51"
        if($idRiesgo==='1' || $idRiesgo==='6'){
            $sql .= "AND $idVariable<0 ";          
        }if ($idRiesgo==='2' || $idRiesgo==='6') {
            $sql .= "AND ($idVariable<".$datosVariable['valor_minimo']." OR $idVariable>".$datosVariable['valor_maximo'].") ";
        }if ($datosVariable['variable_activa']===true && $idRiesgo==='5') { #VALIDAR EL 5 EN EL FORMULARIO
            $sql .= "AND $idVariable IS NOT NULL ";
        }if ($idRiesgo==='3' || $idRiesgo==='6') {
            if($datosVariable['valor_minimo']>0){ $sql .= "AND $idVariable=0"; }
        }
        $sql .= "ORDER BY 1, 2";
        echo $sql;
        $cantidad=$objDatos->executeQuery($sql);
        $datosProcesados = $cantidad;
        $tam = count($cantidad);
        if ($idRiesgo===4) {
            if($cantidad){#revisar el atributo.
                for ($i=1; $i<$tam; $i++){
                    if($cantidad[$i-1]!==NULL && $cantidad[$i]!==NULL){
                        $diferencia= $cantidad[$i-1]-$cantidad[$i];
                        if(abs($diferencia)>$datosVariable['diferencia_anterior']){array_push($datosProcesados, $cantidad[$i]);}
                    }
                }
            }
        }elseif($idRiesgo===6){
            if($cantidad){
                for ($i=1; $i<$tam; $i++){ #revisar lo de los nulos por lo de la diferencia verificar condicion de $datosVariable['variable_activa']===true del riesgo 5
                    $diferencia = abs(strtotime($cantidad[$i-1]['tiempo'])-strtotime($cantidad[$i]['tiempo']));
                    $prom = 2 * diferenciaTiempos($cantidad);
                    if($diferencia > $prom){array_push($datosProcesados, $cantidad[$i]); }
                }
            }
        }else{
            #$datosProcesados=$cantidad;
            #$datosProcesados = diferenciaTiempos($cantidad);
            if($cantidad){
                for ($i=1; $i<$tam; $i++){
                    #revisar lo de los nulos por lo de la diferencia
                    #verificar condicion de $datosVariable['variable_activa']===true del riesgo 5
                    $diferencia = abs(strtotime($cantidad[$i-1]['tiempo'])-strtotime($cantidad[$i]['tiempo']));
                    $prom = 2 * diferenciaTiempos($cantidad);
                    if( $diferencia > $prom ){
                        array_push($datosProcesados, $cantidad[$i]);
                    }
                }
            }
            #$datosProcesados="hola";
            #$datosProcesados = strtotime($cantidad[1]['tiempo'])-strtotime($cantidad[2]['tiempo']);
        }
        return $datosProcesados;
        
    }

    /*
     * Calcula el promedio de las diferencias de tiempos de la estación en transmitir
     * 
     * @param   array   $array  datos (fecha, tiempo, variable)
     * 
     * @return  int     promedio    media de diferencia de tiempos en minutos.
     * 
     */
    function diferenciaTiempos($array){
        $prom = 0; $cant=count($array);
        for ($i=1; $i<$cant; $i++){
            $prom += abs(strtotime($array[$i-1]['tiempo'])-strtotime($array[$i]['tiempo']));
        }
        $prom=$prom/$cant;
        return (integer)$prom;
    }
    
    /*
     * identificar el riesgo segun el id
     * 
     * @param   string  $id     id del riesgo
     * 
     * @return  string  $nombre nombre del riesgo
     * 
     */
    function nombreRiesgo($id){
        $objDatos = new clsDatos();
        $sql = "SELECT descripcion FROM riesgo WHERE id=$id";
        return $objDatos->consultarUnRegistro($sql)['descripcion'];
    }
    
    /*
     * identificar el riesgo segun el id
     * 
     * @param   string  $id     id del riesgo
     * 
     * @return  string  $nombre nombre del riesgo
     * 
     */
    function nombreEstacion($id){
        $objDatos = new clsDatos();
        $sql = "SELECT estacion FROM station_dim WHERE estacion_sk=$id";
        return $objDatos->consultarUnRegistro($sql)['estacion'];
    }
    
    /*
     * identificar el nombre de la tabla segun la variable
     * 
     * @param   string  $id     id del riesgo
     * 
     * @return  string  $nombre nombre del riesgo
     * 
     */
    function nombreTabla($idVariable){
        $objDatos = new clsDatos(); $nombre='fact_table';
        $sql = "SELECT tipologia FROM variable WHERE nombre='$idVariable'";
        if ($objDatos->consultarUnRegistro($sql)['tipologia']=='Aire'){
            $nombre='fact_aire';
        }
        return $nombre;
    }    
    
    /*
     * identificar el riesgo segun el id
     * 
     * @param   string  $id     id del riesgo
     * 
     * @return  string  $nombre nombre del riesgo 18291
     * 
     */
    function asignarRiesgo($idEstacion, $idVariable, $riesgo){
        $objDatos = new clsDatos();
        $mensaje="Fallo al guardar";
        $sql = "SELECT id FROM variable_auditoria WHERE estacion_sk=$idEstacion AND nombre_variable='$idVariable'";
        $idVarAuditoria = $objDatos->consultarUnRegistro($sql)['id'];
        if($idVarAuditoria>0){
            foreach ($riesgo as $value){
                $sql = "SELECT count(variable_auditoria) AS cant FROM auditoria "
                        . "WHERE variable_auditoria=$idVarAuditoria AND riesgo=$value";
                $existe = $objDatos->consultarUnRegistro($sql)['cant'];
                if($existe>0){ 
                    $mensaje="Ya existe este riesgo asignado a la estación y la variable elegidas.";
                }else{
                    $sql = "INSERT INTO auditoria VALUES ($idVarAuditoria, $value)";
                    $objDatos->operacionesCrud($sql);
                    $mensaje = "Parámetros guardados con exito";
                }
            }
        }else{
            $tabla = nombreTabla($idVariable);
            $sql = "INSERT INTO variable_auditoria (nombre_variable, nombre_tabla, estacion_sk) VALUES ('$idVariable', '$tabla',$idEstacion)";
            $objDatos->operacionesCrud($sql);
            $sql = "SELECT id FROM variable_auditoria WHERE nombre_variable='$idVariable' AND estacion_sk=$idEstacion";
            $idVarAuditoria = $objDatos->consultarUnRegistro($sql)['id'];
            foreach ($riesgo as $value){
                $sql = "INSERT INTO auditoria VALUES ($idVarAuditoria, $value)";
                $objDatos->operacionesCrud($sql);
                $mensaje = "Parámetros guardados con exito";
            }
        }
        return $mensaje;
    }    
    
    /*
     * identificar el riesgo segun el id
     * 
     * @param   string  $id     id del riesgo
     * 
     * @return  string  $nombre nombre del riesgo 18291
     * 
     */
    function parametrosFiltros($idEstacion, $idVariable, $maximo, $minimo, $diferencia, $aplica){
        $objDatos = new clsDatos();
        $mensaje="Fallo al guardar";
        $sql = "SELECT id FROM variable_auditoria WHERE estacion_sk=$idEstacion AND nombre_variable='$idVariable'";
        $idVarAuditoria = $objDatos->consultarUnRegistro($sql)['id'];
        if($maximo===''){ $maximo="null"; }
        if($minimo===''){ $minimo="null"; }
        if($diferencia===''){ $diferencia="null"; }
        if($aplica==='on'){$aplica='false';}else{$aplica='true';}
        if($idVarAuditoria>0){
            $sql = "UPDATE variable_auditoria SET valor_maximo=$maximo, valor_minimo=$minimo, 
                    diferencia_anterior=$diferencia, variable_activa=$aplica  WHERE id=$idVarAuditoria";
            $objDatos->operacionesCrud($sql);
            $mensaje = "Parámetros guardados con exito";
        }else{
            $tabla = nombreTabla($idVariable);
            $sql = "INSERT INTO variable_auditoria (nombre_variable, nombre_tabla, 
                estacion_sk, valor_maximo, valor_minimo, diferencia_anterior, variable_activa) 
                VALUES ('$idVariable', '$tabla',$idEstacion, $maximo, $minimo, $diferencia, $aplica)";
            $objDatos->operacionesCrud($sql);
            $mensaje = "Parámetros guardados con exito";
        }
        return $mensaje;
    }    
    
    /*
     * identificar el riesgo segun el id
     * 
     * @param   string  $id     id del riesgo
     * 
     * @return  string  $nombre nombre del riesgo 18291
     * 
     */
    function listaRiesgo($idEstacion, $idVariable){
        $objDatos = new clsDatos();
        $sql = "SELECT r.id as id, r.descripcion as name FROM riesgo r, auditoria a, variable_auditoria v WHERE r.id=a.riesgo AND a.variable_auditoria=v.id AND v.estacion_sk=$idEstacion AND v.nombre_variable='$idVariable'";
        $datos = $objDatos->executeQuery($sql);
        $mensaje = "";
        foreach ($datos as $values){ $mensaje .= "<b>R".$values['id'].": </b>".$values['name']."<br>"; }
        return $mensaje;
    }    
    
    /*
     * identificar el riesgo segun el id
     * 
     * @param   string  $id     id del riesgo
     * 
     * @return  string  $nombre nombre del riesgo 18291
     * 
     */
    function listaVariables($idEstacion, $idVariable){
        $objDatos = new clsDatos();
        $sql = "SELECT valor_maximo, valor_minimo, diferencia_anterior FROM variable_auditoria WHERE estacion_sk=$idEstacion AND nombre_variable='$idVariable'";
        $datos = $objDatos->executeQuery($sql);
        $mensaje = "";
        foreach ($datos as $values){ 
            $mensaje .= "<b>Valor mínimo: </b>".$values['valor_minimo']."<br><b>Valor máximo: </b>".$values['valor_maximo']."<br>
                         <b>Valor máximo de la diferencia con el anterior: </b>".$values['diferencia_anterior']."<br>";
        }
        return $mensaje;
    }
    
    /*
     * Datos resultantes
     * @param   int     $idEstacion     Identificacion de la estacion
     * @return  array   $cantidadErrores
     */
    function diferencias($idEstacion){
        require_once("clsDW.php");
        $objFiltrado = new clsDatos();
        $objOriginal = new clsFuente();
        
    }
    
?>