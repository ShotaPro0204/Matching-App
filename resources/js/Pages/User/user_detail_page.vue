<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    user_info: Array,
    my_id: Number,
    like_already_exist: Array,
    like_count: Number,
});

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

<template>
    <h1 class="text-center">user_detail_page</h1>
<div v-for="info in user_info" :key="info.id" class="card" style="width: 18rem;">
  <div class="card-body">
    <img :src="'/images/' + info.image" alt="">
    <h5 class="card-title">{{ info.name }}</h5>
    <p class="card-text">{{ info.bio }}&nbsp;&nbsp;&nbsp;<span>{{ like_count }}</span></p>
    <a v-if="like_already_exist.length === 0" :href="'/send_good?user_id=' + info.user_id + '&my_id=' + my_id" class="btn btn-primary">いいね</a>
    <a v-else class="btn btn-secondary">いいね済み</a>
  </div>

</div>
</template>


