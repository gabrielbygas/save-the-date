<?php

namespace Modules\Photos\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Photos\Models\Payment as Payment;
use Modules\Photos\Models\Album;
use Modules\Photos\Models\AlbumAccessLog;

class AlbumAccessLogsController extends Controller
{
    /**
     * Display access logs for a specific album.
     */
    public function logs(Request $request, $slug)
    {
        $album = Album::where('slug', $slug)->firstOrFail();

        $query = AlbumAccessLog::where('album_id', $album->id);

        // Filtrage par date
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // Filtrage par IP
        if ($request->filled('visitor_ip')) {
            $query->where('visitor_ip', $request->visitor_ip);
        }

        $accessLogs = $query->latest()->paginate(20);
        $stats = [
            'total_visits' => $accessLogs->total(),
            'unique_ips' => $accessLogs->pluck('visitor_ip')->unique()->count(),
        ];

        return view('photos::access_logs.show', compact('album', 'accessLogs'));
    }

    public function export(Request $request, $slug)
    {
        $album = Album::where('slug', $slug)->firstOrFail();

        $query = AlbumAccessLog::where('album_id', $album->id);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $accessLogs = $query->get();

        $csv = "ID,Album ID,Photo ID,IP,User Agent,Created At\n";
        foreach ($accessLogs as $log) {
            $csv .= "{$log->id},{$log->album_id},{$log->photo_id},{$log->visitor_ip},\"{$log->user_agent}\",{$log->created_at}\n";
        }

        $filename = "album_{$album->slug}_access_logs_" . now()->format('Y-m-d') . ".csv";

        return response()->streamDownload(
            fn() => print($csv),
            $filename,
            ['Content-Type' => 'text/csv']
        );
    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('photos::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('photos::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('photos::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('photos::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}