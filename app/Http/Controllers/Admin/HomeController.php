<?php

namespace App\Http\Controllers\Admin;
use App\User;
use App\Room;
use App\Event;
use Carbon\Carbon;



class HomeController
{
    public function index()
    {

        $userCount = User::count();  // Get the count of users
        $roomCount = Room::count();  // Get the count of rooms
        $eventCount = Event::count();  // Get the count of events
        $incomingEventsCount = Event::where('start_time', '>', Carbon::now())->count();   
        return view('home', [
            'userCount' => $userCount,
            'roomCount' => $roomCount,
            'eventCount' => $eventCount,
            'incomingEventsCount'=> $incomingEventsCount
        ]);
    }
}

