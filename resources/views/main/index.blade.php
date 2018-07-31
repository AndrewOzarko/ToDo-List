@extends('layout.app')

@section('title', 'ToDo List')

@section('body')
    <br>
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <h1>ToDo List</h1>
            </div>
            <div class="col-lg-3">
                <input type="text" id="search" placeholder="Search" class="form-control">
            </div>
            <div class="col-lg-2">
                <button type="button" id="addTask" class="btn btn-info" data-toggle="modal" data-target="#popup">Add task</button>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <ul class="list-group" id="items">
                    @forelse($tasks as $task)
                    <li data-toggle="modal" data-id="{{ $task->id }}" data-target="#popup" class="list-group-item d-flex justify-content-between align-items-center my-item">
                        {{ $task->body }}
                    </li>
                    @empty
                        No tasks
                    @endforelse
                </ul>
            </div>
        </div>

        <div id="popup" class="modal fade">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            {{ csrf_field() }}
                            <fieldset>
                                <div class="form-group">
                                    <textarea name="body" class="form-control my-task-text" rows="3"></textarea>
                                    <input type="hidden" id="item-id">
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal" id="delete" style="display: none">Delete</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" id="save" style="display: none">Save changes</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" id="addBtn">Add</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')

    <script>

        function isEmpty(str) {
            if (str.trim() == '')
                return true;

            return false;
        }

        $(function() {

            $('#addTask').on('click', function() {
                $('.modal-title').text('Add task');
                $('.my-task-text').text('');
                $('#delete').hide(400);
                $('#save').hide(400);
                $('#addBtn').show(400);
            });

            $(document).on('click', '.my-item', function() {

                    $('.modal-title').text('Edit task');

                    var text = $.trim($(this).text());
                    var id = $(this).attr('data-id');

                    $('.my-task-text').text(text);
                    $('#item-id').val(id);
                    $('#delete').show(400);
                    $('#save').show(400);
                    $('#addBtn').hide(400);

            });

            $('#addBtn').on('click', function () {
                var text = $('.my-task-text').val();

                if(isEmpty(text)) {
                    return false;
                }

                $.ajax({
                    url: '/create',
                    type: 'post',
                    data: {
                        'text': text,
                        '_token': $('input[name=_token]').val()
                    },
                    success: function (data) {
                        console.log(data);
                        $('#items').load(location.href + ' #items');
                    }
                });

            });

            $('#delete').on('click', function() {
                var id = $('#item-id').val();

                if(isEmpty(id)) {
                    return false;
                }

                $.ajax({
                    url: 'delete',
                    type: 'post',
                    data: {
                        'id': id,
                        '_token': $('input[name=_token]').val(),
                    },
                    success: function(data) {
                        console.log(data);
                        $('#items').load(location.href + ' #items');
                    }
                });
                
            });
            
            $('#save').on('click', function () {
                var id = $('#item-id').val();
                var text = $('textarea[name=body]').val();

                if(isEmpty(id) || isEmpty(text)) {
                    return false;
                }

                $.ajax({
                    url: 'update',
                    type: 'post',
                    data: {
                        'id': id,
                        'text': text,
                        '_token': $('input[name=_token]').val()
                    },
                    success: function (data) {
                        $('#items').load(location.href + ' #items');
                        console.log(data);
                    }
                });
            });

            // search



            $('#search').on('click', function () {
                $.ajax({
                    url: 'api/search',
                    type: 'get',
                    success: function (data) {
                        $( "#search" ).autocomplete({
                            source: data
                        });
                    }
                });
            });

        });
    </script>
@endpush
