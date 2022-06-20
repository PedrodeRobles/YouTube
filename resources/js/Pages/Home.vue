<template>
    <div>
        <Header @getQuery="querySon"></Header>
        <div class="bg-slate-900 pt-20 pb-96 sm:grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5">
            <div v-for="video in videos" :key="video.id" class="sm:flex sm:justify-center">
                <div class="mb-6 grid grid-cols-1 place-content-start">
                    <div>
                        <img class="h-48 w-full sm:h-40 sm:w-72" src="../../img/videoImage.png" alt="Video Cover">
                    </div>
                    <div class="grid grid-cols-6 w-80 sm:w-72 space-x-2 mt-2 ml-4 sm:ml-0">
                        <div class="col-span-1">
                            <img src="../../img/profile.png" alt="Profile">
                        </div>
                        <div class="col-span-5">
                            <h6 class="text-white text-lg font-semibold">{{ video.title }}</h6>
                            <div class="text-slate-500 flex space-x-2 sm:block sm:space-x-0">
                                <p>{{ video.user.name }} .</p>
                                <p>{{ video.views}} Views</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Header from './Header/Header.vue';

export default {
    components: {
        Header,
    },
    data() {
        return {
            q: null
        }
    },
    props: {
        videos: {
            type: Array,
        },
    },
    methods: {
        querySon(value) {
            this.q = value;
        }
    },
    watch: {
        q: function (q) {
            this.$inertia.get(this.route('home', {q: q}), {}, {preserveState: true})
        }
    },
}
</script>