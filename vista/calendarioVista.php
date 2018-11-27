<?php
session_start();
$permisos = validarPermisos("calendario de eventos");
if(empty($permisos)){
    header("Location:{$url_base}paginas/Inicio");
}
?>

<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="<?=$url_base?>resources/css/estilosInicio.css">
        <link rel="stylesheet" href="<?=$url_base?>resources/css/estilosGenerales.css">
        <link rel ="stylesheet" href="<?=$url_base?>resources/css/estilos.css">
        <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Montaga'>
        <script src="<?=$url_base?>resources/js/jquery.min.js"></script>
        <script src="<?=$url_base?>resources/js/moment.min.js"></script>
        <link rel="stylesheet" href="<?=$url_base?>resources/css/fullcalendar.min.css">
        <script src="<?=$url_base?>resources/js/fullcalendar.min.js"></script>
        <script src="<?=$url_base?>resources/js/es.js"></script>
        <style>
            #CalendarioWeb {
                background-color:rgba(200,198,176,.94);
                box-shadow: 0px 15px 15px 0px;
                border-style: inset;
                border-width: 1px;
                width: 85%;
                margin-right: auto;
                margin-left: auto; 
            }
            
            .middle-content{
                background-color: white;
                overflow: hidden;
                position: relative; 
                box-shadow: 0px 10px 10px 0px;
                text-align: center;
                 
            }
            
            .fc-toolbar, fc-header-toolbar{
                
            }
            
            .fc-day-header{
                background-color: rgba( 200,230,197,.80)!important;
            }
            
            #middle{
                padding: 0 1rem;
                margin: 1rem;
                overflow: hidden;
            }
        </style>
        <title>Inicio</title>
