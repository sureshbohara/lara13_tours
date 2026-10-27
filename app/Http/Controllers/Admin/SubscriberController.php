<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Services\Admin\SubscriberService;
use Illuminate\Http\Request;

class SubscriberController extends BaseController
{
    public function __construct(protected SubscriberService $service)
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request){
        $filters = $request->only('status', 'search');
        $subscribers = $this->service->getSubscribers($filters);
        
        return view('admin.subscribers.index', compact('subscribers', 'filters'));
    }

    public function toggleStatus(Request $request){
        $request->validate(['id' => 'required|exists:subscribers,id']);
        $newStatus = $this->service->toggleStatus((int) $request->id);
        
        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }

    public function destroy(int $id){
        $this->service->deleteSubscriber($id);
        return redirect()->back()->with('success', 'Subscriber deleted successfully!');
    }

    public function import(Request $request){
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $path = $request->file('csv_file')->getRealPath();
        $result = $this->service->importFromCsv($path);

        return redirect()->back()->with('success', "Successfully imported {$result['imported']} subscribers. Failed: {$result['failed']}");
    }
}