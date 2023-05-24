<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class WebSettingController extends Controller
{
    public function settings()
    {
        $setting = DB::table('web_settings')->where('key', 'contactInfo')->first();
        if(count((array)$setting)){
            $data['contact'] = json_decode($setting->data);
        }else{
            $data['contact'] = [];
        }
        $setting = DB::table('web_settings')->where('key', 'socialLinks')->first();
        if(count((array)$setting)){
            $data['links'] = json_decode($setting->data);
        }else{
            $data['links'] = [];
        }
        $logo = DB::table('web_settings')->where('key', 'logo')->first();
        $favicon = DB::table('web_settings')->where('key', 'favicon')->first();
        if(count((array)$logo)){
            $data['logo'] = json_decode($logo->data);
        }else{
            $data['logo'] = null;
        }
        if(count((array)$favicon)){
            $data['favicon'] = json_decode($favicon->data);
        }else{
            $data['favicon'] = null;
        }
        $setting = DB::table('web_settings')->where('key', 'smtp')->first();
        if(count((array)$setting)){
            $data['smtp'] = json_decode($setting->data);
        }else{
            $data['smtp'] = [];
        }
        return view('admin.settings.index', $data);
    }
    public function webLogosProcess(Request $request)
    {
        if($request->updateLogo){
            return $this->addOrUpdateLogos('logo', $request);
        }
        elseif($request->updateFavicon){
            return $this->addOrUpdateLogos('favicon', $request);
        }
        else{
            return redirect()->route('admin.dashboard');
        }
    }

    public function contactInfoProcess(Request $request)
    {
        $request->validate([
            'email' => 'required',
        ]);
        $info['phone'] = $request->phone;
        $info['email'] = $request->email;
        $info['address'] = $request->address;
        $contactInfo = DB::table('web_settings')->where('key', 'contactInfo')->first();
        if(!$contactInfo){
            $webSetting = new WebSetting();
            $webSetting->key = 'contactInfo';
            $webSetting->data = json_encode($info);
            if($webSetting->save()){
                if (Cache::has('webSetting')) {
                    Cache::forget('webSetting');
                }
                $data['type'] = "success";
                $data['message'] = "Setting Added Successfuly!.";
                $data['icon'] = 'mdi-check-all';
            }
            else
            {
                $data['type'] = "danger";
                $data['message'] = "Failed to Add Setting, please try again.";
                $data['icon'] = 'mdi-block-helper';
            }
            return redirect()->route('admin.web.settings')->with($data);
        }
        else{
            $setting = WebSetting::where('key', 'contactInfo')->update([
                'data' => json_encode($info)
            ]);
            if($setting){
                if (Cache::has('webSetting')) {
                    Cache::forget('webSetting');
                }
                $data['type'] = "success";
                $data['message'] = "Setting Updated Successfuly!.";
                $data['icon'] = 'mdi-check-all';
            }
            else
            {
                $data['type'] = "danger";
                $data['message'] = "Failed to Update Setting, please try again.";
                $data['icon'] = 'mdi-block-helper';
            }
            return redirect()->route('admin.web.settings')->with($data);
        }
    }
    
    public function socialLinkProcess(Request $request)
    {
        $info['facebook'] = $request->facebook;
        $info['instagram'] = $request->instagram;
        $info['twitter'] = $request->twitter;
        $info['linkedin'] = $request->linkedin;
        $info['tiktok'] = $request->tiktok;
        $contactInfo = DB::table('web_settings')->where('key', 'socialLinks')->first();
        if(!$contactInfo){
            $webSetting = new WebSetting();
            $webSetting->key = 'socialLinks';
            $webSetting->data = json_encode($info);
            if($webSetting->save()){
                if (Cache::has('webSetting')) {
                    Cache::forget('webSetting');
                }
                $data['type'] = "success";
                $data['message'] = "Setting Added Successfuly!.";
                $data['icon'] = 'mdi-check-all';
            }
            else
            {
                $data['type'] = "danger";
                $data['message'] = "Failed to Add Setting, please try again.";
                $data['icon'] = 'mdi-block-helper';
            }
            return redirect()->route('admin.web.settings')->with($data);
        }
        else{
            $setting = WebSetting::where('key', 'socialLinks')->update([
                'data' => json_encode($info)
            ]);
            if($setting){
                if (Cache::has('webSetting')) {
                    Cache::forget('webSetting');
                }
                $data['type'] = "success";
                $data['message'] = "Setting Updated Successfuly!.";
                $data['icon'] = 'mdi-check-all';
            }
            else
            {
                $data['type'] = "danger";
                $data['message'] = "Failed to Update Setting, please try again.";
                $data['icon'] = 'mdi-block-helper';
            }
            return redirect()->route('admin.web.settings')->with($data);
        }
    }

    public function addOrUpdateLogos($getInput, $request)
    {
        $request->validate([
            $getInput => 'required|mimes:jpeg,jpg,bmp,png,ico|max:1024'
        ], [$getInput.'.required' => 'Please upload valid image for '.$getInput]);
        $logo = DB::table('web_settings')->where('key', $getInput)->first();
        $image = $request->file($getInput);
        if(!$logo){
            $webSetting = new WebSetting();
            $webSetting->key = $getInput;
            if ($image->move('backend/assets/images/websettings/', $image->getClientOriginalName())) {
                $webSetting->data = json_encode([$getInput => $image->getClientOriginalName()]);
                if($webSetting->save())
                {
                    if (Cache::has('webSetting')) {
                        Cache::forget('webSetting');
                    }
                    $data['type'] = "success";
                    $data['message'] = Str::ucfirst($getInput)." Added Successfuly!.";
                    $data['icon'] = 'mdi-check-all';
                }
                else
                {
                    $data['type'] = "danger";
                    $data['message'] = "Failed to Add ".Str::ucfirst($getInput).", please try again.";
                    $data['icon'] = 'mdi-block-helper';
                }
                return redirect()->route('admin.web.settings')->with($data);
            }
            else{
                $data['type'] = "danger";
                $data['message'] = "Failed to upload image, please try again.";
                $data['icon'] = 'mdi-block-helper';
                return redirect()->route('admin.web.settings')->with($data);
            }
        }
        else{
            if ($image->move('backend/assets/images/websettings/', $image->getClientOriginalName())) {
                $setting = WebSetting::where('key', $getInput)->update([
                    'data' => json_encode([$getInput => $image->getClientOriginalName()])
                ]);
                if($setting)
                {
                    if (Cache::has('webSetting')) {
                        Cache::forget('webSetting');
                    }
                    $data['type'] = "success";
                    $data['message'] = Str::ucfirst($getInput)." Updated Successfuly!.";
                    $data['icon'] = 'mdi-check-all';
                }
                else
                {
                    $data['type'] = "danger";
                    $data['message'] = "Failed to Update ".Str::ucfirst($getInput).", please try again.";
                    $data['icon'] = 'mdi-block-helper';
                }
                return redirect()->route('admin.web.settings')->with($data);
            }
            else{
                $data['type'] = "danger";
                $data['message'] = "Failed to upload image, please try again.";
                $data['icon'] = 'mdi-block-helper';

                return redirect()->route('admin.web.settings')->with($data);
            }
        }
    }
    
    public function smtpSettingProcess(Request $request)
    {
        $request->validate([
            "host" => "required",
            "port" => "required",
            "username" => "required",
            "password" => "required",
            "encryption" => "required",
            "from_name" => "required"
        ]);
        $setting = WebSetting::where('key', 'smtp')->first();
        if(count((array)$setting))
        {
            $smtp['host'] = $request->host;
            $smtp['port'] = $request->port;
            $smtp['username'] = $request->username;
            $smtp['password'] = Crypt::encryptString($request->password);
            $smtp['encryption'] = $request->encryption;
            $smtp['from_name'] = $request->from_name;
            $setting->data = json_encode($smtp);
            if($setting->save())
            {
                if (Cache::has('smtpSetting')) {
                    Cache::forget('smtpSetting');
                }
                $data['type'] = "success";
                $data['message'] = "Setting Updated Successfuly!.";
                $data['icon'] = 'mdi-check-all';
            }
            else{
                $data['type'] = "danger";
                $data['message'] = "Failed to Update Setting, please try again.";
                $data['icon'] = 'mdi-block-helper';
            }
            return redirect()->route('admin.web.settings')->with($data);
        }
        else{
            $setting = new WebSetting();
            $smtp['host'] = $request->host;
            $smtp['port'] = $request->port;
            $smtp['username'] = $request->username;
            $smtp['password'] = Crypt::encryptString($request->password);
            $smtp['encryption'] = $request->encryption;
            $smtp['from_name'] = $request->from_name;
            $setting->key = 'smtp';
            $setting->data = json_encode($smtp);
            if($setting->save())
            {
                if (Cache::has('smtpSetting')) {
                    Cache::forget('smtpSetting');
                }
                $data['type'] = "success";
                $data['message'] = "Setting Updated Successfuly!.";
                $data['icon'] = 'mdi-check-all';
            }
            else
            {
                $data['type'] = "danger";
                $data['message'] = "Failed to Update Setting, please try again.";
                $data['icon'] = 'mdi-block-helper';
            }
            return redirect()->route('admin.web.settings')->with($data);
        }
    }
    
    public function clearCache()
    {
        \Artisan::call('optimize:clear');
        \Artisan::call('config:cache');
        \Artisan::call('cache:clear');
        \Artisan::call('view:clear');
        \Artisan::call('route:clear');
        return 'Site Cache Cleared Successfuly!';
    }
    
    public function cacheWeb()
    {
        \Artisan::call('optimize');
        return 'Site Cached Successfuly!';
    }
}