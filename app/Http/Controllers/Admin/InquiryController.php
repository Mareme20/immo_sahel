<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PropertyInquiry;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InquiryController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Inquiries/Index', [
            'inquiries' => PropertyInquiry::query()
                ->with(['property:id,title,slug,location', 'contact:id,name,phone,email'])
                ->latest()
                ->paginate(12),
            'stats' => [
                'total' => PropertyInquiry::count(),
                'new' => PropertyInquiry::where('status', 'new')->count(),
                'qualified' => PropertyInquiry::where('status', 'qualified')->count(),
                'visits' => PropertyInquiry::where('status', 'visit_planned')->count(),
                'converted' => PropertyInquiry::where('status', 'converted')->count(),
            ],
        ]);
    }

    public function update(Request $request, PropertyInquiry $inquiry)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:new,qualified,visit_planned,converted,archived'],
        ]);

        $inquiry->update($validated);

        return back()->with('message', 'Le statut de la demande a ete mis a jour.');
    }

    public function destroy(PropertyInquiry $inquiry)
    {
        $inquiry->delete();

        return back()->with('message', 'Demande supprimee.');
    }
}
