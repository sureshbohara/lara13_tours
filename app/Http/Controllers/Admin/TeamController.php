<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\TeamRequest;
use App\Models\Team;
use App\Services\Admin\TeamService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeamController extends BaseController
{
    public function __construct(protected TeamService $service) 
    {
        $this->middleware('auth:admin');
        $this->middleware('can:team.read')->only(['index']);
        $this->middleware('can:team.create')->only(['create', 'store']);
        $this->middleware('can:team.update')->only(['edit', 'update', 'teamStatus', 'updateOrderLevel']);
        $this->middleware('can:team.delete')->only(['destroy']);
    }

    public function index(Request $request): View
    {
        return view('admin.team.index', [
            'items'   => $this->service->getItems($request->only('status', 'search')),
            'filters' => $request->only('status', 'search'),
        ]);
    }

    public function create(): View
    {
        return view('admin.team.form');
    }

    public function store(TeamRequest $request): JsonResponse
    {
        $item = $this->service->store($request->validated());

        return $this->successJson('Team member created successfully!', $item, 201);
    }

    public function edit(Team $team): View
    {
        return view('admin.team.form', compact('team'));
    }

    public function update(TeamRequest $request, Team $team): JsonResponse
    {
        $updated = $this->service->update($team->id, $request->validated());

        return $this->successJson('Team member updated successfully!', $updated);
    }

    public function destroy(Team $team): RedirectResponse
    {
        $this->service->delete($team->id);

        return redirect()->back()->with('success', 'Deleted permanently!');
    }

    public function teamStatus(Request $request): JsonResponse
    {
        $request->validate([
            'status_id' => ['required', 'integer', 'exists:teams,id'],
        ]);

        $newStatus = $this->service->toggleStatus((int) $request->status_id);

        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }

    public function updateOrderLevel(Request $request): JsonResponse
    {
        $request->validate([
            'id'          => ['required', 'integer', 'exists:teams,id'],
            'order_level' => ['required', 'integer', 'min:0'],
        ]);

        $this->service->updateOrderLevel(
            (int) $request->id,
            (int) $request->order_level
        );

        return $this->successJson('Order updated!');
    }
}