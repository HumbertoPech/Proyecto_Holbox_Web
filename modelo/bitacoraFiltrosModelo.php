<?php
        require("core/Conexion.php");
        //$connect = mysqli_connect("localhost", "root", "19980519uli", "proyecto_holbox_db");//Configurar los datos de conexion
        $con = new Conexion();
        $conexion = $con->get_conexion();
        $getAllData =  get_all_data($conexion);
        while($row_usuarios = mysqli_fetch_array($getAllData))
        {
            $data_usuarios[] = $row_usuarios["nombre_usuario"];
        }
        $data_usuarios = array_unique($data_usuarios);
        //Permisos
        $data_permisos = array();
        $getAllData =  get_all_data($conexion);
        while($row_permisos = mysqli_fetch_array($getAllData))
        {
            $data_permisos[] = $row_permisos["nombre_permiso"];
        }
        //$this->$data_permisos = array_unique($data_permisos);
        $data_permisos = array_unique($data_permisos);
        
        //Sistema
        $data_sistemas = array();
        $getAllData =  get_all_data($conexion);
        while($row_sistemas = mysqli_fetch_array($getAllData))
        {
            $data_sistemas[] = $row_sistemas["nombre_sistema"];
        }
        //$this->$data_sistemas = array_unique($data_sistemas);
        $data_sistemas = array_unique($data_sistemas);

    function get_all_data($conexion)
    {
        $query = "SELECT Bi.fecha_registro, Bi.hora_registro, Bi.actividad, Bi.id_permiso, Bi.id_usuario, Bi.id_sistema, Us.nombre_usuario, Pe.nombre_permiso, Si.nombre_sistema FROM bitacora Bi INNER JOIN usuarios Us ON Bi.id_usuario = Us.id_usuario INNER JOIN permisos Pe ON Bi.id_permiso = Pe.id_permiso INNER JOIN sistemas Si ON Bi.id_sistema = Si.id_sistema";   
        $result = mysqli_query($conexion, $query);
         return $result;
    }
?>
