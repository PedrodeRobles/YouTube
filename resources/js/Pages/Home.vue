<template>
    <div class="bg-principal">
        <Header 
            @getQuery="querySon"
            @getShowNavBar="getShowNavBar"
            :showNavBar="showNavBar"
        >
        </Header>

        <NavBar 
            :homeView="homeView"
            :showNavBar="showNavBar"
        />

        <div class="md:pl-16">
            <NavSection :all="all"/>
    
            <!-- Videos -->
            <div class="sm:flex justify-center bg-principal">
                <div class="pt-6 pb-[100rem] 2xl:pb-[1000px] sm:grid sm:grid-cols-2 sm:gap-x-3 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5">
                    <div v-for="video in videos" :key="video.id">
                        <Link :href="route('videos.show', video.id)">
                            <div class="mb-6 grid grid-cols-1 place-content-start cursor-pointer">
                                <div>
                                    <img class="h-48 w-full sm:h-40 sm:w-72 sm:rounded-lg" :src="video.image" alt="Video Cover">
                                </div>
                                <div class="grid grid-cols-6 w-80 sm:w-72 space-x-2 mt-2 ml-4 sm:ml-0">
                                    <div class="col-span-1">
                                        <Link :href="route('userVideos', video.user.name)">
                                        <div v-if="video.user.profile_image == null">
                                            <img src="../../img/profile.png" alt="Profile image">
                                        </div>
                                        <div v-else>
                                            <img 
                                                class="h-[50px] w-[50px] rounded-full"
                                                :src="video.userImg" alt="Profile image">
                                        </div>
                                        </Link>
                                    </div>
                                    <div class="col-span-5">
                                        <h6 class="text-white text-lg font-semibold">{{ video.title }}</h6>
                                        <div class="text-txt flex space-x-2 sm:block sm:space-x-0">
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
import Header from './Header/Header.vue';
import NavSection from './Section/NavSection.vue';
import NavBar from './Section/NavBar.vue';
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        Header,
        Link,
        NavSection,
        NavBar
    },
    data() {
        return {
            q: null,
            all: true,
            homeView: true,
            showNavBar: true
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
        },
        getShowNavBar(data) {
            this.showNavBar = data;
            console.log(this.showNavBar);
        }
    },
    watch: {
        q: function (q) {
            this.$inertia.get(this.route('home', {q: q}), {}, {preserveState: true})
        }
    },
}
</script>