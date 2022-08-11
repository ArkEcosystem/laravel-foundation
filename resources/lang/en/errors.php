<?php

declare(strict_types=1);

return [
    'heading'     => 'Oops, something went wrong ...',
    'message'     => 'Please try again or get in touch if the issue persists.',
    '401'         => 'Unauthorized',
    '403'         => 'Forbidden',
    '403_heading' => 'Oops, this is a restricted area!',
    '403_message' => 'You don\'t have the proper security clearance to access this part of the site.',
    '404'         => 'Not Found',
    '419'         => 'Page Expired',
    '429'         => 'Too Many Requests',
    '500'         => 'Internal Server Error',
    '503'         => 'Service Unavailable',
    '503_heading' => config('app.name').' is currently down for scheduled maintenance.',
    '503_message' => 'We expect to be back soon. Thanks for your patience.',
];
