<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {


            $search = $request->input('search.value');
            $start = $request->input('start') ?? 0;
            $length = $request->input('length') ?? 10;
            
            
            $query = Blog::Leftjoin('blog_categories', 'blog_categories.id', '=', 'blogs.category_id')
            ->Leftjoin('users', 'users.id', '=', 'blogs.author_id');

             if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('blogs.title', 'like', "%{$search}%")
                    ->orWhere('blog_categories.name', 'like', "%{$search}%")
                    ->orWhere('users.companyName', 'like', "%{$search}%");
                });
            }



          
            $totalData = clone $query;

            $data = $query->select(
                    'blogs.*',
            )
            // ->orderBy('created_at','desc')
            ->offset($start)
            ->limit($length)
            ->get()
            ->map(function ($blog) {


                    $editUrl = route('blogs.edit', $blog->id);
                    $deleteUrl = route('blogs.destroy', $blog->id);
                    $showUrl = route('blogs.show', $blog->slug);
                  
                       $html = ' <a href="' . $showUrl . '" class="btn btn-sm btn-info" target="_blank">View</a>
                        <a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>
                        <form action="' . $deleteUrl . '" method="POST" style="display:inline-block;">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                        </form>';

                  return [
                      $blog->id,
                      '<img style="width:50px;" src="'.asset('/public/uploads/blogs/'.$blog->image).'" />',
                      $blog->title,
                      $blog->category->name ?? 'N/A',
                      $blog->author->companyName ?? 'N/A',
                      $blog->created_at->toDateTimeString(),
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

    
        return view('admin.blog.index',[]);
    }


    public function ajaxData(Request $request)
    {
        if ($request->ajax()) {
            $data = Blog::with('author', 'category')->select('blogs.*');

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('d M Y');
                })
                ->addColumn('category', function ($row) {
                    return $row->category->name ?? 'N/A';
                })
                ->addColumn('author', function ($row) {
                    return $row->author ? $row->author->name : 'N/A';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('blogs.edit', $row->id);
                    $deleteUrl = route('blogs.destroy', $row->id);
                    $showUrl = route('blogs.show', $row->slug);
                    return '
                        <a href="' . $showUrl . '" class="btn btn-sm btn-info" target="_blank">View</a>
                        <a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>
                        <form action="' . $deleteUrl . '" method="POST" style="display:inline-block;">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                        </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }


    public function create()
    {
        $categories = BlogCategory::all();
        return view('admin.blog.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image',
            'description' => 'required',
            'date' => 'nullable|date',
            'category_id' => 'nullable|exists:blog_categories,id',
            'tag' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keyword' => 'nullable|string',
            'slug' => 'required|string|unique:blogs,slug',
            'status' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('blogs', 'public');
        }

  

        $validated['author_id'] = Auth::id();

        $blog = Blog::create($validated);

        if ($request->file('image')) {
            $fileName = time() . '__ff__' . $request->file('image')->getClientOriginalName();
            $filePath = public_path('uploads/blogs');
            $request->file('image')->move($filePath, $fileName);
            $blog->image = $fileName;
            $blog->save();
        }

        return redirect()->route('blogs.index')->with('success', 'Blog created successfully.');
    }

    public function edit(Blog $blog)
    {
        $categories = BlogCategory::all();
        return view('admin.blog.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image',
            'description' => 'required',
            'date' => 'nullable|date',
            'category_id' => 'nullable|exists:blog_categories,id',
            'tag' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keyword' => 'nullable|string',
            'slug' => 'required|string|unique:blogs,slug,' . $blog->id,
            'status' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('blogs', 'public');
        }

        $blog->update($validated);

        if($request->file('image')) {
            // Remove existing thumbnail if it exists
            if ($blog->avatar && file_exists(public_path('uploads/' . $blog->image))) {
                unlink(public_path('uploads/' . $blog->image));
            }
            $fileName = time() . '__ff__' . $request->file('image')->getClientOriginalName();
            $filePath = public_path('uploads/blogs');
            $request->file('image')->move($filePath, $fileName);
            $blog->image = $fileName;
            $blog->save();
        }

        return redirect()->route('blogs.index')->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route('blogs.index')->with('success', 'Blog deleted.');
    }
    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        return view('admin.blog.show', compact('blog'));
    }


    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '.' . $file->getClientOriginalName();
            $file->move(public_path('uploads/blog-images'), $filename);
    
            $url = asset('public/uploads/blog-images/' . $filename);
    
            return response()->json([
                'url' => $url
            ]);
        }
    
        return response()->json(['error' => 'No file uploaded.'], 400);
    }
    

}
