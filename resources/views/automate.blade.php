@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><a href="/board/{{ $Board->getId() }}">Board <b>{{ $Board->getName() }}</b></a> / List <b>{{ $List['name'] }}</b> </div>

                    <div class="panel-body">

                        <a href="/board/{{ $Board->getId() }}/automate/{{ $List['id'] }}/new" class="btn btn-primary">
                            New record
                        </a> <br><br>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Frenquecy</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(count($Automates) > 0)
                                @foreach($Automates as $Automate)
                                    <tr>
                                        <td>{{ $Automate->title }}</td>
                                        <td>{{ $Automate->getFrequency() }}</td>
                                        <td data-id="{{ $Automate->id }}">
                                            <a href="#" onclick="deleteItem({{ $Automate->id }})">Delete</a> |
                                            <a href="/board/{{ $Board->getId() }}/automate/{{ $List['id'] }}/{{ $Automate->id }}">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3">
                                        No records found. <a href="/board/{{ $Board->getId() }}/automate/{{ $List['id'] }}/new">Click here</a> to create a record.
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>

                    </div>
            </div>
        </div>
    </div>

    <script>
        function deleteItem (id) {

            if ( confirm('Are you sure you want to delete the record?') ) {

                $.ajax({
                    url: '/board/{{ $Board->getId() }}/automate/{{ $List['id'] }}/' + id + '/delete',
                    type: 'POST',
                    data: {
                      _token: '{{ csrf_token() }}'
                    },
                    success: function () {
                        window.location = '/board/{{ $Board->getId() }}/automate/{{ $List['id'] }}';
                    },
                    error: function () {
                        alert('Error deleting record');
                    }
                });
            }

            return false;
        }
    </script>
@endsection
