<template>
    <div>
        <Header></Header>

        <div class="pt-14 pb-96 bg-slate-900 text-white">
            <div class="sm:p-5">
                <iframe 
                    :src="iframe" 
                    frameborder="0"
                    class="w-full h-56 sm:h-96"
                >
                </iframe>
            </div>
            <div class="mx-5 mt-2">
                <h2 class="text-xl text-bold">
                    {{ video.title }}
                </h2>
                <p class="text-gray-500 md:invisible md:h-0">
                    {{ video.views }} views
                </p>
                <div class="md:flex md:items-center">
                    <div>
                        <p class="text-gray-500 invisible h-0 w-0 md:visible md:h-3 md:w-20">
                            {{ video.views }} views
                        </p>
                    </div>
                    <div class="flex justify-around md:justify-start md:space-x-5 mt-2">
                        <div class="md:flex md:items-center md:space-x-2">
                            <img src="../../img/like.png" alt="Like">
                            <p>{{ video.likes }}</p>
                        </div>
                        <div class="md:flex md:items-center md:space-x-2">
                            <img src="../../img/disLike.png" alt="Dislike">
                            <p>{{ video.dislikes }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-y border-slate-600 mt-2 md:mt-4 px-5 sm:px-0 sm:mx-5 pt-2">
                <div class="flex justify-between items-start">
                    <div class="flex">
                        <div>
                            <img src="../../img/profile.png" alt="Profile">
                        </div>
                        <div class="ml-2 sm:w-60">
                            <h3 class="text-semibold">
                                {{ video.user.name }}
                            </h3>
                            <p class="text-gray-500 text-sm">
                                {{ video.user.subscribers }} subscribers
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center mt-4">
                        <p class="text-red-500 text-bold">
                            SUBSCRIBE
                        </p>
                    </div>
                </div>
                <div class="px-20 pb-4">
                    <p class="mt-4">
                        {{ video.description }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Header from './Header/Header.vue';

export default {
    components: {
        Header
    },
    props: {
        video: Object,
        iframe: String,
        image: String,
        videos: Array,
    },
}

</script>