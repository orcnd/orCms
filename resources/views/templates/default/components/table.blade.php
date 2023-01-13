<table class="table table-striped">
    <thead>
        <tr>
            @foreach ($columns as $column => $columnData)
            <th scope="col">{{__($columnData['text'])}}</th>
            @endforeach
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach($data as $d)
        @include('templates.default.components.tableRow',['routeNamePrefix'=>$routeNamePrefix,'actions'=>$actions,'columns'=>$columns,'row'=>$d])
    @endforeach
    </tbody>
</table>
