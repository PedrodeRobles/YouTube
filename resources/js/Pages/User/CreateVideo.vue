<template>
    <div class="bg-principal">
        <Header 
            @getQuery="querySon"
            :userLoggedName="userLoggedName"
            :userLoggedId="userLoggedId"
            :userAuthImg="userAuthImg"
        >
        </Header>

        
        <div>
            <!-- Show message when uploading video -->
            <div v-show="message == null" class="p-1 w-full bg-yellow-300 pt-6">
                <p class="text-center text-black text-xl">
                    .
                </p>
            </div>
            <div v-show="message != null" class="p-1 w-full bg-yellow-300 pt-16">
                <p class="text-center text-black text-xl">
                    {{ message }}
                </p>
            </div>

            <!-- Form -->
            <div class="pt-8 pb-96 flex justify-center text-white w-full">
                <div>
                    <div class="flex justify-center mb-4">
                        <h2 class="text-2xl">Upload video</h2>
                    </div>
                    <div class="border border-slate-500 rounded-lg p-2">
                        <form @submit.prevent="submit" class="space-y-3">
                            <div>
                                <p>Title</p>
                                <div v-if="errors.title" class="text-red-500">
                                    {{ errors.title }}
                                </div>
                                <input 
                                    type="text" 
                                    v-model="form.title" 
                                    class="bg-secondary w-full"
                                >
                            </div>
                            <div>
                                <p>Image</p>
                                <div v-if="errors.image" class="text-red-500">
                                    {{ errors.image }}
                                </div>
                                <input 
                                    type="file"
                                    ref="photo"
                                    accept="image/*"
                                >
                            </div>
                            <div>
                                <p>Video / Max 60.000 KB</p>
                                <div v-if="errors.video" class="text-red-500">
                                    {{ errors.video }}
                                </div>
                                <input 
                                    type="file"
                                    ref="video"
                                    accept="video/*"
                                >
                            </div>
                            <div>
                                <p>Description (optional)</p>
                                <textarea 
                                    v-model="form.description"
                                    cols="30" 
                                    rows="4" 
                                    class="bg-secondary w-full"
                                ></textarea>
                            </div>
                            <div>
                                <p>Category</p>
                                <div v-if="errors.category_id" class="text-red-500">
                                    {{ errors.category_id }}
                                </div>
                                <select v-model="form.category_id" class="bg-secondary">
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
            },
            message: null,
        }
    },
    props: {
        categories: Array,
        userLoggedName: String,
        userLoggedId: Number,
        userAuthImg: Array,
        errors: Object,
    },
    methods: {
        submit() {
            this.message = "Uploading video please wait...";

            if (this.$refs.photo && this.$refs.video) {
                this.form.image = this.$refs.photo.files[0];
                this.form.video = this.$refs.video.files[0];
            }
            this.$inertia.post(this.route('videos.store'), this.form);

            this.form.title = '';
            this.form.image = '';
            this.form.video = '';
            this.form.description = '';
            this.form.category_id = '';
        },
    }
}
</script>