<template>
    <div class="bg-slate-900">
        <Header 
            @getQuery="querySon"
            :userAuth="userAuth"
            :userLoggedName="userLoggedName"
        >
        </Header>

        <div class="pt-20 pb-96 flex justify-center text-white">
            <div>
                <div class="flex justify-center mb-4">
                    <h2 class="text-2xl">Upload video</h2>
                </div>
                <div class="border border-slate-500 rounded-lg p-2">
                    <form @submit.prevent="updateVideo" class="space-y-3">
                        <div>
                            <p>Title</p>
                            <input 
                                type="text" 
                                v-model="form.title" 
                                class="bg-slate-800 w-full"
                            >
                        </div>
                        <div>
                            <p>Image</p>
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
                            <p class="text-red-600">Select the same video or a new video</p>
                            <input 
                                type="file"
                                ref="video"
                                @input="form.video = $event.target.files[0]"
                                accept="video/mp4"
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
    userAuth: Boolean,
    userLoggedName: String,
    video: Object
});

const form = useForm({
    title: props.video.title,
    image: props.video.image,
    video: props.video.video,
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

// export default {
//     components:{
//         Header
//     },
//     data() {
//         return {
//             form: {
//                 title: this.video.title,
//                 image: '',
//                 video: '',
//                 description: this.video.description,
//                 category_id: this.video.category_id,
//             }
//         }
//     },
//     props: {
//         categories: Array,
//         userAuth: Boolean,
//         userLoggedName: String,
//         video: Object
//     },
//     methods: {
//         submit() {
//             // if (this.$refs.photo && this.$refs.video) {
//             //     this.form.image = this.$refs.photo.files[0];
//             //     this.form.video = this.$refs.video.files[0];
//             // }
//             if (this.$refs.photo) {
//                 this.form.image = this.$refs.photo.files[0];
//             }
//             this.$inertia.put(this.route('videos.update', this.video.id), this.form)
//         },
//     }
// }
</script>