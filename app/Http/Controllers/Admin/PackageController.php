<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\PackageRequest;
use App\Models\Category;
use App\Models\Package;
use App\Services\Admin\PackageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PackageController extends BaseController
{
    public function __construct(protected PackageService $service)
    {
        $this->middleware('auth:admin');
        $this->middleware('can:package.read')->only(['index', 'packagePrices', 'fixDepature']);
        $this->middleware('can:package.create')->only(['create', 'store', 'fixDepatureAdd']);
        $this->middleware('can:package.update')->only([
            'edit', 'update', 'packageStatus', 'updateOrderLevel', 'updatePackageType', 
            'updatePackagePrices', 'deleteGalleryImage', 'tripItinerary', 'tripIncExc', 
            'tripEquipment', 'fixDepatureStatus'
        ]);
        $this->middleware('can:package.delete')->only(['destroy', 'deleteFixDepature']);
    }



    public function index(Request $request): View
    {
        $filters = $request->only('status', 'name', 'search');
        
        return view('admin.package.index', [
            'packages' => $this->service->getPackages($filters),
            'filters' => $filters,
        ]);
    }

    public function create(): View
    {
        $getCategories = Category::whereNull('parent_id')
            ->with('children')
            ->orderBy('order_level')
            ->get();
            
        return view('admin.package.form', compact('getCategories'));
    }

    public function store(PackageRequest $request): JsonResponse
    {
        $package = $this->service->storePackage(
            $request->validated(), 
            $request->input('category_id', [])
        );
        
        return $this->successJson('Package created successfully!', $package, 201);
    }

    public function edit(Package $package): View
    {
        $getCategories = Category::whereNull('parent_id')
            ->with('children')
            ->orderBy('order_level')
            ->get();
            
        return view('admin.package.form', [
            'package' => $package,
            'getCategories' => $getCategories,
            'selectedCategoryIds' => $package->categories->pluck('id')->toArray(),
        ]);
    }

    public function update(PackageRequest $request, Package $package): JsonResponse
    {
        $updated = $this->service->updatePackage(
            $package->id, 
            $request->validated(), 
            $request->input('category_id', [])
        );
        
        return $this->successJson('Package updated successfully!', $updated);
    }

    public function destroy(Package $package): RedirectResponse
    {
        $this->service->delete($package->id);
        return redirect()->back()->with('success', 'Package deleted successfully!');
    }


    public function tripItinerary(Request $request, int $id): View|RedirectResponse
    {
        if ($request->isMethod('POST')) {
            $this->service->updateItinerary($id, $request->only([
                'title', 'content', 'max_elevation', 'duration', 'distance', 'meals', 'accommodation'
            ]));
            return redirect()->route('admin.trip.itinerary', $id)->with('success', 'Itinerary updated successfully!');
        }
        
        return view('admin.package.itinerary', ['data' => Package::findOrFail($id)]);
    }

    public function tripIncExc(Request $request, int $id): View|RedirectResponse
    {
        if ($request->isMethod('POST')) {
            $this->service->updateIncExc($id, $request->only('included', 'excluded'));
            return redirect()->route('admin.trip.incexc', $id)->with('success', 'Inclusions & Exclusions updated successfully!');
        }
        
        return view('admin.package.inc_exc', ['data' => Package::findOrFail($id)]);
    }

    public function tripEquipment(Request $request, int $id): View|RedirectResponse
    {
        if ($request->isMethod('POST')) {
            $this->service->updateEquipment($id, $request->only([
                'equipment1', 'equipment2', 'equipment3', 'equipment4', 'equipment5'
            ]));
            return redirect()->route('admin.trip.equipment', $id)->with('success', 'Equipment list updated successfully!');
        }
        
        return view('admin.package.equipment', ['data' => Package::findOrFail($id)]);
    }



    public function packagePrices(): View
    {
        return view('admin.package.package_price', [
            'datas' => Package::ordered()->get(),
        ]);
    }

    public function updatePackagePrices(Request $request): JsonResponse
    {
        $request->validate([
            'id' => 'required|integer|exists:packages,id',
            'trip_previous_price' => 'nullable|numeric',
            'trip_price' => 'nullable|numeric',
        ]);
        
        $this->service->updatePrices((int) $request->id, $request->only('trip_previous_price', 'trip_price'));
        
        return response()->json(['success' => true, 'message' => 'Prices updated successfully!']);
    }

    public function deleteGalleryImage(Request $request): JsonResponse
    {
        $request->validate([
            'id' => 'required|integer|exists:packages,id',
            'image' => 'required|string',
        ]);
        
        $this->service->deleteGalleryImage((int) $request->id, $request->image);
        
        return response()->json(['status' => 200, 'message' => 'Gallery image deleted successfully!']);
    }

 

    public function fixDepature(): View
    {
        return view('admin.package.fix_departure', [
            'getData' => $this->service->getFixedDepartures(),
        ]);
    }

    public function fixDepatureAdd(Request $request): JsonResponse
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'discount_price' => 'required|numeric',
            'max_seats' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);
        
        $this->service->addFixedDeparture([
            'package_id' => (int) $request->package_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'discount_price' => (float) $request->discount_price,
            'max_seats' => (int) $request->max_seats,
            'description' => $request->description,
            'booked_seats' => 0,
            'status' => 'active',
        ]);
        
        return response()->json(['status' => 200, 'message' => 'Fixed departure added successfully!']);
    }

    public function deleteFixDepature(int $id): RedirectResponse
    {
        try {
            $this->service->deleteFixedDeparture($id);
            return redirect()->back()->with('success', 'Fixed departure deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function fixDepatureStatus(Request $request): JsonResponse
    {
        $request->validate([
            'id' => 'required|exists:fixed_departures,id',
            'status' => 'required|string|in:active,inactive',
        ]);
        
        $this->service->toggleDepartureStatus((int) $request->id, $request->status);
        
        return response()->json(['status' => 200, 'message' => 'Departure status updated successfully!']);
    }

  

    public function packageStatus(Request $request): JsonResponse
    {
        $request->validate(['status_id' => 'required|exists:packages,id']);
        $newStatus = $this->service->toggleStatus((int) $request->status_id);
        
        return $this->successJson('Package status updated successfully!', ['new_status' => $newStatus]);
    }

    public function updateOrderLevel(Request $request): JsonResponse
    {
        $request->validate([
            'id' => 'required|exists:packages,id',
            'order_level' => 'required|integer|min:0',
        ]);
    
        $this->service->updateOrderLevel((int) $request->id, (int) $request->order_level);
        
        return $this->successJson('Display order updated successfully!');
    }

    public function updatePackageType(Request $request): JsonResponse
    {
        $request->validate([
            'id' => 'required|exists:packages,id',
            'display_on' => 'nullable|string',
        ]);
        
        $this->service->updateDisplayType((int) $request->id, $request->display_on);
        
        return $this->successJson('Display location updated successfully!');
    }
}