<?php

namespace App\Http\Controllers;

use App\CPU\Helpers;
use App\Model\Section;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class InstallController extends Controller
{
 

    public function step0()
    {
        return view('installation.step0');
    }

    public function step1()
    {
        $permission['curl_enabled'] = function_exists('curl_version');
        $permission['db_file_write_perm'] = is_writable(base_path('.env'));
        $permission['routes_file_write_perm'] = is_writable(base_path('app/Providers/RouteServiceProvider.php'));
        return view('installation.step1', compact('permission'));
    }

    public function step2()
    {
        return view('installation.step2');
    }

    public function step3()
    {
        return view('installation.step3');
    }

    public function step4()
    {
        return view('installation.step4');
    }

    public function step5()
    {
        // Artisan::call('config:cache');
        // Artisan::call('config:clear');
        return view('installation.step5');
    }

    // public function purchase_code(Request $request)
    // {
    //     Helpers::setEnvironmentValue('SOFTWARE_ID', 'MzE0NDg1OTc=');
    //     Helpers::setEnvironmentValue('BUYER_USERNAME', $request['username']);
    //     Helpers::setEnvironmentValue('PURCHASE_CODE', $request['purchase_key']);

    //     $post = [
    //         'name' => $request['name'],
    //         'email' => $request['email'],
    //         'username' => $request['username'],
    //         'purchase_key' => $request['purchase_key'],
    //         'domain' => preg_replace("#^[^:/.]*[:/]+#i", "", url('/')),
    //     ];
    //     $response = $this->dmvf($post);

    //     return redirect($response . '?token=' . bcrypt('step_3'));
    // }

    public function system_settings(Request $request)
    {
        // Artisan::call('config:cache');
        //  Artisan::call('config:clear');

        //create user 
        $role = Section::where('name', 'Admin')->first();

        $user = User::create([
            'name' => $request['admin_name'],
            'email' => $request['admin_email'],
            'branch_id' => 1,
            'is_main_branch' => 1,
            'section_id' => $role->id,
            'password' => bcrypt($request['admin_password']),
            'phone' => $request['admin_phone'],
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        $user->syncPermissions([
            0 => '22'
        ]);
        //create branch 

        DB::table('branches')->insertOrIgnore([
            'name' => $request['admin_name'],
            'email' => $request['admin_email'],
            'branch_id' =>  1,
            'is_main_branch' => 1,
            'phone_number' => $request['admin_phone'],
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('settings')->updateOrInsert(['key' => 'site_name'], [
            'value' => $request['site_name']
        ]);

        DB::table('cash_drawers')->insert([
            'name' => $request['admin_name'],
            'branch_id' => 1,
            'amount' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $previousRouteServiceProvider = base_path('app/Providers/RouteServiceProvider.php');
        $newRouteServiceProvider = base_path('app/Providers/RouteServiceProvider.txt');
        
        if (file_exists($previousRouteServiceProvider)) {
            if (copy( $newRouteServiceProvider , $previousRouteServiceProvider)) {
                 session()->flash('success', 'done');
            } else {
                echo "Failed to copy the file.";
            }
        } else {
            echo "Source file does not exist.";
        }
        Artisan::call('config:cache');
         Artisan::call('config:clear');
      
        return view('installation.step6');
    }

    public function database_installation(Request $request)
    {
        // return $request->all();
        if (self::check_database_connection($request->DB_HOST, $request->DB_DATABASE, $request->DB_USERNAME, $request->DB_PASSWORD)) {
        
            $key = base64_encode(random_bytes(32));
            $output = 'APP_NAME=POS' . time() . '
                    APP_ENV=live
                    APP_KEY=base64:' . $key . '
                    APP_DEBUG=false
                    APP_INSTALL=true
                    APP_LOG_LEVEL=debug
                    APP_MODE=live
                    APP_URL=' . URL::to('/') . '

                    DB_CONNECTION=mysql
                    LOG_CHANNEL=stack
                    DB_HOST=' . $request->DB_HOST . '
                    DB_PORT=3306
                    DB_DATABASE=' . $request->DB_DATABASE . '
                    DB_USERNAME=' . $request->DB_USERNAME . '
                    DB_PASSWORD=' . $request->DB_PASSWORD . '

                    BROADCAST_DRIVER=log
                    CACHE_DRIVER=file
                    SESSION_DRIVER=file
                    SESSION_LIFETIME=60
                    QUEUE_DRIVER=sync

                    AWS_ENDPOINT=
                    AWS_ACCESS_KEY_ID=
                    AWS_SECRET_ACCESS_KEY=
                    AWS_DEFAULT_REGION=us-east-1
                    AWS_BUCKET=

                    REDIS_HOST=127.0.0.1
                    REDIS_PASSWORD=null
                    REDIS_PORT=6379

                    PUSHER_APP_ID=
                    PUSHER_APP_KEY=
                    PUSHER_APP_SECRET=
                    PUSHER_APP_CLUSTER=mt1

                    PURCHASE_CODE=' . session('purchase_key') . '
                    BUYER_USERNAME=' . session('username') . '
                    SOFTWARE_ID=MzE0NDg1OTc=

                    SOFTWARE_VERSION=1.0
                    ';
            $file = fopen(base_path('.env'), 'w');
            fwrite($file, $output);
            fclose($file);

            $path = base_path('.env');
            if (file_exists($path)) {
                return redirect('step4');
            } else {
                session()->flash('error', 'Database error!');
                return redirect('step3');
            }
        } else {
            session()->flash('error', 'Database error!');
            return redirect('step3');
        }
    }

    public function import_sql()
    {
        try {
            $sql_path = base_path('install/db/database.sql');
            DB::unprepared(file_get_contents($sql_path));
            return redirect('step5');
        } catch (\Exception $exception) {
            session()->flash('error', 'Your database is not clean, do you want to clean database then import?');
            return back();
        }
    }

    public function force_import_sql()
    {
        try {
            Artisan::call('db:wipe');
            $sql_path = base_path('install/db/database.sql');
            DB::unprepared(file_get_contents($sql_path));
            return redirect('step5');
        } catch (\Exception $exception) {
            session()->flash('error', 'Check your database permission!');
            return back();
        }
    }

    function check_database_connection($db_host = "", $db_name = "", $db_user = "", $db_pass = "")
    {

        if (@mysqli_connect($db_host, $db_user, $db_pass, $db_name)) {
            return true;
        } else {
            return false;
        }
    }
}
