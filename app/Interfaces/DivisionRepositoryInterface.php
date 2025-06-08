<?php

namespace App\Interfaces;

interface DivisionRepositoryInterface
{
    public function index(array $query);
    public function createDivision(array $data);
    public function detailDivision(int $id);
    public function updateDivision(int $id,array $data);
    public function deleteDivision(int $id);
}