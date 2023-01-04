@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header card-header-primary">
            <h4 class="card-title">
                {{ trans('global.edit') }} {{ __('Event Images') }}
            </h4>
        </div>
        <div class="card-body">
            <div class="raw">
                <div class="col-md-12">
                    <form action="{{ route('admin.events.add_event_images', $id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf


                        <input type="hidden" name="event_id" value="{{ $id }}" />
                        <div class="form-group {{ $errors->has('event_title') ? 'has-error' : '' }}">
                            <h3 for="title">{{ $event->event_title }}</h3>
                        </div>


                        <div class=" {{ $errors->has('featured_image') ? 'has-error' : '' }}">
                            <label for="title">{{ __('Event Featured Image') }}</label>
                            <input type="file" id="featured_image" name="featured_image" class="form-control"
                                value=''>
                            @if ($errors->has('featured_image'))
                                <p class="help-block text-danger">
                                    {{ $errors->first('featured_image') }}
                                </p>
                            @endif

                        </div>
                        <div>
                            <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="header">Gallery</h2>
        </div>


        <div class="card-body">
            <div class="raw">
                <div class="col-md-12">
                    <table>
                        <thead>
                            <tr>
                               
                                <th>
                                    Title
                                </th>
                                <th>
                                    Image
                                </th>
                                <th>
                                    Action
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            @if ($event_images->count())
                                @foreach ($event_images as $key => $images)
                                    @if (!empty($images->featured_image))
                                        <tr data-entry-id="">
                                            <td>
                                                {{ $images->featured_image }}
                                            </td>
                                            <td>
                                                
                                                
                                                <a href="{{ URL(asset('images/EventImage/' . $images->id . '/' . $images->featured_image)) }}"
                                                    target="_blank"><img
                                                        src="{{ URL(asset('images/EventImage/' . $images->id .'/' . $images->featured_image)) }}"
                                                        width="50" /></a>
                                                

                                            </td>

                                            <td>
                                                <a class="btn btn-xs btn-danger"
                                                    href="{{ route('admin.events.delete_images', [$images->event_id,$images->id]) }}">Delete</a>
                                            </td>


                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection


{{-- Lorem ipsum dolor sit amet consectetur adipisicing elit. Error officiis, voluptas ducimus libero enim qui molestias dicta ipsa tempore. Ab, labore aliquid suscipit optio rem incidunt? Officia voluptates itaque voluptas. --}}
