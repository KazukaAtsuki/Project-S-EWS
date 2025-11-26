<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotificationSetting;
use App\Models\GeneralSetting; // Import Model Baru
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    // Halaman General Settings
    public function general()
    {
        // Ambil data setting pertama, jika tidak ada buat baru dummy
        $general = GeneralSetting::first() ?? new GeneralSetting();
        return view('settings.general', compact('general'));
    }

    // Update General Settings
    public function updateGeneral(Request $request)
    {
        $request->validate([
            'site_title' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'app_logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $setting = GeneralSetting::first();
        if (!$setting) {
            $setting = new GeneralSetting();
        }

        $data = $request->except(['app_logo', '_token', '_method']);

        // Handle Upload Logo
        if ($request->hasFile('app_logo')) {
            // Hapus logo lama jika ada
            if ($setting->app_logo) {
                Storage::disk('public')->delete($setting->app_logo);
            }
            // Simpan logo baru
            $path = $request->file('app_logo')->store('settings', 'public');
            $data['app_logo'] = $path;
        }

        $setting->fill($data);
        $setting->save();

        return redirect()->route('settings.general')->with('success', 'General settings updated successfully!');
    }

    // ... (Method notifications & updateNotifications biarkan saja seperti sebelumnya) ...
    public function notifications()
    {
        $settings = NotificationSetting::all();
        return view('settings.notifications', compact('settings'));
    }

    public function updateNotifications(Request $request)
    {
        $data = $request->input('settings', []);
        foreach ($data as $id => $values) {
            $setting = NotificationSetting::find($id);
            if ($setting) {
                $setting->update([
                    'email_enabled' => isset($values['email']),
                    'telegram_enabled' => isset($values['telegram']),
                    'whatsapp_enabled' => isset($values['whatsapp']),
                ]);
            }
        }
        return redirect()->back()->with('success', 'Notification settings updated successfully!');
    }
}