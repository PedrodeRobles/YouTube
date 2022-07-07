<template>
    <div>
        <Header></Header>

        <div class="pt-14 pb-96 bg-slate-900 text-white lg:grid lg:grid-cols-8">
            <div class="lg:col-span-5 xl:col-span-6">
                <div class="sm:px-5 sm:pt-5">
                    <iframe 
                        :src="iframe" 
                        frameborder="0"
                        class="w-full h-56 sm:h-96 lg:h-[22rem] xl:h-[35rem] 2xl:h-[40rem]"
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
                <div class="border-y border-slate-600 mt-2 md:mt-4 px-5 sm:px-0 sm:mx-5 pt-4">
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
                        <div class="flex items-center">
                            <button class="bg-red-600 py-2 px-3">
                                <p>SUBSCRIBE</p> 
                            </button>
                        </div>
                    </div>
                    <div class="px-20 pb-4">
                        <p class="mt-4">
                            {{ video.description }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="mt-5 md:flex md:justify-center lg:justify-start lg:mr-6 lg:col-span-3 xl:col-span-2">
                <div class="md:grid md:grid-cols-2 md:gap-4 lg:grid-cols-none">
                    <div v-for="video in videos" :key="video.id">
                        <Link :href="route('videos.show', video.id)">
                            <div class="lg:flex lg:items-start">
                                <div>
                                    <img 
                                        :src="video.image" 
                                        alt="Video"
                                        class="w-full h-48 sm:h-72 md:h-36 lg:h-24 lg:w-40">
                                </div>
                                <div class="grid grid-cols-6 w-80 sm:w-72 space-x-2 mt-2 lg:mt-0 ml-4 sm:ml-0 lg:w-40 xl:w-40">
                                    <div class="col-span-1 lg:col-auto">
                                        <img src="../../img/profile.png" alt="Profile" class="lg:invisible lg:w-0 lg:h-0">
                                    </div>
                                    <div class="col-span-5 lg:col-span-6">
                                        <h6 class="text-white text-lg font-semibold">{{ video.title }}</h6>
                                        <div class="text-slate-500 flex space-x-2 sm:block sm:space-x-0">
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
        </div>
    </div>
</template>

<script>
import Header from './Header/Header.vue';
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        Header,
        Link,
    },
    props: {
        video: Object,
        iframe: String,
        image: String,
        videos: Array,
    },
}

</script>