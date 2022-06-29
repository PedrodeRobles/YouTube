<template>
    <div class="bg-slate-900">
        <Header></Header>

        <InfoProfile 
            :user="userName"
            :subscribers="subscribers"
        >
        </InfoProfile>

        <!-- Videos -->
        <p class="text-2xl text-white pt-4 bg-slate-900 md:pl-10">
            Uploads
        </p>
        <div class="bg-slate-900 pb-96 pt-4 sm:grid sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-8 md:px-10 md:gap-2">
            <div v-for="video in userVideos" :key="video.id" class="sm:flex sm:justify-center">
                <div class="mb-2 grid grid-cols-1 place-content-start">
                    <div>
                        <img class="h-48 w-full sm:h-28 sm:w-52 xl:w-full" src="../../../img/videoImage.png" alt="Video Cover">
                    </div>
                    <div class="grid grid-cols-6 w-full sm:w-52 md:w-full lg:w-full space-x-2 mt-2">
                        <div class="col-span-1 pl-2">
                            <img src="../../../img/profile.png" alt="Profile">
                        </div>
                        <div class="col-span-5">
                            <h6 class="text-white text-md font-semibold">{{ video.title }}</h6>
                            <div class="text-slate-500 flex space-x-2 sm:block sm:space-x-0">
                                <p>{{ video.user.name }} .</p>
                                <p>{{ video.views}} Views</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- endVideos -->
    </div>
</template>

<script>
import Header from '../Header/Header.vue';
import InfoProfile from './InfoProfile.vue';

export default {
    components: {
        Header,
        InfoProfile
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
        }
    },
}
</script>