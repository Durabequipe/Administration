<button id="{{ $video->id  }}" type="button" class="draggable border"
        style="width:150px;height:150px;position: absolute; transform: translate3d({{ $video->position_x }}px, {{ $video->position_y  }}px, 1px)">{{ $video->name  }}</button>
