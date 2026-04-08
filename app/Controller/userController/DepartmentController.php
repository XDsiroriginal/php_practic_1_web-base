<?php

namespace Controller\userController;

use Model\User;
use Model\Department;
use Model\Equipment;

use Src\View;
use Src\Request;
use Src\Auth\Auth;

class DepartmentController
{
    public function department(): string
    {
        $user = Auth::user();
        $departments = Department::where('department_id', $user->department_id)->first();
        $equipment = Equipment::where('department_id', $departments->department_id)->get();

        $userOnThisDepartment = User::where('department_id', $departments->department_id)->get();

        $allUser = User::all();
        $allDepartments = Department::all();
        $allEquipment = Equipment::all();
        return new View('site.department', [
            'user' => $user,
            'departments' => $departments,
            'equipment' => $equipment,
            'userOnThisDepartment' => $userOnThisDepartment,
            'allUser' => $allUser,
            'allDepartments' => $allDepartments,
            'allEquipment' => $allEquipment
        ]);
    }
}