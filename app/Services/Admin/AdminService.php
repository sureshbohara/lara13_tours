<?php

declare(strict_types=1);

namespace App\Services\Admin;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminService
{
  
    public function __construct(
        protected Admin $admin,
        protected MediaService $mediaService
    ) {
        //
    }

  
    public function getAdmins(array $filters = [], ?int $excludeId = null){
        return Admin::getFilteredRecords($filters, $excludeId);
    }


 
    public function getRolesForSelect(){
        return Role::active()
            ->orderBy('name')
            ->pluck('display_name', 'id');
    }


    public function storeAdmin(array $data){
        return DB::transaction(function () use ($data) {
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $path = $this->mediaService->uploadImage($data['image'], 'admin-avatars');
                $this->mediaService->dispatchImageProcessing($path);
                $data['image'] = $path;
            }

            return $this->admin->create($data);
        });
    }

   
    public function updateAdmin(int $id, array $data){
        return DB::transaction(function () use ($id, $data) {
            $admin = $this->admin->findOrFail($id);

            if (empty($data['password'])) {
                unset($data['password']);
            } else {
                $data['password'] = Hash::make($data['password']);
            }

            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                if ($admin->image) {
                    $this->mediaService->deleteImageVariants($admin->image);
                }

                $path = $this->mediaService->uploadImage($data['image'], 'admin-avatars');
                $this->mediaService->dispatchImageProcessing($path);
                $data['image'] = $path;
            } elseif (array_key_exists('image', $data) && $data['image'] === null) {
                if ($admin->image) {
                    $this->mediaService->deleteImageVariants($admin->image);
                }

                $data['image'] = null;
            } else {
                unset($data['image']);
            }

            $admin->update($data);

            return $admin->fresh(['role']);
        });
    }

    public function deleteAdmin(int $id): bool
    {
        $admin = $this->admin->findOrFail($id);

        if ($admin->image) {
            $this->mediaService->deleteImageVariants($admin->image);
        }

        return $admin->delete();
    }

 
    public function toggleStatus(int $id): bool
    {
        $admin = $this->admin->findOrFail($id);
        $admin->status = !$admin->status;
        $admin->save();

        return $admin->status;
    }

  
    public function updateOrderLevel(int $id, int $orderLevel): bool
    {
        $this->admin->findOrFail($id)->update([
            'order_level' => $orderLevel,
        ]);

        return true;
    }
}