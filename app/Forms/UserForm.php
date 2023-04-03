<?php

namespace App\Forms;

use Filament\Forms\Components\TextInput;
use RalphJSmit\Tall\Interactive\Forms\Form;

class UserForm extends Form
{
    public function getFormSchema(): array
    {
        return [
            TextInput::make('firstname')
                ->label('Prénom')
                ->required()
        ];
    }

    public function submit(): void
    {
        //
    }

    public function mount(): void
    {
        //
    }

    /** Only applicable for Modals and SlideOvers */
    public function onOpen(): void
    {
        //
    }
}
