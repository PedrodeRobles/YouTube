<template>
    <div>
        <div class="pt-12">
            <div class="bg-slate-700">
                <div v-if="userBackgroundImage !== null">
                    <img 
                        class="h-32 sm:h-26 md:h-40 w-full object-cover"
                        :src="userBackgroundImage" alt="Cover photo">
                </div>
                <div v-else>
                    <img class="h-32 sm:h-26 md:h-40 w-full object-cover" src="../../../img/videoImage.png" alt="image">
                </div>
                <!-- <img class="h-32 sm:h-26 md:h-44 lg:h-60 w-full" src="../../../img/videoImage.png" alt="image"> -->
            </div>
            <div class="flex justify-center pt-2 w-full md:py-4">
                <div class="flex-none md:flex md:w-full md:justify-between md:px-10 md:items-center">
                    <div class="flex justify-center">
                        <div class="flex-none md:flex md:items-center">
                            <div class="flex justify-center">
                                <div v-if="userImage == null">
                                    <img src="../../../img/profile.png" alt="Profile image">
                                </div>
                                <div v-else>
                                    <img 
                                        class="h-[50px] w-[50px] rounded-full"
                                        :src="userImage" alt="User img">
                                </div>
                            </div>
                            <div class="text-white h-8 md:ml-4 md:mb-4">
                                <div class="flex justify-center md:justify-start">
                                    <h2 class="text-2xl text-bold">
                                        {{ user }}
                                    </h2>
                                </div>
                                <p class="text-white invisible md:visible md:text-gray-400">
                                    {{ subscribers }} subscribers
                                </p>
                            </div>
                        </div>
                    </div>

                    <div v-if="userLoggedId == userId" class="flex justify-center items-center space-x-2">
                        <Link :href="route('editProfile', userLoggedId)" class="flex items-center p-2 bg-blue-500 hover:bg-blue-400 text-white rounded-lg">
                            <span>
                                Edit profile
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="#ffffff" d="M3 21v-4.25L16.2 3.575q.3-.275.663-.425t.762-.15t.775.15t.65.45L20.425 5q.3.275.438.65T21 6.4q0 .4-.137.763t-.438.662L7.25 21zM17.6 7.8L19 6.4L17.6 5l-1.4 1.4z"/></svg>
                        </Link>
                        <Link :href="route('videos.create')" class="flex items-center p-2 bg-[#FF4E45] hover:bg-red-500 text-white rounded-lg">
                            <span>
                                Add video
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="#ffffff" d="M11 16V7.85l-2.6 2.6L7 9l5-5l5 5l-1.4 1.45l-2.6-2.6V16zm-5 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z"/></svg>
                        </Link>
                    </div>
                    <div v-else class="flex justify-center py-2">
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

                    <div class="flex justify-center md:hidden">
                        <p class="text-white">
                            {{ subscribers }} subscribers
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';


export default  {
    components: {
        Link
    },
    props: {
        user: String,
        subscribers: Number,
        userLoggedId: Number,
        userId: Number,
        subscribed: Object,
        users: Array,
        userImage: String,
        userBackgroundImage: String
    },
    data() {
        return {
            form: {
                'user_id': this.userLoggedId,
                'otherUser': this.userId,
                'subscribers' :this.subscribers,
            },
        }
    },
    methods: {
        subscribe() {
            this.$inertia.post('subscribe', this.form)
        },
        unsubscribe() {
            this.$inertia.delete(this.route('unsubscribe', this.form));
        }
    },
}

</script>