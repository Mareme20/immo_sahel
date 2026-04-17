<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contact;
use App\Models\Property;
use App\Models\Category;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Properties/Index', [
            'properties' => Property::with(['category', 'mainImage', 'ownerContact', 'tenantContact'])
                ->latest()
                ->paginate(10),
            'stats' => [
                'total' => Property::count(),
                'available' => Property::where('status', 'available')->count(),
                'rented' => Property::where('status', 'rented')->count(),
                'maintenance' => Property::where('status', 'maintenance')->count(),
                'published' => Property::where('is_published', true)->count(),
            ],
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Properties/Create', [
            'categories' => Category::orderBy('name')->get(),
            'contacts' => Contact::query()->where('is_active', true)->orderBy('name')->get(['id', 'name', 'type', 'phone']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validatedData($request);
        $data = collect($validated)->except('images')->all();
        $data['user_id'] = auth()->id();
        $data['slug'] = $this->generateSlug($validated['title']);
        $data['published_at'] = $data['is_published'] ? now() : null;

        $property = Property::create($data);

        if ($request->hasFile('images')) {
            $this->storeImages($property, $request->file('images'));
        }

        return redirect()->route('admin.properties.index')->with('message', 'Bien ajouté avec succès !');
    }

    public function edit(Property $property)
    {
        return Inertia::render('Admin/Properties/Edit', [
            'property' => $property->load(['images', 'ownerContact', 'tenantContact']),
            'categories' => Category::orderBy('name')->get(),
            'contacts' => Contact::query()->where('is_active', true)->orderBy('name')->get(['id', 'name', 'type', 'phone']),
        ]);
    }

    public function update(Request $request, Property $property)
    {
        $validated = $this->validatedData($request);
        $data = collect($validated)->except('images')->all();
        $data['published_at'] = $data['is_published']
            ? ($property->published_at ?? now())
            : null;

        if ($property->title !== $validated['title']) {
            $data['slug'] = $this->generateSlug($validated['title'], $property);
        }

        $property->update($data);

        if ($request->hasFile('images')) {
            $this->storeImages($property, $request->file('images'));
        }

        return redirect()->route('admin.properties.index')->with('message', 'Bien mis à jour !');
    }

    public function destroy(Property $property)
    {
        // Supprimer les fichiers physiques avant de supprimer la base
        foreach($property->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        $property->delete();
        return redirect()->route('admin.properties.index')->with('message', 'Bien supprimé.');
    }

    private function validatedData(Request $request): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'owner_contact_id' => ['nullable', 'exists:contacts,id'],
            'tenant_contact_id' => ['nullable', 'exists:contacts,id'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'location' => ['required', 'string', 'max:255'],
            'address_line' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'district' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'type' => ['required', 'in:sale,rent'],
            'status' => ['required', 'in:available,rented,maintenance'],
            'area' => ['nullable', 'integer', 'min:0'],
            'rooms' => ['nullable', 'integer', 'min:0'],
            'bathrooms' => ['nullable', 'integer', 'min:0'],
            'parking_spaces' => ['nullable', 'integer', 'min:0'],
            'featured' => ['nullable', 'boolean'],
            'is_published' => ['nullable', 'boolean'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:500'],
            'images' => ['nullable', 'array'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
        ]);

        foreach ([
            'owner_contact_id',
            'tenant_contact_id',
            'address_line',
            'city',
            'district',
            'latitude',
            'longitude',
            'area',
            'rooms',
            'bathrooms',
            'parking_spaces',
            'seo_title',
            'seo_description',
        ] as $field) {
            $validated[$field] = blank($validated[$field] ?? null) ? null : $validated[$field];
        }

        $validated['featured'] = $request->boolean('featured');
        $validated['is_published'] = $request->boolean('is_published', true);

        return $validated;
    }

    private function generateSlug(string $title, ?Property $property = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while (Property::query()
            ->where('slug', $slug)
            ->when($property, fn ($query) => $query->whereKeyNot($property->id))
            ->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    private function storeImages(Property $property, array $images): void
    {
        $lastOrder = (int) ($property->images()->max('sort_order') ?? -1);
        $hasExistingImages = $property->images()->exists();

        foreach ($images as $index => $image) {
            $path = $image->store('properties', 'public');

            PropertyImage::create([
                'property_id' => $property->id,
                'image_path' => $path,
                'sort_order' => $lastOrder + $index + 1,
                'is_main' => ! $hasExistingImages && $index === 0,
            ]);
        }
    }
}
