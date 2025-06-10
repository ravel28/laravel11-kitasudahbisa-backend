<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\UserRepositoryInterface;
use App\Classes\ApiResponseClass;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    private UserRepositoryInterface $userRepositoryInterface;
    
    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->userRepositoryInterface = $userRepositoryInterface;
    }

    public function index(int $take, Request $request) {
        try{
            $query = [
                'take' => $take,
                'page' => $request->input('page')
            ];

            $data       = $this->userRepositoryInterface->index($query);
            $meta       = $data['meta'];
            $status_code= 200;

            return ApiResponseClass::sendResponse(UserResource::collection($data['items']),$meta,$status_code);
        } catch(Throwable $e) {
            ApiResponseClass::throw($e);
        }
    }

    public function checkUserAccount(Request $request) {
        try{
            $data = [
                'user' => $request->input('user'),
                'password' => $request->input('password'),
            ];

            $result     = $this->userRepositoryInterface->checkUser($data);
            $meta       = [];
            $status_code= 200;

            return ApiResponseClass::sendResponse(UserResource::make($result),$meta,$status_code);
        } catch(Exception $e) {
            ApiResponseClass::throw($e, 'My custom error message',400);
        }
    }

    public function checkUserAccountById($id) {
        try{
            $result     = $this->userRepositoryInterface->checkUserById($id);
            $meta       = [];
            $status_code= 200;
            
            return ApiResponseClass::sendResponse(UserResource::make($result),$meta,$status_code);
        } catch(Exception $e) {
            ApiResponseClass::throw($e, 'My custom error message',400);
        }
    }

    public function createUser(Request $request) {
        try{
            $data = [
                'email'         => $request->input('email'),
                'username'      => $request->input('username'),
                'name'          => $request->input('name'),
                'motto'         => $request->input('motto'),
                'birthdate'     => $request->input('birthdate'),
                'division_id'   => $request->input('division_id'),
            ];
            $create = $this->userRepositoryInterface->createUser($data);
            $output         = new \Symfony\Component\Console\Output\ConsoleOutput();
            $output->writeln($create['id']);
            $result = $this->userRepositoryInterface->checkUserById($create['id']);
            $output->writeln($result);

            $meta=[];
            $status_code=201;
            
            return ApiResponseClass::sendResponse(UserResource::make($result),$meta,$status_code);
        } catch(Exception $e) {
            ApiResponseClass::throw($e, 'My custom error message',400);
        }
    }

    public function updateUser(int $id, Request $request) {
        try{    
            $data = [
                'name'          => $request->input('name'),
                'email'         => $request->input('email'),
                'motto'         => $request->input('motto'),
                'birthdate'     => $request->input('birthdate'),
                'division_id'   => $request->input('division_id'),
            ];

            //Note :: result this query is 1 or undefined, i will make search again data by id
            $result     = $this->userRepositoryInterface->checkUserById($id);
            $updated    = $this->userRepositoryInterface->updateUser($id,$data);

            $meta=[];
            $status_code=200;

            return ApiResponseClass::sendResponse(UserResource::make($result),$meta,$status_code);
        } catch(Exception $e) {
            ApiResponseClass::throw($e, 'My custom error message',400);
        }
    }

    public function deleteUser(int $id) {
        try {
            $check  = $this->userRepositoryInterface->checkUserById($id);
            $result = $this->userRepositoryInterface->deleteUser($id);
    
            $meta=[];
            $status_code=204;
    
            return ApiResponseClass::sendResponse(UserResource::make($result),$meta,$status_code);
            return '';
        } catch(Exception $e) {
            ApiResponseClass::throw($e, 'My custom error message',400);
        }
    }
}
