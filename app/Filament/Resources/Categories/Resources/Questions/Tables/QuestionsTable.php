<?php

namespace App\Filament\Resources\Categories\Resources\Questions\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class QuestionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('order')
            ->columns([
                TextColumn::make('order')
                    ->label('↑↓')
                    ->badge()
                    ->color('primary'),
                TextColumn::make('question_text')
                    ->label('Frage')
                    ->searchable()
                    ->limit(50),
                IconColumn::make('is_active')
                    ->label('Aktiv')
                    ->boolean(),
                TextColumn::make('points')
                    ->label('Punkte')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Erstellt')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Aktualisiert')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('moveUp')
                    ->label('↑')
                    ->icon('heroicon-o-chevron-up')
                    ->color('gray')
                    ->action(function ($record) {
                        $record->moveOrderUp();
                    })
                    ->visible(fn ($record) => $record->order > 1),
                Action::make('moveDown')
                    ->label('↓')
                    ->icon('heroicon-o-chevron-down')
                    ->color('gray')
                    ->action(function ($record) {
                        $record->moveOrderDown();
                    }),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
