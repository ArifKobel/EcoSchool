<?php

namespace App\Filament\Resources\Categories\Resources\Questions\Pages;

use App\Filament\Resources\Categories\Resources\Questions\QuestionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateQuestion extends CreateRecord
{
    protected static string $resource = QuestionResource::class;
}
