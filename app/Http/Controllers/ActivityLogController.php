<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display the activity log.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Dummy data for activity log
        // $activityLog = [
        //     [
        //         'user' => 'Novia Dwi Lestari',
        //         'action' => 'Updated profile',
        //         'timestamp' => '20 December 2024, 10:30 AM',
        //     ],
        //     [
        //         'user' => 'John Doe',
        //         'action' => 'Uploaded a document',
        //         'timestamp' => '20 December 2024, 09:15 AM',
        //     ],
        //     [
        //         'user' => 'Jane Smith',
        //         'action' => 'Logged in',
        //         'timestamp' => '19 December 2024, 11:45 PM',
        //     ],
        //     [
        //         'user' => 'Alex Brown',
        //         'action' => 'Changed password',
        //         'timestamp' => '19 December 2024, 08:20 PM',
        //     ],
        //     [
        //         'user' => 'Chris Taylor',
        //         'action' => 'Deleted an entry',
        //         'timestamp' => '18 December 2024, 02:10 PM',
        //     ],
        // ];

        // Pass the data to the Blade view
        // return view('activity-log', compact('activityLog'));
        // return view('pages.activity-log.activity-log', compact('activityLog'));
        return view('pages.activity-log.activity-log');
    }
}
