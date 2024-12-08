<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use App\Models\Setting;
use Filament\Forms;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;

class EditSetting extends EditRecord
{
    protected static string $resource = SettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    public function mount($record): void
    {
        parent::mount($record);

        // Rellenar valores del formulario
        $relatedSettings = [
            'days_active' => 'days_enabled',
            'max_reservation_active' => 'max_reservation'
        ];

        $currentKey = $this->record->key;
        $relatedKey = array_search($currentKey, $relatedSettings) ?:
            array_search($currentKey, array_flip($relatedSettings));

        if ($relatedKey) {
            $relatedSetting = Setting::where('key', $relatedKey)->first();
            if ($relatedSetting) {
                $this->form->fill([
                    'value' => $this->record->value == '1',
                    'related_value' => $relatedSetting->value,
                ]);
            }
        } else {
            $this->form->fill([
                'value' => $this->record->value == '1',
            ]);
        }
    }


    public function form(Form $form): Form
    {
        $fieldType = $this->record->type;

        $relatedSettings = [
            'days_active' => 'days_enabled',
            'max_reservation_active' => 'max_reservation'
        ];

        if (
            in_array($this->record->key, array_keys($relatedSettings)) ||
            in_array($this->record->key, array_values($relatedSettings))
        ) {

            $currentKey = $this->record->key;
            $relatedKey = array_search($currentKey, $relatedSettings) ?:
                array_search($currentKey, array_flip($relatedSettings));


            $relatedSetting = Setting::where('key', $relatedKey)->first();

            $formSchema = [
                Forms\Components\Section::make(__('config.info_1'))
                    ->description($this->record->description)
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([

                                Forms\Components\Toggle::make('value')
                                    ->label(__('config.' . $this->record->key))
                                    ->default((string)$this->record->value == '1') // Compara el valor como cadena
                                    ->inline(false)
                                    ->live()
                                    ->afterStateUpdated(function ($state) {
                                        $this->record->value = $state ? '1' : '0'; // Almacena como cadena '1' o '0'
                                        $this->record->save();
                                    }),

                                Forms\Components\TextInput::make('related_value')
                                    ->label(__('config.' . $relatedSetting->key))
                                    ->numeric()
                                    ->required()
                                    ->disabled(fn() => $this->record->value != '1')
                                    ->dehydrated(fn() => $this->record->value == '1')
                                    ->extraAttributes(fn() => [
                                        'class' => $this->record->value != '1' ? 'opacity-50' : ''
                                    ])
                                    ->afterStateUpdated(function ($state) use ($relatedSetting) {
                                        $relatedSetting->value = $state;
                                        $relatedSetting->save();
                                    })

                            ]),
                    ])
            ];
        } else {

            $formSchema = [
                Forms\Components\Section::make(__('config.info_1'))
                    ->description($this->record->description)
                    ->schema([
                        Forms\Components\Grid::make(1)
                            ->schema([
                                $this->getFieldByType($fieldType)
                            ]),
                    ])
            ];
        }

        return $form->schema($formSchema);
    }



    private function getFieldByType(string $type)
    {
        switch ($type) {
            case 'boolean':
                return Forms\Components\Toggle::make('value')
                    ->label(__('config.' . $this->record->key))
                    ->default($this->record->value == 1)
                    ->inline(false)
                    ->columnSpan(1)
                    ->afterStateUpdated(function ($state) {
                        $this->record->value = $state ? '1' : '0';
                    });

            case 'integer':
                return Forms\Components\TextInput::make('value')
                    ->label(__('config.' . $this->record->key))
                    ->numeric()
                    ->required()
                    ->columnSpan(1);

            case 'image':
                return Forms\Components\FileUpload::make('value')
                    ->label(__('config.' . $this->record->key))
                    ->image()
                    ->directory('logos')
                    ->disk('public')
                    ->columnSpan(1)
                    ->required();

            case 'string':
            default:
                return Forms\Components\TextInput::make('value')
                    ->label(__('config.' . $this->record->key))
                    ->required()
                    ->columnSpan(1);
        }
    }
}
