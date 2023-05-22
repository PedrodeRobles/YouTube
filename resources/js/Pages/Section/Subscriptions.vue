<template>
    <div class="bg-principal">
        <Header 
            @getQuery="querySon"
        >
        </Header>

        <NavBar :subsView="subsView"/>
    
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
import NavBar from './NavBar.vue';

export default {
    components: {
        Header,
        Link,
        NavBar
    },
    props: {
        subscriptions: Array,
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
    data() {
        return {
            subsView: true
        }
    }
}
</script>