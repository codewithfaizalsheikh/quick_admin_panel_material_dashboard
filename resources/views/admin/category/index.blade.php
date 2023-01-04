@extends('layouts.admin')
@section('content')



@can('category_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.category.create') }}">
                {{ trans('global.add') }} {{ __("Category") }}
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
                            Category Name
                        </th>
                        <th>
                            Status
                        </th>
                        <th>Action</th>
                       
                    </tr>
                </thead>
                <tbody>
                        @if($category->count())
                	       @foreach($category as $key => $category)
	                        <tr data-entry-id="$category->id">
	                            <td>

	                            </td>
	                            <td>
	                               {{$category->id}}

	                            </td>
	                            <td>
	                                 {{$category->category_name}}
	                            </td>
                                <td>
                                     {{$category->category_status}}
                                </td>
                                <td>
                                     @can('category_edit')
                                        <a class="btn btn-xs btn-primary" href="{{route('admin.category.edit',$category->id)}}" >Edit</a>
                                        @endcan
                                        @can('category_delete')
                                           <a class="btn btn-xs btn-danger" href="{{route('admin.category.delete',$category->id)}}" >Delete</a>
                                         @endcan('category_delete')
                                         
                                </td>
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
<script>


</script>
@endsection
