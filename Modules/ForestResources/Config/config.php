<?php

return [
    'name' => 'ForestResources',
    'srid' => env('FORESTRESOURCES_SRID', 5223), // Gabon srid -> see https://epsg.io/5223
    'default_bbox' => env('FORESTRESOURCES_DEFAULT_BBOX', '2405626.154191067,1164288.8148398048,-169995.95090623206,-1037097.5997732715') // bbox for gabon default
];
