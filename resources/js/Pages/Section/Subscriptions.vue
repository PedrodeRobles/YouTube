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
                            <img src="../../../img/like.png" alt="Liked" class="md:ml-2">
                            <p class="text-sm md:ml-1">
                                Liked
                            </p>
                        </Link>
                    </div>
                    <div>
                        <Link :href="route('subscriptions')">
                            <img src="../../../img/clickSubs.png" alt="subscriptions" class="md:ml-2 md:h-[24px] md:w-[24px]">
                            <p class="text-sm md:ml-1">
                                Subs.
                            </p>
                        </Link>
                    </div>
                </div>
            </div>
        </nav>
    
        <section class="pt-20 pb-[50rem] text-white">
            <h1 class="text-xl text-center mb-4">Subscriptions</h1>
            <div v-for="subscription in subscriptions" :key="subscription.id">
                <div v-for="user in users" :key="user.id">
                    <div v-show="subscription.otherUser == user.id" class="flex justify-center">
                        <Link :href="route('userVideos', user.name)">
                            <div class="border border-slate-600 flex w-72 p-2 items-center space-x-2 hover:bg-slate-400 hover:text-black">
                                <img v-if="user.profile_image == null" src="../../../img/profile.png" alt="Profile Image Default">
                                <img
                                    v-else
                                    class="h-[50px] w-[50px] rounded-full"
                                    :src="user.profile_imageAsset" 
                                    alt="Profile Image"
                                >
                                <p>{{ user.name }}</p>
                            </div>
                        </Link>
                    </div>
                </div>
            </div>
        </section>

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
        userAuth: Boolean,
        userLoggedName: String,
        userLoggedId: Number,
        subscriptions: Array,
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