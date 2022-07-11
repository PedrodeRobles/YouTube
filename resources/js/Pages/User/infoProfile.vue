<template>
    <div>
        <div class="bg-slate-800 pt-12">
            <div class="bg-indigo-600">
                <img class="h-32 sm:h-26 md:h-44 lg:h-60 w-full" src="../../../img/videoImage.png" alt="image">
            </div>
            <div class="flex justify-center pt-2 w-full md:py-4">
                <div class="flex-none md:flex md:w-full md:justify-between md:px-10 md:items-center">
                    <div class="flex justify-center">
                        <div class="flex-none md:flex md:items-center">
                            <div class="flex justify-center">
                                <img class="md:w-20" src="../../../img/profile.png" alt="Profile">
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

                    <div v-if="userLoggedId == userId" class="flex justify-center">
                        <Link :href="route('videos.create')">
                            <img src="../../../img/create.png" alt="Add video">
                        </Link>
                    </div>
                    <div v-else class="flex justify-center py-2">
                        <!-- <button class="bg-red-600 py-2 px-3">
                            <p class="text-white">SUBSCRIBE</p> 
                        </button> -->
                        <form v-if="subscribed == null" @submit.prevent="subscribe">
                            <button class="bg-red-600 py-2 px-3" type="submit">
                                <p class="text-white">SUBSCRIBE</p> 
                            </button>
                        </form>
                        <div v-else>
                            Chau
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
        subscribed: Object
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
    },
}

</script>