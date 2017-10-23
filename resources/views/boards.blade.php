<ul>
    @foreach($Boards as $Board)
        <li>
                <a href="/board/{{ $Board['id'] }}">
                        {{ $Board['name'] }}
                </a>
        </li>
    @endforeach
</ul>