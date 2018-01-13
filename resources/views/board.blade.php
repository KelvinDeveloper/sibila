@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Board <b>{{ $Board->getName() }}</b></div>

                    <div class="panel-body">

                        <div class="form-group board-configuration">

                            <!--Backlog-->
                            <label for="backlog-list">Backlog list</label>

                            <select name="list_backlog-list" class="form-control save-settings">
                                <div class="col-md-6">
                                    <option value="">Select</option>
                                @foreach($Lists as $List)
                                    <option id="backlog-list" value="{{ $List['id'] }}" {{ $List['id'] == $Settings->list_backlog_id ? 'selected': '' }}>{{ $List['name'] }}</option>
                                @endforeach
                                </div>
                            </select> <br>

                            <!--Sprint-->
                            <label for="sprint-list">Sprint list</label>

                            <select name="list_sprint-list" class="form-control save-settings">
                                <div class="col-md-6">
                                    <option value="">Select</option>
                                @foreach($Lists as $List)
                                        <option id="sprint-list" value="{{ $List['id'] }}" {{ $List['id'] == $Settings->list_sprint_id ? 'selected': '' }}>{{ $List['name'] }}</option>
                                    @endforeach
                                </div>
                            </select> <br>

                            <!--Doing-->
                            <label for="doing-list">Doing list</label>

                            <select name="list_doing-list" class="form-control save-settings">
                                <div class="col-md-6">
                                    <option value="">Select</option>
                                @foreach($Lists as $List)
                                        <option id="doing-list" value="{{ $List['id'] }}" {{ $List['id'] == $Settings->list_doing_id ? 'selected': '' }}>{{ $List['name'] }}</option>
                                    @endforeach
                                </div>
                            </select> <br>

                            <!--Done-->
                            <label for="done-list">Done list</label>

                            <select name="list_done-list" class="form-control save-settings">
                                <div class="col-md-6">
                                    <option value="">Select</option>
                                    @foreach($Lists as $List)
                                        <option id="done-list" value="{{ $List['id'] }}" {{ $List['id'] == $Settings->list_done_id ? 'selected': '' }}>{{ $List['name'] }}</option>
                                    @endforeach
                                </div>
                            </select> <br>

                            <label for="automate-list">Automate card creation</label>

                            <select name="automate-list" class="form-control">
                                <div class="col-md-6">
                                    <option value="">Select</option>
                                    @foreach($Lists as $List)
                                        <option id="automate-list">{{ $List['name'] }}</option>
                                    @endforeach
                                </div>
                            </select> <br>

                            <label for="automate-list">Select Task</label>

                            <select name="task_id" class="form-control save-settings">
                                <div class="col-md-6">
                                    <option value="">Select</option>
                                    @foreach($Settings->tasks as $task_id => $Task)
                                        <option id="task" value="{{ $task_id }}" {{ $task_id == $Settings->task_id ? 'selected' : '' }}>{{ $Task }}</option>
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

        $('select.save-settings').change(function () {

            $.ajax({
                url: '/board/{{ $id }}/settings/save',
                type: 'POST',
                data: {
                    'list_backlog_id': $('select[name="list_backlog-list"]').val(),
                    'list_sprint_id': $('select[name="list_sprint-list"]').val(),
                    'list_doing_id': $('select[name="list_doing-list"]').val(),
                    'list_done_id': $('select[name="list_done-list"]').val(),
                    'task_id': $('select[name="task_id"]').val(),
                    '_token': '{{ csrf_token() }}'
                },
                error: function () {
                    alert('Error saving record')
                }
            })
        });

        $('select[name="automate-list"]').change(function () {

            if ( $(this).val() == '' ) return false;

            return window.location="/board/{{ $id }}/automate/" + $(this).val();
        });
    });
    </script>
@endsection
