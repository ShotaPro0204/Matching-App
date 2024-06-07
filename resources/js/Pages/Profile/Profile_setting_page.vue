<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    profile_data: Array,
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
    <h1 class="text-center">Profile Setting Page</h1>
    <form @submit.prevent="submit">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Profile image</label><br>
            <input type="file" @change="onFileChange" class="form-control">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Bio</label>
            <input v-model="form.bio" name="bio" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Interest</label>
            <input v-model="form.interest" name="interest" class="form-control" id="exampleInputPassword1">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
</form>
</template>
