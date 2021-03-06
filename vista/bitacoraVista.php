<?php
session_start();
$nombre = "bitacora";
$redireccion = "paginas/Inicio";

$a= validarPermisos($nombre);
if (empty($a)){   
    header("location:" . $url_base . $redireccion);
}
?>
<!DOCTYPE html>
<html lang="es-Mx">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="<?=$url_base?>resources/css/estilosGenerales.css">
        <script src="<?=$url_base?>resources/js/jquery.min.js"></script>
        <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Montaga'>
        <title>BITACORA</title>
        <link rel="stylesheet" href="<?=$url_base;?>resources/bootstrap-3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?=$url_base;?>resources/bootstrap-3.3.7/css/csscustom.css">  
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">   
                     
    </head>
    <body>

        <style>
            body
            {
                margin:0;
                padding:0;
                background-color:#f1f1f1;
            }
            .box
            {
                width:100%;
                padding:20px;
                background-color:#fff;
                border:1px solid #ccc;
                border-radius:5px;
                margin-top:25px;
            }
            </style>
        <div class="header-general">
        <div style="padding: 8px 16px; overflow: hidden;">
        
                <div class="tamano-5" id="logo"><span>HOLBOX</span></div>
                <div class="tamano-5" id="logo-derecho"><span>VIVE UNA EXPERIENCIA SIN IGUAL</span></div>
            </div>
            <div class="menu-general">
                <nav>
                    <ul class ="nav">
                        <li><a href="<?= $url_base ?>paginas/Inicio">Inicio</a></li>
                        <li><a href="">Secciones</a>
                            <ul>
                                <li><a href="<?= $url_base ?>paginas/Historia">Historia</a></li>
                                <li><a href="<?= $url_base ?>paginas/LugaresHolbox">¿Qué hacer?</a></li>
                                <li><a href="<?= $url_base ?>paginas/Gastronomia">Gastronomía</a></li>
                                <li><a href="<?= $url_base ?>paginas/FloraFauna">Flora y Fauna</a></li>
                            </ul>
                        </li>
                        <?php
                        include("libs/manejador_sesiones.php");
                        $menu = get_Menu();

                        foreach( $menu as $opcion => $link){
                            echo "<li><a href=\"$link\">$opcion</a></li>";
                        }
                        ?>
                    </ul>
                </nav>
            </div>
            <div id="sesiones">
                <?php
                if(empty($_SESSION)){
                    echo "<label><a href='{$url_base}inicioSesion/iniciarSesion'>Iniciar Sesión  </a></label>";
                    echo "<label><a href='{$url_base}registroUsuario/registrarUsuario'> Registrarse</a></label>";
                }else{
                    echo "<script src = '{$url_base}resources/js/autologout.js'></script>";
                    echo "<label>Bienvenido ".$_SESSION['nombre'] ." </label>";
                    echo "<label><a href='{$url_base}inicioSesion/logout'>Cerrar Sesión </a></label>";
                }
                ?>
            </div>
        <div>      <!--fin header-->

        <div class="container box">
        <div class="content">
            <h1 align="center">BITÁCORA</h1>
                <div class="table-responsive" >
                        <table id="tabla_bitacora" class="table  table-striped  table-hover">
                            <tr>
                                <th>Nombre de Usuario</th>
                                <th>Fecha de registro</th>
                                <th>Hora de registro</th>
                                <th>Actividad</th>
                                <th>Nombre de Permiso</th>
                                <th>Nombre de Sistema</th>
                            </tr>
                            <?php
                            $resultadosBitacora= array();
                            $resultadosBitacora = solicitarListaBitacora();
                            if( count($resultadosBitacora)<=0){
                                echo '<tr><td colspan="8">No hay datos.</td></tr>';
                            }else{
                                for($i=0; $i< count($resultadosBitacora); $i++){
                                    $no = 1;							
                                    echo '
                                    <tr>
                                        <td> <span class="glyphicon glyphicon-user" aria-hidden="true"></span>'.$resultadosBitacora[$i]['nombre_usuario'].'</td>
                                        <td>'.$resultadosBitacora[$i]['fecha_registro'].'</td>
                                        <td>'.$resultadosBitacora[$i]['hora_registro'].'</td>
                                        <td>'.$resultadosBitacora[$i]['actividad'].'</td>
                                        <td>'.$resultadosBitacora[$i]['nombre_permiso'].'</td>                                         <td>'.$resultadosBitacora[$i]['nombre_sistema'].'</td></tr>';
                                    $no++;							
                                }
                            }
                            ?>
                        </table>
                    
                    
 
                <br/>
            </div>
            </div>
        </div>
        </div>
        <style>
            .myfooter{
                background-color: rgba(51,51,51,.95);
                margin-top: 10px;
                box-shadow: 0 2px 5px 0;
            }

            body {
                line-height: 1.5 !important;
                background-color: #839A91 !important;
            }

        </style>

        <div class="myfooter">   
            <div id="about">
                    <div class="tamano-7" id="menu-footer">
                        <nav>
                            <ul>
                                <li><a href="<?=$url_base?>paginas/Inicio">Inicio</a></li>
                                <li><a href="<?= $url_base ?>paginas/Historia">Historia</a></li>
                                <li><a href="<?= $url_base ?>paginas/LugaresHolbox">¿Qué hacer?</a></li>
                                <li><a href="<?= $url_base ?>paginas/Gastronomia">Gastronomía</a></li>
                                <li><a href="<?= $url_base ?>paginas/FloraFauna">Flora y Fauna</a></li>
                                <?php
                                    $menu = get_Menu();

                                    foreach( $menu as $opcion => $link){
                                        echo "<li><a href=\"$link\">$opcion</a></li>";
                                    }
                                ?>
                            </ul>
                        </nav>
                    </div>
                    <div class="tamano-5" id="nosotros">
                        <h3>Sobre Nosotros</h3>
                        <ul>
                            <li>Chuc Arcia Alejandro</li>
                            <li>Ancona Graniel Ulises</li>
                            <li>Interian Bojorquez Shaid</li>
                            <li>Pech Huchin Humberto</li>
                            <li>Sosa Lopez Wendy</li>
                        </ul>
                    </div>
                </div>
                <p id="copyright">
                    Todos los derechos reservados &copy;. Holbox 2018
                </p>
            </div>
        </div>

    </body>
