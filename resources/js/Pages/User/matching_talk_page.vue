<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import { defineProps } from "vue";
import { useForm } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import axios from "axios";
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.min.css';

// プロパティからフラッシュメッセージを受け取る
const flashmessage = ref("");

// マウント時にセッションからフラッシュメッセージを取得して表示する
onMounted(() => {
    // propsからフラッシュメッセージをセット
    flashmessage.value = props.flashmessage || "";
});

const props = defineProps({
    user_list: Array,
    my_user_id: Number,
    flashmessage: String,
    target_user_info: Array,
    partner_user_id: Array,
    message_list: Array,
    user_info: Array,
});

console.log(props.flashmessage);

const form = useForm({
    sender_id: null,
    receiver_id: null,
    message_content: null,
    message_id: null,
});

function onFileChange(event) {
    form.image = event.target.files[0];
}

function submit() {
    form.sender_id = props.my_user_id;
    form.receiver_id = props.partner_user_id;

    if (form.message_content == null) {
        alert("メッセージを入力してください");
    }

    // router.post('/send_message', form);

    axios
        .post("/send_message", form)
        .then((response) => {
            // 成功した場合の処理
            console.log("メッセージが送信されました:", response.data);
            location.reload();
            // ここでページの更新などを行う
        })
        .catch((error) => {
            // エラーが発生した場合の処理
            console.error("メッセージの送信中にエラーが発生しました:", error);
            // エラーメッセージを表示するなどの処理を行う
        });
}

function delete_message($message_id){

    form.message_id = $message_id;

    Swal.fire({
        title: 'メッセージを送信しますか？',
        text: "この操作は取り消せません。",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'はい',
        cancelButtonText: 'キャンセル',
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            axios
                .post("/delete_message", form)
                .then((response) => {
                    // 成功した場合の処理
                    Swal.fire({
                        icon: 'success',
                        title: 'メッセージ送信成功',
                        text: 'メッセージが送信されました。',
                    });
                    console.log("メッセージが送信されました:", response.data);
                    location.reload();
                    // ここでページの更新などを行う
                })
                .catch((error) => {
                    // エラーが発生した場合の処理
                    Swal.fire({
                        icon: 'error',
                        title: 'メッセージ送信エラー',
                        text: 'メッセージの送信中にエラーが発生しました。再度お試しください。',
                    });
                    console.error("メッセージの送信中にエラーが発生しました:", error);
                    // エラーメッセージを表示するなどの処理を行う
                });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // キャンセルされた場合の処理
            Swal.fire({
                icon: 'info',
                title: 'キャンセルされました',
                text: 'メッセージの送信がキャンセルされました。',
            });
        }
    });

}


</script>

<style>
/* フラッシュメッセージのスタイルを定義 */
.flash-message {
    background-color: #f0f0f0;
    color: #333;
    padding: 10px;
    margin-bottom: 10px;
}
</style>

<style id="line-talk-css">
/*/////////////////////////////////////////////////
//LINE風チャット画面(会話方式)を記事に表示する方法
/////////////////////////////////////////////////*/

.line__container {
    padding: 0;
    background: #7494c0; /* LINEトークルーム背景色 */
    overflow: hidden;
    max-width: 400px;
    margin: 20px auto;
    font-size: 80%;
}

/* 1 タイトル部分 */
.line__container .line__title {
    background: #273246;
    padding: 10px;
    text-align: center;
    font-size: 150%;
    color: #ffffff;
}

/* 2 会話部分 */
.line__container .line__contents {
    padding: 10px;
    overflow: hidden;
    line-height: 135%;
}

.line__container .scroll {
    height: 500px;
    overflow-y: scroll;
}

/* 4 スタンプ画像最大幅 */
.line__container .stamp img {
    max-width: 120px;
}

/* 5 相手の会話 */
.line__container .line__left {
    /*width: 100%;*/
    display: inline-block;
    position: relative;
    display: block;
    margin-bottom: 5px;
    max-width: 90%;
    clear: both;
}

/* 6 アイコン画像 */
.line__container .line__left figure {
    width: 50px;
    position: absolute;
    top: 15px;
    left: 0;
    padding: 0;
    margin: 0;
}

/* 7 正方形を用意 */
.line__container .line__left figure img {
    border-radius: 50%;
    width: 50px;
    height: 50px;
}

.line__container .line__left .line__left-text {
    margin-left: 60px; /* 70px */
}

.line__container .line__left .line__left-text .name {
    font-size: 80%;
    color: #ffffff;
}

