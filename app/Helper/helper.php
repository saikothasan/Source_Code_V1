<?php

use App\Constant\Constant;
use App\Model\Bank;
use App\Model\Branch;
use App\Model\Brand;
use App\Model\Category;
use App\Model\Customer;
use App\Model\DeliveryMan;
use App\Model\Department;
use App\Model\Designation;
use App\Model\FrontendSetting;
use App\Model\Offer;
use App\Model\PaymentMethod;
use App\Model\Product;
use App\Model\ProductImage;
use App\Model\Section;
use App\Model\Setting;
use App\Model\Stock;
use App\Model\Supplier;
use App\Model\User;
use App\Services\TranslateService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use NumberToWords\NumberToWords;
use Illuminate\Support\Facades\Auth;

if (!function_exists('getWeekendName')) {
    function getWeekendName(): array
    {
        return [
            0 => 'No Weekend',
            1 => 'Saturday',
            2 => 'Sunday',
            3 => 'Monday',
            4 => 'Tuesday',
            5 => 'Wednesday',
            6 => 'Thursday',
            7 => 'Friday',
        ];
    }
}
if (!function_exists('getMonths')) {
    function getMonths(): array
    {
        return [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'Jun',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];
    }
}

if (!function_exists('monthName')) {
    function monthName($month): string
    {
        return getMonths()[$month];
    }
}

if (!function_exists('getAllSupplier')) {
    function getAllSupplier()
    {
        return Supplier::query()
            ->select('id as value', 'name as text')
            ->orderBy('name')
            ->get();
    }
}

if (!function_exists('getAllCategory')) {
    function getAllCategory()
    {
        return Cache::rememberForever('allCategory', function () {
            return Category::query()
                ->select('id as value', 'name as text')
                ->orderBy('name')
             
                ->get();
        });
    }
}
if (! function_exists('getTopCategory')) {
    function getTopCategory()
    {
        return Cache::rememberForever('topCategory', function () {
            return Category::query()
                ->select('id as value', 'name as text')
                ->orderBy('name')

                ->get()->take(11);
        });
    }
}

if (! function_exists('getTopBrand')) {
    function getTopBrand()
    {
        return Cache::rememberForever('topBrand', function () {
            return Brand::query()
                ->select('id as value', 'name as text')
                ->orderBy('name')
                ->get()->take(10);
        });
    }
}
if (! function_exists('getRandomProduct')) {
    function getRandomProduct()
    {
        return Cache::rememberForever('RandomProduct', function () {
            return Product::inRandomOrder()->select('id as value', 'name as text')
            ->orderBy('name')->limit(10)->get();
        });
    }
}

if (!function_exists('getAllBrand')) {
    function getAllBrand()
    {
        return Brand::query()
            ->select('id as value', 'name as text')
      
            ->orderBy('name')
            ->get();
    }
}
if (!function_exists('getRandomCategory')) {
    function getRandomCategory()
    {
        return Category::query()
          ->inRandomOrder()
            ->select('id as value', 'name as text')
        
            ->limit(5)->orderBy('name')
            ->get();
    }
}


if(!function_exists('user_info')){
    function user_info(){
        $user_id = Auth::guard('customer')->user()->id;

        $user_info = Customer::findOrFail($user_id);
        return $user_info;
    }
}

//cart data
 if(! function_exists('cart_data')){
    function cart_data(){
        $cart = session()->get('cart', []);
        $cart = collect($cart)->map(function ($item) {
            $productImage = ProductImage::query()->where('product_id', $item['id'])->first();
            $item['image'] = $productImage ?: '/ecommerce/error-img.jpg';
            return $item;
        });
        return $cart;
    }
 }
 if(!function_exists('cart_total')){
    function cart_total (){

        $total = collect(session('cart'))->every(function ($item) {
            return $item['price'] > 0;
        })
            ? collect(session('cart'))->sum(function ($item) {
                return $item['price'] * $item['quantity'];
            })
            : '0.00';
    return $total;
    }
 }

if (! function_exists('numberToWords')) {
    function numberToWords($number): string
    {
        return Str::ucfirst(NumberToWords::transformNumber('en', $number));
    }
}

if (!function_exists('getDeliveryMans')) {
    function getDeliveryMans()
    {
        return DeliveryMan::query()
            ->active()
            ->select('*', 'id as value', 'name as text')
            ->orderBy('name')
            ->get()
            ->toArray();
    }
}

