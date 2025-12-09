<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogCategory;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon; // Add this at the top if not already



class BlogCategoryController extends Controller
{



    public function index(Request $request)
{


     if ($request->ajax()) {


            $search = $request->input('search.value');
            $start = $request->input('start') ?? 0;
            $length = $request->input('length') ?? 10;

            $query = BlogCategory::query();

             if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('blog_categories.name', 'like', "%{$search}%");
                });
            }

            $totalData = clone $query;
            

            $data = $query->select(
                    'blog_categories.*',
            )
            ->orderBy('created_at','desc')
            ->offset($start)
            ->limit($length)
            ->get()
            ->map(function ($blog) {


                    $editUrl = url('/admin/blogcategories/'.$blog->id.'/edit');
                    $deleteUrl = url('/admin/blogcategories/'.$blog->id);

                    $html =  '<a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>
                    <form method="POST" action="' . $deleteUrl . '" style="display:inline-block">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                    </form>';

                  return [
                      $blog->id,
                      $blog->name,
                      $blog->created_at ? $blog->created_at->toDateTimeString() : '',
                      $html,
                  ];
              });

    
                return  [
                    "draw" => intval($request->input('draw')),
                    "recordsTotal" => $totalData->count(),
                    "recordsFiltered" => $totalData->count(),
                    "data" => $data
                ];
        }



     return view('admin.blogcategories.index'); // no need to compact('categories')
   }

    public function create()
    {
        return view('admin.blogcategories.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        BlogCategory::create($request->all());
        return redirect('/admin/blogcategories')->with('success', 'Category added.');
    }

    public function edit(BlogCategory $blogcategory)
    {
        return view('admin.blogcategories.edit', compact('blogcategory'));
    }

    public function update(Request $request, BlogCategory $blogcategory)
    {
        $request->validate(['name' => 'required']);
        $blogcategory->update($request->all());
        return redirect('/admin/blogcategories')->with('success', 'Category updated.');
    }

    public function destroy(BlogCategory $blogcategory)
    {
        $blogcategory->delete();
        return redirect('/admin/blogcategories')->with('success', 'Category deleted.');
    }
}
