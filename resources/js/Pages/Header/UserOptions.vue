<template>
    <div class="bg-secondary border border-slate-600 text-white fixed mt-1 mr-4 animate__animated animate__fadeIn">
        <div class="p-2 w-28 space-y-1">
            <div>
                <Link :href="route('userVideos', userLoggedId)">
                    My Channel
                </Link>
            </div>
            <div>
                <Link :href="route('editProfile', userLoggedId)">
                    Edit profile
                </Link>
            </div>
            <form @submit.prevent="logout">
                <button class="text-red-500">
                    Log Out
                </button>
            </form>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import 'animate.css';

export default {
    props: {
        userLoggedName: String,
        userLoggedId: Number,
        showOptions: Boolean
    },
    components: {
        Link
    },
    methods: {
        logout() {
            this.$inertia.post(this.route('logout'), this.form);
        },
    },
}
</script>