/* 10 コメントエリア */
.line__container .line__left .text {
    margin: 0;
    display: inline-block;
    position: relative;
    padding: 10px;
    border-radius: 20px;
    background-color: #edf1ee; /* 吹き出し背景色 相手 */
    color: #000000; /* トーク文字色 相手 */
    font-size: 11px; /* トーク文字サイズ 相手 */
}

/* 11 吹き出し */
.line__container .line__left .text::after {
    content: "";
    position: absolute;
    display: block;
    width: 0;
    height: 0;
    left: -10px;
    top: 3px;
    border-right: 20px solid #edf1ee; /* 吹き出し枠線色 相手 */
    border-top: 10px solid transparent;
    border-bottom: 10px solid transparent;
    transform: rotate(35deg);
    -webkit-transform: rotate(35deg);
}

/* 12 自分の会話 */
.line__container .line__right {
    position: relative;
    display: block;
    margin: 5px 0;
    max-width: 95%;
    float: right;
    margin-right: 5px; /* 15px */
    clear: both;
}

/* 13 コメントエリア */
.line__container .line__right .text {
    padding: 10px;
    border-radius: 20px;
    margin: 0;
    margin-left: 80px;
    background-color: #8de055; /* 吹き出し背景色 自分 */
    color: #000000; /* トーク文字色 自分 */
    font-size: 11px; /* トーク文字サイズ 自分 */
}

/* 14 吹き出し */
.line__container .line__right .text::after {
    content: "";
    position: absolute;
    display: block;
    width: 0;
    height: 0;
    right: -10px;
    top: 3px;
    border-left: 20px solid #8de055; /* 吹き出し枠線色 自分 */
    border-top: 10px solid transparent;
    border-bottom: 10px solid transparent;
    transform: rotate(-35deg);
    -webkit-transform: rotate(-35deg);
}

/* 15 自分がスタンプを送る時 */
.line__container .line__right .stamp {
    position: relative;
    margin-left: 80px;
}

/* 16 時間エリア 相手
.line__container .line__left .time {
  content: '';
  position: absolute;
  display: inline-block;
  width: 0px;
  text-align: left;
  right: 0px;
  bottom: 0px;
  font-size: 80%;
  color: #ffffff;
}
*/

/* 17 既読／時間エリア 自分 */
.line__container .line__right .date {
    content: "";
    position: absolute;
    display: block;
    width: 100px;
    text-align: right;
    left: -25px;
    bottom: 0px;
    font-size: 80%;
    color: #ffffff;
}
</style>

<template>
    <h1 class="text-center">This is talk page</h1>

    <!-- ▼LINE風トークルーム全体 ここから -->
    <DIV class="line__container">
        <!-- タイトル -->
        <div
            v-for="info in target_user_info"
            :key="info.id"
            class="line__title"
        >
            {{ info.name }}
        </div>

        <!-- ▼会話エリア scrollを外すと高さ固定解除 -->
        <DIV class="line__contents scroll">
            <!-- 1. 相手の吹き出し <br><br>夏バテにはやっぱりキウイだよね！ -->
            <div v-for="list in message_list" :key="list.id">
                <div v-if="list.sender_id != my_user_id" class="line__left">
                    <figure>
                        <img src="img/ishihara-satomi-3.jpg" />
                    </figure>
                    <div class="line__left-text">
                        <div
                            v-for="info in target_user_info"
                            :key="info.id"
                            class="name"
                        >
                            <br />
                            {{ info.name }}
                        </div>
                        <div class="text" id="talk_fr1">
                            {{ list.message_content }}
                        </div>
                        <!--<div style="display:inline-block;margin-left:0" class="time"><span class="time2">10:30</span></div>-->
                    </div>
                </div>

                <!-- 1. 自分の吹き出し -->
                <div v-else class="line__right">
                    <div
                        @click="delete_message(list.id)"
                        class="text"
                        id="talk_my1"
                    >
                        {{ list.message_content }}
                    </div>

                    <span v-if="list.is_read == 0" class="date"
                        >未読<br
                    /></span>
                    <span v-else class="date">既読<br />0:30</span>
                </div>
            </div>
        </DIV>
        <!--　▲会話エリア ここまで -->
    </DIV>
    <!--　▲LINE風トークルーム全体ここまで -->
    <div class="text-center">
        <form @submit.prevent="submit" action="">
            <textarea
                v-model="form.message_content"
                name="message_content"
                id=""
                cols="50"
                rows="10"
            ></textarea
            ><br />
            <button class="btn btn-primary">送信する</button>
        </form>
    </div>
</template>
