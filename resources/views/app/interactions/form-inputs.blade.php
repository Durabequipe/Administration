@php $editing = isset($interaction) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.number
            name="delay"
            label="Delay"
            :value="old('delay', ($editing ? $interaction->delay : ''))"
            max="255"
            placeholder="Delay"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="position"
            label="Position"
            :value="old('position', ($editing ? $interaction->position : ''))"
            maxlength="255"
            placeholder="Position"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
