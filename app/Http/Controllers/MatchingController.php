<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Match_History;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Redis;

class MatchingController extends Controller
{

    public function matching_list_page(Request $request){

        $user_id = $request->get('my_user_id');
        $matching_user_list = User::whereIn('id', function ($query) use ($user_id) {
            $query->selectRaw('CASE
                WHEN user_id1 = ? THEN user_id2
                ELSE user_id1
            END AS matched_user_id', [$user_id])
            ->from('match__histories')
            ->where('user_id1', $user_id)
            ->orWhere('user_id2', $user_id);
        })->get();

        return Inertia::render('User/matching_list_page', [
            'matching_user_list' => $matching_user_list,
            'user_id' => $user_id,
        ]);

    }

    public function matching_talk_page(Request $request){
        $my_user_id = $request->get('user_id1');
        $matching_user_id = $request->get('user_id2');
        $user_info = User::getDetailByCondition($my_user_id);
        $target_user_info = User::getDetailByCondition($matching_user_id);
        $message_list = Message::whereRaw('((sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)) AND is_deleted = 0', [$my_user_id, $matching_user_id, $matching_user_id, $my_user_id])->get();

        return Inertia::render('User/matching_talk_page', [

            'target_user_info' => $target_user_info,
            'my_user_id' => $my_user_id,
            'partner_user_id' => $matching_user_id,
            'message_list' => $message_list,
            'user_info' => $user_info,
        ]);
    }

    public function send_message(Request $request){

        $sender_id = $request->get('sender_id');
        $receiver_id = $request->get('receiver_id');
        $message_content = $request->input('message_content');

        $data = [
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'message_content' => $message_content,
        ];

        $result = Message::insert($data);

        if($result){

            return response()->json(['message' => 'Message sent successfully']);

        }else {

            echo "fail";

        }

    }

    public function delete_message(Request $request){

        $message_id = $request->input('message_id');

        $delete_message_data = [
            "is_deleted" => 1
        ];

        $result = Message::Where('id', '=', $message_id)->update($delete_message_data);

        if($result){

            return response()->json(['message' => 'Message deleted successfully']);

        }else {

            return response()->json(['message' => 'fail']);

        }

    }
}
