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
                'commission_date' => !empty($request->commission_date) ? $request->commission_date : null,
                'cost' => !empty($request->cost) ? floatval($request->cost) : null,
                'status_id' => !empty($request->status_id) ? intval($request->status_id) : null,
                'user_id' => !empty($request->user_id) ? intval($request->user_id) : null,
                'department_id' => !empty($request->department_id) ? intval($request->department_id) : null,
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
            $equipment->name = $request->name ?? null;
            $equipment->model = $request->model ?? null;
            $equipment->manufacturer = $request->manufacturer ?? null;
            $equipment->commission_date = !empty($request->commission_date) ? $request->commission_date : null;
            $equipment->cost = !empty($request->cost) ? floatval($request->cost) : null;
            $equipment->status_id = !empty($request->status_id) ? intval($request->status_id) : null;
            $equipment->user_id = !empty($request->user_id) ? intval($request->user_id) : null;
            $equipment->department_id = !empty($request->department_id) ? intval($request->department_id) : null;
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