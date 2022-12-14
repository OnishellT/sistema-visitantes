<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BackendController;
use App\Libraries\MyString;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Setting;

class SettingController extends BackendController
{

    public function __construct()
    {
        parent::__construct();

        $this->data['sitetitle'] = 'Opciones';

        $this->middleware(['permission:setting']);
    }

    // Site Setting
    public function index()
    {
        return view('admin.setting.site');
    }

    public function siteSettingUpdate(Request $request)
    {

        $niceNames    = [];
        $settingArray = $this->validate($request, $this->siteValidateArray(), [], $niceNames);

        if ($request->hasFile('site_logo')) {
            $site_logo                 = request('site_logo');
            $settingArray['site_logo'] = $site_logo->getClientOriginalName();
            $request->site_logo->move(public_path('images'), $settingArray['site_logo']);
        } else {
            unset($settingArray['site_logo']);
        }

        if (isset($settingArray['timezone'])) {
            MyString::setEnv('APP_TIMEZONE', $settingArray['timezone']);
            Artisan::call('optimize:clear');
        }

        Setting::set($settingArray);
        Setting::save();

        return redirect(route('admin.setting.index'))->withSuccess('The Site setting updated successfully');
    }

    // SMS Setting
    public function smsSetting()
    {
        return view('admin.setting.sms');
    }

    public function smsSettingUpdate(Request $request)
    {
        $niceNames    = [];
        $settingArray = $this->validate($request, $this->smsValidateArray(), [], $niceNames);

        Setting::set($settingArray);
        Setting::save();
        return redirect(route('admin.setting.sms'))->withSuccess('The SMS setting updated successfully.');
    }

    // email template Setting
    public function emailTemplateSetting()
    {
        return view('admin.setting.email-template');
    }

    public function mailTemplateSettingUpdate(Request $request)
    {
        $niceNames    = [];
        $settingArray = $this->validate($request, $this->emailTemplateValidateArray(), [], $niceNames);

        Setting::set($settingArray);
        Setting::save();
        return redirect(route('admin.setting.email-template'))->withSuccess('The Email & Sms template setting updated successfully.');
    }

    // EMail Setting
    public function emailSetting()
    {
        return view('admin.setting.email');
    }

    public function emailSettingUpdate(Request $request)
    {
        $niceNames         = [];
        $emailSettingArray = $this->validate($request, $this->emailValidateArray(), [], $niceNames);

        Setting::set($emailSettingArray);
        Setting::save();

        return redirect(route('admin.setting.email'))->withSuccess('The Email setting updated successfully');
    }

    // Notification Setting
    public function notificationSetting()
    {
        return view('admin.setting.notification');
    }

    public function notificationSettingUpdate(Request $request)
    {

        $niceNames                = [];
        $notificationSettingArray = $this->validate($request, $this->notificationValidateArray(), [], $niceNames);

        Setting::set($notificationSettingArray);
        Setting::save();

        return redirect(route('admin.setting.notification'))->withSuccess('The Notification setting updated successfully.');
    }

    // Homepage Setting
    public function homepageSetting()
    {
        return view('admin.setting.homepage');
    }

    public function homepageSettingUpdate(Request $request)
    {
        $niceNames    = [];
        $settingArray = $this->validate($request, $this->frontendValidateArray(), [], $niceNames);

        Setting::set($settingArray);
        Setting::save();

        return redirect(route('admin.setting.homepage'))->withSuccess('The Home page setting updated successfully');
    }



    // Site Setting validation
    private function siteValidateArray()
    {
        return [
            'site_name'                       => 'required|string|max:100',
            'site_email'                      => 'required|string|max:100',
            'site_phone_number'               => 'required', 'max:60',
            'site_footer'                     => 'required|string|max:200',
            'timezone'                        => 'required|string',
            'site_logo'                       => 'nullable|mimes:jpeg,jpg,png,gif|max:3096',
            'site_description'                => 'required|string|max:500',
            'site_address'                    => 'required|string|max:500',
        ];
    }

    // SMS Setting validation
    private function smsValidateArray()
    {
        return [
            'twilio_auth_token'  => 'required|string|max:200',
            'twilio_account_sid' => 'required|string|max:200',
            'twilio_from'        => 'required|string|max:20',
            'twilio_disabled'    => 'numeric',
        ];
    }


    // EMAIL Setting validation
    private function emailValidateArray()
    {
        return [
            'mail_host'         => 'required|string|max:100',
            'mail_port'         => 'required|string|max:100',
            'mail_username'     => 'required|string|max:100',
            'mail_password'     => 'required|string|max:100',
            'mail_from_name'    => 'required|string|max:100',
            'mail_from_address' => 'required|string|max:200',
            'mail_disabled'     => 'numeric',
        ];
    }

    // Notification Setting validation
    private function notificationValidateArray()
    {
        return [
            'notifications_email'           => 'nullable|string|max:100',
            'notifications_sms'             => 'nullable|string|max:100',
        ];
    }

    // Notification Setting validation
    private function emailTemplateValidateArray()
    {
        return [
            'notify_templates'              => 'nullable|string|max:150',
            'invite_templates'              => 'nullable|string|max:150',
        ];
    }

    // Homepage Setting validation
    private function frontendValidateArray()
    {
        return [
            'front_end_enable_disable'      => 'required|string|max:100',
            'visitor_agreement'             => 'required|string|max:100',
            'welcome_screen'                => 'nullable|string|max:255',
            'terms_condition'               => 'nullable|string|max:255',
        ];
    }

}
