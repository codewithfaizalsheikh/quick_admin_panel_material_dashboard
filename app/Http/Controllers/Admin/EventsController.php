<?php
namespace App\Http\Controllers\Admin;

use App\EventImage;
use App\Http\Controllers\Controller;

use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Gate;
use DB;
use App\EventCategory;
use App\Event;
use App\EventDetail;
use File;
use App\Role;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Http\Requests\StoreEventRequest;

use App\User;

class EventsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('event_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // $events = Event::all();
        $user_roles = Auth::user()->roles->pluck('title', 'id')->toArray();



        if (in_array('EventManager', $user_roles)) {
            $user_role = 'EventManager';
            $events = DB::table('events')
                ->leftJoin('event_categories', 'events.event_category_id', '=', 'event_categories.id')
                ->leftJoin('event_details', 'events.id', '=', 'event_details.event_id')
                ->leftJoin('users', 'events.user_id', '=', 'users.id')
                ->select('events.*', 'users.name as user_name', 'event_categories.category_name', 'event_details.featured_image', 'event_details.event_id')
                ->where('events.user_id', Auth::user()->id)
                ->whereNull('events.deleted_at')
                ->get();
        } else if (in_array('Admin', $user_roles)) {
            $user_role = 'Admin';
            $events = DB::table('events')
                ->leftJoin('event_categories', 'events.event_category_id', '=', 'event_categories.id')
                ->leftJoin('event_details', 'events.id', '=', 'event_details.event_id')
                ->leftJoin('users', 'events.user_id', '=', 'users.id')
                ->select('events.*', 'users.name as user_name', 'event_categories.category_name', 'event_details.featured_image', 'event_details.event_id')
                ->whereNull('events.deleted_at')
                ->get();
        }


        return view('admin.events.index', compact('events', 'user_role'));
    }

    public function create()
    {
        abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user_roles = Auth::user()->roles->pluck('title', 'id')->toArray();

        if (in_array('EventManager', $user_roles)) {
            $user_role = 'EventManager';
        } else if (in_array('Admin', $user_roles)) {
            $user_role = 'Admin';
        } else {
            $user_role = 'User';
        }

        $managers = array();
        $users = User::all();
        if ($users->count()) {
            foreach ($users as $key => $user) {
                $user_roles = $user->roles->pluck('title', 'id')->toArray();
                if (in_array('EventManager', $user_roles)) {
                    $managers[$user->id] = $user->name;
                }
            }
        }


        $cat = EventCategory::where('category_status', 1)->get();


        return view('admin.events.create', compact('cat', 'user_role', 'managers'));
    }

    public function store(StoreEventRequest $request)
    {
        abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user_roles = Auth::user()->roles->pluck('title', 'id')->toArray();



        if (in_array('EventManager', $user_roles)) {
            $new_array = array();
            $new_array['user_id'] = Auth::user()->id;
            $request->merge($new_array);

            $event = Event::create($request->all());
        } else if (in_array('Admin', $user_roles)) {
            $event = Event::create($request->all());
        }






        return redirect()->route('admin.events.index')->with('success', 'Event Created Successfully!');
    }

    public function edit(Request $request, $id)
    {
        abort_if(Gate::denies('event_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user_roles = Auth::user()->roles->pluck('title', 'id')->toArray();

        if (in_array('EventManager', $user_roles)) {
            $user_role = 'EventManager';
        } else if (in_array('Admin', $user_roles)) {
            $user_role = 'Admin';
        } else {
            $user_role = 'User';
        }

        $managers = array();
        $users = User::all();
        if ($users->count()) {
            foreach ($users as $key => $user) {
                $user_roles = $user->roles->pluck('title', 'id')->toArray();
                if (in_array('EventManager', $user_roles)) {
                    $managers[$user->id] = $user->name;
                }
            }
        }


        if (!$id) {
            return redirect()->route('admin.events.index')->with('error', 'Event ID not found!');
        }

        $event = DB::table('events')
            ->leftJoin('event_categories', 'events.event_category_id', '=', 'event_categories.id')
            ->leftJoin('event_details', 'events.id', '=', 'event_details.event_id')
            ->leftJoin('users', 'events.user_id', '=', 'users.id')
            ->select('events.*', 'users.name as user_name', 'event_categories.category_name', 'event_details.featured_image', 'event_details.event_id')
            ->where('events.id', $id)
            ->whereNull('events.deleted_at')
            ->first();

        if (!$event) {
            return redirect()->route('admin.events.index')->with('error', 'Event ID not found!');
        }


        $cat = EventCategory::where('category_status', 1)->get();



        return view('admin.events.edit', compact('event', 'id', 'user_role', 'cat', 'managers'));


        // $users = User::all();

        // return view('admin.events.index', compact('users'));
    }



    public function update(Request $request, $id)
    {

        abort_if(Gate::denies('event_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (!$id) {
            return redirect()->route('admin.events.index')->with('error', 'Event ID not found!');
        }

        $event = Event::find($id);

        if (!$event) {
            return redirect()->route('admin.events.index')->with('error', 'Event ID not found!');
        }

        $user_roles = Auth::user()->roles->pluck('title', 'id')->toArray();



        if (in_array('EventManager', $user_roles)) {
            $new_array = array();
            $new_array['user_id'] = Auth::user()->id;
            $request->merge($new_array);

            $event->update($request->all());

            $check_event_detail = EventDetail::where('event_id', $id)->get()->count();

            if ($check_event_detail) {

                $event_detail = EventDetail::where('event_id', $id)->first();

                $event_detail->update($request->all());

                if ($request->hasFile('featured_image')) {

                    $current_file = $request->file('featured_image');
                    // $file_name = $current_file->getClientOriginalName();

                    $file_name = "EFI_" . time() . "." . $request->file('featured_image')->getClientOriginalExtension();

                    $path = public_path('/images/Event/' . $event_detail->event_id);


                    if (!File::isDirectory($path)) {
                        File::makeDirectory($path, 0777, true, true);
                    }
                    $current_file->move($path, $file_name);
                    $event_detail->featured_image = $file_name;
                    $event_detail->save();
                }

            } else {
                $event_detail = EventDetail::create($request->all());
                //$event_detail->event_id = $id;
                //$event_detail->event_description = $request->event_description;
                //$event_detail->save();
            }



        } else if (in_array('Admin', $user_roles)) {
            // $product = product::update([ 'key' => $request['key'], 'name' => $request['name'], // 'value' => $request['value'], ]);


            $event->update($request->all());

            $check_event_detail = EventDetail::where('event_id', $id)->get()->count();

            if ($check_event_detail) {

                $event_detail = EventDetail::where('event_id', $id)->first();

                $event_detail->update($request->all());

                if ($request->hasFile('featured_image')) {

                    $current_file = $request->file('featured_image');
                    // $file_name = $current_file->getClientOriginalName();

                    $file_name = "EFI_" . time() . "." . $request->file('featured_image')->getClientOriginalExtension();

                    $path = public_path('/images/Event/' . $event_detail->event_id);


                    if (!File::isDirectory($path)) {
                        File::makeDirectory($path, 0777, true, true);
                    }
                    $current_file->move($path, $file_name);
                    $event_detail->featured_image = $file_name;
                    $event_detail->save();
                }

            } else {
                $event_detail = EventDetail::create($request->all());
                //$event_detail->event_id = $id;
                //$event_detail->event_description = $request->event_description;
                //$event_detail->save();
            }
        }


        // $event->update($request->all());

        // $check_event_detail = EventDetail::where('event_id',$id)->get()->count();

        // if($check_event_detail){

        //     $event_detail = EventDetail::where('event_id',$id)->first();

        //     $event_detail->update($request->all());

        //             if($request->hasFile('featured_image'))
        //               {       

        //                       $current_file = $request->file('featured_image');
        //                        // $file_name = $current_file->getClientOriginalName();

        //                       $file_name= "EFI_".time().".".$request->file('featured_image')->getClientOriginalExtension();

        //                       $path = public_path('/images/Event/'.$event_detail->event_id);


        //                  if(!File::isDirectory($path))
        //                        {
        //                            File::makeDirectory($path, 0777, true, true);
        //                        }
        //                        $current_file->move($path,$file_name);
        //                        $event_detail->featured_image = $file_name;
        //                        $event_detail->save();
        //                }



        //$event_detail->event_description = $request->event_description;
        //$event_detail->save();

        // }
        // else
        // {
        //     $event_detail = EventDetail::create($request->all());
        //     //$event_detail->event_id = $id;
        //     //$event_detail->event_description = $request->event_description;
        //     //$event_detail->save();


        // }

        return redirect()->route('admin.events.index')->with('success', 'Event updated!');
    }

    public function delete(Request $request, $id)
    {
        abort_if(Gate::denies('event_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (!$id) {
            return redirect()->route('admin.events.index')->with('error', 'Event ID not found!');
        }

        $event = Event::find($id);
        if (!$event) {
            return redirect()->route('admin.events.index')->with('error', 'Event ID not found!');
        }
        $event->delete();

        return back();

    }

    public function show(Request $request, $id)
    {
        abort_if(Gate::denies('event_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (!$id) {
            return redirect()->route('admin.events.index')->with('error', 'Id Not Found');
        }

        if (Event::where('id', $id)->get()->count()) {
            $event = Event::leftJoin('event_categories', 'events.event_category_id', '=', 'event_categories.id')
                ->leftJoin('event_details', 'events.id', '=', 'event_details.event_id')
                ->leftJoin('event_images', 'events.id', '=', 'event_images.event_id')
                ->where('events.id', $id)
                ->select('events.*', 'event_categories.category_name', 'event_details.*','event_images.featured_image as image')
                ->first();

            $event_detail = EventDetail::where('event_id', $id)->first();

            


            return view('admin.events.show', compact('event', 'event_detail'));
        } else {
            return redirect()->route('admin.events.index')->with('error', 'Id Not Found');
        }


    }

    public function storeDetails(Request $request, $id)
    {
        abort_if(Gate::denies('event_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (!$id) {
            return redirect()->route('admin.events.index')->with('error', 'Event ID not found!');
        }

        $event = Event::find($id);

        if (!$event) {
            return redirect()->route('admin.events.index')->with('error', 'Event ID not found!');
        }

        $check_event_detail = EventDetail::where('event_id', $id)->get()->count();

        if ($check_event_detail) {
            $event_detail = EventDetail::where('event_id', $id)->first();
            $event_detail->update($request->all());
        } else {
            $event_detail = EventDetail::create($request->all());


        }

        // $users = User::all();

        // return view('admin.events.index', compact('users'));
        return redirect()->route('admin.events.index')->with('success', 'Event updated!');
    }
    public function event_images(Request $request, $id)
    {
        abort_if(Gate::denies('event_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (!$id) {
            return redirect()->route('admin.events.index')->with('error', 'Event ID not found!');
        }

        $user_roles = Auth::user()->roles->pluck('title', 'id')->toArray();

        if (in_array('EventManager', $user_roles)) {
            $user_role = 'EventManager';
            $user_id = Auth::user()->id;
            $event_count = Event::where('id', $id)->where('user_id', $user_id)->get()->count();
        } else if (in_array('Admin', $user_roles)) {
            $user_role = 'Admin';
            $event_count = Event::where('id', $id)->get()->count();
        } else {
            $user_role = 'User';
        }

        if (!$event_count) {
            return redirect()->route('admin.events.index')->whith('error', 'Event not found!');
        }

        $event = DB::table('events')
            ->leftJoin('event_categories', 'events.event_category_id', '=', 'event_categories.id')
            ->leftJoin('event_details', 'events.id', '=', 'event_details.event_id')
            ->leftJoin('users', 'events.user_id', '=', 'users.id')
            
            ->select('events.*', 'users.name as user_name', 'event_categories.category_name', 'event_details.featured_image', 'event_details.event_id')
            ->where('events.id', $id)
            ->whereNull('events.deleted_at')
            ->first();

        if (!$event) {
            return redirect()->route('admin.events.index')->with('error', 'Event ID not found!');
        }
        $event_images = EventImage::join('events', 'event_images.event_id', '=', 'events.id')
            ->select('event_images.*')
            ->where('event_images.event_id', $id)
            ->get();

        return view('admin.events.event_images', compact('event', 'id', 'user_role','event_images'));


        // $users = User::all();

        // return view('admin.events.index', compact('users'));
    }

    public function add_event_images(Request $request, $id)
    {
       
            $event_images = EventImage::where('event_id', $id)->first();
            $event_images=EventImage::create($request->all());


            if ($request->hasFile('featured_image')) {

                $current_file = $request->file('featured_image');
                // $file_name = $current_file->getClientOriginalName();

                $file_name = "E_FI_" . time() . "." . $request->file('featured_image')->getClientOriginalExtension();

                $path = public_path('/images/EventImage/' . $event_images->id);


                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }
                $current_file->move($path, $file_name);
                $event_images->featured_image = $file_name;
                $event_images->save();
            }

             return back();
    }
    public function delete_images(Request $request, $event_id,$image_id)
    {
        
        //abort_if(Gate::denies('event_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (empty($event_id) || empty($image_id)) {
            return redirect()->route('admin.events.index')->with('error', 'Event ID not found!');
        }

        //Delete if Admin or Event manage on this event
        
        $check_img = EventImage::where('event_id',$event_id)->where('id',$image_id)->get()->count();
        if($check_img > 0){
            $event_images = EventImage::find($image_id);
            $event_images->delete();
            return redirect()->back()->with('success','Image deleted');
        }else{
            return redirect()->back()->with('error','Cant not delete');
        }
        
        //$event_images->delete();

        //

    }



}