<?php


namespace Modules\Admin\Http\Controllers;


use Illuminate\Routing\Controller;

class MapController extends Controller
{
    /**
     * Features Collection for the mobile map
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function mobileFeatures()
    {

        $data = app('db')
            ->table('public.mobile_maps')
            ->select([
                'name',
                app('db')->raw("(select public.st_asgeojson(the_geom) as geojson)"),
                'z_min', 'z_max', 'y_min', 'y_max', 'x_min', 'x_max',
                'server_path', 'id', 'ver',
                app('db')->raw("'uninstalled' as available")
            ])
            ->where('available', true)
            ->get();

        $features = $data->transform(function ($item, $key) {
            return [
                "type" => "Feature",
                "id" => $item->id,
                "geometry" => json_decode($item->geojson),
                "properties" => [
                    "name" => $item->name,
                    "z_min" => $item->z_min,
                    "z_max" => $item->z_max,
                    "y_min" => $item->y_min,
                    "y_max" => $item->y_max,
                    "x_min" => $item->x_min,
                    "x_max" => $item->x_max,
                    "server_path" => $item->server_path,
                    "id" => $item->id,
                    "ver" => $item->ver,
                    "available" => $item->available,
                ]
            ];
        });

        return response()->json([
            "data" => [
                "type" => "FeatureCollection",
                "features" => $features
            ]
        ]);
    }

}
