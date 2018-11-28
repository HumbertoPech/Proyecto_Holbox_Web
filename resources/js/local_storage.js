//Es llamado en el boton de enviar*************************
function guardar_local() {
    //obtiene los valores de los campos
    var nombre = document.getElementById('usuario').value;
    var correo = document.getElementById('correo').value;
    //comprueba que esten completos
    if(nombre !== '' || correo !== ''){
        let user = {
            name: nombre,
            email: correo
        };
        //nombre de la llave y valor(JSON)
        localStorage.setItem("usuario", JSON.stringify(user));
        console.log("usuario guardado en localstorage");

    }
}

//Se vuelven a poner los datos que el usuario ingreso
obtener_local("usuario");

function obtener_local(key) {
    //Pregunta si existe el localstorage
    if (localStorage.getItem(key)) {
        if (confirm("¿Desea agregar los datos anteriores?")) {
            //obtiene la cadena y la convierte al objeto original
            var user = JSON.parse(localStorage.getItem(key));
            console.log(user);
            //Se ponen los elementos que se habían "perdido" en los campos
            document.getElementById('nombre').value = user.name;
            document.getElementById('correo').value = user.email;
            
            //Esto va en la pagina donde ya se acepto el usuario (que seria la de inicio en este caso),
            //porque ya que no hay necesidad de guardarlo, entonces lo borramos.
            //localStorage.removeItem("usuario");
        } else {
            console.log("Pues no ._.");
        }
    } else {
        console.log("No hay datos");
    }
}
