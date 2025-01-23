<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Filament\Resources\TaskResource\RelationManagers;
use App\Http\Middleware\TaskMiddleware;
use App\Models\Task;
use App\Policies\TaskPolicy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;
    protected static ?string $navigationLabel = 'Tasks';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static bool $shouldSkipAuthorization = true;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('start_date')
                    ->required(),
                Forms\Components\DatePicker::make('due_date')
                    ->required(),
                Forms\Components\Select::make('priority')
                    ->options([
                        'low' => 'Low',
                        'medium' => 'Medium',
                        'high' => 'High',
                    ])
                    ->required(),
            Forms\Components\Select::make('user_id')
                ->label('User')
                ->required()
                ->relationship('user', 'name') // 'user' is the relation method, 'name' is the column displayed
                ->searchable(),
                
                Forms\Components\Toggle::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                    Tables\Columns\TextColumn::make('due_date')
                    ->label('Remaining Time')
                    ->getStateUsing(function ($record) {
                        return $record->days_remaining; // Access the 'getDaysRemainingAttribute' accessor
                    })
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('priority')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
             
                    // فیلتر اول برای اولویت
                    Tables\Filters\Filter::make('priority')
                        ->form([
                            Forms\Components\Select::make('priority')
                                ->options([
                                    'low' => 'Low',
                                    'medium' => 'Medium',
                                    'high' => 'High',
                                ])
                                ->placeholder('Select priority'), // افزودن placeholder
                        ]),
                
                    // فیلتر دوم برای وضعیت
                    Tables\Filters\Filter::make('status')
                        ->form([
                            Forms\Components\Toggle::make('status')
                                ->label('Active/Inactive'), // افزودن لیبل برای راحتی بیشتر
                        ]),
                
                    // فیلتر تاریخ
                    Tables\Filters\Filter::make('date_range')
                        ->form([
                            Forms\Components\DatePicker::make('start_date')->placeholder('Start Date'),
                            Forms\Components\DatePicker::make('due_date')->placeholder('Due Date'),
                        ])
                        ->query(function (Builder $query, array $data) {
                            // فیلتر ساده با مقایسه تاریخ‌ها
                            if (!empty($data['start_date'])) {
                                $query->where('start_date', '>=', $data['start_date']);
                            }
                            if (!empty($data['due_date'])) {
                                $query->where('due_date', '<=', $data['due_date']);
                            }
                            return $query;
                        }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }
}
