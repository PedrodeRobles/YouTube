<template>
    <div class="bg-slate-900">
        <Header 
            @getQuery="querySon"
            :userAuth="userAuth"
            :userLoggedName="userLoggedName"
            :userLoggedId="userLoggedId"
        >
        </Header>

        <div class="flex justify-center">
            <div class="pt-24 flex justify-between text-white sm:space-x-2 md:space-x-4">
                <Link :href="route('home')">
                    <button class="bg-slate-800 rounded-[15px] py-1 px-2">
                        All
                    </button>
                </Link>
                <Link :href="route('gaming')">
                    <button class="bg-white rounded-[15px] py-1 px-2 text-black">
                        Gaming
                    </button>
                </Link>
                <Link :href="route('music')">
                    <button class="bg-slate-800 rounded-[15px] py-1 px-2">
                        Music
                    </button>
                </Link>
                <Link :href="route('news')">
                    <button class="bg-slate-800 rounded-[15px] py-1 px-2">
                        News
                    </button>
                </Link>
                <Link :href="route('sports')">
                    <button class="bg-slate-800 rounded-[15px] py-1 px-2">
                        Sports
                    </button>
                </Link>
                <Link :href="route('learning')">
                    <button class="bg-slate-800 rounded-[15px] py-1 px-2">
                        Learning
                    </button>
                </Link>
            </div>
        </div>

        <!-- Videos -->
        <div class="sm:flex justify-center bg-slate-900">
            <div class="pt-24 pb-[100rem] 2xl:pb-[1000px] sm:grid sm:grid-cols-2 sm:gap-x-3 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5">
                <div v-for="video in videos" :key="video.id">
                    <Link :href="route('videos.show', video.id)">
                        <div class="mb-6 grid grid-cols-1 place-content-start cursor-pointer">
                            <div>
                                <img class="h-48 w-full sm:h-40 sm:w-72" :src="video.image" alt="Video Cover">
                            </div>
                            <div class="grid grid-cols-6 w-80 sm:w-72 space-x-2 mt-2 ml-4 sm:ml-0">
                                <div class="col-span-1">
                                    <Link :href="route('userVideos', video.user.name)">
                                    <div v-if="video.user.profile_image == null">
                                        <img src="../../../img/profile.png" alt="Profile image">
                                    </div>
                                    <div v-else>
                                        <img 
                                            class="h-[50px] w-[50px] rounded-full"
                                            :src="users[video.user_id - 1].profile_image" alt="">
                                    </div>
                                    </Link>
                                </div>
                                <div class="col-span-5">
                                    <h6 class="text-white text-lg font-semibold">{{ video.title }}</h6>
                                    <div class="text-slate-500 flex space-x-2 sm:block sm:space-x-0">
                                        <Link :href="route('userVideos', video.user.name)">
                                            <p class="hover:underline hover:underline-offset-1">{{ video.user.name }} .</p>
                                        </Link>
                                        <p>{{ video.views}} Views</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
        <!-- endVideos -->
    </div>
</template>

<script>
import Header from '../Header/Header.vue';
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        Header,
        Link,
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
        userAuth: Boolean,
        userLoggedName: String,
        userLoggedId: Number,
        users: Array,
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