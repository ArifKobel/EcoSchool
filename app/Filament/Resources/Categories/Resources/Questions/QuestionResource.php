<?php

namespace App\Filament\Resources\Categories\Resources\Questions;

use App\Filament\Resources\Categories\CategoryResource;
use App\Filament\Resources\Categories\Pages\ManageCategoryQuestions;
use App\Filament\Resources\Categories\Resources\Questions\Pages\CreateQuestion;
use App\Filament\Resources\Categories\Resources\Questions\Pages\EditQuestion;
use App\Filament\Resources\Categories\Resources\Questions\Schemas\QuestionForm;
use App\Filament\Resources\Categories\Resources\Questions\Tables\QuestionsTable;
use App\Models\Question;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $parentResource = CategoryResource::class;

    public static function form(Schema $schema): Schema
    {
        return QuestionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QuestionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'create' => CreateQuestion::route('/create'),
            'edit' => EditQuestion::route('/{record}/edit')
        ];
    }
}
