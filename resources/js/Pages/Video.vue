<template>
    <div>
        <Header 
            @getQuery="querySon"
        >
        </Header>

        <div class="pt-14 pb-[50rem] bg-principal text-white lg:grid lg:grid-cols-8">
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
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl text-bold">
                            {{ video.title }}
                        </h2>
                        <a :href="route('download_video', video.id)" class="flex items-center space-x-1 bg-secondary hover:bg-gray-700 rounded-lg p-1 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="#ffffff" d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z"/></svg>
                            <span>download</span>
                        </a>
                    </div>
                    <p class="text-txt md:invisible md:h-0">
                        {{ video.views }} views
                    </p>
                    <div class="md:flex md:items-center">
                        <div>
                            <p class="text-txt invisible h-0 w-0 md:visible md:h-3 md:w-20">
                                {{ video.views }} views
                            </p>
                        </div>
                        <div class="flex justify-around md:justify-start md:space-x-5 mt-2 md:bg-secondary md:rounded-lg md:p-1">
                            <form 
                                v-if="liked == null"
                                @submit.prevent="like" 
                                class="md:flex md:items-center md:space-x-2"
                            >
                                <button type="submit">
                                    <img src="../../img/like.png" alt="Like">
                                </button>
                                <p>{{ video.likes }}</p>
                            </form>
                            <form 
                                v-else 
                                @submit.prevent="unlike" 
                                class="md:flex md:items-center md:space-x-2"
                            >
                                <button type="submit">
                                    <img src="../../img/clickLike.png" alt="Unlike">
                                </button>
                                <p>{{ video.likes }}</p>
                            </form>
                            <span class="text-gray-600 text-xl invisible md:visible">|</span>
                            <form 
                                v-if="disliked == null"
                                @submit.prevent="dislike" 
                                class="md:flex md:items-center md:space-x-2"
                            >
                                <button type="submit">
                                    <img src="../../img/disLike.png" alt="Dislike">
                                </button>
                                <p>{{ video.dislikes }}</p>
                            </form>
                            <form 
                                v-else
                                @submit.prevent="undislike" 
                                class="md:flex md:items-center md:space-x-2"
                            >
                                <button type="submit">
                                    <img src="../../img/clickDislike.png" alt="">
                                </button>
                                <p>{{ video.dislikes }}</p>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="border-y border-slate-600 mt-2 md:mt-4 px-5 sm:px-0 sm:mx-5 pt-4">
                    <div class="flex justify-between items-start">
                        <div class="flex">
                            <div>
                                <div v-if="video.user.profile_image == null">
                                    <img src="../../img/profile.png" alt="Profile image">
                                </div>
                                <div v-else>
                                    <img 
                                        class="h-[50px] w-[50px] rounded-full"
                                        :src="video.userImg" alt="">
                                </div>
                            </div>
                            <div class="ml-2 sm:w-60">
                                <Link :href="route('userVideos', video.user.id)" class="text-semibold">
                                    {{ video.user.name }}
                                </Link>
                                <p class="text-txt text-sm">
                                    {{ video.user.subscribers }} subscribers
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <form v-if="subscribed == null" @submit.prevent="subscribe">
                                <button class="bg-white py-2 px-3 rounded-full" type="submit">
                                    <p class="text-principal">SUBSCRIBE</p> 
                                </button>
                            </form>
                            <div v-else>
                                <button  
                                    @click.prevent="unsubscribe" 
                                    class="bg-secondary py-2 px-3 rounded-full"
                                >
                                    <p class="text-white">UNSUBSCRIBE</p>
                                </button>
                            </div>
                        </div>
                        
                    </div>
                    <div class="px-20 pb-4">
                        <p v-if="video.description" class="mt-4 bg-secondary p-3 rounded-lg">
                            {{ video.description }}
                        </p>
                    </div>

                    <!-- Small to medium screen comments -->
                    <div class="border-t border-slate-600 lg:invisible lg:w-0 lg:h-0">
                        <div @click="showComments = !showComments" class="flex justify-between items-center">
                            <h3 class="py-4 text-lg">
                                Comments
                            </h3>
                            <img v-show="showComments == false" src="../../img/arrowDown.png" alt="Arrow" class="w-8 h-8 cursor-pointer">
                            <img v-show="showComments == true" src="../../img/arrowUp.png" alt="Arrow" class="w-8 h-8 cursor-pointer">
                        </div>
                        <div v-show="showComments == true">
                            <form @submit.prevent="comment">
                                <div class="grid grid-cols-12 mb-4">
                                    <div class="col-span-1">
                                        <div v-if="authUserImage == null">
                                            <img src="../../img/profile.png" alt="Profile image">
                                        </div>
                                        <div v-else>
                                            <img 
                                                class="h-7 w-7 rounded-full"
                                                :src="authUserImage" alt="">
                                        </div>
                                    </div>
                                    <div class="ml-2 col-span-11">
                                        <div>
                                            <p>Add comment:</p> 
                                            <div class="md:flex">
                                                <textarea 
                                                    v-model="form.content"
                                                    cols="30" rows="1" 
                                                    class="bg-secondary borber-b border-slate-500 w-full"
                                                    maxlength="250"
                                                >
                                                </textarea>
                                                <div class="flex justify-between md:pl-4">
                                                    <span class="text-gray-300 text-sm">
                                                        Max 250 characters
                                                    </span>
                                                    <button type="submit" class="p-2 bg-blue-600">
                                                        Comment
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="comments-container">
                            <div v-show="showComments" v-for="comment in comments" :key="comment.id">
                                <div class="grid grid-cols-12 mb-6">
                                    <div class="col-span-1">
                                        <div v-if="comment.has_profile_image">
                                            <img 
                                                class="h-7 w-7 rounded-full"
                                                :src="comment.profile_image" alt="">
                                            </div>
                                        <div v-else>
                                            <img src="../../img/profile.png" alt="Profile image">
                                        </div>
                                    </div>
                                    <div class="ml-2 col-span-11">
                                        <Link :href="route('userVideos', video.user.id)" class="text-semibold">
                                            <p class="text-semibold">
                                                {{ comment.user_name }}
                                            </p>
                                        </Link>
                                        <p class="w-full" style="word-break: break-word; overflow-wrap: break-word;">
                                            {{ comment.content }} 
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Comments on the large screen -->
                    <div class="border-t border-slate-600 invisible h-0 lg:visible">
                        <div class="flex justify-between items-center">
                            <h3 class="py-4 text-lg">
                                Comments
                            </h3>
                        </div>
                        <form @submit.prevent="comment">
                            <div class="grid grid-cols-12 mb-4">
                                <div class="col-span-1">
                                    <div v-if="authUserImage == null">
                                        <img src="../../img/profile.png" alt="Profile image">
                                    </div>
                                    <div v-else>
                                        <img 
                                            class="h-12 w-12 rounded-full"
                                            :src="authUserImage" alt="">
                                    </div>
                                </div>
                                <div class="ml-2 col-span-11">
                                    <div>
                                        <p>Add comment</p>
                                        <div class="md:flex">
                                            <textarea 
                                                v-model="form.content"
                                                cols="30" rows="1" 
                                                class="bg-secondary borber-b border-slate-500 w-full"
                                                maxlength="250"
                                            >
                                            </textarea>
                                            <div class="flex justify-end md:pl-4">
                                                <button type="submit" class="p-2 bg-blue-600">
                                                    Comment
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-gray-300 text-sm">
                                        Max 250 characters
                                    </span>
                                </div>
                            </div>
                        </form>
                        <div class="comments-container">
                            <div 
                                v-for="comment in comments" :key="comment.id"
                                class="bg-primary"
                            >
                                <div class="grid grid-cols-12 lg:flex pb-6">
                                    <div class="col-span-1">
                                        <div v-if="comment.has_profile_image">
                                            <img 
                                            class="h-12 w-12 rounded-full"
                                            :src="comment.profile_image" alt="">
                                        </div>
                                        <div v-else>
                                            <img src="../../img/profile.png" alt="Profile image" class="h-12 w-12">
                                        </div>
                                    </div>
                                    <div class="ml-2 col-span-11 w-4/5">
                                        <Link :href="route('userVideos', video.user.id)" class="text-semibold">
                                            <p class="text-semibold">
                                                {{ comment.user_name }}
                                            </p>
                                        </Link>
                                        <p class="w-full" style="word-break: break-word; overflow-wrap: break-word;">
                                            {{ comment.content }} 
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Videos of other users -->
            <div class="mt-5 md:flex md:justify-center lg:justify-start lg:mr-6 lg:col-span-3 xl:col-span-2">
                <div class="md:grid md:grid-cols-2 md:gap-4 lg:grid-cols-none">
                    <div v-for="video in videos" :key="video.id">
                        <Link :href="route('videos.show', video.id)">
                            <div class="lg:flex lg:items-start">
                                <div>
                                    <img 
                                        :src="video.image" 
                                        alt="Video"
                                        class="w-full h-48 sm:h-72 md:h-36 lg:h-24 lg:w-40 sm:rounded-lg">
                                </div>
                                <div class="grid grid-cols-6 w-80 sm:w-72 space-x-2 mt-2 lg:mt-0 ml-4 sm:ml-0 lg:w-40 xl:w-40">
                                    <div class="col-span-1 lg:col-auto">
                                        <div v-if="video.user.profile_image == null">
                                            <img src="../../img/profile.png" alt="Profile image" class="lg:invisible lg:w-0 lg:h-0">
                                        </div>
                                        <div v-else>
                                            <img 
                                                class="h-[50px] w-[50px] rounded-full lg:invisible lg:w-0 lg:h-0"
                                                :src="video.userImg" alt="">
                                        </div>
                                    </div>
                                    <div class="col-span-5 lg:col-span-6">
                                        <h6 class="text-white text-lg font-semibold">{{ video.title }}</h6>
                                        <div class="text-txt flex space-x-2 sm:block sm:space-x-0">
                                            <Link :href="route('userVideos', video.user.id)">
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
        searchVideos: Array,
        userId: Number,
        subscribed: Object,
        liked: Object,
        disliked: Object,
        comments: Array,
        users: Array,
        userLoggedId: Number,
        authUserImage: String,
    },
    data() {
        return {
            form: {
                'user_id': this.userLoggedId,
                'otherUser': this.userId,
                'subscribers' :this.subscribers,
                'video_id': this.video.id,
                'content': '',
            },
            q: null,
            showComments: false
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
        subscribe() {
            this.$inertia.post('subscribe', this.form)
        },
        unsubscribe() {
            this.$inertia.delete(this.route('unsubscribe', this.form));
        },
        like() {
            this.$inertia.post('like', this.form);
        },
        unlike() {
            this.$inertia.delete(this.route('unlike', this.form));
        },
        dislike() {
            this.$inertia.post('dislike', this.form);
        },
        undislike() {
            this.$inertia.delete(this.route('undislike', this.form));
        },
        comment()
        {
            this.$inertia.post('comment', this.form);
            this.form.content = "";
        }
    },
}

</script>

<style scoped>
.comments-container {
    max-height: 500px; /* Ajusta la altura según sea necesario */
    overflow-y: auto; /* Permite el desplazamiento vertical */
    padding: 1rem; /* Espaciado interno */
    border: 1px solid #b3b0b05b; /* Borde opcional */
    border-radius: 8px; /* Bordes redondeados opcionales */
}

/* Barra de desplazamiento */
::-webkit-scrollbar {
    width: 10px; /* Ancho de la barra de desplazamiento */
}

/* Fondo de la barra de desplazamiento */
::-webkit-scrollbar-track {
    background: #f1f1f18a; /* Color de fondo de la pista */
}

/* Tamaño del "thumb" o la parte que puedes arrastrar */
::-webkit-scrollbar-thumb {
    background: #555; /* Color del thumb */
    border-radius: 10px; /* Bordes redondeados del thumb */
}
</style>