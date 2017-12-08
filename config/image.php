<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */

    'driver' => 'gd',
    'route' => 'imagecache',
    'paths' => array(
        'storage/uploads/media'
    ),
    'templates' => array(
      'small' => 'Intervention\Image\Templates\Small',
      'medium' => 'Intervention\Image\Templates\Medium',
      'large' => 'Intervention\Image\Templates\Large'
  )
);
