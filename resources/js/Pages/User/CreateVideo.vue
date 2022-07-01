<template>
    <div class="bg-slate-900">
        <Header></Header>

        <div class="pt-44 pb-96 flex justify-center text-white">
            <div>
                <form @submit.prevent="submit">
                    <div>
                        <p>Title</p>
                        <input type="text" v-model="form.title" class="bg-slate-800">
                    </div>
                    <div>
                        <p>Image</p>
                        <input type="text" v-model="form.image" class="bg-slate-800">
                    </div>
                    <div>
                        <p>Video</p>
                        <input type="text" v-model="form.video" class="bg-slate-800">
                    </div>
                    <div>
                        <p>Description</p>
                        <input type="text" v-model="form.description" class="bg-slate-800">
                    </div>
                    <div>
                        <p>Category</p>
                        <select v-model="form.category_id" class="bg-slate-800">
                            <option v-for="category in categories" :key="category.id" :value="category.id">
                                {{ category.category }}
                            </option>
                        </select>
                    </div>
                    <div>
                        <button>
                            Create
                        </button>
                    </div>
                </form>
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
    },
    methods: {
        submit() {
            this.$inertia.post(this.route('videos.store'), this.form);
        }
    }
}
</script>