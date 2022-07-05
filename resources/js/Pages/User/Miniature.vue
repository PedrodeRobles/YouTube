<template>
    <div>
        <div class="mb-2 grid grid-cols-1 place-content-start">
            <div>
                <img class="h-48 w-full sm:h-28 sm:w-52 xl:w-full" src="../../../img/videoImage.png" alt="Video Cover">
            </div>
            <div class="grid grid-cols-6 w-full sm:w-52 md:w-full lg:w-full space-x-2 mt-2">
                <div class="col-span-1 pl-2">
                    <img src="../../../img/profile.png" alt="Profile" @change="previewImage">
                    <img :src="video.image" alt="">
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
</template>

<script>
export default {
    props: {
        video: Object,
    },
    
}
</script>