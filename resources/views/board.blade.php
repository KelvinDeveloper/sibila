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
                                    <option>Selecionar</option>
                                @foreach($Lists as $List)
                                    <option id="doing-list" value="{{ $List['id'] }}" {{ $List['id'] == $Settings->list_doing_id ? 'selected': '' }}>{{ $List['name'] }}</option>
                                @endforeach
                                </div>
                            </select> <br>

                            <label for="doing-list">Automate card creation</label>

                            <select name="automate-list" class="form-control">
                                <div class="col-md-6">
                                    <option>Selecionar</option>
                                    @foreach($Lists as $List)
                                        <option id="doing-list" value="{{ $List['id'] }}" {{ $List['id'] == $Settings->list_doing_id ? 'selected': '' }}>{{ $List['name'] }}</option>
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

        $('select[name="doing-list"]').change(function () {

            $.ajax({
                url: '/board/{{ $id }}/settings/save',
                type: 'POST',
                data: {
                    'list_doing_id': $(this).val(),
                    '_token': '{{ csrf_token() }}'
                },
                success: function () {
                    $('div.board-configuration').hide();
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
