<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Backup;
use App\Services\Admin\BackupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BackupController extends BaseController
{
    public function __construct(protected BackupService $service)
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        $backups = Backup::with('creator')->latest()->paginate(15);
        return view('admin.settings.backups', compact('backups'));
    }

    public function store(){
        $result = $this->service->createBackup(Auth::guard('admin')->id());
        return $this->successJson($result['message'], $result['data'], 201);
    }

    public function download(int $id){
        $backup = Backup::findOrFail($id);
        $filePath = storage_path('app/' . $backup->file_path);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'Backup file not found.');
        }

        return response()->download($filePath, $backup->file_name);
    }

    public function destroy(int $id){
        $this->service->deleteBackup($id);
        return redirect()->back()->with('success', 'Backup deleted successfully!');
    }
}