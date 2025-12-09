<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\User;
use App\Models\NewsCategory;
use App\Models\MembershipPlan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use DataTables;
use Illuminate\Support\Facades\URL;

class AdminNewscrudController extends Controller
{

    // Show list of news with pin counts
    public function index(Request $request) {

         if ($request->ajax()) {

            $search = $request->input('search.value');
            $start = $request->input('start') ?? 0;
            $length = $request->input('length') ?? 10;
            
            $query = News::Leftjoin('users', 'users.id', '=', 'news.created_by')
            ->leftJoin('news_categories', 'news_categories.id', '=', 'news.category_id');

             if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('news.title', 'like', "%{$search}%")
                    ->orWhere('users.firstName', 'like', "%{$search}%");
                    // ->orWhere('users.companyName', 'like', "%{$search}%");
                });
            }

            $totalData = clone $query;
            $data = $query->select(
                    'news.*',
                    'users.firstName',
                    DB::raw('(SELECT COUNT(*) FROM news_user_pins WHERE news_user_pins.news_id = news.id) as pin_count'),
                     'news_categories.name as category_name'
            )
            ->orderBy('created_at','desc')
            ->offset($start)
            ->limit($length)
            ->get()
            ->map(function ($blog) {
        
                    $html = '';
                    $html .= '<a href="' .URL::to('/admin/news/'.$blog->id.'/edit'). '" class="btn btn-sm btn-warning" >Edit</a>';
                    $html .= '<form action="' .URL::to('/admin/news/'.$blog->id). '" method="POST" style="display:inline-block;">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Delete this news?\')">Delete</button>
                    </form>';

                    $img = '<span class="badge bg-secondary">N/A</span>';
                    if($blog->feature_image) {
                        $img = '<img src="' . asset('/public/uploads/news/' . $blog->feature_image) . '" width="80" height="60" style="object-fit: cover;">';
                    } 

                  return [
                      $blog->id,
                      \Str::limit(strip_tags($blog->title), 40),
                      \Str::limit(strip_tags($blog->category_name), 40),
                      $img,
                      \Str::limit(strip_tags($blog->description), 40),
                      $blog->created_at ? $blog->created_at->toDateTimeString() : '',
                      $blog->firstName,
                      $blog->pin_count,
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


        $news = News::withCount(['pinnedUsers as pins_count'])->get();
        return view('admin.news.index', compact('news'));
    }



    // Show create form
    public function create() {
        return view('admin.news.create');
    }

    public function getCategory(Request $request)
        {
            $search = $request->input('q');

            $makes = NewsCategory::where('name', 'like', "%$search%")
                ->select('id', 'name as text')
                ->limit(20)
                ->get();

            return response()->json(['results' => $makes]);
        }

    public function getmemberships(Request $request)
        {
            $search = $request->input('q');

            $makes = MembershipPlan::where('plan_name', 'like', "%$search%")
                ->select('id', 'plan_name as text')
                ->limit(20)
                ->get();

            return response()->json(['results' => $makes]);
        }

    // Store new news
    public function store(Request $request) {
        $request->validate([
            'title' => 'required|max:255',
            'newcat' => 'required|integer',
            'feature_image' => 'nullable|image',
            'description' => 'required',
            'date' => 'nullable|date'
        ]);

        $news = new News();
        $news->title = $request->title;
        $news->category_id = $request->newcat;
        $news->description = $request->description;
        $news->date = $request->date;
        $news->created_by = auth()->id();

        // if ($request->hasFile('feature_image')) {
        //     $path = $request->feature_image->store('news', 'public');
        //     $news->feature_image = 'storage/' . $path;
        // }

        $news->save();

        if($request->file('feature_image')) {
            $fileName = time() . '__ff__' . $request->file('feature_image')->getClientOriginalName();
            $filePath = public_path('uploads/news');
            $request->file('feature_image')->move($filePath, $fileName);
            $news->feature_image = $fileName;
            $news->save();
        }

     

        return redirect('/admin/news')->with('success', 'News created successfully.');
    }

    // Show edit form
    public function edit(News $news) {
        return view('admin.news.edit', compact('news'));
    }

    // Update existing news
    public function update(Request $request, News $news) {

        $request->validate([
            'title' => 'required|max:255',
            'newcat' => 'required|integer',
            'feature_image' => 'nullable|image',
            'description' => 'required',
            'date' => 'nullable|date'
        ]);

        $news->title = $request->title;
        $news->category_id = $request->newcat;
        $news->description = $request->description;
        $news->date = $request->date;

        // if ($request->hasFile('feature_image')) {
        //     // dd($request->all());
        //     $path = $request->feature_image->store('news', 'public');
        //     $news->feature_image = 'storage/' . $path;
        // }

        $news->save();


        if($request->file('feature_image')) {
            // Remove existing thumbnail if it exists
            if ($news->avatar && file_exists(public_path('uploads/' . $news->feature_image))) {
                unlink(public_path('uploads/' . $news->feature_image));
            }
            $fileName = time() . '__ff__' . $request->file('feature_image')->getClientOriginalName();
            $filePath = public_path('uploads/news');
            $request->file('feature_image')->move($filePath, $fileName);
            $news->feature_image = $fileName;
            $news->save();
        }

        return redirect('/admin/news')->with('success', 'News updated successfully.');
    }

    // Delete news
    public function destroy(News $news) {
        $news->delete();
        return redirect('/admin/news')->with('success', 'News deleted successfully.');
    }


}
