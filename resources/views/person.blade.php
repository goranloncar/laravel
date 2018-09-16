@extends('layouts.app')

@section('fonts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if(session()->has('message'))
                    <p class="text-success">{{ session()->get('message') }}</p>
                @endif
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        <h1>People</h1>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button class="btn btn-success btn-add-person">Add Person</button>
                            </div>
                        </div>
                        <br>
                        <table class="table">
                            <tehad>
                                <th scope="col">Image</th>
                                <th scope="col">Name /Email</th>
                                <th scope="col">Actions</th>
                            </tehad>
                            <tbody>
                            @if(count($persons) > 0)
                                @foreach($persons as $person)
                                    <tr>
                                        <td>
                                            <?php
                                            if(isset($person->image)){
                                            ?>
                                            <div >
                                                <img class="img-responsive center-block" src=".{{$person->image}}" alt="{{$person->name}}" style="height: 50px;width:auto;">
                                            </div>
                                            <?php
                                            }

                                            ?>
                                        </td>
                                        <td>{{ $person->name }} / {{ $person->email }}</td>
                                        <td>
                                            <button type="button" class="btn btn-light btn-send-message" data-id={{$person->id}} data-toggle="tooltip" data-placement="top" title="Send email to {{$person->name}}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M0 3v18h24v-18h-24zm6.623 7.929l-4.623 5.712v-9.458l4.623 3.746zm-4.141-5.929h19.035l-9.517 7.713-9.518-7.713zm5.694 7.188l3.824 3.099 3.83-3.104 5.612 6.817h-18.779l5.513-6.812zm9.208-1.264l4.616-3.741v9.348l-4.616-5.607z"/></svg></button>
                                            <span data-toggle="tooltip" data-placement="top" title="Delete person: {{$person->name}}">
                                                <button type="button" class="btn btn-light"  data-href="{{route('delete',$person->id) }}" data-toggle="modal" data-target="#exampleModal">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M9 19c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5-17v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.315c0 .901.73 2 1.631 2h5.712zm-3 4v16h-14v-16h-2v18h18v-18h-2z" btn-delete-person/></svg>
                                                </button>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <br />
                <div class="card add-person">
                    <div class="card-header">Add Person</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="{{ action('PersonsController@store')}}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                        <label>Image: </label>
                                        <input type="file" name="image">
                                        @if ($errors->has('image'))
                                            <span class="help-block">
                                         <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label>* Name: </label>
                                        <input class="form-control" type="text" name="name" value="{{ old('name') }}">
                                        @if ($errors->has('name'))
                                            <span class="help-block alert-danger">
                                            <strong>{{ $errors->first('name') }}</strong>
                                         </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label>* Email: </label>
                                        <input class="form-control" type="text" name="email" value="{{ old('email') }}">
                                        @if ($errors->has('email'))
                                            <span class="help-block alert-danger">
                                    <strong>{{ $errors->first('email') }}</strong>
                                             </span>
                                        @endif
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 text-right">
                                            <button type="submit" class="btn btn-danger">Cancel</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-primary">Add</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="card send-message">
                    <div class="card-header">Send Message</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="{{ action('MemosController@store') }}" method="post">

                                    {{ csrf_field() }}

                                    <input type="hidden" name="user_id" value="{{auth()->user()->getAuthIdentifier()}}">
                                    <input type="hidden" name="person_id" id="personId" value="">

                                    <div class="form-group{{ $errors->has('memos') ? ' has-error' : '' }}">
                                        <label>* Message: </label>
                                        <textarea class="form-control" rows="3" name="memos">{{ old('memos') }}</textarea>
                                        @if ($errors->has('memos'))
                                            <span class="help-block alert-danger">
                                             <strong>{{ $errors->first('memos') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 text-right">
                                            <button type="submit" class="btn btn-danger">Cancel</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-primary">Send Message</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Person!!!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a type="button" href="" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('custom-js')
    <script>
        $(document).ready(function(){

            <!--show/hide elements-->
            $('.add-person').hide();
            $('.send-message').hide();
            $('.btn-add-person').click(function () {
                $('.send-message').hide();
                $('.add-person').show();
            });
            $('.btn-send-message').click(function () {
                $('.add-person').hide();
                $('.send-message').show();

                var id = $(this).data('id');
                $('#personId').val(id);
            });
            <!--modal-->
            $('#exampleModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var href = button.data('href');
                console.log(href);
                var modal = $(this)
                modal.find('.btn-danger').attr('href', href);

            });


        });
    </script>

    <!--tooltips-->
    <script>
        $(document).ready(function(){
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });
        });
    </script>

    <!--ckeditor-->
    <script src="https://cdn.ckeditor.com/4.10.1/standard/ckeditor.js"></script>
    <script>
        $(document).ready(function(){
            CKEDITOR.replace( 'memos' );
        });
    </script>
@endsection
