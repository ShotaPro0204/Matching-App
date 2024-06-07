<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment_method;
use Exception;

class PaymentController extends Controller
{
    public function register_credit_card(Request $request)
        {
            $user_id = $request->input('user_id');
            $card_token = $request->input('card_token'); // トークンを取得

            // StripeのAPIキーを設定
            \Stripe\Stripe::setApiKey(config('stripe.stripe_secret_key'));
g
            // try {
            //     // 支払いを作成
            //     \Stripe\Charge::create([
            //         'source' => $card_token, // カードトークンを使用
            //         'amount' => 10000, // 支払額（例: 10000円）
            //         'currency' => 'jpy',
            //         'description' => 'Charge for user ' . $user_id, // 説明（任意）
            //     ]);

            //     $data = [
            //         'user_id' => $user_id,
            //         'stripe_id' => $user_id,
            //     ];


            // } catch (\Exception $e) {
            //     // エラー処理
            //     return back()->with('error', '決済に失敗しました: ' . $e->getMessage());
            // }


            return back()->with('status', '決済が完了しました！');
        }
}
