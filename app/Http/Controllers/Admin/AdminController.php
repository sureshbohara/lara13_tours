<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\AdminRequest;
use App\Models\Admin;
use App\Services\Admin\AdminService;
use App\Services\Admin\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends BaseController
{
    public function __construct(
        protected AdminService $adminService,
        protected NotificationService $notificationService
    ) {
        $this->middleware('auth:admin');
        $this->middleware('can:user.read')->only(['index']);
        $this->middleware('can:user.create')->only(['create', 'store']);
        $this->middleware('can:user.update')->only(['edit', 'update', 'userStatus', 'updateOrderLevel']);
        $this->middleware('can:user.delete')->only(['destroy']);
    }

    public function index(Request $request): View
    {
        $filters = $request->only('status', 'name', 'role_id');

        return view('admin.admin_user.index', [
            'admins'  => $this->adminService->getAdmins($filters, auth('admin')->id()),
            'filters' => $filters,
            'roles'   => $this->adminService->getRolesForSelect(),
        ]);
    }

    public function create(): View
    {
        return view('admin.admin_user.form', [
            'roles' => $this->adminService->getRolesForSelect(),
        ]);
    }

    public function store(AdminRequest $request): JsonResponse
    {
        $admin = $this->adminService->storeAdmin($request->validated());
        $this->notificationService->sendWelcomeEmail($admin);

        return $this->successJson('Admin created!', $admin, 201);
    }

    public function edit(Admin $user): View
    {
        return view('admin.admin_user.form', [
            'admin' => $user,
            'roles' => $this->adminService->getRolesForSelect(),
        ]);
    }

    public function update(AdminRequest $request, Admin $user): JsonResponse
    {
        $updated = $this->adminService->updateAdmin($user->id, $request->validated());

        return $this->successJson('Admin updated successfully!', $updated);
    }

    public function destroy(Admin $user): RedirectResponse
    {
        $this->adminService->delete($user->id);

        return redirect()->back()->with('success', 'Admin deleted permanently!');
    }

    public function userStatus(Request $request): JsonResponse
    {
        $request->validate([
            'status_id' => ['required', 'integer', 'exists:admins,id'],
        ]);

        $newStatus = $this->adminService->toggleStatus((int) $request->status_id);

        $admin = Admin::find((int) $request->status_id);
        if ($admin) {
            $this->notificationService->sendAccountStatusChange($admin, $newStatus);
        }

        return $this->successJson('Status updated', [
            'new_status' => $newStatus,
        ]);
    }

    public function updateOrderLevel(Request $request): JsonResponse
    {
        $request->validate([
            'id'          => ['required', 'integer', 'exists:admins,id'],
            'order_level' => ['required', 'integer', 'min:0'],
        ]);

        $this->adminService->updateOrderLevel(
            (int) $request->id,
            (int) $request->order_level
        );

        return $this->successJson('Order updated!');
    }
}