<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotificationSetting;

class SettingsController extends Controller
{
    // Halaman General (Kosongkan dulu atau isi sesuai kebutuhan)
    public function general()
    {
        return view('settings.general');
    }

    // Halaman Notification
    public function notifications()
    {
        $settings = NotificationSetting::all();
        return view('settings.notifications', compact('settings'));
    }

    // Simpan Perubahan Setting
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