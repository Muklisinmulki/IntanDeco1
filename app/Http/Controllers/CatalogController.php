<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use Illuminate\Http\Request;
use App\Models\Category;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $catalogs = Catalog::with('category')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('code', 'like', "%{$search}%");
            })
            ->latest()
            ->get();

        return Inertia::render('Catalog/Index', [
            'catalogs' => $catalogs,
            'categories' => Category::all(),
            'filters' => [
                'search' => $search
            ]
        ]);
    }

    public function getCatalogsFull(Request $request)
    {
        $catalogs = Catalog::with('category')
            ->select(['id', 'name', 'code', 'image', 'category_id'])
            ->get();

        return response()->json([
            'catalogs' => $catalogs,
            'categories' => Category::all(),
        ]);
    }
    public function getCatalogsTotal()
    {
        $totalProducts = Catalog::count(); // Or your specific count logic
        
        return response()->json([
            'totalProducts' => $totalProducts
        ]);
    }

    public function getCatalogs(Request $request)
    {
        // Subquery untuk mendapatkan ID produk terbaru di setiap kategori
        $latestPerCategory = Catalog::select(DB::raw('MAX(id) as id'))
            ->groupBy('category_id');

        // Ambil produk berdasarkan ID-ID tersebut, maksimal 8
        $catalogs = Catalog::with('category')
            ->whereIn('id', $latestPerCategory)
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        return response()->json([
            'catalogs' => $catalogs,
            'categories' => Category::all(),
        ]);
    }

    public function getCatalogByCategory(): JsonResponse
    {
        $catalogByCategory = Category::select('categories.name', DB::raw('count(catalogs.id) as total'))
            ->leftJoin('catalogs', 'categories.id', '=', 'catalogs.category_id')
            ->groupBy('categories.id', 'categories.name')
            ->get();

        return response()->json($catalogByCategory);
    }
    
    public function getCatalogsByDate()
    {
        $catalogs = Catalog::select([
                'id',
                'name',
                'code',
                'image',
                DB::raw("DATE(created_at) as date"),
                DB::raw("'bg-yellow-500' as color")
            ])
            ->whereNotNull('image')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => 'New Catalog: ' . $item->name,
                    'date' => $item->date,
                    'color' => $item->color,
                    'image' => $item->image ? asset('storage/' . $item->image) : null,
                    'code' => $item->code
                ];
            });

        return response()->json($catalogs);
    }
    // CatalogController.php
    public function checkUpdates(Request $request)
    {
        $lastId = $request->input('last_id', 0);
        $currentIds = $request->input('current_ids', []);
        
        // Data baru
        $newCatalogs = Catalog::with('category')
            ->where('id', '>', $lastId)
            ->orderBy('id', 'desc')
            ->get();
        
        // Data yang dihapus
        $removedIds = Catalog::whereIn('id', $currentIds)
            ->pluck('id')
            ->toArray();
        $actuallyRemoved = array_diff($currentIds, $removedIds);

        return response()->json([
            'new_catalogs' => $newCatalogs,
            'removed_ids' => $actuallyRemoved,
            'total_products' => Catalog::count(),
            'last_id' => Catalog::max('id') ?: 0
        ]);
    }

    public function getCatalogChartData(): JsonResponse
    {
        $data = Catalog::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        return response()->json($data);
    }

    public function countTodayCatalogs()
    {
        $count = Catalog::whereDate('created_at', now()->format('Y-m-d'))->count();
        return response()->json(['count' => $count]);
    }


    public function create()
    {
        return Inertia::render('Catalog/Create', [
            'categories' => Category::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:catalogs,code',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('catalogs', 'public');
        }

        Catalog::create($validated);

        return redirect()->route('catalog.index')->with('success', 'Catalog created successfully.');
    }

    public function edit(Catalog $catalog)
    {
        return Inertia::render('Catalog/Edit', [
            'catalog' => $catalog->load('category'),
            'categories' => Category::all()
        ]);
    }

    public function update(Request $request, Catalog $catalog)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:catalogs,code,' . $catalog->id,
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($catalog->image) {
                Storage::disk('public')->delete($catalog->image);
            }
            $validated['image'] = $request->file('image')->store('catalogs', 'public');
        } else {
            $validated['image'] = $catalog->image;
        }

        $catalog->update($validated);

        return redirect()->route('catalog.index')->with('success', 'Catalog updated successfully.');
    }

    public function destroy(Catalog $catalog)
    {
        try {
            if ($catalog->image) {
                Storage::disk('public')->delete($catalog->image);
            }
            $catalog->delete();
            return redirect()->route('catalog.index')->with('success', 'Catalog deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('catalog.index')->with('error', 'Failed to delete catalog.');
        }
    }
}
