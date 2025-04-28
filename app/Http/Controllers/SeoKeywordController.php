<?php
// app/Http/Controllers/SeoKeywordController.php
namespace App\Http\Controllers;

use App\Models\SeoKeyword;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SeoKeywordController extends Controller
{
    public function index(Request $request)
    {
        $query = SeoKeyword::query();
        
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('keyword', 'like', '%'.$request->search.'%')
                ->orWhere('page_url', 'like', '%'.$request->search.'%')
                ->orWhere('meta_title', 'like', '%'.$request->search.'%');
            });
        }
        
        $keywords = $query->orderBy('priority', 'desc')
            ->orderBy('keyword')
            ->paginate(10)
            ->appends($request->query());
            
        return Inertia::render('SeoKeywords/Index', [
            'keywords' => $keywords,
            'filters' => $request->only(['search'])
        ]);
    }

    public function create()
    {
        return Inertia::render('SeoKeywords/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'keyword' => 'required|string|max:255',
            'page_url' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'priority' => 'nullable|integer|min:0|max:10',
        ]);

        SeoKeyword::create($request->all());

        return redirect()->route('seo-keywords.index')
            ->with('success', 'SEO keyword added successfully.');
    }

    public function edit(SeoKeyword $seoKeyword)
    {
        return Inertia::render('SeoKeywords/Edit', [
            'keyword' => $seoKeyword
        ]);
    }

    public function update(Request $request, SeoKeyword $seoKeyword)
    {
        $request->validate([
            'keyword' => 'required|string|max:255',
            'page_url' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'priority' => 'nullable|integer|min:0|max:10',
        ]);

        $seoKeyword->update($request->all());

        return redirect()->route('seo-keywords.index')
            ->with('success', 'SEO keyword updated successfully.');
    }

    public function destroy(SeoKeyword $seoKeyword)
    {
        $seoKeyword->delete();

        return redirect()->route('seo-keywords.index')
            ->with('success', 'SEO keyword deleted successfully.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt'
        ]);
        
        $file = $request->file('file');
        $csvData = file_get_contents($file);
        $rows = array_map('str_getcsv', explode("\n", $csvData));
        $header = array_shift($rows);
        
        foreach ($rows as $row) {
            if (count($row) === count($header)) {
                $row = array_combine($header, $row);
                
                SeoKeyword::updateOrCreate(
                    ['keyword' => $row['keyword'], 'page_url' => $row['page_url']],
                    $row
                );
            }
        }
        
        return back()->with('success', 'Keywords imported successfully.');
    }

    public function export()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="seo_keywords_'.date('Y-m-d').'.csv"',
        ];
        
        $keywords = SeoKeyword::all();
        
        $callback = function() use ($keywords) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, [
                'keyword', 'page_url', 'meta_title', 'meta_description', 'meta_keywords', 'content', 'priority'
            ]);
            
            foreach ($keywords as $keyword) {
                fputcsv($file, [
                    $keyword->keyword,
                    $keyword->page_url,
                    $keyword->meta_title,
                    $keyword->meta_description,
                    $keyword->meta_keywords,
                    $keyword->content,
                    $keyword->priority
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}