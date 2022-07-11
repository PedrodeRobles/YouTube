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
                    <form @submit.prevent="submit" class="space-y-3">
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
                            <input 
                                type="file"
                                ref="photo"
                                accept="image/*"
                            >
                        </div>
                        <div>
                            <p>Video (.mp4)</p>
                            <input 
                                type="file"
                                ref="video"
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
                                Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Header from '../Header/Header.vue';

export default {
    components:{
        Header
    },
    data() {
        return {
            form: {
                title: '',
                image: '',
                video: '',
                description: '',
                category_id: '',
            }
        }
    },
    props: {
        categories: Array,
        userAuth: Boolean,
        userLoggedName: String
    },
    methods: {
        submit() {
            if (this.$refs.photo && this.$refs.video) {
                this.form.image = this.$refs.photo.files[0];
                this.form.video = this.$refs.video.files[0];
            }
            this.$inertia.post(this.route('videos.store'), this.form);
        },
    }
}
</script>