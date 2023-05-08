<template>
    <div class="bg-slate-900">
        <Header 
            @getQuery="querySon"
            :userAuthImg="userAuthImg"
        >
        </Header>

        <nav class="invisible w-0 h-0 md:visible md:w-16 md:h-screen bg-slate-800 md:mt-14 md:fixed text-white">
            <div class="flex justify-center md:mt-4">
                <div class="space-y-6">
                    <div>
                        <Link :href="route('home')">
                            <img src="../../../img/home.png" alt="Home" class="md:ml-2">
                            <p class="text-sm">
                                Home
                            </p>
                        </Link>
                    </div>
                    <div>
                        <Link :href="route('liked')">
                            <img src="../../../img/like.png" alt="Liked" class="md:ml-2">
                            <p class="text-sm md:ml-1">
                                Liked
                            </p>
                        </Link>
                    </div>
                    <div>
                        <Link :href="route('subscriptions')">
                            <img src="../../../img/subscriptions.png" alt="subscriptions" class="md:ml-2 md:h-[24px] md:w-[24px]">
                            <p class="text-sm md:ml-1">
                                Subs.
                            </p>
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <div class="md:pl-16">
            <div class="flex justify-center">
                <div class="pt-20 flex justify-between text-white sm:space-x-2 md:space-x-4">
                    <Link :href="route('home')">
                        <button class="bg-slate-800 rounded-[15px] py-1 px-2">
                            All
                        </button>
                    </Link>
                    <Link :href="route('gaming')">
                        <button class="bg-slate-800 rounded-[15px] py-1 px-2">
                            Gaming
                        </button>
                    </Link>
                    <Link :href="route('music')">
                        <button class="bg-white rounded-[15px] py-1 px-2 text-black">
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
                <div class="pt-6 pb-[100rem] 2xl:pb-[1000px] sm:grid sm:grid-cols-2 sm:gap-x-3 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5">
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
        users: Array,
        userAuthImg: Array
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