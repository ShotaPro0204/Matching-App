<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import { defineProps } from "vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    profile_data: Array,
    user_list: Array,
    like_count: Number,
    user_id: Number,
});

const form = useForm({
    name: null,
    email: null,
    password: null,
    category_id: null,
    book_id: null,
});

function search_user() {
    router.post("/search_user", form);
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <a class="navbar-brand" :href="'/my_page?user_id=' + user_id">My page</a>
                    <button
                        class="navbar-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent"
                        aria-expanded="false"
                        aria-label="Toggle navigation"
                    >
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <p>aa</p>
                    <p>bbb</p>
                </div>
            </nav>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div v-if="profile_data == null" class="p-6 text-gray-900">
                        not profile setting <br />You should set profile for the
                        first time <br /><a href="/profile_setting_page"
                            >click here</a
                        >
                    </div>
                    <div v-else class="p-6 text-gray-900">
                        <div
                            v-for="data in profile_data"
                            :key="data"
                            class="card"
                            style="width: 18rem"
                        >
                            <img :src="'/images/' + data.image" alt="" />
                            <div class="card-body">
                                <h5 class="card-title">{{ data.name }}</h5>
                                <p class="card-text">{{ data.bio }}</p>
                                <span class="badge text-bg-secondary">{{
                                    like_count
                                }}</span>
                                <a
                                    :href="
                                        '/my_good_like_page?user_id=' + data.id
                                    "
                                    >いいね</a
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h1 class="text-center">User list</h1>
            \
            <h2>検索フォーム</h2>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">名前</label>
                <input
                    v-model="form.name"
                    type="name"
                    name="name"
                    class="form-control"
                    id="exampleInputEmail1"
                    aria-describedby="emailHelp"
                />
            </div>
            <button @click="search_user()" class="btn btn-primary">
                絞り込む
            </button>

            <div v-for="list in user_list" :key="list.id">
                <div class="card" style="width: 18rem">
                    <img src="" class="card-img-top" alt="..." />
                    <div class="card-body">
                        <h5 class="card-title">{{ list.name }}</h5>
                        <p class="card-text">{{ list.bio }}</p>
                        <a
                            :href="'/user_detail_page?user_id=' + list.id"
                            class="btn btn-primary"
                            >detail</a
                        >
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
