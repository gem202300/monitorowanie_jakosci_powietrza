<?php

namespace App\Livewire\Parameters;

use App\Models\Parameter;
use Livewire\Component;
use WireUi\Traits\WireUiActions;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ParameterForm extends Component
{
    use AuthorizesRequests, WireUiActions;

    public ?Parameter $parameter;
    public $name = '123';
    public $label = '123';
    public $unit = '123';
    public $valueType = '123';

    public function mount(Parameter $parameter = null)
{
    $this->parameter = $parameter ?? new Parameter();

    $this->parameters = Parameter::all()->map(function ($param) {
        return [
            'id' => $param->id,
            'label' => "{$param->label} ({$param->unit})",
        ];
    })->toArray();

    if ($this->parameter->exists) {
        $this->name = $this->parameter->name;
        $this->label = $this->parameter->label;
        $this->unit = $this->parameter->unit;
        $this->valueType = $this->parameter->valueType;
    }
}

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'label' => ['required', 'string', 'max:255'],
            'unit' => ['required', 'string', 'max:255'],
            'valueType' => ['required', 'numeric', 'min:-180', 'max:180'],
        ];
    }

    public function validationAttributes()
    {
        return [
            'name' => __('parameter_forma.attributes.name'),
            'label' => __('parameter_forma.attributes.label'),
            'unit' => __('parameter_forma.attributes.unit'),
            'valueType' => __('parameter_forma.attributes.valueType'),
        ];
    }

    public function submit()
    {
        if ($this->parameter->exists) {
            $this->authorize('update', $this->parameter);
        } else {
            $this->authorize('create', Parameter::class);
        }

        $this->valueType = str_replace(',', '.', $this->valueType);

        $this->validate();
        
        $parameter = Parameter::updateOrCreate(
            ['id' => $this->parameter->id ?? null],
            $this->only(['name', 'label', 'unit', 'valueType'])
        );

        flash(
            $this->parameter->exists
                ? __('translation.messages.successes.updated_title')
                : __('translation.messages.successes.stored_title'),
            $this->parameter->exists
                ? __('parameters.messages.successes.updated', ['name' => $this->name])
                : __('parameters.messages.successes.stored', ['name' => $this->name]),
            'success'
        );

        return redirect()->route('parameters.index');
    }
    

 
    public function render()
    {
        return view('livewire.parameters.parameter-form');
    }
}
