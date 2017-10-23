@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Setup - <i>Trello</i></div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('setup') }}">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="api_key" class="col-md-4 control-label">API Key</label>

                                <div class="col-md-6">
                                    <input id="api_key" type="text" class="form-control" name="api_key" required autofocus>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="token" class="col-md-4 control-label">Token</label>

                                <div class="col-md-6">
                                    <input id="token" type="text" class="form-control" name="token" required autofocus>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="username" class="col-md-4 control-label">Username</label>

                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control" name="username" required autofocus>
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
    </div>
@endsection
