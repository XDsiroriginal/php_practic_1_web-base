<?php

namespace Controller\userController;

use Model\User;
use Model\Department;
use Model\Equipment;

use Src\View;
use Src\Request;
use Src\Auth\Auth;
use Model\Status;

class EquipmentController
{
    public function equipment() : string
    {
        $user = Auth::user();
        $equipment = Equipment::where('user_id', $user->user_id)->get();
        $status = Status::all();

        $allUser = User::all();
        $allDepartments = Department::all();
        $allEquipment = Equipment::all();
        return new View('site.equipment', [
            'user' => $user,
            'equipments' => $equipment,
            'status' => $status,
            'allUser' => $allUser,
            'allDepartments' => $allDepartments,
            'allEquipment' => $allEquipment
        ]);
    }
}