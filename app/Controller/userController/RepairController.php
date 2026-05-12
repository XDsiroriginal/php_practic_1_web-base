<?php

namespace Controller\userController;

use Model\User;
use Model\Department;
use Model\Equipment;

use Src\View;
use Src\Request;
use Src\Auth\Auth;
use Model\Status;
use Model\Repair;

class RepairController
{
    public function repair() : string {
        $user = Auth::user();
        $equipment = Equipment::all();

        if ($user->role == 'ADMIN') {
            $repair = Repair::all();
        }
        else {
            $repair = Repair::where('user_id', $user->user_id)->get();
        }


        return new View('site.repair', [
            'users' => $user,
            'equipments' => $equipment,
            'repairs' => $repair
        ]);
    }

    public function add_repair(Request $request): string
    {
        $user = Auth::user();
        if ($request->method === 'POST') {

            $repair = [
                'equipment_id' => $request->equipment ?? null,
                'break_message' => $request->break_message ?? null,
                'user_id' => $user->user_id,
            ];

            Repair::create($repair);
            $equipment = Equipment::where('equipment_id', $request->equipment)->first();
            $equipment->status_id = 3;
            $equipment->update();
            app()->route->redirect('/repair');
        } else {
            $equipment = Equipment::where('user_id', $user->user_id)->where('status_id', 1)->get();

            return (new View())->render('site.add_repair', [
                'equipments' => $equipment,
                'users' => $user,
            ]);
        }
    }

    public function changeRepair(Request $request): string
    {
        $repair = Repair::where('repair_id', $_GET['repair_id'])->first();

        if ($request->method === 'POST') {
            $repair->break_message = $request->break_message;

            $repair->update();

            app()->route->redirect('/admin_control/equipment_control');
        } else {
            $departments = Department::all();
            $statuses = Status::all();
            $users = User::all();

            return (new View())->render('site.admin_control.equipment_change', [
                'equipment' => $equipment,
                'departments' => $departments,
                'statuses' => $statuses,
                'users' => $users,
            ]);
        }
    }
}