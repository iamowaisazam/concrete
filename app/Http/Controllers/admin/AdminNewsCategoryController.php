<?php


namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;


class AdminNewsCategoryController extends Controller
{



    public function index(Request $request)
{

     if ($request->ajax()) {


            $search = $request->input('search.value');
            $start = $request->input('start') ?? 0;
            $length = $request->input('length') ?? 10;

            $query = NewsCategory::query();

             if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('news_categories.name', 'like', "%{$search}%");
                });
            }

            $totalData = clone $query;
            

            $data = $query->select(
                    'news_categories.*',
            )
            ->orderBy('created_at','desc')
            ->offset($start)
            ->limit($length)
            ->get()
            ->map(function ($blog) {


                    $editUrl = url('/admin/ncategories/'.$blog->id.'/edit');
                    $deleteUrl = url('/admin/ncategories/'.$blog->id);

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



     return view('admin.newscategories.index');
   }

    public function create()
    {
        return view('admin.newscategories.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        NewsCategory::create($request->all());
        return redirect('/admin/ncategories')->with('success', 'Category added.');
    }
    public function edit(NewsCategory $newsCategory)
    {

        return view('admin.newscategories.edit', compact('newsCategory'));
    }


    public function update(Request $request, NewsCategory $newsCategory)
    {
        $request->validate(['name' => 'required']);
        $newsCategory->update($request->all());
        return redirect('/admin/ncategories')->with('success', 'Category updated.');
    }

    public function destroy(NewsCategory $newsCategory)
    {
        $newsCategory->delete();
        return redirect('/admin/ncategories')->with('success', 'Category deleted.');
    }
}