</html>

<script type="text/javascript" language="javascript" >
    $(document).ready(function(){
        $('.input-daterange').datepicker({"locale": {
            "separator": " - ",
            "applyLabel": "Aplicar",
            "cancelLabel": "Cancelar",
            "fromLabel": "Desde",
            "toLabel": "Hasta",
            "customRangeLabel": "Custom",
            "daysOfWeek": [
                "Do",
                "Lu",
                "Ma",
                "Mi",
                "Ju",
                "Vi",
                "Sa"
            ],
            "monthNames": [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre"
            ],
            "firstDay": 1
        },
            format: "yyyy-mm-dd",
            autoclose: true
        });
        //fetch_data('no');
        /*function fetch_data(is_date_search, start_date='', end_date='',nombre_usuario='', nombre_permiso='', nombre_sistema='')
        {   
                var dataTable = $('#order_data').DataTable({
                "language":{
                    "lengthMenu":"Mostrar _MENU_ registros por página.",
                    "zeroRecords": "Lo sentimos. No se encontraron registros.",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros aún.",
                    "infoFiltered": "(filtrados de un total de _MAX_ registros)",
                    "search" : "Búsqueda por carácter",
                    "LoadingRecords": "Cargando ...",
                    "Processing": "Procesando...",
                    "SearchPlaceholder": "Comience a teclear...","paginate": {
                        "previous": "Anterior",
                        "next": "Siguiente", 
                    }
                },
                "processing" : true,
                "serverSide" : true,
                "sort": false,
                "order" : [],
                "sort": [[ 0, "asc" ]],
                "ajax" : {
                    url:'<?=$url_base;?>modelo/bitacoraTablaModelo.php',
                    type:"POST",
                    data:{
                        is_date_search:is_date_search, start_date:start_date, end_date:end_date, 
                        nombre_usuario:nombre_usuario, nombre_permiso:nombre_permiso, nombre_sistema:nombre_sistema
                    }
                }
            });
        }*/
        /*$('#search').click(function(){
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var selectUsers = document.getElementById("select_users");
            var  nombre_usuario = selectUsers.options[selectUsers.selectedIndex].text;
            var selectPermisos = document.getElementById("select_permisos");
            var  nombre_permiso = selectPermisos.options[selectPermisos.selectedIndex].text;
            var selectSistemas = document.getElementById("select_users");
            var  nombre_sistema = selectSistemas.options[selectSistemas.selectedIndex].text;           
            if(start_date != '' && end_date !='')
            {
                $('#order_data').DataTable().destroy();
                fetch_data('yes', start_date, end_date, nombre_usuario, nombre_permiso, nombre_sistema );
            }
            else
            {
                $('#order_data').DataTable().destroy();
                fetch_data('no', '','', nombre_usuario, nombre_permiso, nombre_sistema);
            }
        });

        $('#mostrar_todos').click(function(){
                $('#order_data').DataTable().destroy();
                fetch_data('no');
        });*/

    });
</script>
