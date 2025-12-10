<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PhoneSelectable extends Component
{
    public string $name;
    public string $label;
    public string $placeholder;
    public string $value;
    public bool $required;

    public array $countries;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $name = 'phone',
        string $label = 'Phone',
        string $placeholder = 'Phone',
        string $value = '',
        bool $required = true
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->required = $required;

        // PH only
        $this->countries = [
            (object)[
                'iso2'       => 'PH',
                'name'       => 'Philippines',
                'emoji'      => '🇵🇭',
                'phone_code' => '63',
            ],
        ];
    }

    /**
     * Render the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.phone-selectable', [
            'countries' => $this->countries,
        ]);
    }
}
