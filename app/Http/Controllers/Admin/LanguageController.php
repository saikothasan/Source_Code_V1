<?php

namespace App\Http\Controllers\Admin;

use App;
use App\Http\Controllers\Controller;
use App\Language;
use App\Model\Setting;
use App\Services\TranslateService;
use DB;
use File;
use Illuminate\Http\Request;
use Session;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class LanguageController extends Controller
{
    public function index()
    {
        return view('admin.setting.language.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Language is required!',
        ]);

        $language =Setting::where('key', 'language')->first();
        $lang_array = [];
        $codes = [];
        foreach (json_decode($language['value'], true) as $key => $data) {
            if ($data['code'] != $request['code']) {
                if (!array_key_exists('default', $data)) {
                    $default = array('default' => ($data['code'] == 'en') ? true : false);
                    $data = array_merge($data, $default);
                }
                array_push($lang_array, $data);
                array_push($codes, $data['code']);
            }
        }
        array_push($codes, $request['code']);

        if (!file_exists(base_path('resources/lang/' . $request['code']))) {
            mkdir(base_path('resources/lang/' . $request['code']), 0777, true);
        }

        $lang_file = fopen(base_path('resources/lang/' . $request['code'] . '/' . 'messages.php'), "w") or die("Unable to open file!");
        $read = file_get_contents(base_path('resources/lang/en/messages.php'));
        fwrite($lang_file, $read);

        $lang_array[] = [
            'id' => count(json_decode($language['value'], true)) + 1,
            'name' => $request['name'],
            'code' => $request['code'],
            'direction' => $request['direction'],
            'status' => 0,
            'default' => false,
        ];

       Setting::updateOrInsert(['key' => 'language'], [
            'value' => $lang_array
        ]);

        DB::table('settings')->updateOrInsert(['key' => 'pnc_language'], [
            'value' => json_encode($codes),
        ]);

        session()->flash('success','Language Added!');
        return back();
    }

    public function update_status(Request $request)
    {
        $language =Setting::where('key', 'language')->first();
        $lang_array = [];
        foreach (json_decode($language['value'], true) as $key => $data) {
            if ($data['code'] == $request['code']) {
                $lang = [
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'direction' => $data['direction'] ?? 'ltr',
                    'code' => $data['code'],
                    'status' => $data['status'] == 1 ? 0 : 1,
                    'default' => (array_key_exists('default', $data) ? $data['default'] : (($data['code'] == 'en') ? true : false)),
                ];
                $lang_array[] = $lang;
            } else {
                $lang = [
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'direction' => $data['direction'] ?? 'ltr',
                    'code' => $data['code'],
                    'status' => $data['status'],
                    'default' => (array_key_exists('default', $data) ? $data['default'] : (($data['code'] == 'en') ? true : false)),
                ];
                $lang_array[] = $lang;
            }
        }
        $settingSetting =Setting::where('key', 'language')->update([
            'value' => $lang_array
        ]);

        return $settingSetting;
    }

    public function update_default_status(Request $request)
    {
        $language =Setting::where('key', 'language')->first();
        $lang_array = [];
        foreach (json_decode($language['value'], true) as $key => $data) {
            if ($data['code'] == $request['code']) {
                $lang = [
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'direction' => $data['direction'] ?? 'ltr',
                    'code' => $data['code'],
                    'status' => 1,
                    'default' => true,
                ];
                $lang_array[] = $lang;
            } else {
                $lang = [
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'direction' => $data['direction'] ?? 'ltr',
                    'code' => $data['code'],
                    'status' => $data['status'],
                    'default' => false,
                ];
                $lang_array[] = $lang;
            }
        }
       Setting::where('key', 'language')->update([
            'value' => $lang_array
        ]);

        session()->flash('success', ' Updated successfully !');

        return back();
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Language is required!',
        ]);

        $language =Setting::where('key', 'language')->first();
        $lang_array = [];
        foreach (json_decode($language['value'], true) as $key => $data) {
            if ($data['code'] == $request['code']) {
                $lang = [
                    'id' => $data['id'],
                    'name' => $request['name'],
                    'direction' => $request['direction'] ?? 'ltr',
                    'code' => $data['code'],
                    'status' => 0,
                    'default' => (array_key_exists('default', $data) ? $data['default'] : (($data['code'] == 'en') ? true : false)),
                ];
                $lang_array[] = $lang;
            } else {
                $lang = [
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'direction' => $data['direction'] ?? 'ltr',
                    'code' => $data['code'],
                    'status' => $data['status'],
                    'default' => (array_key_exists('default', $data) ? $data['default'] : (($data['code'] == 'en') ? true : false)),
                ];
                $lang_array[] = $lang;
            }
        }
       Setting::where('key', 'language')->update([
            'value' => $lang_array
        ]);
        session()->flash('success','Language updated!');
        return back();
    }

    public function translate($lang)
    {
        $full_data = include(base_path('resources/lang/' . $lang . '/messages.php'));

        ksort($full_data);

        return view('admin.setting.language.translate', compact('lang', 'full_data'));
    }

    public function translate_key_remove(Request $request, $lang)
    {
        $full_data = include(base_path('resources/lang/' . $lang . '/messages.php'));
        unset($full_data[$request['key']]);
        $str = "<?php return " . var_export($full_data, true) . ";";
        file_put_contents(base_path('resources/lang/' . $lang . '/messages.php'), $str);
    }

    public function translate_submit(Request $request, $lang)
    {
        $full_data = include(base_path('resources/lang/' . $lang . '/messages.php'));
        $data_filtered = [];
        foreach ($full_data as $key => $data) {
            $data_filtered[TranslateService::remove_invalid_charcaters($key)] = $data;
        }
        $data_filtered[$request['key']] = $request['value'];
        $str = "<?php return " . var_export($data_filtered, true) . ";";
        file_put_contents(base_path('resources/lang/' . $lang . '/messages.php'), $str);
    }

    // public function auto_translate(Request $request, $lang): \Illuminate\Http\JsonResponse
    // {
    //     $lang_code = getLanguageCode($lang);
    //     $full_data = include(base_path('resources/lang/' . $lang . '/messages.php'));
    //     $data_filtered = [];

    //     foreach ($full_data as $key => $data) {
    //         $data_filtered[Helpers::remove_invalid_charcaters($key)] = $data;
    //     }

    //     $translated = auto_translator($request['key'], 'en', $lang_code);
    //     $data_filtered[$request['key']] = $translated;

    //     $str = "<?php return " . var_export($data_filtered, true) . ";";
    //     file_put_contents(base_path('resources/lang/' . $lang . '/messages.php'), $str);

    //     return response()->json([
    //         'translated_data' => $translated
    //     ]);
    // }

    public function delete($lang)
    {
        $language =Setting::where('key', 'language')->first();

        $del_default = false;
        foreach (json_decode($language['value'], true) as $key => $data) {
            if ($data['code'] == $lang && array_key_exists('default', $data) && $data['default'] == true) {
                $del_default = true;
            }
        }

        $lang_array = [];
        foreach (json_decode($language['value'], true) as $key => $data) {
            if ($data['code'] != $lang) {
                $lang_data = [
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'direction' => $data['direction'] ?? 'ltr',
                    'code' => $data['code'],
                    'status' => ($del_default == true && $data['code'] == 'en') ? 1 : $data['status'],
                    'default' => ($del_default == true && $data['code'] == 'en') ? true : (array_key_exists('default', $data) ? $data['default'] : (($data['code'] == 'en') ? true : false)),
                ];
                array_push($lang_array, $lang_data);
            }
        }

       Setting::where('key', 'language')->update([
            'value' => $lang_array
        ]);

        $dir = base_path('resources/lang/' . $lang);
        if (File::isDirectory($dir)) {
            $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
            $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
            foreach ($files as $file) {
                if ($file->isDir()) {
                    rmdir($file->getRealPath());
                } else {
                    unlink($file->getRealPath());
                }
            }
            rmdir($dir);
        }


        $languages = array();
        $pnc_language =Setting::where('key', 'pnc_language')->first();
        foreach (json_decode($pnc_language['value'], true) as $key => $data) {
            if ($data != $lang) {
                array_push($languages, $data);
            }
        }
        if (in_array('en', $languages)) {
            unset($languages[array_search('en', $languages)]);
        }
        array_unshift($languages, 'en');

        DB::table('settings')->updateOrInsert(['key' => 'pnc_language'], [
            'value' => json_encode($languages),
        ]);

        session()->flash('success','Removed Successfully!');
        return back();
    }


    public function setLanguage($local)
    {

        $direction = 'ltr';
        $language = Setting::where('key', 'language')->first();
        foreach (json_decode($language['value'], true) as $key => $data) {
            if ($data['code'] == $local) {
                $direction = isset($data['direction']) ? $data['direction'] : 'ltr';
            }
        }


        session()->forget('language_settings');
        TranslateService::language_load();
        session()->put('local', $local);
        Session::put('direction', $direction);

        return redirect()->back();
    }


    public function vueGet(Request $request)
    {
        $keys = $request->input('keys');
        $locale = session('local');
        App::setLocale($locale);

        try {
            $langArray = include(base_path('resources/lang/' . $locale . '/messages.php'));

            $translations = [];

            foreach ($keys as $key) {
                $processedKey = ucfirst(str_replace('_', ' ', TranslateService::remove_invalid_charcaters($key)));
                $key = TranslateService::remove_invalid_charcaters($key);

                if (!array_key_exists($key, $langArray)) {
                    $langArray[$key] = $processedKey;
                    $str = "<?php return " . var_export($langArray, true) . ";";
                    file_put_contents(base_path('resources/lang/' . $locale . '/messages.php'), $str);
                    $translations[$key] = $processedKey;
                } else {
                    $translations[$key] = __('messages.' . $key);
                }
            }

            return $translations;
        } catch (\Exception $exception) {
            return [];
        }
    }
}
