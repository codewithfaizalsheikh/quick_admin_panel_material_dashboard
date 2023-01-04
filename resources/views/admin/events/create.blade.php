@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            {{ trans('global.add') }} {{ __("Event") }}
        </h4>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group ">
                @if($user_role == 'Admin')
                <label for="user_id">{{__('Event Manager') }}*</label>
                
                    <select name="user_id" id="user_id" class="form-control select2" >
                        <option value="" >Select manager</option>
                        @if(count($managers))
                            @foreach($managers as $key => $manager)
                                <option value="{{ $key}}"  >{{$manager}}</option>
                            @endforeach
                        @endif
                    </select>
                @else
                    <input type="hidden" name="user_id" id="user_id" value="" />
                @endif
                
            </div>

            <div class="form-group {{ $errors->has('event_title') ? 'has-error' : '' }}">
                <label for="title">{{ __("Event Title") }}*</label>
                <input type="text" id="event_title" name="event_title" class="form-control" value="{{ old('title', isset($event) ? $event->title : '') }}" >
                @if($errors->has('event_title'))
                    <p class="help-block text-danger">
                        {{ $errors->first('event_title') }}
                    </p>
                @endif
                
            </div>
            
            <div class="form-group {{ $errors->has('start_date') ? 'has-error' : '' }}">
                <label for="title">{{ __("Event Start Date") }}*</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ old('title', isset($event) ? $event->start_date : '') }}" >
                @if($errors->has('event_title'))
                    <p class="help-block text-danger">
                        {{ $errors->first('start_date') }}
                    </p>
                @endif
                
            </div>

            <div class="form-group {{ $errors->has('end_date') ? 'has-error' : '' }}">
                <label for="title">{{ __("Event End Date") }}*</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ old('title', isset($event) ? $event->end_date : '') }}" >
                @if($errors->has('event_title'))
                    <p class="help-block text-danger">
                        {{ $errors->first('end_date') }}
                    </p>
                @endif
                
            </div>
            <div class="form-group {{ $errors->has('event_status') ? 'has-error' : '' }}">
                <label for="title">{{ __("Event status") }}*</label>
                <input type="text" id="event_status" name="event_status" class="form-control" value="{{ old('title', isset($event) ? $event->event_status : '') }}" >
                @if($errors->has('event_title'))
                    <p class="help-block text-danger">
                        {{ $errors->first('event_status') }}
                    </p>
                @endif
                
            </div>
            <div class="form-group ">
                <label for="perevent_category_idmissions">{{__('Event Category') }}*<
                <select name="event_category_id" id="event_category_id" class="form-control select2" >
                    
                    @if($cat->count())

                        @foreach($cat as $key => $data)
                            
                            <option value="{{ $data->id}}"  >{{$data->category_name}}</option>
                        @endforeach
                        @endif
                </select>
                
                
                
            </div>
            
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>

</div>

     


@endsection
