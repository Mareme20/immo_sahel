<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropertyImageController extends Controller
{
    public function main(Property $property, PropertyImage $image)
    {
        abort_unless($image->property_id === $property->id, 404);

        $property->images()->update(['is_main' => false]);
        $image->update(['is_main' => true]);

        return back()->with('message', 'Image principale mise a jour.');
    }

    public function destroy(Property $property, PropertyImage $image)
    {
        abort_unless($image->property_id === $property->id, 404);

        Storage::disk('public')->delete($image->image_path);
        $wasMain = $image->is_main;
        $image->delete();

        if ($wasMain) {
            $property->images()->orderBy('sort_order')->first()?->update(['is_main' => true]);
        }

        return back()->with('message', 'Image supprimee.');
    }

    public function reorder(Request $request, Property $property)
    {
        $validated = $request->validate([
            'order' => ['required', 'array'],
            'order.*' => ['required', 'integer', 'exists:property_images,id'],
        ]);

        foreach ($validated['order'] as $index => $imageId) {
            $property->images()->whereKey($imageId)->update(['sort_order' => $index]);
        }

        return back()->with('message', 'Ordre des images mis a jour.');
    }
}
