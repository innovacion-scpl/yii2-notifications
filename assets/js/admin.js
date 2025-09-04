function checkAsociarAusentismo(check, canal_id, notificacion_id, url, user_id){
    if (!check.checked) {
        krajeeDialog.confirm('Sí quita la notificación del sistema, ningún usuario recibirá la notificación ¿Esta seguro?', function(out){
            if(out) {
                asignarDesasignarNoti(check, canal_id, notificacion_id, url, user_id);
            }
        });
    }else{
        asignarDesasignarNoti(check, canal_id, notificacion_id, url, user_id);
    }


}

function asignarDesasignarNoti(check, canal_id, notificacion_id, url, user_id){
    $.ajax({
        type: 'POST',
        url: location.origin + "/rrhh/"+ url,
        data: {
            'id_canal': canal_id,
            'id_notificacion': notificacion_id,
            'check': check.checked,
            'user_id': user_id
        },
        dataType: "json",
        async: false,
        success: function (response) {
            $.pjax.reload({container: '#pjax-grid'});
        },
        error: function(xhr,err){
            console.log(err);
            
            alert('Ocurrió un error. Contacte a los administradores.')
        }
    });
}