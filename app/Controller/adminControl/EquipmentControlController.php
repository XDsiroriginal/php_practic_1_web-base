<?php
namespace Controller\adminControl;

use Model\Department;
use Model\Status;
use Model\User;
use Model\Equipment;
use Src\View;
use Src\Request;
use Src\Auth\Auth;

class EquipmentControlController
{
    public function equipmentControl(): string
    {
        $user = Auth::user();
        $search = $_GET['search'] ?? '';
        $equipments = Equipment::all();
        $departments = Department::all();
        $statuses = Status::all();

        if (!empty($search)) {
            $search = strtolower($search);
            $equipments = $equipments->filter(function($equipment) use ($search) {
                return stripos($equipment->name, $search) !== false ||
                    stripos($equipment->model, $search) !== false ||
                    stripos($equipment->manufacturer, $search) !== false;
            });
        }

        return (new View())->render('site.admin_control.equipment_control', [
            'user' => $user,
            'equipments' => $equipments,
            'departments' => $departments,
            'statuses' => $statuses
        ]);
    }

    public function addEquipment(Request $request): string
    {
        if ($request->method === 'POST') {
            $equipment = [
                'name' => $request->name ?? null,
                'model' => $request->model ?? null,
                'manufacturer' => $request->manufacturer ?? null,
                'commission_date' => $request->commission_date ?? null,
                'cost' => $request->cost ?? null,
                'status_id' => $request->status_id ?? null,
                'user_id' => $request->user_id ?? null,
                'department_id' => $request->department_id ?? null,
            ];

            Equipment::create($equipment);
            app()->route->redirect('/admin_control/equipment_control');
        } else {
            $departments = Department::all();
            $statuses = Status::all();
            $users = User::all();

            return (new View())->render('site.admin_control.add_equipment', [
                'departments' => $departments,
                'statuses' => $statuses,
                'users' => $users,
            ]);
        }
    }

    public function changeEquipment(Request $request): string
    {
        $equipment = Equipment::where('equipment_id', $_GET['equipment_id'])->first();

        if ($request->method === 'POST') {
            $equipment->name = $request->name;
            $equipment->model = $request->model;
            $equipment->manufacturer = $request->manufacturer;
            $equipment->commission_date = $request->commission_date;
            $equipment->cost = $request->cost;
            $equipment->status_id = $request->status_id;
            $equipment->user_id = $request->user_id;
            $equipment->department_id = $request->department_id;
            $equipment->update();

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