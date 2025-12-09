<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\NotificationEvent;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\UserNotificationSetting;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Mail\NewsAndBlogNotification;
use Illuminate\Support\Facades\Mail;
use App\Models\UserNotificationAlert;

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


                    $editUrl = url('/admin/blogs/'.$blog->id.'/edit/');
                    $deleteUrl = url('/admin/blogs/'.$blog->id);

                    $showUrl = url('/admin/blogs/'.$blog->slug);
                  
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

    public function create()
    {
        $categories = BlogCategory::all();
        return view('admin.blog.create', compact('categories'));
    }

    private function getNewsAndBlogUsers()
    {
        return UserNotificationSetting::where('type', 'news_and_blog')
            ->where('browser', 1)
            ->where(function ($query) {
                $query->where('send_preference', 'anytime')
                      ->orWhereNull('send_preference'); 
            })
            ->pluck('user_id') 
            ->toArray();       
    }

    private function getNewsAndBlogUsersEmail()
    {
        $emails = User::whereIn('id', function($query) {
                $query->select('user_id')
                    ->from('user_notification_settings')
                    ->where('type', 'news_and_blog')
                    ->where('email', 1)
                    ->where(function($q) {
                        $q->where('send_preference', 'anytime')
                            ->orWhereNull('send_preference');
                    });
            })
            ->whereNotNull('personalEmail') 
            ->where('personalEmail', '!=', '') 
            ->pluck('personalEmail')
            ->toArray();

        return $emails; 
    }

    private function sendNewsAndBlogEmail(array $emails, string $title, string $messageContent)
{
    if (empty($emails)) {
        return false; // nothing to send
    }

    foreach ($emails as $email) {
        Mail::to($email)->send(new NewsAndBlogNotification($title, $messageContent));
    }

    return true;
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

            $users = $this->getNewsAndBlogUsers(); 

            foreach ($users as $userId) {
                $user = User::find($userId); 
             

                if ($user) {
                    $blogPageLink="blogs?id=".$blog->id;
                    $imageblog=  $fileName ?? NULL ;
                    event(new NotificationEvent($user, $blog->title, $blog->title,$blogPageLink,$imageblog));
                }
            }
            $userEmail = $this->getNewsAndBlogUsersEmail();
            if($userEmail){

                $this->sendNewsAndBlogEmail($userEmail, $blog->title, $blog->description);
            }
            
        return redirect('/admin/blogs')->with('success', 'Blog created successfully.');
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

        return redirect('/admin/blogs')->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect('/admin/blogs')->with('success', 'Blog deleted.');
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
