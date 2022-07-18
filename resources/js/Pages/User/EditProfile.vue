<template>
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
    user: Object
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