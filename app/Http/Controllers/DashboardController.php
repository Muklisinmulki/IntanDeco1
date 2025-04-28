<?php
// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use App\Models\Catalog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function catalogByCategory()
    {
        $categories = Catalog::join('categories', 'catalogs.category_id', '=', 'categories.id')
            ->selectRaw('categories.name, COUNT(*) as total')
            ->groupBy('categories.name')
            ->get();

        return response()->json($categories);
    }
    
    public function catalogsByDate()
    {
        $catalogs = Catalog::select('id', 'name', 'image', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($catalog) {
                return [
                    'id' => $catalog->id,
                    'title' => $catalog->name,
                    'date' => Carbon::parse($catalog->created_at)->format('Y-m-d'),
                    'image' => $catalog->image,
                    'color' => 'bg-amber-500'
                ];
            });
            
        return response()->json($catalogs);
    }
}