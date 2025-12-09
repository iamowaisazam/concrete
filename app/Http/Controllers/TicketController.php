<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Support\Facades\Auth;
use DataTables;

class TicketController extends Controller
{
    public function create()
    {
        return view("user.ticket.create");
    }

    public function store(Request $request)
    {

        $request->validate([
            "issue_topic" => "required|string",
            "issue_type" => "required|string",
            "details" => "required|string",
            "priority" => "required|in:Low,Medium,High",
            "attachment" => "nullable|file|max:2048",
        ]);

        $user = Auth::user();

    

        $t = Ticket::create([
            "user_id" => $user->id,
            "user_name" => $user->firstName . " " . $user->surname,
            "issue_topic" => $request->issue_topic,
            "issue_type" => $request->issue_type,
            "details" => $request->details,
            "priority" => $request->priority, 
            "status" => 0, 
            "attachment" => '',
            "response" => 1,
        ]);

        
        if ($request->file('attachment')) {
            $fileName = time() . '__ff__' . $request->file('attachment')->getClientOriginalName();
            $filePath = public_path('uploads/tickets');
            $request->file('attachment')->move($filePath, $fileName);
            $t->attachment = $fileName;
            $t->save();
        }

        return redirect()
            ->route("ticket.create")
            ->with("success", "Ticket submitted successfully!");
    }


    public function history(Request $request)
    {


        if ($request->ajax()) {

            $search = $request->input('search.value');
            $start = $request->input('start') ?? 0;
            $length = $request->input('length') ?? 10;

            $query = Ticket::where("user_id", Auth::user()->id);
             if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('tickets.issue_topic', 'like', "%{$search}%")
                    ->orWhere('tickets.issue_type', 'like', "%{$search}%");
                    // ->orWhere('users.companyName', 'like', "%{$search}%");
                });
            }

            $totalData = clone $query;
            $data = $query->select(
                    'tickets.*',
            )
            ->orderBy('created_at','desc')
            ->offset($start)
            ->limit($length)
            ->get()
            ->map(function ($row) {

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
                       '<a href="' .route("ticket.view", $row->id) .'" class="btn btn-sm btn-info">View</a>',
                  ];

              });

    
                return  [
                    "draw" => intval($request->input('draw')),
                    "recordsTotal" => $totalData->count(),
                    "recordsFiltered" => $totalData->count(),
                    "data" => $data
                ];
        }



        $user = Auth::user();
        $tickets = Ticket::where("user_id", $user->id)
            ->latest()
            ->get();

        return view("user.ticket.history", compact("tickets"));
    }

    public function view($id)
    {
        $ticket = Ticket::with("replies")->findOrFail($id);
        return view("user.ticket.view", compact("ticket"));
    }

    public function reply(Request $request, $ticket_id)
    {
        $request->validate([
            "message" => "required|string",
            "attachment" => "nullable|file|max:2048",
        ]);

        $user = Auth::user();

        $attachmentPath = $request->hasFile("attachment")
            ? $request->file("attachment")->store("attachments", "public")
            : null;

        TicketReply::create([
            "ticket_id" => $ticket_id,
            "user_id" => $user->id,
            "is_admin" => 0,
            "message" => $request->message,
            "attachment" => $attachmentPath,
        ]);

        return redirect()
            ->back()
            ->with("success", "Reply submitted!");
    }

    public function historyData(Request $request)
    {
        $user = Auth::user();

        if ($request->ajax()) {
            $tickets = Ticket::where("user_id", $user->id)->latest();

            return DataTables::of($tickets)
                ->addIndexColumn()

                // Format issue topic
                ->editColumn("issue_topic", function ($row) {
                    return "" . e($row->issue_topic) . "";
                })

                // Priority as string with color
                ->addColumn("priority", function ($row) {
                    $color = match (strtolower($row->priority)) {
                        "low" => "bg-success",
                        "medium" => "bg-warning",
                        "high" => "bg-danger",
                        default => "bg-secondary",
                    };
                    return '<span class="badge ' .
                        $color .
                        '">' .
                        ucfirst($row->priority) .
                        "</span>";
                })

                // Status
                ->addColumn("status_label", function ($row) {
                    $statuses = ["Open", "In Progress", "Resolved", "Closed"];
                    $statusText = $statuses[$row->status ?? 0] ?? "Unknown";
                    $badgeClass = match ($row->status) {
                        0 => "bg-success",
                        1 => "bg-warning",
                        2 => "bg-info",
                        3 => "bg-dark",
                        default => "bg-light",
                    };
                    return '<span class="badge ' .
                        $badgeClass .
                        '">' .
                        $statusText .
                        "</span>";
                })

                // Shorten description
                ->editColumn("details", function ($row) {
                    return \Str::limit(strip_tags($row->details), 60);
                })

                // Attachment
                ->editColumn("attachment", function ($row) {
                    if ($row->attachment) {
                        $url = asset("/public/storage/" . $row->attachment);
                        return '<a href="' .
                            $url .
                            '" class="btn btn-sm btn-outline-primary" target="_blank">View</a>';
                    } else {
                        return '<span class="text-muted">No file</span>';
                    }
                })

                // Format date
                ->editColumn("created_at", function ($row) {
                    return $row->created_at->format("d M Y");
                })

                // View button
                ->addColumn("action", function ($row) {
                    return '<a href="' .
                        route("ticket.view", $row->id) .
                        '" class="btn btn-sm btn-info">View</a>';
                })

                ->rawColumns([
                    "issue_topic",
                    "priority",
                    "status_label",
                    "attachment",
                    "action",
                ])
                ->make(true);
        }
    }

    public function submitFeedback(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        // Only allow feedback on closed tickets
        if ($ticket->status != 3) {
            return back()->with(
                "error",
                "Feedback can only be submitted for closed tickets."
            );
        }

        // Only allow one feedback per ticket
        if (!is_null($ticket->feedback) || !is_null($ticket->rating)) {
            return back()->with("error", "Feedback already submitted.");
        }

        $request->validate([
            "rating" => "required|integer|min:1|max:5",
            "feedback" => "required|string|max:1000",
        ]);

        $ticket->update([
            "rating" => $request->rating,
            "feedback" => $request->feedback,
        ]);

        return back()->with("success", "Thank you for your feedback!");
    }
}
