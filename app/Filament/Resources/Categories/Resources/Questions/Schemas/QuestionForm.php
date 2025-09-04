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
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->required(),
                TextInput::make('points')
                    ->required()
                    ->numeric()
                    ->default(1),
                Textarea::make('help_text')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('metadata')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
