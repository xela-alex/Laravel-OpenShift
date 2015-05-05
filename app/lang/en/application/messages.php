<?php

return array(

    'create' => array(
        'error'                     => 'Application was not sent, please try again.',
        'success'                   => 'Application sent successfully.',
        'errorNotIsVolunteer'       => 'Only volunteers can apply.',
        'errorNotVolunteerPlaces'   => 'Not available places.',
        'errorIsCooperateYet'       => 'You already cooperate in the project.',
        'errorIsApplyYet'           => 'You already apply the project.',
        'errorFinishProject'        => 'The project has been completed.',
        'errorOverlapsDates'        => 'The project date overlaps with your other projects.',
    ),
    'cancel' => array(
        'errorIsAnswered'           => 'Ean not delete answered applications.',
        'error'                     => 'The application was not delete, please try again.',
        'success'                   => 'The application has been successfully deleted.',

    ),
    'answer' => array(
        'error'                     => 'Application was not answer, please try again.',
        'success'                   => 'Application answered successfully.',
        'errorNotHisProject'        => 'Only can answered applications of his/her projects.',
        'errorAnsweredYet'          => 'The application has been already answered.',
        'errorRequest'              => 'In request url.',
    )

);
