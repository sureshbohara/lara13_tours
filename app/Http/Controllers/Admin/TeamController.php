<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\TeamRequest;
use App\Models\Team;
use App\Services\Admin\TeamService;
use Illuminate\Http\Request;

class TeamController extends BaseController
{
    public function __construct(protected TeamService $service) {}

    public function index(Request $request)
    {
        return view('admin.team.index', [
            'items'   => $this->service->getItems($request->only('status', 'search')),
            'filters' => $request->only('status', 'search'),
        ]);
    }

    public function create()
    {
        return view('admin.team.form');
    }

    public function store(TeamRequest $request)
    {
        $item = $this->service->store($request->validated());
        return $this->successJson('Team member created successfully!', $item, 201);
    }

    public function edit(Team $team)
    {
        return view('admin.team.form', compact('team'));
    }

    public function update(TeamRequest $request, Team $team)
    {
        $updated = $this->service->update($team->id, $request->validated());
        return $this->successJson('Team member updated successfully!', $updated);
    }

    public function destroy(Team $team)
    {
        $this->service->delete($team->id);
        return redirect()->back()->with('success', 'Deleted permanently!');
    }

    public function teamStatus(Request $request)
    {
        $request->validate(['status_id' => 'required|exists:teams,id']);
        $newStatus = $this->service->toggleStatus((int) $request->status_id);
        
        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }

    public function updateOrderLevel(Request $request)
    {
        $request->validate([
            'id'          => 'required|exists:teams,id',
            'order_level' => 'required|integer|min:0',
        ]);
        
        $this->service->updateOrderLevel((int) $request->id, (int) $request->order_level);
        return $this->successJson('Order updated!');
    }
}