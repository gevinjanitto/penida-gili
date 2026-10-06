<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/** Site settings: social media links, WhatsApp number/message and contact details. */
class SettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings', [
            'definitions' => Setting::definitions(),
            'values' => Setting::all_values(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $rules = collect(Setting::definitions())->map(fn (array $def) => match ($def['type']) {
            'url' => ['nullable', 'url', 'max:255'],
            'email' => ['nullable', 'email', 'max:160'],
            'tel' => ['required', 'regex:/^\+?[0-9 \-]{8,20}$/'],
            'toggle' => ['nullable'],
            default => ['nullable', 'string', 'max:255'],
        })->all();

        $data = $request->validate($rules, ['whatsapp.regex' => 'Use digits only, e.g. 6281236300562.']);

        $values = collect(Setting::definitions())->mapWithKeys(function (array $def, string $key) use ($data, $request) {
            if ($def['type'] === 'toggle') {
                return [$key => $request->boolean($key) ? '1' : '0'];
            }
            $value = $data[$key] ?? '';

            return [$key => $key === 'whatsapp' ? preg_replace('/\D+/', '', (string) $value) : (string) $value];
        })->all();

        Setting::store($values);

        return redirect()->route('admin.settings')->with('flash', 'Settings saved.');
    }
}
