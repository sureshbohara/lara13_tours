<?php
declare(strict_types=1);

namespace App\Services\Admin;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminService extends BaseCrudService
{
    public function __construct(Admin $model, MediaService $mediaService)
    {
        parent::__construct($model, $mediaService, 'admin-avatars');
    }

    public function getAdmins(array $filters = [], ?int $excludeId = null)
    {
        return Admin::getFilteredRecords($filters, $excludeId);
    }

    public function getRolesForSelect()
    {
        return Role::active()->orderBy('name')->pluck('display_name', 'id');
    }

    public function storeAdmin(array $data): Admin
    {
        return DB::transaction(function () use ($data) {
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }
            
            $this->handleImage($data, null, 'image');

            return $this->model->create($data);
        });
    }

    public function updateAdmin(int $id, array $data): Admin
    {
        return DB::transaction(function () use ($id, $data) {
            $admin = $this->model->findOrFail($id);

            if (empty($data['password'])) {
                unset($data['password']);
            } else {
                $data['password'] = Hash::make($data['password']);
            }


            $this->handleImage($data, $admin, 'image');

            $admin->update($data);
            return $admin->fresh(['role']);
        });
    }


    protected function deleteAssociatedImages(Model $item): void
    {
        if ($item->image) {
            $this->mediaService->deleteImageVariants($item->image);
        }
    }
}