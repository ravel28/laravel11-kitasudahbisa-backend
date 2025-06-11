<?php

namespace App\Repositories;

use App\Models\Position;
use App\Interfaces\PositionRepositoryInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PositionRepository implements PositionRepositoryInterface
{
    public function index(array $query) {
        try {
            $take       = $query['take'];
            $page       = $query['page'] ?? 1;
            $position   = DB::table('user_count_by_position')
                                    // ->orderby('user_count_by_position.level','asc')
                                    ->paginate($take);
            $total      = Position::all()->count();

            if(count($position) < 1) abort(404, "Data is null");

            $meta   = [
                'current_page'  => $page,
                'take'          => $take,
                'total_pages'   => ceil($total/$take),
                'item_per_page' => count($position),
                'total_items'   => $total
            ];
            $data   = [
                'items' => $position,
                'meta'  => $meta,
            ];
            return $data;
        } catch(Throwable $e) {
            ApiResponseClass::throw($e);
        }
    }

    public function createPosition(array $data) {
        try{
            $create_data = Position::create([
                'position' => $data['position'],
                'level'    => $data['level'],
            ]);
            return $create_data;
        } catch(Throwable $e) {
            ApiResponseClass::throw($e);
        }
    }

    public function detailPosition(int $id){
        try {
            $checkPosition = Position::whereRaw('id = ?',$id)
                                ->first();
            if(!$checkPosition) abort(404, "Position is not found !");
            return $checkPosition;
        } catch(Throwable $e) {
            ApiResponseClass::throw($e);
        }
    }

    public function updatePosition(int $id,array $data) {
        try{
            $update_data = Position::whereRaw('id = ?',$id)->update([
                'position' => $data['position'],
                'level' => $data['level'],
            ]);
            
            return $update_data;
        } catch(Throwable $e) {
            ApiResponseClass::throw($e);
        }
    }

    public function deletePosition(int $id) {
        try {
            $delete_data = Position::whereRaw('id = ?',$id)->delete();
            return $delete_data;
        } catch(Throwable $e){
            ApiResponseClass::throw($e);
        }
     }
}
