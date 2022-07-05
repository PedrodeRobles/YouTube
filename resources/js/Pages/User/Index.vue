<template>
    <div class="bg-slate-900">
        <Header  @getQuery="querySon"></Header>

        <InfoProfile 
            :user="userName"
            :subscribers="subscribers"
            :userLoggedId="userLoggedId"
            :userId="userId"
        >
        </InfoProfile>

        <!-- Videos -->
        <p class="text-2xl text-white pt-4 bg-slate-900 sm:pl-16 md:pl-10">
            Uploads
        </p>
        <div class="bg-slate-900 pb-96 pt-4 sm:grid sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-8 md:px-10 md:gap-2">
            <div v-for="video in userVideos" :key="video.id" class="sm:flex sm:justify-center">
                <Miniature :video="video"></Miniature>
            </div>
        </div>
        <!-- endVideos -->
    </div>
</template>

<script>
import Header from '../Header/Header.vue';
import InfoProfile from './InfoProfile.vue';
import Miniature from './Miniature.vue';

export default {
    components: {
        Header,
        InfoProfile,
        Miniature
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
        video: {
            type: Object
        },
    },
    data() {
        return {
            q: null
        }
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