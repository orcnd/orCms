<tr>
    @foreach ($columns as $column => $columnData)
    @php $col=$columnData['name'] @endphp
    <td>

        @if ($columnData['type'] == 'text')
        {{$row[$col]}}
        @endif

        @if ($columnData['type'] == 'textarea')
        {{Str::limit($row[$col],200)}}
        @endif

        @if ($columnData['type'] == 'select')
        {{$row[$col]}}
        @endif
    </td>
    @endforeach
    <td>
    @if (isset($actions))
    <div class="btn-group" role="group" aria-label="Basic example">

        @foreach ($actions as $action)
            @if ($action['route'] == 'destroy')
            <form action="{{route($routeNamePrefix.'.'.$action['route'],$row)}}" method="POST" onsubmit="return confirm('{{__('Are you sure to delete this item')}}')">
                @csrf
                <button type="submit" class="btn btn-danger">{{$action['text']}}</button>
            </form>
            @else
                <a href="{{route($routeNamePrefix.'.'.$action['route'],$row)}}" class="btn btn-secondary">{{$action['text']}}</a>
            @endif
        @endforeach
        @endif
    </div>
    </td>
</tr>
