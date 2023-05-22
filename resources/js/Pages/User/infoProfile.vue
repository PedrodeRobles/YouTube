<template>
    <div>
        <div class="pt-12">
            <div class="bg-slate-700">
                <div v-if="userBackgroundImage !== null">
                    <img 
                        class="h-32 sm:h-26 md:h-40 w-full object-cover"
                        :src="users[userId - 1].bg_image" alt="">
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
                                        :src="users[userId - 1].profile_image" alt="">
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
                        <Link :href="route('editProfile', userLoggedId)">
                            <p class="p-2 bg-blue-500 hover:bg-blue-400 text-white rounded-full">
                                Edit profile
                            </p>
                        </Link>
                        <Link :href="route('videos.create')">
                            <p class="p-2 bg-[#FF4E45] hover:bg-red-500 text-white rounded-full">
                                Add video
                            </p>
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