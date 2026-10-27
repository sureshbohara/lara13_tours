<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\PermissionRequest;
use App\Models\Permission;
use App\Services\Admin\PermissionService;
use Illuminate\View\View;

class PermissionController extends BaseController
{
    public function __construct(protected PermissionService $service)
    {
        $this->middleware('auth:admin');
        $this->middleware('can:permission.read')->only('index');
        $this->middleware('can:permission.create')->only(['create', 'store']);
        $this->middleware('can:permission.update')->only(['edit', 'update']); 
        $this->middleware('can:permission.delete')->only('destroy');
    }

    public function index(): View
    {
        $permissions = Permission::with('role')
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('admin.permissions.index', [
            'permissions' => $permissions,
            'datas' => $this->service->getPermissionData(),
        ]);
    }

    public function create(): View
    {
        $data = $this->service->getPermissionData();

        return view('admin.permissions.form', [
            'permission' => null,
            'entities' => $data['entities'],
            'actions' => $data['actions'],
            'defaultPermissions' => $data['permissions'],
            'roles' => $data['roles'],
        ]);
    }

    public function store(PermissionRequest $request){
        $permission = $this->service->createPermissions(
            (int) $request->role_id,
            $request->permission ?? []
        );

        return $this->successJson('Permission created!', $permission, 201);
    }

    public function edit(int $id): View
    {
        $permission = Permission::with('role')->findOrFail($id);
        $data = $this->service->getPermissionData($permission->role_id);

        return view('admin.permissions.form', [
            'permission' => $permission,
            'entities' => $data['entities'],
            'actions' => $data['actions'],
            'defaultPermissions' => $data['permissions'],
            'roles' => $data['roles'],
        ]);
    }

    public function update(PermissionRequest $request, Permission $permission){
        if ($permission->role?->name === 'super_admin' && !auth('admin')->user()->isSuperAdmin()) {
            return $this->errorJson('Cannot modify Super Admin', null, 403);
        }

        $updated = $this->service->updatePermissions(
            $permission->id,
            $request->permission ?? []
        );

        return $this->successJson('Permission updated!', $updated);
    }

    public function destroy(Permission $permission){
        $this->service->deletePermissions($permission->id); 
         return redirect()->back()->with('success', 'Permission deleted permanently!');
    }
}