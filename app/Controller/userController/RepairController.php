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
            app()->route->redirect('/repair');
        } else {
            $equipment = Equipment::where('user_id', $user->user_id)->get();

            return (new View())->render('site.add_repair', [
                'equipments' => $equipment,
                'users' => $user,
            ]);
        }
    }
}