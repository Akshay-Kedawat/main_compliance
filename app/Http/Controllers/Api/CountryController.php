<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Country;

class CountryController extends Controller
{
    public function getCountry()
    {
        DB::beginTransaction();
        try {
            $country = Country::all();
            if (count($country) > 0) {
                DB::commit();
                $this->status  = true;
                $this->message = trans('message.list_country');
                $this->data    = $country;
            } else {
                DB::rollback();
                $this->status  = false;
                $this->message = trans('message.data_not_found');
                $this->data    = (object) [];
            }
        }catch (\Exception $e) {
            DB::rollback();
            $this->status  = false;
            $this->message = $e->getMessage();
            $this->data    = (object) [];
        }
        $this->apiResponse();
    }
}
