function mensajeError($mensaje) {
    swal.fire({
        title: "ERROR",
        text: $mensaje,
        icon: 'error',
        width: '550px',
        allowOutsideClick: false,
        confirmButtonColor: '#0F4C75',
    }).then(function() {
        $('#enviarTurno').prop('disabled', false);
    });
}
function mensajeExito($mensaje) {
    Swal.fire({
        icon: 'success',
        width: '550px',
        title: $mensaje,
        allowOutsideClick: false,
    }).then(function() {
        window.location.reload();
    });
}
function mensajeAviso($mensaje){
    Swal.fire({
    icon:'info',
    width:'550px',
    title: $mensaje, 
    allowOutsideClick: false,
    })
}
