@extends('layouts.admin')
@section('content')
    @can('event_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.events.create') }}">
                    {{ trans('global.add') }} {{ __('Event') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header card-header-primary">
            <h4 class="card-title">
                {{ __('Event') }} {{ trans('global.list') }}
            </h4>
        </div>


        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-striped table-hover datatable datatable-User">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                ID
                            </th>
                            <th>
                                Title
                            </th>
                            <th>
                                Category
                            </th>
                            @if ($user_role == 'Admin')
                                <th>User</th>
                            @endif
                            <th>
                                Start Date
                            </th>

                            <th>
                                End Date
                            </th>
                            <th>
                                Status
                            </th>

                            <th>Action</th>
                            <th>
                                Image
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($events->count())
                            @foreach ($events as $key => $event)
                                <tr data-entry-id="{{ $event->id }} ">
                                    <td>

                                    </td>
                                    <td>
                                        {{ $event->id }}
                                    </td>
                                    <td>
                                        {{ $event->event_title }}
                                    </td>
                                    <td>
                                        {{ $event->event_category_id }} --- {{ $event->category_name }}
                                    </td>
                                    @if ($user_role == 'Admin')
                                        <td>{{ $event->user_name }}</td>
                                    @endif
                                    <td>

                                        {{ date('dM,Y', strtotime($event->start_date)) }}
                                    </td>

                                    <td>
                                        @if ($event->end_date == '')
                                            <span>End date not declare</span>
                                        @else
                                            {{ date('dM,Y', strtotime($event->end_date)) }}
                                        @endif
                                    </td>
                                    <td>

                                        @if ($event->event_status == 1)
                                            <span class="badge badge-info">Yes</span>
                                        @else
                                            <span class="badge badge-danger">No</span>
                                        @endif

                                    </td>
                                    <td>
                                        @can('event_edit')
                                            <a class="btn btn-xs btn-primary"
                                                href="{{ route('admin.events.edit', $event->id) }}">Edit</a>
                                        @endcan
                                        @can('event_edit')
                                            <a class="btn btn-xs btn-primary"
                                                href="{{ route('admin.events.images', $event->id) }}">Image</a>
                                        @endcan
                                        @can('event_delete')
                                            <a class="btn btn-xs btn-danger"
                                                href="{{ route('admin.events.delete', $event->id) }}">Delete</a>
                                        @endcan('event_delete')

                                        @can('event_show')
                                            <a class="btn btn-xs btn-info"
                                                href="{{ route('admin.events.show', $event->id) }}">view</a>
                                        @endcan
                                    </td>
                                    <td>


                                        @if (!empty($event->featured_image))
                                            <a href="{{ URL(asset('images/Event/' . $event->event_id . '/' . $event->featured_image)) }}"
                                                target="_blank"><img
                                                    src="{{ URL(asset('images/Event/' . $event->event_id . '/' . $event->featured_image)) }}"
                                                    width="50" /></a>
                                        @else
                                            <a href="{{ URL(asset('images/featured_image.png')) }}" target="_blank"><img
                                                    src="{{ URL(asset('images/featured_image.png')) }}"
                                                    width="40" /></a>
                                        @endif




                                    </td>

                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script></script>
@endsection
