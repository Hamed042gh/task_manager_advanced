<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use App\Models\Task;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Gate;

class EditTask extends EditRecord
{
    protected static string $resource = TaskResource::class;
    public static function canView(): bool
    {
        return Gate::allows('view', Task::class);  // استفاده از Gate برای بررسی دسترسی
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
