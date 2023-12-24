<!-- SneakersList.vue -->

<template>
    <div class="sneakers-list grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div v-for="sneaker in sneakers" :key="sneaker.id" class="p-4 border rounded">
            <div>
                <strong>OTD:</strong> {{ sneaker.otd }}
            </div>
            <div>
                <strong>Price:</strong> {{ sneaker.price }}
            </div>
            <div>
                <strong>Luck Base:</strong> {{ sneaker.luck_base }}
            </div>
            <div>
                <strong>Luck Socket:</strong> {{ sneaker.luck_socket }}
            </div>
            <div>
                <strong>Comfort:</strong> {{ sneaker.comfort }}
            </div>
            <div>
                <strong>Resilience:</strong> {{ sneaker.resilience }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        sneakers: {
            type: Array,
            required: true,
        },
    },
};
</script>

<style scoped>
/* Add any scoped styles here if needed */
.sneakers-list {
    max-width: 800px;
    margin: 0 auto;
}
</style>
