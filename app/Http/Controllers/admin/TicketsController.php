<?php


namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class TicketsController extends Controller
{
    public function index(Request $request) {

        if ($request->ajax()) {

            $search = $request->input('search.value');
            $start = $request->input('start') ?? 0;
            $length = $request->input('length') ?? 10;
            
            $query = Ticket::Leftjoin('users', 'users.id', '=', 'tickets.user_id');

             if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('tickets.title', 'like', "%{$search}%")
                    ->orWhere('users.firstName', 'like', "%{$search}%");
                    // ->orWhere('users.companyName', 'like', "%{$search}%");
                });
            }

            $totalData = clone $query;
            $data = $query->select(
                    'tickets.*',
                    'users.firstName',
            )
            ->orderBy('created_at','desc')
            ->offset($start)
            ->limit($length)
            ->get()
            ->map(function ($row) {
        
                    $html = '';
                    $html .= '<a href="' .url('/admin/tickets/'.$row->id). '" class="btn btn-sm btn-warning" >View</a>';
                    $html .= '<form action="' .url('/admin/tickets/'.$row->id). '" method="POST" style="display:inline-block;">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Delete this news?\')">Delete</button>
                    </form>';


                    $color = match (strtolower($row->priority)) {
                        "low" => "bg-success",
                        "medium" => "bg-warning",
                        "high" => "bg-danger",
                        default => "bg-secondary",
                    };

                    $statuses = ["Open", "In Progress", "Resolved", "Closed"];
                    $statusText = $statuses[$row->status ?? 0] ?? "Unknown";
                    $badgeClass = match ($row->status) {
                        0 => "bg-success",
                        1 => "bg-warning",
                        2 => "bg-info",
                        3 => "bg-dark",
                        default => "bg-light",
                    };

             

                  return [
                     $row->id,
                      "" . e($row->issue_topic) . "",
                      \Str::limit(strip_tags($row->details), 60),
                      '<span class="badge ' .$color .'">' .ucfirst($row->priority) ."</span>",
                      '<span class="badge ' . $badgeClass .'">' .$statusText ."</span>",
                      
                       $row->attachment ? '<a href="' .asset("/public/uploads/tickets/".$row->attachment).'" class="btn btn-sm btn-outline-primary" target="_blank">View</a>' : '<span class="text-muted">No file</span>',

                       $row->created_at->format("d M Y"),

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

        return view('admin.tickets.index');
    }

  
    public function show($id) {
        $ticket = Ticket::with('replies.user')->findOrFail($id);
        return view('admin.tickets.show', compact('ticket'));
    }

    public function reply(Request $request, $id) {
        $request->validate(['message' => 'required']);
        TicketReply::create([
            'ticket_id' => $id,
            'user_id' => auth()->id(),
            'is_admin' => 1,
            'message' => $request->message,
        ]);
        return back()->with('success', 'Reply sent.');
    }

    public function updateStatus(Request $request, $id) {
        $ticket = Ticket::findOrFail($id);
        $ticket->update([
            'status' => $request->status,
            'priority' => $request->priority,
            'closed_at' => $request->status == 3 ? now() : null,
            'rating' => $request->rating,
            'feedback' => $request->feedback,
        ]);
        return back()->with('success', 'Ticket updated.');
    }
}
