<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\PositionRepositoryInterface;
use App\Classes\ApiResponseClass;
use App\Http\Resources\PositionResource;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PositionController extends Controller
{
    private PositionRepositoryInterface $positionRepositoryInterface;
    
    public function __construct(PositionRepositoryInterface $positionRepositoryInterface)
    {
        $this->positionRepositoryInterface = $positionRepositoryInterface;
    }


    public function index(int $take, Request $request) {
        try{
            $query = [
                'take' => $take,
                'page' => $request->input('page')
            ];

            $data       = $this->positionRepositoryInterface->index($query);
            $meta       = $data['meta'];
            $status_code= 200;

            return ApiResponseClass::sendResponse(PositionResource::collection($data['items']),$meta,$status_code);
        } catch(Throwable $e) {
            ApiResponseClass::throw($e);
        }
    }

    public function createPosition(Request $request) {
        try{
            $data = [
                'position' => $request->input('position'),
                'level' => $request->input('level'),
            ];

            $result     = $this->positionRepositoryInterface->createPosition($data);
            $meta       = [];
            $status_code= 201;

            return ApiResponseClass::sendResponse(PositionResource::make($result),$meta,$status_code);
        } catch(Throwable $e) {
            ApiResponseClass::throw($e);
        }
    }    

    public function updatePosition(int $id,Request $request) {
        try{
            $data = [
                'position'  => $request->input('position'),
                'level'     => $request->input('level'),
            ];

            $updated    = $this->positionRepositoryInterface->updatePosition($id,$data);
            $result     = $this->positionRepositoryInterface->detailPosition($id);
            $meta       = [];
            $status_code= 200;

            return ApiResponseClass::sendResponse(PositionResource::make($result),$meta,$status_code);
        } catch(Throwable $e) {
            ApiResponseClass::throw($e);
        }
    }

    public function deleteDivision(int $id) {
        try{
            $result     = $this->positionRepositoryInterface->deleteDivision($id);
            $meta       = [];
            $status_code= 204;

            return ApiResponseClass::sendResponse(PositionResource::make($result),$meta,$status_code);
        } catch(Throwable $e) {
            ApiResponseClass::throw($e);
        }
    }

}
