<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use App\Models\Task;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Gate;

class ListTasks extends ListRecords
{
    protected static string $resource = TaskResource::class;
    public static function canView(): bool
    {
        return Gate::allows('view', Task::class);  // استفاده از Gate برای بررسی دسترسی
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
