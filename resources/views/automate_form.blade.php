@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><a href="/board/{{ $Board->getId() }}">Board <b>{{ $Board->getName() }}</b></a> / List <b>{{ $List['name'] }}</b> </div>

                    <div class="panel-body">

                        <form class="form-horizontal" method="POST" action="/board/{{ $Board->getId() }}/automate/{{ $List['id'] }}/{{ $id_automate }}/save">

                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="title" class="col-md-4 control-label">Title</label>

                                <div class="col-md-6">
                                    <input id="title" type="text" class="form-control" name="title" value="{{ $Automate->title }}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="col-md-4 control-label">Description</label>

                                <div class="col-md-6">
                                    <textarea id="description" type="text" class="form-control" name="description">{{ $Automate->description }}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="frequency" class="col-md-4 control-label">Frequency</label>

                                <div class="col-md-6">
                                    <select id="frenquency" type="text" class="form-control" name="frequency">
                                        <option value="1"{{ $Automate->frequency == 1 ? ' selected' : '' }}>Daily</option>
                                        <option value="2"{{ $Automate->frequency == 2 ? ' selected' : '' }}>Weekly</option>
                                        <option value="3"{{ $Automate->frequency == 3 ? ' selected' : '' }}>Monthly</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
@endsection
