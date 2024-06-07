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
    matching_user_list: Array,
    user_id: Number,
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
    <h1 class="text-center">This is talk list page</h1>
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
        <a class="p-2 text-dark" href="/matching_list_page">トーク</a>
        <a class="p-2 text-dark" href="#">Enterprise</a>
        <a class="p-2 text-dark" href="#">Support</a>
        <a class="p-2 text-dark" href="#">Pricing</a>
      </nav>
    </div>

    <ul v-for="list in matching_user_list" :key="list.id" class="list-group">
        <a :href="'matching_talk_page?user_id1=' + user_id + '&user_id2=' + list.id">
            <li class="list-group-item" style="border-top: 1px solid black;">
                <p>{{ list.name }}</p>
            </li>
        </a>
    </ul>

  </body>
</html>

</template>


