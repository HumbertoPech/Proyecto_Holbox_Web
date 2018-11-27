<?php
        session_start();

    function accion_iniciar() {
        global $aplicacion, $url_base, $variables_ruta, $controlador, $accion;
        /** @ignore */
        // Incluye el modelo que corresponde
        echo($_SESSION['id']);
        $contrasena="";
        global $nombre;
        $nombre="";
        $correo="";
        include('modelo/informacion_PerfilModelo.php');

        //include('modelo/bitacoraTablaModelo.php');
        //$titulo = generarTitulo();
        /** @ignore */
        // Pasa a la vista toda la informacion que se desea representar
        include('vista/informacion_perfilVista.php');
    }
    function accion_validarDatos() {
        global $aplicacion, $url_base, $variables_ruta, $controlador, $accion;
        /** @ignore */
        // Incluye el modelo que corresponde
        $contrasena="";
        global $nombre;
        $nombre="";
        $correo="";
        include('modelo/informacion_PerfilModelo.php');

        //include('modelo/bitacoraTablaModelo.php');
        //$titulo = generarTitulo();
        /** @ignore */
        // Pasa a la vista toda la informacion que se desea representar
        include('vista/informacion_perfilVista.php');
    }
    function accion_eliminarCuenta() {

        $id = $_POST['id'];
        //$id;
        include('modelo/informacion_PerfilModelo.php');
        eliminarCuenta($id);
        include('vista/informacion_perfilVista.php');
    }
?>