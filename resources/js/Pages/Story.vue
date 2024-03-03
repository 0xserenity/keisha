<template>
    <div class="relative h-screen">
        <div :style="{ backgroundImage: 'url(' + imageUrl + ')' }" class="absolute inset-0 bg-cover bg-center md:bg-contain"></div>
        <div class="absolute inset-0 bg-white opacity-75"></div>
        <div class="absolute inset-0 flex flex-col justify-center items-center">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">{{ story.title }}</h1>
            <p class="text-lg md:text-xl lg:text-2xl text-center px-4 md:px-8 lg:px-12 mb-8">{{ story.content }}</p>
            <div class="flex">
                <button @click="loadPrevious" class="bg-pink-400 hover:bg-pink-500 text-white font-bold py-2 px-4 rounded mr-2">
                    <span role="img" aria-label="Previous">👈</span>
                </button>
                <button @click="loadNext" class="bg-blue-400 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded">
                    <span role="img" aria-label="Next">👉</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        imageUrl: String,
        story: Object
    },
    methods: {
        loadPrevious() {
            // Assuming you have a method to fetch previous story using Inertia.js
            this.$inertia.visit(`/stories/${this.story.previous}`);
        },
        loadNext() {
            // Assuming you have a method to fetch next story using Inertia.js
            this.$inertia.visit(`/stories/${this.story.next}`);
        }
    }
};
</script>
