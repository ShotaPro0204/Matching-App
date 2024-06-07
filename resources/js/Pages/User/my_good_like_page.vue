<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';


// プロパティからフラッシュメッセージを受け取る
const flashmessage = ref('');

// マウント時にセッションからフラッシュメッセージを取得して表示する
onMounted(() => {
    // propsからフラッシュメッセージをセット
    flashmessage.value = props.flashmessage || '';
});

const props = defineProps({
    user_list: Array,
    my_user_id: Number,
    flashmessage: String,
});

console.log(props.flashmessage);

const form = useForm({
    file: null,
    bio: null,
    interest: null,
});

function onFileChange(event){
    form.image = event.target.files[0];
}

function submit(){
    router.post('/set_profile', form);
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

<template>
    <h1 class="text-center">My good Like page</h1>
    <!DOCTYPE html>
<html lang="jp">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Pricing example · Bootstrap</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link href="css/pricing.css" rel="stylesheet">
  </head>

  <body>


    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 border-bottom shadow-sm">
      <h5 class="my-0 mr-md-auto font-weight-normal">Company name</h5>
      <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 text-dark" :href="'matching_list_page?my_user_id=' + my_user_id">トーク</a>

        <a class="p-2 text-dark" href="#">Enterprise</a>
        <a class="p-2 text-dark" href="#">Support</a>
        <a class="p-2 text-dark" href="#">Pricing</a>
      </nav>
      <a class="btn btn-outline-primary" href="#">Sign up</a>
    </div>

    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
      <h5 class="display-4">お相手からもらったいいね</h5>
      <div v-if="flashmessage" class="flash-message">{{ flashmessage }}</div>
    </div>

    <!-- この行を編集 コンテナの設置 -->
    <div class="container">
      <div v-for="list in user_list" :key="list.id" class="card-deck mb-3 text-center">
        <div class="card mb-4 shadow-sm">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal">{{ list.name }}</h4>
          </div>
          <div class="card-body">
            <ul class="list-unstyled mt-3 mb-4">
                <img :src="'/images/' + list.image" alt="">
              <li>{{ list.bio }}</li>
              <li>2 GB of storage</li>
              <li>Email support</li>
              <li>Help center access</li>
              <a v-if="list.match_flg != 1" :href="'thank_you_like_other_user?receiver_id=' + list.my_user_id + '&sender_id=' + my_user_id" class="btn btn-primary">ありがとう</a>
              <a v-else href="/" class="btn btn-primary">マッチング済み</a>
            </ul>
          </div>
        </div>
      </div>
    </div>

  </body>
</html>

</template>


