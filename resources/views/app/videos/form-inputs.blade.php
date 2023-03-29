@php $editing = isset($video) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select name="project_id" label="Project" required>
            @php $selected = old('project_id', ($editing ? $video->project_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Project</option>
            @foreach($projects as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="desktop_path"
            label="Desktop Path"
            :value="old('desktop_path', ($editing ? $video->desktop_path : ''))"
            maxlength="255"
            placeholder="Desktop Path"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <div
            x-data="imageViewer('{{ $editing && $video->desktop_thumbnail ? \Storage::url($video->desktop_thumbnail) : '' }}')"
        >
            <x-inputs.partials.label
                name="desktop_thumbnail"
                label="Desktop Thumbnail"
            ></x-inputs.partials.label
            ><br />

            <!-- Show the image -->
            <template x-if="imageUrl">
                <img
                    :src="imageUrl"
                    class="object-cover rounded border border-gray-200"
                    style="width: 100px; height: 100px;"
                />
            </template>

            <!-- Show the gray box when image is not available -->
            <template x-if="!imageUrl">
                <div
                    class="border rounded border-gray-200 bg-gray-100"
                    style="width: 100px; height: 100px;"
                ></div>
            </template>

            <div class="mt-2">
                <input
                    type="file"
                    name="desktop_thumbnail"
                    id="desktop_thumbnail"
                    @change="fileChosen"
                />
            </div>

            @error('desktop_thumbnail')
            @include('components.inputs.partials.error') @enderror
        </div>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.checkbox
            name="is_main"
            label="Is Main"
            :checked="old('is_main', ($editing ? $video->is_main : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>
</div>
