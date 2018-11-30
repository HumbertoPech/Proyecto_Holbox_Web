<?php
    require("core/Conexion.php");
    //$connect = mysqli_connect("localhost", "root", "19980519uli", "proyecto_holbox_db");//Configurar los datos de conexion
    $con = new Conexion();
    $conexion = $con->get_conexion();
    $getAllData =  get_all_data();
    while($rows = mysqli_fetch_array($getAllData))
    {
        $data_usuarios[] = $rows["nombre_usuario"];
        $data_permisos[] = $rows["nombre_permiso"];
        $data_sistemas[] = $rows["nombre_sistema"];
    }
    $data_usuarios = array_unique($data_usuarios);
    $data_permisos = array_unique($data_permisos);
    $data_sistemas = array_unique($data_sistemas);
    
    function solicitarListaBitacora(){
        global $conexion;
        $query = "SELECT Bi.fecha_registro, Bi.hora_registro, Bi.actividad, Bi.id_permiso, Bi.id_usuario, Bi.id_sistema, Us.nombre_usuario, Pe.nombre_permiso, Si.nombre_sistema FROM bitacora Bi INNER JOIN usuarios Us ON Bi.id_usuario = Us.id_usuario INNER JOIN permisos Pe ON Bi.id_permiso = Pe.id_permiso INNER JOIN sistemas Si ON Bi.id_sistema = Si.id_sistema";  
        $result = mysqli_query($conexion, $query);


        if (!empty($result)) {
            while($row = $result->fetch_assoc()){                    
                $arrayBitacora[]=$row;
            }
            return $arrayBitacora;
        }   
        return $arrayBitacora; 
    }
    function get_all_data()
    {
        global $conexion;
        $query = "SELECT Bi.fecha_registro, Bi.hora_registro, Bi.actividad, Bi.id_permiso, Bi.id_usuario, Bi.id_sistema, Us.nombre_usuario, Pe.nombre_permiso, Si.nombre_sistema FROM bitacora Bi INNER JOIN usuarios Us ON Bi.id_usuario = Us.id_usuario INNER JOIN permisos Pe ON Bi.id_permiso = Pe.id_permiso INNER JOIN sistemas Si ON Bi.id_sistema = Si.id_sistema";   
        $result = mysqli_query($conexion, $query);
         return $result;
    }

?>
