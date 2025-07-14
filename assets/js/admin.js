function checkAsociarAusentismo(check, canal_id, notificacion_id, url){
    // var id = element.value;
    console.log(check.checked);
    
    $.ajax({
        type: 'POST',
        url: location.origin + "/rrhh/"+ url,
        data: {
            'id_canal': canal_id,
            'id_notificacion': notificacion_id,
            'check': check.checked
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