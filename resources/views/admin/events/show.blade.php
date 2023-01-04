@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header card-header-primary">
            <h4 class="card-title">
                {{ trans('global.show') }} {{ trans('cruds.role.title') }}
            </h4>
        </div>

        <div class="card-body">
            <div class="mb-2">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                {{ __('ID') }}
                            </th>
                            <td>
                                {{ $event->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ __('User ID') }}
                            </th>
                            <td>
                                {{ $event->user_id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Event Id
                            </th>
                            <td>
                                {{ $event->event_id }}

                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ __('Event Title') }}
                            </th>
                            <td>
                                {{ $event->event_title }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Event category id
                            </th>
                            <td>
                                {{ $event->event_category_id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Event Category
                            </th>
                            <td>

                                {{ $event->category_name }}

                            </td>
                        </tr>
                        <tr>
                            <th>
                                Start Date
                            </th>
                            <td>
                                {{ date('dM,Y', strtotime($event->start_date)) }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                End Date
                            </th>
                            <td>
                                {{ date('dM,Y', strtotime($event->end_date)) }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Status
                            </th>
                            <td>
                                @if ($event->event_status == 1)
                                    <span style="color: green;">Yes</span>
                                @else
                                    <span style="color: red;">No</span>
                                @endif

                            </td>
                        </tr>

                        <tr>
                            <th>
                                Event Featured Image
                            </th>
                            <td>
                                @if (!empty($event->featured_image))
                                    <a href="{{ URL(asset('images/Event/' . $event->event_id . '/' . $event->featured_image)) }}"
                                        target="_blank"><img
                                            src="{{ URL(asset('images/Event/' . $event->event_id . '/' . $event->featured_image)) }}"
                                            width="50" /></a>
                                @else
                                <a href="{{ URL(asset('images/featured_image.png')) }}"
                                    target="_blank"><img
                                        src="{{ URL(asset('images/featured_image.png')) }}"
                                        width="50" /></a>

                                @endif

                            </td>
                        </tr>
                       
                        <tr>
                            <th>
                                Event Description
                            </th>
                            <td>
                                {{ $event->event_description }}

                            </td>
                        </tr>
                        <tr>
                            <th>
                                Event Info
                            </th>
                            <td>
                                {{ $event->event_info }}

                            </td>
                        </tr>
                        <tr>
                            <th>
                                Event Short Description
                            </th>
                            <td>
                                {{ $event->short_desc  }}

                            </td>
                        </tr>
                        <tr>
                            <th>
                                Event Price
                            </th>
                            <td>
                                {{ $event->event_price }}

                            </td>

                        </tr>
                        <tr>
                            <th>
                                Images
                            </th>
                            <td> {{$event->image}}
                                @if (!empty($event->image))
                                    
                                    <a href="{{ URL(asset('images/EventImage/' . $event->id . '/' . $event->image)) }}"
                                        target="_blank"><img
                                            src="{{ URL(asset('images/EventImage/' . $event->id . '/' . $event->image)) }}"
                                            width="50" /></a>
                                @else
                                <a href="{{ URL(asset('images/featured_image.png')) }}"
                                    target="_blank"><img
                                        src="{{ URL(asset('images/featured_image.png')) }}"
                                        width="50" /></a>

                                @endif

                            </td>
                            
                        </tr>
                        </tr>
                    </tbody>
                </table>
                <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>

            <nav class="mb-3">
                <div class="nav nav-tabs">

                </div>
            </nav>
            <div class="tab-content">

            </div>
        </div>
    </div>
@endsection
