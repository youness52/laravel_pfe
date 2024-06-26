<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyEventRequest;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Room;
use App\Services\EventService;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Mail;

class EventsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('event_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $events = Event::all();

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rooms = Room::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.events.create', compact('rooms', 'users'));
    }

    public function store(StoreEventRequest $request, EventService $eventService)
    {
        if ($eventService->isRoomTaken($request->all())) {
            return redirect()->back()
                    ->withInput($request->input())
                    ->withErrors('Cette salle n est pas disponible à l heure que vous avez choisie');
        }

        $event = Event::create($request->all());

        if ($request->filled('recurring_until')) {
            $eventService->createRecurringEvents($request->all());
        }

        try {
            $user = User::find($request->input('user_id'));
            Mail::raw('Bonjour '.$user->name . ' Votre Réunion '. $request->input("title") .' est bien Crée a partir ' .$request->input("start_time") . ' a '.$request->input("end_time"), function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Créer Réunion');
            });

        } catch (\Throwable $th) {
            //throw $th;
        }
      

        return redirect()->route('admin.events.index');

    }

    public function edit(Event $event)
    {
        abort_if(Gate::denies('event_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rooms = Room::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $event->load('room', 'user');

        return view('admin.events.edit', compact('rooms', 'users', 'event'));
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $event->update($request->all());
        try {
            $user = User::find($request->input('user_id'));
            Mail::raw('Bonjour '.$user->name . ' Votre Réunion '. $request->input("title") .' est bien modifier a partir ' .$request->input("start_time") . ' a '.$request->input("end_time"), function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('modifier Réunion');
            });

        } catch (\Throwable $th) {
            //throw $th;
        }
        return redirect()->route('admin.events.index');

    }

    public function show(Event $event)
    {
        abort_if(Gate::denies('event_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $event->load('room', 'user');

        return view('admin.events.show', compact('event'));
    }

    public function destroy(Event $event)
    {
        abort_if(Gate::denies('event_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $event->delete();
        return back();

    }

    public function massDestroy(MassDestroyEventRequest $request)
    {
        Event::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);

    }
}
