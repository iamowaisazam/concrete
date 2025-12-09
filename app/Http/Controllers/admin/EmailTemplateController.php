<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class EmailTemplateController extends Controller
{
    public function index() {
        $templates = EmailTemplate::all();
        return view('admin.email_templates.index', compact('templates'));
    }
    
    public function create() {
        return view('admin.email_templates.create');
    }
    
    public function store(Request $request) {
        $request->validate([
            'subject' => 'required',
            'body' => 'required',
        ]);
    
        EmailTemplate::create($request->only('subject', 'body'));
    
        return redirect()->route('admin.email_templates.index')->with('success', 'Template created.');
    }
    
    public function sendForm($id) {
        $template = EmailTemplate::findOrFail($id);
        $users = User::all(); // or filter by membership
        return view('admin.email_templates.send', compact('template', 'users'));
    }
    
    public function sendEmail(Request $request, $id) {
        $template = EmailTemplate::findOrFail($id);
        $users = User::whereIn('id', $request->input('user_ids'))->get();
    
        foreach ($users as $user) {
            Mail::send([], [], function ($message) use ($user, $template) {
                $message->to($user->email)
                        ->subject($template->subject)
                        ->setBody($template->body, 'text/html');
            });
        }
    
        return back()->with('success', 'Emails sent successfully.');
    }
}
