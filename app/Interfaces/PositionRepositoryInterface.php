<?php

namespace App\Interfaces;

interface PositionRepositoryInterface
{
    public function index(array $query);
    public function createPosition(array $data);
    public function detailPosition(int $id);
    public function updatePosition(int $id,array $data);
    public function deletePosition(int $id);
}