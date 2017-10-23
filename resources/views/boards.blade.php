<ul>
    @foreach($Boards as $Board)
        <li>{{ $Board['name'] }}</li>
    @endforeach
</ul>