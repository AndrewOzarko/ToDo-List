@extends('layout.app')

@section('title', 'ToDo Lists')

@section('body')
    <br>
    <div class="container">
        <div class="row">
            <div class="col-lg-10">
                <h1>ToDo Lists</h1>
            </div>
            <div class="col-lg-2">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#popup">Add task</button>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <ul class="list-group">
                    @forelse($tasks as $task)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $task->body }}
                        <span class="badge badge-primary badge-pill">{{ $task->created_at->diffForHumans() }}</span>
                    </li>
                    @empty
                        No tasks
                    @endforelse
                </ul>
            </div>
        </div>

        <!--PopUp-->

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
                        <form action="/todo" method="post">
                            {{ csrf_field() }}
                            <fieldset>
                                <div class="form-group">
                                    <textarea name="body" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection