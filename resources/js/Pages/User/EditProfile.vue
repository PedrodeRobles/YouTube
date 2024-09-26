<template>
    <div class="min-h-screen flex flex-col justify-between bg-principal">
        <Header 
            :userLoggedName="userLoggedName"
            :userLoggedId="userLoggedId"
            :userAuthImg="userAuthImg"
        >
        </Header>
    
        <div class="pt-20 flex justify-center text-white bg-principal">
                <div>
                    <div class="flex justify-center mb-4">
                        <h2 class="text-2xl">Update profile</h2>
                    </div>
                    <div class="border border-slate-500 rounded-lg p-2">
                        <form @submit.prevent="editProfileImg(props.user.id)" class="space-y-3">
                            <div>
                                <p>Profile Image</p>
                                <input 
                                    type="file"
                                    accept="image/*"
                                    @input="form.profile_image = $event.target.files[0]" 
                                    class="w-full"
                                >
                            </div>
                            <div class="pt-4 flex justify-center">
                                <button class="bg-slate-600 hover:bg-slate-700 p-2 rounded-md">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
    
                    <div class="border border-slate-500 rounded-lg p-2 mt-6">
                        <form @submit.prevent="editProfileBackgroundImg(props.user.id)" class="space-y-3">
                            <div>
                                <p>Background Image</p>
                                <input 
                                    type="file"
                                    accept="image/*"
                                    @input="form.bg_image = $event.target.files[0]" 
                                    class="w-full"
                                >
                            </div>
                            <div class="pt-4 flex justify-center">
                                <button class="bg-slate-600 hover:bg-slate-700 p-2 rounded-md">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
    
                    <div class="mt-6">
                        <Link :href="route('profile.show')">
                            <h3 class="p-4 bg-blue-500 hover:bg-blue-600 rounded-md text-center">
                                Advanced options to edit profile
                            </h3>
                        </Link>
                    </div>
    
                </div>
            </div>
    </div>

</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import Header from '../Header/Header.vue';
import { defineComponent } from '@vue/runtime-core';
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';

defineComponent({
    Header,
    Link,
});

const props = defineProps({
    user: Object,
    userLoggedName: String,
    userLoggedId: Number,
    userAuthImg: Array
});

const form = useForm({
    profile_image: null,
    bg_image: null,
});

function editProfileImg(id) {
    Inertia.post(`/users/editProfileImg/${id}`, {
    _method: 'put',
    profile_image: form.profile_image,
})}

function editProfileBackgroundImg(id) {
    Inertia.post(`/users/editProfileBackgroundImg/${id}`, {
    _method: 'put',
    bg_image: form.bg_image,
})}

</script>