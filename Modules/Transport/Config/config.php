<?php

return [
    'name' => 'Transport',
    'srid' => env('TRANSPORT_SRID', 3857), // srid 3857 - see https://epsg.io/3857
    'default_bbox' => env('TRANSPORT_DEFAULT_BBOX', '-169995.95090623206,-1037097.5997732715,2405626.154191067,1164288.8148398048') // bbox for gabon default
];
