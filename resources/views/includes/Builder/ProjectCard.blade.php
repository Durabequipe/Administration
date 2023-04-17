<div class="flex flex-col">
    <a href="{{ route('builder.show', $project) }}">
        <div class="col-span-1 border-2 h-96 rounded flex justify-center items-center">
            <div class="flex flex-col">
                {{ $project->name }}
                <br>
                <br>
                @if(!$project->is_active)
                    <i class="fas fa-eye-slash text-5xl"></i>
                @endif
            </div>

        </div>
    </a>

    <div class="flex justify-between">
        <form action="{{ route('builder.destroy', $project) }}" method="POST" class="">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-danger-500 hover:bg-danger-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-trash"></i>
                Supprimer
            </button>
        </form>

        <a href="{{ route('builder.edit', $project) }}"
           class="bg-warning-500 hover:bg-warning-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-edit"></i>
            Modifier
        </a>
    </div>
</div>
