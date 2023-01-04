@extends('layouts.admin')
@section('content')


<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            {{ trans('global.edit') }} {{ __("Event") }}
        </h4>
    </div>

        <form action="{{ route('admin.events.update',$id) }}" method="POST" enctype="multipart/form-data">
            @csrf


            <input type="hidden" name="event_id" value="{{$id}}" />
            <div class="form-group ">
                @if($user_role == 'Admin')
                <label for="user_id">{{__('Event Manager') }}*</label>
                
                    <select name="user_id" id="user_id" class="form-control select2" >
                        <option value="" >Select manager</option>
                        @if(count($managers))
                            @foreach($managers as $key => $manager)
                                <option value="{{ $key}}" @if($key == $event->user_id) selected @endif >{{$manager}}</option>
                            @endforeach
                        @endif
                    </select>
                @else
                    <input type="hidden" name="user_id" id="user_id" value="{{ $event->user_id}}" />
                    
                @endif
                
            </div>


            <div class="form-group {{ $errors->has('event_title') ? 'has-error' : '' }}">
                <label for="title">{{ __("Event Title") }}*</label>
                <input type="text" id="event_title" name="event_title" class="form-control" value="{{ old('title', isset($event) ? $event->event_title : '') }}" >
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
                <label for="event_status">{{ __("Event status") }}*</label>
                {{-- {<label for="event_status_1"> --}}
                    {{-- <input type="radio" id="event_status_1" name="event_status" class="form-control" @if($event->event_status == 1) checked @endif value="1" />
                    Yes
                </label>
                <label for="event_status_0">
                    <input type="radio" id="event_status_0" name="event_status" class="form-control" @if($event->event_status == 0) checked @endif value="0" />
                    No
                </label> --}}

                <select name="event_status" id="event_status" class="form-control_" >
                    <option value="0" @if($event->event_status == 0) selected @endif >No</option>
                    <option value="1" @if($event->event_status == 1) selected @endif >Yes</option>
                </select>
                @if($errors->has('event_title'))
                    <p class="help-block text-danger">
                        {{ $errors->first('event_status') }}
                    </p>
                @endif
            </div>

          
            
                
            
             <div class="form-group {{ $errors->has('event_description') ? 'has-error' : '' }}">
                <label for="title">{{ __("Event Description") }}</label>
                <textarea class="form-control" id="event_description" name="event_description" rows="3" value="{{ old('event_description', isset($event_detail) ? $event_detail->event_description : '') }}"></textarea>
                {{-- <input type="text" id="event_description" name="event_description" class="form-control" value="{{ old('event_description', isset($event_detail) ? $event_detail->event_description : '') }}" > --}}
                @if($errors->has('event_info'))
                    <p class="help-block text-danger">
                        {{ $errors->first('event_description') }}
                    </p>
                @endif
                
            </div>
             <div class="form-group {{ $errors->has('event_info') ? 'has-error' : '' }}">
                <label for="title">{{ __("Event Info") }}</label>
                <textarea class="form-control" id="event_detail" name="event_detail" rows="2" value="{{ old('event_detail', isset($event_detail) ? $event_detail->event_info : '') }}"></textarea>
                {{-- <input type="text" id="event_info" name="event_info" class="form-control" value="{{ old('event_info', isset($event_detail) ? $event_detail->event_info : '') }}" > --}}
                @if($errors->has('event_info'))
                    <p class="help-block text-danger">
                        {{ $errors->first('event_info') }}
                    </p>
                @endif
                
            </div>
            <div class=" {{ $errors->has('featured_image') ? 'has-error' : '' }}">
                <label for="title">{{ __("Event Featured Image") }}</label>
                <input type="file" id="featured_image" name="featured_image" class="form-control" value='' >
                @if($errors->has('featured_image'))
                    <p class="help-block text-danger">
                        {{ $errors->first('featured_image') }}
                    </p>
                @endif
                
            </div>
            <div class="form-group {{ $errors->has('short_desc') ? 'has-error' : '' }}">
                <label for="title">{{ __("Short Description") }}</label>
                <input type="text" id="short_desc" name="short_desc" class="form-control" value="{{ old('short_desc', isset($event_detail) ? $event_detail->short_desc : '') }}" >
                @if($errors->has('short_desc'))
                    <p class="help-block text-danger">
                        {{ $errors->first('short_desc') }}
                    </p>
                @endif
                
            </div>
            <div class="form-group {{ $errors->has('event_price') ? 'has-error' : '' }}">
                <label for="title">{{ __("Event Price") }}</label>
                <input type="text" id="event_price" name="event_price" class="form-control" value="{{ old('event_price', isset($event_detail) ? $event_detail->event_price : '') }}" >
                @if($errors->has('event_price'))
                    <p class="help-block text-danger">
                        {{ $errors->first('event_price') }}
                    </p>
                @endif
                
            </div>
            
           
            <div class="form-group">
                <label for="event_category_id">{{__('Event Category') }}*
                <select name="event_category_id" id="event_category_id" class="form-control select2" >
                    @if($cat->count())
                    @foreach($cat as $key => $data)
                    
                        <option value="{{ $data->id}}" @if($data->id == $event->event_category_id) selected @endif >{{$data->category_name}}</option>
                    @endforeach
                </select>
                
                @endif
                
            </div>
            




            <div>


                <input class="btn btn-danger" type="submit" value="{{ trans('global.update') }}">
            </div>
        </form>
    </div>


</div>
@endsection


{{-- Lorem ipsum dolor sit amet consectetur adipisicing elit. Error officiis, voluptas ducimus libero enim qui molestias dicta ipsa tempore. Ab, labore aliquid suscipit optio rem incidunt? Officia voluptates itaque voluptas. --}}