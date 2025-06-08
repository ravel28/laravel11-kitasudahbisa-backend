<?php

namespace App\Repositories;

use App\Models\Division;
use App\Interfaces\DivisionRepositoryInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DivisionRepository implements DivisionRepositoryInterface
{
    public function index(array $query) {
        try {
            $take       = $query['take'];
            $page       = $query['page'] ?? 1;
            $division   = Division::orderby('divisions.division','asc')
                                    ->paginate($take);
            $total      = Division::all()->count();

            if(count($division) < 1) abort(404, "User data is null or not found !");

            $meta   = [
                'current_page'  => $page,
                'take'          => $take,
                'total_pages'   => ceil($total/$take),
                'item_per_page' => count($division),
                'total_items'   => $total
            ];
            $data   = [
                'items' => $division,
                'meta'  => $meta,
            ];
            return $data;
        } catch(Throwable $e) {
            ApiResponseClass::throw($e);
        }
    }

    public function createDivision(array $data) {
        try{
            $create_data = Division::create([
                'division' => $data['division'],
            ]);
            return $create_data;
        } catch(Throwable $e) {
            ApiResponseClass::throw($e);
        }
    }

    public function detailDivision(int $id){
        try {
            $checkDivision = Division::whereRaw('id = ?',$id)
                                ->first();
            if(!$checkDivision) abort(404, "Divison is not found !");
            return $checkDivision;
        } catch(Throwable $e) {
            ApiResponseClass::throw($e);
        }
    }

    public function updateDivision(int $id,array $data) {
        try{
            $update_data = Division::whereRaw('id = ?',$id)->update([
                'division' => $data['division'],
            ]);
            
            return $update_data;
        } catch(Throwable $e) {
            ApiResponseClass::throw($e);
        }
    }

    public function deleteDivision(int $id) {
        try {
            $delete_data = Division::whereRaw('id = ?',$id)->delete();
            return $delete_data;
        } catch(Throwable $e){
            ApiResponseClass::throw($e);
        }
     }
}
