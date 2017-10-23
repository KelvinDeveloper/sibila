@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Board <b>{{ $Board->getName() }}</b> <a href="#" class="material-icons board-configuration right">settings</a> </div>

                    <div class="panel-body">

                        <div class="form-group board-configuration">

                            <label for="doing-list">Doing list</label>

                            <select name="doing-list" class="form-control">
                                <div class="col-md-6">
                                @foreach($Lists as $List)
                                    <option id="doing-list" value="{{ $List['id'] }}">{{ $List['name'] }}</option>
                                @endforeach
                                </div>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function () {
        $('a.board-configuration').click(function () {
            $('div.board-configuration').toggle();
            return false;
        });
    });
    </script>
@endsection
