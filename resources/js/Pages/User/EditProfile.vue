<template>
    <form @submit.prevent="editProfileImg(user.id)">
        <input type="text" v-model="form.information">
        <button type="submit">
            Send
        </button>
    </form>
</template>

<script>

export default {
    props: {
        user: Object
    },
    data() {
        return {
            form: {
                information: '',
            }
        }
    },
    methods: {
        editProfileImg(id) {
            this.$inertia.put(route('editProfileImg', id), this.form);
        }
    }
}
</script>