if (!function_exists('getPaymentMethods')) {
    function getPaymentMethods($ignore = []): array
    {
        return PaymentMethod::query()
            ->active()
            ->whereNotIn('name', $ignore)
            ->select('id as value', 'name as text', 'reference_status')
            ->orderBy('name')
            ->get()
            ->toArray();
    }
}

if(!function_exists('branch_id')){
    function branch_id(){
        return auth()->user()->branch_id;
    }
}

if (!function_exists('getBranchUsers')) {
    function getBranchUsers(): array
    {
        return User::active()
            ->when(isBranch(), function ($query) {
                $query->where('branch_id', auth()->user()->branch_id);
            })
            ->whereNotNull('branch_id')
            ->select('id as value', 'name as text')
            ->orderBy('name')
            ->get()
            ->toArray();
    }
}

if (!function_exists('getUsers')) {
    function getUsers(): array
    {
        return User::query()
            ->active()
            ->select('id as value', 'name as text')
            ->latest('name')
            ->get()
            ->toArray();
    }
}

if (!function_exists('managementBanks')) {
    function managementBanks(): array
    {
        return Bank::query()
            ->where('branch_id', auth()->user()->branch_id)
            ->where('is_main_bank', 1)
            ->latest('name')
            ->get()
            ->map(function ($data) {
                return [
                    'value' => $data->id,
                    'text' => $data->name . ' (' . number_format($data->amount).get_settings('currency_symbol') . ')',
                    'account_no' => $data->account_no,
                    'amount' => $data->amount,
                ];
            })->toArray();
    }
}

if (!function_exists('getAllDepartment')) {
    function getAllDepartment()
    {
        return Department::query()
            ->select('id as value', 'name as text')
            ->orderBy('name')
            ->get();
    }
}

if (!function_exists('getAllDesignation')) {
    function getAllDesignation()
    {
        return Designation::query()
            ->select('id as value', 'name as text')
            ->orderBy('name')
            ->get();
    }
}

if (!function_exists('getSections')) {
    function getSections()
    {
        return Section::query()
            ->orderBy('name')
            ->get();
    }
}


if (!function_exists('getAllSections')) {
    function getAllSections()
    {
        return Section::query()
            ->select('id as value', 'name as text')
            ->orderBy('name')
            ->get();
    }
}


if (!function_exists('getAllBranch')) {
    function getAllBranch($mainBranchSkip = '', $shipBranch = '')
    {
        return Branch::query()->active()->when($mainBranchSkip, function ($query) {
            $query->withOutMainBranch();
        })->when($shipBranch, function ($query) use ($shipBranch) {
            $query->where('id', '!=', $shipBranch);
        })->select('id as value', 'name as text', 'is_main_branch')
            ->get();
    }
}

if (!function_exists('getSetting')) {
    function getSetting(string $key, ?string $default = null)
    {
        return Setting::get($key, $default);
    }
}

if(!function_exists('get_settings')){
    function get_settings($name)
    {
        $config = null;

            $data = Setting::where(['key' => $name])->first();
            if (isset($data)) {
                $config = json_decode($data['value'], true);
                if (is_null($config)) {
                    $config = $data['value'];
                }
            }

            return $config;
    }


}

if (!function_exists('frontendSetting')) {
    function frontendSetting(string $key, ?string $default = null)
    {
        return FrontendSetting::get($key, $default);
    }
}
if (!function_exists('ecommerceBranchId')) {
    function ecommerceBranchId()
    {
        return frontendSetting('branch_id');
    }
}
if (!function_exists('availableStock')) {
    function availableStock($product_barcode, $branch_id = null, $offer_id = null): int
    {
        if (!$branch_id) {
            $branch_id = auth()->user()->branch_id;
        }

        return Stock::query()
            ->stockProduct()
            ->when(isSupplier(), function ($query) {
                $query->where('supplier_id', supplierAuth()->supplier->id);
            })
            ->where('product_barcode', $product_barcode)
            ->where('current_branch', $branch_id)
//            ->when($offer_id !== null, function ($query) use ($offer_id) {
//                $query->where('offer_id', $offer_id);
//            })
//            ->when($offer_id === null, function ($query) use ($offer_id) {
//                $query->whereNull('offer_id');
//            })
            ->count();
    }
}

