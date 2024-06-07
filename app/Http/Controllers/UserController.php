<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Like;
use App\Models\Match_History;
use App\Models\Payment_method;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Match_;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function user_detail_page(Request $request){
        $user_id = $request->get('user_id');
        $user_info = User::getDetailByCondition($user_id);
        $my_id = Auth::id();
        $like_already_exist = LIKE::getDetailByCondition($my_id, $user_id);
        $condition = [
            'target_user_id' => $user_id,
        ];
        $count = LIKE::getListByCondition($condition);
        $like_count = count($count);

        return Inertia::render('User/user_detail_page', [
            'user_info' => $user_info,
            'my_id' => $my_id,
            'like_already_exist' => $like_already_exist,
            'like_count' => $like_count,
        ]);
    }

    public function send_good(Request $request){

        $sender_id = $request->get('my_id');
        $receiver_id = $request->get('user_id');

        $data = [
            'user_id' => $sender_id,
            'target_user_id' => $receiver_id,
        ];

        $result = LIKE::insert($data);

        if($result){
            echo "success";
        }else {
            echo "fail";
        }

    }

    public function my_good_like_page(Request $request){
        //いいねを送られたユーザーリストの取得
        $user_id = $request->get('user_id');
        $condition = [
            "target_user_id" => $user_id,
        ];

        $new_user_list = [];

        $user_list = LIKE::getListByCondition($condition);

        foreach ($user_list as $user) {
            $match_flg = Match_History::where('user_id1', $user->target_user_id)->where('user_id2', $user->user_id)->get();
            $user_array = json_decode(json_encode($user), true);
            if(!empty($match_flg)){
                $match_flg = 1;
            }else {
                $match_flg = 0;
            }
            $user_array['match_flg'] = $match_flg;
            $new_user_list[] = $user_array;
        }
        return Inertia::render('User/my_good_like_page', [
            'user_list' => $new_user_list,
            'my_user_id' => $user_id,
        ]);
    }

    public function thank_you_like_other_user(Request $request){

        $sender_id = $request->get('sender_id');
        $receiver_id = $request->get('receiver_id');

        $data = [
            'user_id1' => $sender_id,
            'user_id2' => $receiver_id,
        ];

        //マッチング履歴を残す
        $result = Match_History::insert($data);

        if($result){

            Session::flash('flashmessage', 'マッチングが成立しました');
            return Inertia::location('/my_good_like_page?user_id=2');

        }else{

            Session::flash('flashmessage', 'システムに問題が発生しました');
            return Inertia::location('/my_good_like_page?user_id=2');

        }
    }

    public function search_user(Request $request){
        $name = $request->input('name');
        $condition = [
            'name' => $name
        ];

        $user_list = User::getListByCondition($condition);
        Session::put('user_list', $user_list);

        Session::flash('flashmessage', '検索結果');

        return Inertia::location('/dashboard?search_flg=1&name=' . $name);

    }

    public function my_page(Request $request){

        $user_id = $request->get('user_id');
        $user_info = User::getDetailByCondition($user_id);

        return Inertia::render('User/my_page', [
            // 'user_id' => $user_id,
            'user_info' => $user_info,
        ]);

    }

    public function plan_edit_page(Request $request){
        $user_id = $request->get('user_id');
        $user_data = User::find($user_id);

        return Inertia::render('User/plan_edit_page', [
            'user_id' => $user_id,
            'user_data' => $user_data,
        ]);
    }

    public function upgrade_plan_page(Request $request){

        $user_id = $request->get('user_id');

        $credit_card_info = User::where('stripe_id', $user_id)->first();

        return Inertia::render('User/upgrade_plan_page', [
            'user_id' => $user_id,
            'credit_card_info' => $credit_card_info
        ]);

    }
}
