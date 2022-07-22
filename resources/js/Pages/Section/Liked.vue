<template>
    <div class="bg-slate-900">
        <Header 
            @getQuery="querySon"
            :userAuth="userAuth"
            :userLoggedName="userLoggedName"
            :userLoggedId="userLoggedId"
        >
        </Header>
    
        <div class="invisible w-0 h-0 md:visible md:w-16 md:h-screen bg-slate-800 md:mt-14 md:fixed text-white">
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
                        <img src="../../../img/subscriptions.png" alt="subscriptions" class="md:ml-2 md:h-[24px] md:w-[24px]">
                        <p class="text-sm md:ml-1">
                            Subs.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-white pt-20 flex justify-center">
            <div>
                <div>
                    <h1 class="text-xl">Liked Videos</h1>
                </div>
            
                <div class="pb-[200rem] pt-4">
                    <div v-for="like in liked" :key="like.id">
                        <Link :href="route('videos.show', like.video.id)">
                            <div class="border border-slate-500 p-2 hover:bg-slate-800">
                                <h3>
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