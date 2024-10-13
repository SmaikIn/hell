<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\EventResource;
use App\Models\Event;
use Filament\Forms;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Saade\FilamentFullCalendar\Actions;

class CalendarWidget extends FullCalendarWidget
{
    public string|null|Model $model = Event::class;

    public function fetchEvents(array $fetchInfo): array
    {
        return Event::query()
            ->where('start_time', '>=', $fetchInfo['start'])
            ->where('end_time', '<=', $fetchInfo['end'])
            ->get()
            ->map(
                fn(Event $event) => [
                    'id' => $event->id,
                    'title' => $event->title,
                    'color' => $event->color,
                    'description' => $event->description,
                    'start' => $event->start_time,
                    'end' => $event->end_time,
                    'url' => EventResource::getUrl(name: 'edit', parameters: ['record' => $event]),
                    'shouldOpenUrlInNewTab' => false
                ]
            )
            ->all();
    }

    public function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(255),
            Forms\Components\ColorPicker::make('color')
                ->required(),
            Forms\Components\MarkdownEditor::make('description')
                ->columnSpanFull(),
            Forms\Components\DateTimePicker::make('start_time')
                ->seconds(false)
                ->native(false)

                ->closeOnDateSelection()
                ->required(),
            Forms\Components\DateTimePicker::make('end_time')
                ->seconds(false)
                ->native(false)

                ->closeOnDateSelection()
                ->required()
        ];
    }

    protected function headerActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mountUsing(
                    function (Forms\Form $form, array $arguments) {
                        $form->fill([
                            'start_time' => $arguments['start'] ?? null,
                            'end_time' => $arguments['end'] ?? null
                        ]);
                    }
                )
        ];
    }

    protected function modalActions(): array
    {
        return [
            Actions\EditAction::make()
                ->mountUsing(
                    function (Event $record, Forms\Form $form, array $arguments) {
                        $form->fill([
                            'title' => $record->title,
                            'color' => $record->color,
                            'description' => $record->description,
                            'start_time' => $arguments['event']['start'] ?? $record->start_time,
                            'end_time' => $arguments['event']['end'] ?? $record->end_time
                        ]);
                    }
                ),
            Actions\DeleteAction::make(),
        ];
    }
}
