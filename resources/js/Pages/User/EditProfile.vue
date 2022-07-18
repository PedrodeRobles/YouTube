<template>
    <Header 
        :userAuth="userAuth"
        :userLoggedName="userLoggedName"
        :userLoggedId="userLoggedId"
    >
    </Header>

    <div class="pt-20 pb-96 flex justify-center text-white bg-slate-900">
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
                                class="bg-slate-900 w-full"
                            >
                        </div>
                        <div class="pt-4 flex justify-center">
                            <button class="bg-slate-600 hover:bg-slate-700 p-2 rounded-md">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    <form @submit.prevent="editProfileImg(props.user.id)">
        <input type="file" @input="form.profile_image = $event.target.files[0]">
        <button type="submit">
            Send
        </button>
    </form>
</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import Header from '../Header/Header.vue';
import { defineComponent } from '@vue/runtime-core';
import { Inertia } from '@inertiajs/inertia';

defineComponent({
    Header
});

const props = defineProps({
    user: Object,
    userAuth: Boolean,
    userLoggedName: String,
    userLoggedId: Number,
});

const form = useForm({
    profile_image: null,
});

function editProfileImg(id) {
    Inertia.post(`/users/editProfile/${id}`, {
    _method: 'put',
    profile_image: form.profile_image,
})
}

</script>