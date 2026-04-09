<?php

namespace Controller\adminControl;

use Model\Status;
use Model\User;
use Model\Department;
use Model\Equipment;

use Src\View;
use Src\Request;
use Src\Auth\Auth;

class EquipmentControlController
{
    public function equipmentControl() : string {
        $equipments = Equipment::all();
        $departments = Department::all();
        $users = User::all();
        $statuses = Status::all();

        return new View('site.admin_control.equipment_control', [
            'equipments' => $equipments,
            'departments' => $departments,
            'users' => $users,
            'statuses' => $statuses
        ]);
    }

}