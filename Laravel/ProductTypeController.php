<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Constants\Model;
use App\Constants\Page;
use App\Models\ProductType;
use App\Models\UserLog;
use Auth;
use App\Constants\ResponseCodeConstant;
use App\Functions\CheckExistFunction;
class ProductTypeController extends Controller
{
    public function index(Request $request)
    {        
        $perPage = Page::PagePerPage;
        if($request->has('perPage')) {
            $perPage = $request->perPage;
        }
        $type = new ProductType();        
        $type = $this->getQuery($type, $request);
        if($request->has('searchText')) {
            $type = $type->where('type','like',"%".$request->searchText."%");
        }        
        $type = $type->paginate($perPage);
        return $type;   
    }
    public function queryDelete(Request $request) 
    {       
        $perPage = 15;
        if($request->has('perPage')) {
            $perPage = $request->perPage;
        }   
        $type = new ProductType();
        $type = $this->getQuery($type, $request);
        if($request->has('searchText')) {
            $type = $type->where('type','like',"%".$request->searchText."%");            
        }
        $type = $type->paginate($perPage);
        return $type;
    }

}
