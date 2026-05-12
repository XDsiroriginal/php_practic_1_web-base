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

    public function repairChange(Request $request): string
    {
        $repair = Repair::where('repair_id', $_GET['repair_id'])->first();
        $equipment = Equipment::where('equipment_id', $repair->equipment_id )->first();

        if ($request->method === 'POST') {
            $repair->repair_start_date = $request->repair_start_date;
            $repair->repair_end_date = $request->repair_end_date;
            $repair->cost = $request->cost;
            $repair->work_performed = $request->work_performed;
            $repair->status = $request->status;
            $repair->update();

            if ($request->status == 'COMPLETED') {
                $equipment->status_id = 1;
            }
            else {
                $equipment->status_id = 2;
            }
            $equipment->update();

            app()->route->redirect('/admin_control/repair_control');
        } else {
            $departments = Department::all();
            $statuses = Status::all();
            $users = User::all();

            return (new View())->render('site.admin_control.repair_change', [
                'equipment' => $equipment,
                'departments' => $departments,
                'statuses' => $statuses,
                'users' => $users,
                'repair' => $repair,
            ]);
        }
    }
}