<?php

namespace Controller\adminControl;

use Model\User;
use Model\Department;
use Model\Equipment;

use Src\View;
use Src\Request;
use Src\Auth\Auth;
use Model\Status;
use Model\Repair;

class RepairControlController
{
    public function repairControl(): string
    {
        $user = Auth::user();
        $search = $_GET['search'] ?? '';
        $equipments = Equipment::all();
        $departments = Department::all();
        $statuses = Status::all();
        $repairs = Repair::all();

        if (!empty($search)) {
            $search = strtolower($search);
            $equipments = $equipments->filter(function($equipment) use ($search) {
                return stripos($equipment->name, $search) !== false ||
                    stripos($equipment->model, $search) !== false ||
                    stripos($equipment->manufacturer, $search) !== false;
            });
        }

        return (new View())->render('site.admin_control.repair_control', [
            'user' => $user,
            'equipments' => $equipments,
            'departments' => $departments,
            'statuses' => $statuses,
            'repairs' => $repairs,

        ]);
    }
}