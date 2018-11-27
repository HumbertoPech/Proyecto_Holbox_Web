<?php
    $connect = mysqli_connect("localhost", "root", "", "proyecto_holbox_db");//Configurar los datos de conexion
    $columns = array('id_usuario','fecha_registro', 'hora_registro', 'actividad', 'id_permiso','id_sistema');
    $query = 'SELECT Bi.fecha_registro, Bi.hora_registro, Bi.actividad, Bi.id_permiso, Bi.id_usuario,'
        . ' Bi.id_sistema, Us.nombre_usuario, Pe.nombre_permiso, Si.nombre_sistema FROM bitacora Bi '
        . 'INNER JOIN usuarios Us ON Bi.id_usuario = Us.id_usuario INNER JOIN permisos Pe ON Bi.id_permiso = Pe.id_permiso'
        . ' INNER JOIN sistemas Si ON Bi.id_sistema = Si.id_sistema'
        . ' WHERE ';    
    if($_POST["is_date_search"] == "yes")
    {
        $query .= 'Bi.fecha_registro BETWEEN "'.$_POST["start_date"].'" AND "'.$_POST["end_date"].'" AND ';
        if(isset($_POST["nombre_usuario"])){
            $nombre_usuario = $_POST["nombre_usuario"];
            $nombre_permiso = $_POST["nombre_permiso"];
            $query .= 'Us.nombre_usuario LIKE "%'.$nombre_usuario.'%" AND Pe.nombre_permiso LIKE "%'.$nombre_permiso.'%" AND ';                 
        }
    }else{
        if(isset($_POST["nombre_usuario"])){
            $nombre_usuario = $_POST["nombre_usuario"];
            $nombre_permiso = $_POST["nombre_permiso"];
            $query .= 'Us.nombre_usuario LIKE "%'.$nombre_usuario.'%" AND Pe.nombre_permiso LIKE "%'.$nombre_permiso.'%" AND ';                 
        }
    }
    
    /*Busqueda por caracter*/
    if(isset($_POST["search"]["value"]))
    {
        $query .= '
         (Us.nombre_usuario LIKE "%'.$_POST["search"]["value"].'%" 
         OR Bi.fecha_registro LIKE "%'.$_POST["search"]["value"].'%" 
         OR Bi.actividad LIKE "%'.$_POST["search"]["value"].'%" 
         OR Pe.nombre_permiso LIKE "%'.$_POST["search"]["value"].'%"
         OR Si.nombre_sistema LIKE "%'.$_POST["search"]["value"].'%")
        ';
    }
    /*Fin de busqueda por caracter*/
    
    if(isset($_POST["order"]))
    {
        $query .= 'ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' 
     ';
    }
    else
    {
        $query .= 'ORDER BY Us.nombre_usuario DESC ';
    }

    $query1 = '';

    if($_POST["length"] != -1)
    {
        $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }
    

    $number_filter_row = mysqli_num_rows(mysqli_query($connect, $query));
    $result = mysqli_query($connect, $query . $query1);

    $data = array();    
    while($row = mysqli_fetch_array($result))
    {
        $fecha=date("d/m/Y", strtotime($row["fecha_registro"]));
        $time = date('H:i:s', strtotime($row["hora_registro"])); 
        $sub_array = array();
        $sub_array[] = $row["nombre_usuario"];
        $sub_array[] = $fecha;
        $sub_array[] = $time;
        $sub_array[] = $row["actividad"];
        $sub_array[] = $row["nombre_permiso"];
        $sub_array[] = $row["nombre_sistema"];
        $data[] = $sub_array;
    }


    function get_all_dataRows($result)
    {
        return mysqli_num_rows($result);
    }
    function get_all_data2($connect)
    {
        $query = "SELECT * FROM bitacora";
        $result = mysqli_query($connect, $query);
         return $result;
        //return mysqli_num_rows($result);
    }    
    $getAllData =  get_all_data2($connect);
    $output = array(
        "draw"    => intval($_POST["draw"]),
        "recordsTotal"  =>  get_all_dataRows($getAllData),
        "recordsFiltered" => $number_filter_row,
        "data"    => $data
    );
    echo json_encode($output);

?>