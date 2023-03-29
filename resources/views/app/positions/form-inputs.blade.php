@php $editing = isset($position) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.number
            name="x"
            label="X"
            :value="old('x', ($editing ? $position->x : ''))"
            max="255"
            placeholder="X"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="y"
            label="Y"
            :value="old('y', ($editing ? $position->y : ''))"
            max="255"
            placeholder="Y"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="zindex"
            label="Zindex"
            :value="old('zindex', ($editing ? $position->zindex : ''))"
            max="255"
            placeholder="Zindex"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="type"
            label="Type"
            :value="old('type', ($editing ? $position->type : ''))"
            maxlength="255"
            placeholder="Type"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
