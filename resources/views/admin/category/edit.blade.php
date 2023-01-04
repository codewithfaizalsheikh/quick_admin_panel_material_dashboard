@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            {{ trans('global.update') }} {{ __("Category") }}
        </h4>
    </div>

    <div class="card-body">
        <form action="{{route('admin.category.update',$id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('category_name') ? 'has-error' : '' }}">
                <label for="title">{{ __("Category Name") }}*</label>
                <input type="text" id="category" name="category_name" class="form-control" value="{{ old('category_name', isset($category) ? $category->category_name : '') }}" >
                @if($errors->has('category_name'))
                    <p class="help-block text-danger">
                        {{ $errors->first('category_name') }}
                    </p>
                @endif
                
            </div>
            <div class="form-group {{ $errors->has('category_status') ? 'has-error' : '' }}">
                <label for="title">{{ __("Category status") }}*</label>
                <input type="text" id="category_status" name="category_status" class="form-control" value="{{ old('category_status', isset($category) ? $category->category_status : '') }}" >
                @if($errors->has('category_status'))
                    <p class="help-block text-danger">
                        {{ $errors->first('category_status') }}
                    </p>
                @endif
                
            </div>
            
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.update') }}">
            </div>
        </form>
    </div>

</div>

     


@endsection
