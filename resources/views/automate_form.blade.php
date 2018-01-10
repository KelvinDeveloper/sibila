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

                            <div class="form-group week_day" style="display: none">
                                <label for="week_day" class="col-md-4 control-label">Week day</label>

                                <div class="col-md-6">
                                    <select id="week_day" type="text" class="form-control" name="week_day">
                                        @foreach($Automate->weekDays as $key => $value)
                                            <option value="{{ $key }}"{{ $Automate->week_day == $key ? ' selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group month_day" style="display: none">
                                <label for="month_day" class="col-md-4 control-label">Month day</label>

                                <div class="col-md-6">
                                    <select id="month_day" type="text" class="form-control" name="month_day">
                                        @foreach($Automate->monthDays as $value)
                                            <option value="{{ $value }}"{{ $Automate->month_day == $value ? ' selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="col-md-4 control-label">Members</label>

                                <div class="col-md-6">
                                    @foreach($Members as $Member)
                                        <input name="members[]" type="checkbox" id="member-{{ $Member['id'] }}" value="{{ $Member['id'] }}" {{ strstr($Automate->members_id, $Member['id']) ? 'checked' : '' }}>
                                        <label for="member-{{ $Member['id'] }}">{{ $Member['fullName'] }}</label> <br>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="col-md-4 control-label">Labels</label>

                                <div class="col-md-6">
                                    <table>
                                    @foreach($Labels as $Label)
                                        <tr>
                                            <td><input name="labels[]" type="checkbox" id="label-{{ $Label['id'] }}" value="{{ $Label['id'] }}" {{ strstr($Automate->labels_id, $Label['id']) ? 'checked' : '' }}></td>
                                            <td><label class="trello-label {{ $Label['color'] }}" for="label-{{ $Label['id'] }}">{{ $Label['name'] }}</label></td>
                                        </tr>
                                    @endforeach
                                    </table>
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

        <script>

            $(document).ready(function () {

                $('#frenquency').change(function () {

                    $('.week_day, .month_day').hide();

                    if ($(this).val() == 2) {
                        $('.week_day').show();
                    }

                    else if ($(this).val() == 3) {

                        $('.month_day').show();
                    }
                });

                $('#frenquency').change();
            });
        </script>
@endsection
