<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\MaintenanceRequest;
use App\Models\Property;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MaintenanceRequestController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/MaintenanceRequests/Index', [
            'requests' => MaintenanceRequest::query()
                ->with(['property:id,title,location', 'contact:id,name,phone'])
                ->latest()
                ->paginate(12),
            'stats' => [
                'total' => MaintenanceRequest::count(),
                'open' => MaintenanceRequest::where('status', 'open')->count(),
                'in_progress' => MaintenanceRequest::where('status', 'in_progress')->count(),
                'resolved' => MaintenanceRequest::where('status', 'resolved')->count(),
                'urgent' => MaintenanceRequest::where('priority', 'urgent')->count(),
            ],
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/MaintenanceRequests/Create', $this->formOptions());
    }

    public function store(Request $request)
    {
        MaintenanceRequest::create($this->validatedData($request));

        return redirect()->route('admin.maintenance-requests.index')->with('message', 'Demande de maintenance ajoutee.');
    }

    public function edit(MaintenanceRequest $maintenanceRequest)
    {
        return Inertia::render('Admin/MaintenanceRequests/Edit', [
            'maintenanceRequest' => $maintenanceRequest,
            ...$this->formOptions(),
        ]);
    }

    public function update(Request $request, MaintenanceRequest $maintenanceRequest)
    {
        $maintenanceRequest->update($this->validatedData($request));

        return redirect()->route('admin.maintenance-requests.index')->with('message', 'Intervention mise a jour.');
    }

    public function destroy(MaintenanceRequest $maintenanceRequest)
    {
        $maintenanceRequest->delete();

        return redirect()->route('admin.maintenance-requests.index')->with('message', 'Demande supprimee.');
    }

    private function formOptions(): array
    {
        return [
            'properties' => Property::query()->orderBy('title')->get(['id', 'title', 'location']),
            'contacts' => Contact::query()->where('is_active', true)->orderBy('name')->get(['id', 'name', 'phone']),
        ];
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'property_id' => ['required', 'exists:properties,id'],
            'contact_id' => ['nullable', 'exists:contacts,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'priority' => ['required', 'in:low,medium,high,urgent'],
            'status' => ['required', 'in:open,in_progress,resolved,closed'],
            'estimated_cost' => ['nullable', 'numeric', 'min:0'],
            'reported_at' => ['nullable', 'date'],
            'resolved_at' => ['nullable', 'date'],
        ]);
    }
}
