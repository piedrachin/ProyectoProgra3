
function validateForm(){

var valido = true;
//validamos la identificacion
var identificacion = document.getElementById("identificacion").value;
//usando expresiones regulares
if(!/^\d{9,15}$/.test(identificacion)){

    document.getElementById("identificacionError").innerText =
     "Identificacion invalida, debe ser entre 9 a 15 digitos";
    valido = false;
}
else{

    document.getElementById("identificacionError").innerText="";
    
}

// Validadmos nombre (solo texto alfabetico)
var nombre = document.getElementById("nombre").value;

if (!/^[a-zA-Z\s]+$/.test(nombre)) {
    document.getElementById("nombreError").innerText = "Formato no válido.";
    valido = false;
} else {
    document.getElementById("nombreError").innerText = "";
}

// validacion telefono
var telefono = document.getElementById("telefono").value;
if(!/^\d{8}$/(telefono)){

    document.getElementById("telefonoError").innerText = "Telefono invalido son 8 digitos";
}
else{
    document.getElementById("telefonoError").innerText = "";
}

// validar correo
var correo = document.getElementById("correo").value;

if(!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/test(correo)){

    document.getElementById("correoError").innerText = "Formato de correo invalido";
    valido = false;

}else{
    document.getElementById("correoError").innerText="";
}
}


