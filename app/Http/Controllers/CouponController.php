<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $trash = Coupon::onlyTrashed()->get();
        $trash = count($trash) != 0 ? true : false;
        $coupons = Coupon::all();
        return view('coupons.index', compact(['coupons' , 'trash']));
    }
    public function trash()
    {
        $coupons = Coupon::onlyTrashed()->get();
        return view('coupons.trash', compact('coupons'));
    }
    public function restore($coupon)
    {
        $coupon = Coupon::withTrashed()->find($coupon);
        $coupon->restore();
        return redirect()->route('coupon.index')->with(['warning' => 'تخفیف با کد "' . $coupon->code . '" بازتولید شد']);
    }
    public function create()
    {
        return view('Coupons.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|uppercase|unique:coupons,code',
            'percentage' => 'required',
            'expired_at' => 'required|date_format:Y/m/d H:i:s',
        ]);
        if($request->percentage > 100){
            return redirect()->back()->with(['error' => 'درصد تخفیف بیشتر از 100 نمی‌تواند باشد']);
        }
        Coupon::create([
            'code' => $request->code,
            'percentage' => $request->percentage,
            'expired_at' => Verta::parse($request->expired_at)->formatGregorian('Y-n-j H:i'),
        ]);

        return redirect()->route('coupon.index')->with(['success' => 'کد تخفیف با کد "' . $request->code . '" ایجاد شد']);
    }
    public function edit(Coupon $coupon)
    {
        return view('coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code' => 'required|string|uppercase|unique:coupons,code,'.$coupon->id,
            'percentage' => 'required',
            'expired_at' => 'required|date_format:Y/m/d H:i:s',
        ]);
        if($request->percentage > 100){
            return redirect()->back()->with(['error' => 'درصد تخفیف بیشتر از 100 نمی‌تواند باشد']);
        }
        $coupon->update([
            'code' => $request->code,
            'percentage' => $request->percentage,
            'expired_at' => Verta::parse($request->expired_at)->formatGregorian('Y-n-j H:i'),
        ]);

        return redirect()->route('coupon.index')->with(['success' => 'کد تخفیف با موفقیت ویرایش شد']);
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('coupon.index')->with(['info' => 'تخفیف با کد "' . $coupon->code . '" حذف شد']);
    }
}
