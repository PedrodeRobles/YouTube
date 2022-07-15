<template>
    <form @submit.prevent="editProfileImg">
        <input type="text" v-model="form.profile_image">
        <button type="submit">
            Send
        </button>
    </form>
</template>

<script setup>
import { defineProps } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { useForm } from '@inertiajs/inertia-vue3';

const props = defineProps({
    userLogged: Object,
});

const form = useForm({
    profile_image: '',
});

function editProfileImg() {
    Inertia.put(`/users/${props.userLogged.id}`, {
    _method: 'put',
    profile_image: form.profile_image,
})}
</script>