</head>
<body onload="onload()">
        <header class="header-general">
            <div style="padding: 8px 16px; overflow: hidden;">
                <div class="tamano-5" id="logo"><span>HOLBOX</span></div>
                <div class="tamano-5" id="logo-derecho"><span>VIVE UNA EXPERIENCIA SIN IGUAL</span></div>
            </div>
            <div class="menu-general">
                <nav>
                    <ul class ="nav">
                        <li><a href="<?=$url_base?>paginas/Inicio">Inicio</a></li>
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
        </header>
        <div class = "middle-content tamano-12">
            <div id="titulo"><h3>En este apartado se pueden agregar / modificicar / eliminar eventos del calendario.</h3></div>
            <div id= "middle" class="tamano-12"><div id = "CalendarioWeb"></div></div>
            <div id="instrucciones"><h4>Para añadir evento pulse en la casilla del día a crear el evento, para borrar u modificar un evento
                 seleccionar el evento.</h4></div>
            <!-- The Modal  for modify, add or eliminate-->
            <div id="myModal" class="modal">
            
            <!-- Modal content -->
            <div class="modal-content">
            <div class="modal-header">
            <span class="close">&times;</span>
            <h2>Evento</h2>
            <h4 id="tituloEvento"></h4>
            </div>
            <div class="modal-body">
                    <div class="campo">
                    <input type="hidden" id="txtID"  name="txtID"/>
                    </div>

                    <div class="campo">
                            <label for="txtFecha">Fecha: </label>
                            <input type="text" name="txtfecha" disabled id="txtFecha" placeholder="Fecha"><br/>
                    </div>

                    <div class="campo">
                            <label for="txtTitulo">Titulo: </label>
                            <input type="text" name="txttitulo"  id="txtTitulo" placeholder="Titulo del evento"><br/>
                    </div>

                    <div class="campo">
                            <label for="txtHora">Hora: </label>
                            <input type="datetime" name="txthora"  id="txtHora" placeholder="Hora" value = "10:30" ><br/>
                    </div>

                    <div class="campo" >
                            <label for="txtDescripcion">Descripcion: </label>
                            <textarea   id = "txtDescripcion" rows = "3" placeholder="Descripcion del evento" ></textarea><br/>
                    </div>

                    <div class="campo" >
                            <label for="txtColor">Color: </label>
                            <input  type="color" name="txthora"  id="txtColor" style="height:36px;" value = "#ff0000" ><br/>
                    </div>

            </div>
            <div class="modal-footer" style="text-align:center;">
            <button type="button" id="btnAgregar" class="botonModalA">Agregar</button>
            <button type="button" id="btnModificar" class="botonModalM" >Modificar</button>
            <button type="button" id="btnBorrar" class="botonModalB" >Borrar</button>
            <button type="button" id="btnCancelar" class="botonModalC">Cancelar</button>
            </div>
            </div>

            </div>
        </div>
        <footer>
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
        </footer>
        
        <script>
            let id_usuario;
            let tipo_usuario;

            //verifica al cargarse la pagina que tipo de permisos tiene sobre la pagina
            function onload(){
                //permisos de pagina: se puede mejorar haciendo consulta en la bd
                let permisosPagina = {btnAgregar:"crear evento", btnModificar:"modificar evento", btnBorrar:"eliminar evento"};
                let xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if(this.readystate = 4 && this.status == 200){
                        let obj = JSON.parse(this.response);
                        let tamano = Object.keys(obj).length;

                        id_usuario = obj[tamano-1]['id_usuario'];
                        tipo_usuario = obj[tamano-1]['tipo_usuario'];

                        for(let i = 0; i < tamano-1; i++){
                            for(let clave in permisosPagina){
                                if(permisosPagina[clave] == obj[i]['nombre_permiso']){
                                    delete permisosPagina[clave];
                                    break;
                                }
                            }
                        }
                        
                        //los permisos que quedan son los que el usuario no tiene acceso
                        for(let clave2 in permisosPagina){
                            document.getElementById(clave2).style.display = 'none';
                        }
                    }
                };
                xmlhttp.open("POST", "<?=$url_base?>calendario/obtenerPermisos", true);
                xmlhttp.send();
            }
        </script>
        <script>
        // Get the modal
        var modal = document.getElementById('myModal');

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        </script>
        <script>
        $(document).ready(function(){
            $('#CalendarioWeb').fullCalendar({
                dayClick:function(date, jsEvent, view){
                    
                    document.getElementById('btnAgregar').disabled = false;
                    document.getElementById('btnModificar').disabled = true;
                    document.getElementById('btnBorrar').disabled = true;
                    limpiarFormulario();                    
                    $('#txtFecha').val(date.format());
                    document.getElementById('myModal').style.display = "block";
                },
                        events: '<?=$url_base?>libs/eventos.php',
                        
                eventClick:function(calEvent,jsEvent, view){
                    document.getElementById('btnAgregar').disabled = true;
                    document.getElementById('btnModificar').disabled = false;
                    document.getElementById('btnBorrar').disabled = false;
                    $('#tituloEvento').html(calEvent.title);
                    $('#txtDescripcion').val(calEvent.descripcion);
                    $('#txtID').val(calEvent.id);
                    $('#txtTitulo').val(calEvent.title);
                    $('#txtColor').val(calEvent.color);
                    FechaHora =calEvent.start._i.split(" ");
                    $('#txtFecha').val(FechaHora[0]);
                    $('#txtHora').val(FechaHora[1]);
                    document.getElementById('myModal').style.display = "block";
                }
                
            });
        });

    </script>
    <script>
        var NuevoEvento;
        $('#btnAgregar').click(function(){
            RecolectarDatos();
            EnviarInformacion('agregar', NuevoEvento);
            
        });
        $('#btnBorrar').click(function(){
            RecolectarDatos();
            EnviarInformacion('eliminar', NuevoEvento);
            
        });
        $('#btnModificar').click(function(){
            RecolectarDatos();
            EnviarInformacion('modificar', NuevoEvento);
            
        });
        $('#btnCancelar').click(function(){
            document.getElementById('myModal').style.display = "none";
        });

        function RecolectarDatos(){
            NuevoEvento = {
                id_usuario:id_usuario,
                tipo_usuario:tipo_usuario,
                id:$('#txtID').val(),
                title:$('#txtTitulo').val(),
                start:$('#txtFecha').val() + " "+ $('#txtHora').val(),
                color:$('#txtColor').val(),
                descripcion:$('#txtDescripcion').val(),
                textColor:"#FFFFFF",
                end:$('#txtFecha').val() + " "+ $('#txtHora').val()
            };
        }

        function EnviarInformacion(accion, objEvento){
            $.ajax({
                type:'POST',
                url:'<?=$url_base;?>libs/eventos.php?accion='+accion,
                data:objEvento,
                success:function(msg){
                    if(msg){
                        alert("Acción realizada con éxito.");
                        $('#CalendarioWeb').fullCalendar('refetchEvents');
                        document.getElementById('myModal').style.display = "none";
                    }else{
                        alert("Ocurrió un problema al querer realizar cambios en la base de datos");
                    }
                },
                error:function(){
                    alert("Hay un error");
                }
            });
        }

        function limpiarFormulario(){
            $('#txtDescripcion').val('');
            $('#txtID').val('');
            $('#txtTitulo').val('');
            $('#txtColor').val('');
        }

    </script>

</body>
</html>