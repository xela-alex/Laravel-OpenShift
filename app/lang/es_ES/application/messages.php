<?php

return array(

    'create' => array(
        'error'                     => 'La solicitud no se ha podido enviar.',
        'success'                   => 'La solicitud se ha enviado correctamente.',
        'errorNotIsVolunteer'       => 'Sólo los voluntarios pueden solicitar plazas.',
        'errorNotVolunteerPlaces'   => 'No quedan plazas disponibles.',
        'errorIsCooperateYet'       => 'Ya se encuentra colaborando en el proyecto.',
        'errorIsApplyYet'           => 'Ya ha enviado la solicitud para este proyecto.',
        'errorFinishProject'        => 'El proyecto ya ha finalizado.',
        'errorOverlapsDates'        => 'Actualmente se encuentra colaborando en proyectos que coinciden con las fechas éste.',
    ),
    'cancel' => array(
        'errorIsAnswered'           => 'Error, no puedes borrar solicitudes ya respondidas.',
        'success'                   => 'La solicitud se borró correctamente.',
        'error'                     => 'Error al borrar la solicitud, intentelo de nuevo.',

    ) ,
    'answer' => array(
        'error'                     => 'La solicitud no ha podido ser contestada, intentelo de nuevo.',
        'success'                   => 'La solicitud ha sido contestada correctamente.',
        'errorNotHisProject'        => 'Sólo pueden responderse solicitudes sobre sus proyectos.',
        'errorAnsweredYet'          => 'La solicitud ya fue respondida anteriormente.',
        'errorRequest'              => 'En la petición web.',
)
);
