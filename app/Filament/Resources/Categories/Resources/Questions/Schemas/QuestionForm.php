<?php

namespace App\Filament\Resources\Categories\Resources\Questions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class QuestionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('question_text')
                    ->label('Frage')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('order')
                    ->label('Reihenfolge')
                    ->helperText('Niedrigere Zahlen = höhere Position. Verwenden Sie Drag & Drop in der Tabelle für einfache Sortierung.')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->minValue(1),
                Toggle::make('is_active')
                    ->label('Aktiv')
                    ->required(),
                TextInput::make('points')
                    ->label('Punkte')
                    ->helperText('Punkte, die für eine positive Antwort vergeben werden.')
                    ->required()
                    ->numeric()
                    ->default(1)
                    ->minValue(0),
                Textarea::make('help_text')
                    ->label('Hilfstext')
                    ->helperText('Optionaler Hilfstext, der bei der Frage angezeigt wird.')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('metadata')
                    ->label('Zusätzliche Metadaten')
                    ->helperText('Optionale JSON-Metadaten für erweiterte Funktionen.')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