if (!function_exists('availableProductStock')) {
    function availableProductStock($product_barcode, $branch_id = null): int
    {
        if (!$branch_id) {
            $branch_id = auth()->user()->branch_id;
        }
        return Stock::query()
            ->whereNull('offer_id')
            ->whereNull('offer_type')
            ->stockProduct()
            ->when(isSupplier(), function ($query) {
                $query->where('supplier_id', supplierAuth()->supplier->id);
            })
            ->where('product_barcode', $product_barcode)
            ->where('current_branch', $branch_id)
            ->count();
    }
}

if (!function_exists('availableStockByOffer')) {
    function availableStockByOffer($product_barcode, $branch_id = null, $offer_id = null)
    {
        if (!$branch_id) {
            $branch_id = auth()->user()->branch_id;
        }
        return Stock::query()
            ->stockProduct()
            ->when(isSupplier(), function ($query) {
                $query->where('supplier_id', supplierAuth()->supplier->id);
            })
            ->where('product_barcode', $product_barcode)
            ->where('current_branch', $branch_id)
            ->when($offer_id, function ($query) use ($offer_id) {
                $query->where('offer_id', $offer_id);
            }, function ($query) {
                $query->whereNull('offer_id');
            })
            ->count();
    }
}


if (!function_exists('getMainBranch')) {
    function getMainBranch(): Builder|Model
    {
        return Branch::query()
            ->where('is_main_branch', true)
            ->firstOrFail();
    }
}

if (!function_exists('serialNumber')) {
    function serialNumber($data, $loop)
    {
        return $data->firstItem() + $loop->index;
    }
}

if (!function_exists('isBranch')) {
    function isBranch(): bool
    {
        return !auth()->user()->is_main_branch && auth()->user()->branch_id;
    }
}

if (!function_exists('isMainBranch')) {
    function isMainBranch(): bool
    {
        return auth()->user()->is_main_branch && auth()->user()->branch_id;
    }
}

if (!function_exists('isSupplier')) {
    function isSupplier(): bool
    {
        return auth()->user()->hasRole(['Supplier']);
    }
}

if (!function_exists('supplierAuth')) {
    function supplierAuth()
    {
        return auth()->user()->load('supplier:id,name,user_id');
    }
}

if (!function_exists('floatFormat')) {
    function floatFormat($number, $limit = 2): string
    {
        return number_format($number, $limit, '.', '');
    }
}
if (!function_exists('formatWithComma')) {
    function formatWithComma($number, $limit = 2): string
    {
        return number_format($number, $limit, '.', ',');
    }
}
if (!function_exists('getOffers')) {
    function getOffers(): array
    {
        $data = [];
        foreach (Constant::OFFER_TYPE as $key => $value) {
            $data[] = [
                'value' => $key,
                'text' => $value,
            ];
        }
        return $data;
    }
}
if (!function_exists('dateDifference')) {
    function dateDifference($from_data, $to_date): array
    {
        $from = Carbon::parse($from_data);
        $to = Carbon::parse($to_date);
        $diff_in_days = $to->diffInDays($from);
        $diff_in_months = $to->diffInMonths($from);
        $diff_in_years = $to->diffInYears($from);
        return [
            'days' => $diff_in_days,
            'months' => $diff_in_months,
            'years' => $diff_in_years,
        ];
    }
}


if (!function_exists('getCartTotal')) {
    function getCartTotal($cart)
    {
        return collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'] ?: 0.00;
        });
    }
}

if (!function_exists('getCartTotalQuantity')) {
    function getCartTotalQuantity($cart)
    {
        return collect($cart)->sum(function ($item) {
            return $item['quantity'] ?: 0.00;
        });
    }
}
if (!function_exists('getCartTotalItem')) {
    function getCartTotalItem($cart): int
    {
        return collect($cart)->count();
    }
}



        if(!function_exists('translate')){

            function translate($key)
                {
                    $local = session('local');
                    App::setLocale($local);

                    try {
                        $lang_array = include(base_path('resources/lang/' . $local . '/messages.php'));
                        $processed_key = ucfirst(str_replace('_', ' ', TranslateService::remove_invalid_charcaters($key)));
                        $key = TranslateService::remove_invalid_charcaters($key);
                        if (!array_key_exists($key, $lang_array)) {
                            $lang_array[$key] = $processed_key;
                            $str = "<?php return " . var_export($lang_array, true) . ";";
                            file_put_contents(base_path('resources/lang/' . $local . '/messages.php'), $str);
                            $result = $processed_key;
                        } else {

                           $result = __('messages.' . $key);
                        }
                    } catch (\Exception $exception) {
                        $result = __('messages.' . $key);
                    }

                   return $result;
                }
        }
