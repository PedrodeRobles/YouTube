<template>
    <div class="bg-slate-900">
        <Header 
            @getQuery="querySon"
            :userAuth="userAuth"
            :userLoggedName="userLoggedName"
            :userLoggedId="userLoggedId"
            :userAuthImg="userAuthImg"
        >
        </Header>
    
        <nav class="invisible w-0 h-0 md:visible md:w-16 md:h-screen bg-slate-800 md:mt-14 md:fixed text-white">
            <div class="flex justify-center md:mt-4">
                <div class="space-y-6">
                    <div>
                        <Link :href="route('home')">
                            <img src="../../../img/unHome.png" alt="Home" class="md:ml-2">
                            <p class="text-sm">
                                Home
                            </p>
                        </Link>
                    </div>
                    <div>
                        <Link :href="route('liked')">
                            <img src="../../../img/clickLike.png" alt="Liked" class="md:ml-2">
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

        <div class="text-white pt-20 flex justify-center">
            <div>
                <div>
                    <h1 class="text-xl">Liked Videos</h1>
                </div>
            
                <div class="pb-[200rem] pt-4">
                    <div v-for="like in liked" :key="like.id">
                        <Link :href="route('videos.show', like.video.id)">
                            <div class="border border-slate-500 p-2 hover:bg-slate-800">
                                <!-- <div v-show="like.video_id == videos[like.video_id - 1].id">
                                    Culo
                                </div> -->
                                <img 
                                    class="h-48 w-full sm:h-40 sm:w-72"
                                    v-show="like.video_id == videos[like.video_id - 1].id" 
                                    :src="videos[like.video_id - 1].image" 
                                    alt="Video image">
                                <h3 class="w-72">
                                    {{ like.video.title }}
                                </h3>
                            </div>
                        </Link>
                    </div>
                </div>

            </div>
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
    props: {
        liked: Array,
        videos: Array,
        userAuth: Boolean,
        userLoggedName: String,
        userLoggedId: Number,
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