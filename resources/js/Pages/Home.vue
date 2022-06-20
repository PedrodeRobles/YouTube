<template>
    <div>
        <Header></Header>
        <div class="bg-slate-900 pt-20 sm:grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5">
            <div v-for="video in videos" :key="video.id" class="flex justify-center">
                <div class="mb-6 grid grid-cols-1">
                    <div>
                        <img class="h-40 w-72" src="../../img/videoImage.png" alt="Video Cover">
                    </div>
                    <div class="grid grid-cols-6 w-72 space-x-2 mt-2">
                        <div class="col-span-1">
                            <img src="../../img/profile.png" alt="Profile">
                        </div>
                        <div class="col-span-5">
                            <h6 class="text-white text-lg">{{ video.title }}</h6>
                            <div class="text-slate-500">
                                <p>{{ video.user.name }}</p>
                                <p>{{ video.views}} Views</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Header from './Header/Header.vue';

export default {
    components: {
        Header,
    },
    props: {
        videos: {
            type: Array,
        },
    }
}
</script>