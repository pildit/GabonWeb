<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Services\PageResults;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\Parcel;
use Modules\ForestResources\Http\Requests\CreateUpdateParcelRequest;
use ShapeFile\Shapefile;
use Shapefile\ShapefileException;
use Shapefile\ShapefileReader;
use Modules\ForestResources\Services\Parcel as ParcelService;
use Shapefile\Geometry\Polygon;
use Illuminate\Support\Facades\File;

class ParcelController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, PageResults $pr)
    {
        $pr->setSortFields(['Id']);

        return response()->json($pr->getPaginator($request, Parcel::class , ['Name']));
    }

    /**
     * Store parcel
     * @param CreateUpdateParcelRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateUpdateParcelRequest $request)
    {


        $data = $request->validated();

        /* Upload and get polygon from Shapefile

        try {
            // Open Shapefile
            $upload_folder = "uploads";
            $upload_path = public_path($upload_folder).'/';
            $file_name_shp = time().'.shp';
            $request->file('geometry_shp')->move(public_path('uploads'), $file_name_shp);
            $file_path_shp = $upload_path.$file_name_shp;

            $file_name_shx = time().'.shx';
            $request->file('geometry_shx')->move(public_path('uploads'), $file_name_shx);
            $file_path_shx = $upload_path.$file_name_shx;

            $file_name_dbf = time().'.dbf';
            $request->file('geometry_dbf')->move(public_path('uploads'), $file_name_dbf);
            $file_path_dbf = $upload_path.$file_name_dbf;

            $Shapefile = new ShapefileReader([
                Shapefile::FILE_SHP => $file_path_shp,
                Shapefile::FILE_SHX => $file_path_shx,
                Shapefile::FILE_DBF => $file_path_dbf,
            ]);


            while ($Geometry = $Shapefile->fetchRecord()) {
                if ($Geometry->isDeleted()) {
                    continue;
                }

                // dd($Geometry->getDataArray()); //- get name
                $polygon = $Geometry->getWKT();

            }
        } catch (ShapefileException $e) {
            return response()->json([
                'message' =>  "Error Type: " . $e->getErrorType() . "\nMessage: " . $e->getMessage() . "\nDetails: " . $e->getDetails()
            ], 200);
        }


        $data['Geometry'] = isset($polygon) ? $polygon : '';

          */

        $parcel = Parcel::create($data);

        return response()->json([
            'message' => lang("parcel_created_successfully")
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Parcel $parcel)
    {
        return response()->json(['data' => $parcel]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Parcel $parcel
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CreateUpdateParcelRequest $request, Parcel $parcel)
    {

        $data = $request->validated();

        /* Upload and get polygon from Shapefile

        try {
            // Open Shapefile

            $upload_folder = "uploads";
            $upload_path = public_path($upload_folder).'/';
            $file_name_shp = time().'.shp';
            $request->file('geometry_shp')->move(public_path('uploads'), $file_name_shp);
            $file_path_shp = $upload_path.$file_name_shp;

            $file_name_shx = time().'.shx';
            $request->file('geometry_shx')->move(public_path('uploads'), $file_name_shx);
            $file_path_shx = $upload_path.$file_name_shx;

            $file_name_dbf = time().'.dbf';
            $request->file('geometry_dbf')->move(public_path('uploads'), $file_name_dbf);
            $file_path_dbf = $upload_path.$file_name_dbf;

            $Shapefile = new ShapefileReader([
                Shapefile::FILE_SHP => $file_path_shp,
                Shapefile::FILE_SHX => $file_path_shx,
                Shapefile::FILE_DBF => $file_path_dbf,
            ]);


            while ($Geometry = $Shapefile->fetchRecord()) {
                if ($Geometry->isDeleted()) {
                    continue;
                }

                // dd($Geometry->getDataArray()); //- get name
                $polygon = $Geometry->getWKT();

            }
        } catch (ShapefileException $e) {
            return response()->json([
                'message' =>  "Error Type: " . $e->getErrorType() . "\nMessage: " . $e->getMessage() . "\nDetails: " . $e->getDetails()
            ], 200);
        }

        */

       // $data['Geometry'] = isset($polygon) ? $polygon : '';

        $parcel->fill($data);
        $parcel->save($data);

        return response()->json([
            'message' => lang('parcel_update_successful')
        ], 200);

    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Parcel $parcel)
    {
        $parcel->delete();

        return response()->json([
            'message' => lang('parcel_delete_successful')
        ], 204);
    }

    /**
     * @param Request $request
     * @param ParcelService $parcelService
     * @return \Illuminate\Http\JsonResponse
     */
    public function vectors(Request $request, ParcelService $parcelService)
    {
        $request->validate(['bbox' => 'required']);

        return response()->json([
            'data' => [
                'type' => 'FeatureCollection',
                'name' => 'parcels',
                'features' => $parcelService->getVectors($request->get('bbox'))
            ]
        ]);
    }

}
