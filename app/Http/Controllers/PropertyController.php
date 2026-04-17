<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $publishedProperties = Property::query()->where('is_published', true);
        $query = (clone $publishedProperties)->with(['category', 'mainImage']);

        // Filtres de recherche
        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));

            $query->where(function ($searchQuery) use ($search) {
                $searchQuery
                    ->where('title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('district', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }
        if ($request->filled('district')) {
            $query->where('district', $request->district);
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        if ($request->filled('rooms')) {
            $query->where('rooms', '>=', $request->rooms);
        }
        if ($request->filled('bathrooms')) {
            $query->where('bathrooms', '>=', $request->bathrooms);
        }
        if ($request->filled('min_area')) {
            $query->where('area', '>=', $request->min_area);
        }
        if ($request->filled('max_area')) {
            $query->where('area', '<=', $request->max_area);
        }

        $query->orderByDesc('featured');

        match ($request->input('sort')) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'area_asc' => $query->orderBy('area'),
            'area_desc' => $query->orderByDesc('area'),
            'oldest' => $query->oldest(),
            default => $query->latest(),
        };

        return Inertia::render('Properties/Index', [
            'properties' => $query->paginate(9)->withQueryString(),
            'categories' => Category::withCount([
                'properties' => fn ($propertiesQuery) => $propertiesQuery->where('is_published', true),
            ])->orderBy('name')->get(),
            'filters' => $request->only([
                'search',
                'type',
                'status',
                'category',
                'city',
                'district',
                'rooms',
                'bathrooms',
                'min_price',
                'max_price',
                'min_area',
                'max_area',
                'sort',
            ]),
            'stats' => [
                'total' => (clone $publishedProperties)->count(),
                'sales' => (clone $publishedProperties)->where('type', 'sale')->count(),
                'rents' => (clone $publishedProperties)->where('type', 'rent')->count(),
                'featured' => (clone $publishedProperties)->where('featured', true)->count(),
            ],
            'cities' => (clone $publishedProperties)
                ->whereNotNull('city')
                ->where('city', '!=', '')
                ->distinct()
                ->orderBy('city')
                ->pluck('city'),
            'districts' => (clone $publishedProperties)
                ->whereNotNull('district')
                ->where('district', '!=', '')
                ->distinct()
                ->orderBy('district')
                ->pluck('district'),
        ]);
    }

    public function show(Property $property)
    {
        abort_unless($property->is_published, 404);

        return Inertia::render('Properties/Show', [
            'property' => $property->load(['category', 'images', 'user', 'mainImage', 'ownerContact']),
            'related_properties' => Property::with(['category', 'mainImage'])
                ->where('is_published', true)
                ->where('id', '!=', $property->id)
                ->where('category_id', $property->category_id)
                ->orderByDesc('featured')
                ->latest()
                ->take(3)
                ->get(),
        ]);
    }
}
