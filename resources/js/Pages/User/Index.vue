<template>
    <div class="bg-slate-900">
        <Header 
            @getQuery="querySon"
            :userAuth="userAuth"
            :userLoggedName="userLoggedName"
            :userLoggedId="userLoggedId"
        >
        </Header>

        <InfoProfile 
            :user="userName"
            :subscribers="subscribers"
            :userLoggedId="userLoggedId"
            :userId="userId"
            :subscribed="subscribed"
            :users="users"
            :userImage="userImage"
            :userBackgroundImage="userBackgroundImage"
        >
        </InfoProfile>

        <!-- Videos -->
        <p class="text-2xl text-white pt-4 bg-slate-900 sm:pl-16 md:pl-10">
            Uploads
        </p>
        <div class="bg-slate-900 pb-[50rem] pt-4 sm:grid sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-8 md:px-10 md:gap-2">
            <div v-for="video in userVideos" :key="video.id" class="sm:flex sm:justify-center">
                <Link :href="route('videos.show', video.id)">
                    <div class="mb-2 grid grid-cols-1 place-content-start">
                        <div>
                            <img class="h-48 w-full sm:h-28 sm:w-52 xl:w-full" :src="video.image" alt="Video Cover">
                        </div>
                        <div class=" w-full sm:w-52 md:w-full lg:w-full space-x-2 mt-2">
                            <!-- <div class="col-span-1 pl-2">
                                <img src="../../../img/profile.png" alt="Profile">
                            </div> -->
                            <div>
                                <div class="flex justify-between">
                                    <div>
                                        <h6 class="text-white text-md font-semibold">{{ video.title }}</h6>
                                        <div class="text-slate-500 flex space-x-2 sm:block sm:space-x-0">
                                            <p>{{ video.views}} Views</p>
                                        </div>
                                    </div>
                                    <div v-show="userLoggedId == userId">
                                        <Link :href="(route('videos.edit', video.id))">
                                            <img src="../../../img/edit.png" alt="Edit video">
                                        </Link>
                                    </div>
                                    <div v-show="userLoggedId == userId">
                                        <a href="#" @click.prevent="destroy(video.id)" >
                                            <img
                                                src="../../../img/delete.png" 
                                                alt="Edit video"
                                                class="w-8"
                                            >
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </Link>
            </div>
        </div>
        <!-- endVideos -->
    </div>
</template>

<script>
import Header from '../Header/Header.vue';
import InfoProfile from './InfoProfile.vue';
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        Header,
        InfoProfile,
        Link,
    },
    props: {
        userVideos: {
            type: Array,
        },
        userName: {
            type: String
        },
        subscribers: {
            type: Number
        },
        userLoggedId: {
            type: Number
        },
        userId: {
            type: Number
        },
        userAuth: Boolean,
        userLoggedName: String,
        subscribed: Object,
        userLoggedId: Number,
        userId: Number,
        users: Array,
        userImage: String,
        userBackgroundImage: String,
    },
    data() {
        return {
            q: null
        }
    },
    watch: {
        q: function (q) {
            this.$inertia.get(this.route('home', {q: q}), {}, {preserveState: true})
        }
    },
    methods: {
        querySon(value) {
            this.q = value;
        },
        destroy(id) {
            if (confirm('Do you want to delete this video!?')) {
                this.$inertia.delete(this.route('videos.destroy', id))
            }
        }
    },
}
</script>