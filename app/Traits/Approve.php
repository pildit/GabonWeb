<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

trait Approve {


    public function approve(Request $request, $id)
    {
        $item = $this->modelName::findOrFail($id);

        $data = $request->validate([
            'Approved' => 'required|bool'
        ]);

        $item->update($data);

        return response()->json([
            'message' => lang('annual_allowable_cut_update_successful')
        ], 200);

    }

}