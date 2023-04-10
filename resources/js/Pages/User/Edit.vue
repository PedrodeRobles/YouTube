<template>
    <div class="bg-slate-900">
        <Header 
            @getQuery="querySon"
            :userLoggedName="userLoggedName"
            :userLoggedId="userLoggedId"
            :userAuthImg="userAuthImg"
        >
        </Header>

        <div class="pt-20 pb-96 flex justify-center text-white">
            <div>
                <div class="flex justify-center mb-4">
                    <h2 class="text-2xl">Update video</h2>
                </div>
                <div class="border border-slate-500 rounded-lg p-2">
                    <form @submit.prevent="updateVideo" class="space-y-3">
                        <div>
                            <p>Title</p>
                            <div v-if="errors.title" class="text-red-500">
                                {{ errors.title }}
                            </div>
                            <input 
                                type="text" 
                                v-model="form.title" 
                                class="bg-slate-800 w-full"
                            >
                        </div>
                        <div>
                            <p>Image</p>
                            <div v-if="errors.image" class="text-red-500">
                                {{ errors.image }}
                            </div>
                            <p class="text-red-600">Select the same image or a new image</p>
                            <input 
                                type="file"
                                ref="photo"
                                @input="form.image = $event.target.files[0]"
                                accept="image/*"
                            >
                        </div>
                        <div>
                            <p>Video (.mp4) / Max 60.000 KB</p>
                            <div v-if="errors.video" class="text-red-500">
                                {{ errors.video }}
                            </div>
                            <p class="text-red-600">Select the same video or a new video</p>
                            <input 
                                type="file"
                                ref="video"
                                @input="form.video = $event.target.files[0]"
                                accept="video/*"
                            >
                        </div>
                        <div>
                            <p>Description (optional)</p>
                            <textarea 
                                v-model="form.description"
                                cols="30" 
                                rows="4" 
                                class="bg-slate-800 w-full"
                            ></textarea>
                        </div>
                        <div>
                            <p>Category</p>
                            <div v-if="errors.category_id" class="text-red-500">
                                {{ errors.category_id }}
                            </div>
                            <select v-model="form.category_id" class="bg-slate-800">
                                <option v-for="category in categories" :key="category.id" :value="category.id">
                                    {{ category.category }}
                                </option>
                            </select>
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
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import Header from '../Header/Header.vue';
import { defineComponent } from '@vue/runtime-core';
import { Inertia } from '@inertiajs/inertia';
import { ref } from 'vue';

defineComponent({
    Header
});

const props = defineProps({
    categories: Array,
    userLoggedName: String,
    video: Object,
    userLoggedId: Number,
    userAuthImg: Array,
    errors: Object,
});

const form = useForm({
    title: props.video.title,
    image: '',
    video: '',
    description: props.video.description,
    category_id: props.video.category_id,
});

function updateVideo() {
    Inertia.post(`/videos/${props.video.id}`, {
    _method: 'put',
    title: form.title,
    image: form.image,
    video: form.video,
    description: form.description,
    category_id: form.category_id,
})
}

</script>