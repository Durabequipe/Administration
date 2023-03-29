@php $editing = isset($interact) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select name="video_id" label="Video" required>
            @php $selected = old('video_id', ($editing ? $interact->video_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Video</option>
            @foreach($videos as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="link_to" label="Interact With" required>
            @php $selected = old('link_to', ($editing ? $interact->link_to : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Video</option>
            @foreach($videos as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="content"
            label="Content"
            maxlength="255"
            required
            >{{ old('content', ($editing ? $interact->content : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="position_id" label="Position" required>
            @php $selected = old('position_id', ($editing ? $interact->position_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Position</option>
            @foreach($positions as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
