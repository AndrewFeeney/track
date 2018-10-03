<?php

namespace App\Http\Controllers;

use App\Session;
use App\Support\DateTimeFormatter;
use App\Support\DateIntervalFormatter;
use App\Statistics\Sessions;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(DateTimeFormatter $dateTimeFormatter, DateIntervalFormatter $dateIntervalFormatter, Sessions $sessions)
    {
        $this->middleware('auth');

        $this->dateTimeFormatter = $dateTimeFormatter;
        $this->dateIntervalFormatter = $dateIntervalFormatter;
        $this->sessions = $sessions;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home', [
            'todaysWorkSessions' => $todaysWorkSessions = Session::today()->get(),
            'todaysTotal' => $todaysWorkSessions->totalDurationForHumans(),
            'thisWeeksWorkSessions' => $this->sessions->thisWeeksWorkSessions(),
            'thisWeeksTotal' => Session::thisWeek()->get()->totalDurationForHumans(),
        ]);
    }
}
