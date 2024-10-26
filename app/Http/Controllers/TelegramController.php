<?php

namespace App\Http\Controllers;

use App\Events\SendToTelegramEvent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Telegram\Bot\Api;

class TelegramController extends Controller
{

    public function __construct(
        private readonly Api $telegram
    )
    {
    }

    public function index()
    {

        $event = \App\Models\Event::find(2);
        Event::dispatch(new SendToTelegramEvent(
            title: $event->title,
            description: $event->description,
            color: $event->color,
            start: Carbon::parse($event->start_time),
            end: Carbon::parse($event->end_time),
            chat_id: -1002472839215,
        ));
        Event::dispatch(new SendToTelegramEvent(
            title: $event->title,
            description: $event->description,
            color: $event->color,
            start: Carbon::parse($event->start_time),
            end: Carbon::parse($event->end_time),
            chat_id: -1002224260721,
        ));
        //$response = $this->telegram->getUpdates();
        /* $this->telegram->sendMessage(
             [
                 'chat_id' => '-1002472839215',
                 'text' => 'девил чорт',
             ]
         );*/
        //dump($response);
    }
}
