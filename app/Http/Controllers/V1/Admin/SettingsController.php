<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\SettingsResource;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Settings::all();

        return SettingsResource::collection($settings);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = Validator::make($request->all(),[
            'title' => 'required',
            'description' => 'required',
        ]);

        if($data->fails()) {
            return response()->json([
                'message'=> 'please check your credentials and try again'
            ]);
        }
    
             $setting = new Settings;
             $setting->title = $request->input('title');
             $setting->description = $request->input('description');
             $setting->save();
    
             return new SettingsResource($setting);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function show(Settings $setting)
    {
        return new SettingsResource($setting);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function edit(Settings $settings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Settings $setting)
    {
        $data = Validator::make($request->all(),[
            'title' => 'required|max:20',
            'description' => 'required',
        ]);

  
        if($data->fails()) {
            return response()->json([
                'message'=> 'please check your credentials and try again'
            ]);
        }
        
        $setting->title = $request->input('title');
        $setting->description = $request->input('description');
        $setting->update();

        return new SettingsResource($setting);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Settings $setting)
    {
        $setting = $setting->delete();

        // return new CategoryResource($setting);
 
        return response()->json([
         "message" => 'settings deleted successfully !',
         'setting' => $setting
     ]);

    }
}
