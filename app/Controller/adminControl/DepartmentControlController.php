<?php

namespace Controller\adminControl;

use Model\User;
use Model\Department;
use Model\Equipment;

use Src\View;
use Src\Request;
use Src\Auth\Auth;

class DepartmentControlController
{
    public function departmentControl() : string
    {
        $user = Auth::user();
        $departments = Department::all();

        return new View('site.admin_control.department_control', [
            'user' => $user,
            'departments' => $departments,
        ]);
    }
    public function addDepartment(Request $request) : string
    {

        if ($request->method === 'POST') {

            $department = [
                'name' => $request->name,
                'description' => $request->description,
                'code' => $request->code,
            ];

            Department::create($department);

            app()->route->redirect('/admin_control/department_control');
        }

        else{

            return (new View())->render('site.admin_control.add_department', [
            ]);

        }
    }

    public function changeDepartment(Request $request) : string
    {
            $department = Department::where('department_id', $_GET['department_id'])->first();

        if ($request->method === 'POST') {
            $department->name = $request->name;
            $department->description = $request->description;
            $department->code  = $request->code;

            $department->update();

            app()->route->redirect('/admin_control/department_control');
        }

        else{

            return (new View())->render('site.admin_control.department_change', [
                'department' => $department
            ]);

        }
    }
}