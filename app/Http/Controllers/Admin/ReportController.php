<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate([
            'from' => 'nullable|date',
            'to'   => 'nullable|date|after_or_equal:from',
        ]);

        $from = Carbon::parse($data['from'] ?? now()->subDays(29))->toDateString();
        $to   = Carbon::parse($data['to'] ?? now())->toDateString();

        $stats = [
            'borrowed'         => Borrowing::whereBetween('borrowed_at', [$from, $to])->count(),
            'returned'         => Borrowing::whereBetween('returned_at', [$from, $to])->count(),
            'overdue_now'      => Borrowing::overdue()->count(),
            'fines_charged'    => (float) Borrowing::whereBetween('returned_at', [$from, $to])->sum('fine_amount'),
            'fines_outstanding'=> (float) Member::sum('outstanding_fines'),
        ];

        return view('admin.reports.index', compact('stats', 'from', 'to'));
    }
}