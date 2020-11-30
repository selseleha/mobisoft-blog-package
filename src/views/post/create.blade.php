@extends('blog::layouts.livewire')


@section('content')
    <br>
    <div class="container">

            <form method="post" action="{{route('post.store')}}" enctype="multipart/form-data">
                <div class="form-group">
                   @csrf
                    <label for="title">Title:</label>
                    <input type="text" class="form-control" name="title" value="{{old('title')}}"/>
                </div>

                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea cols="10" rows="10" class="form-control" name="content">{{old('content')}}</textarea>
                </div>

                <div class="form-group">
                    <input type="file" name="image" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
    </div>
@endsection
