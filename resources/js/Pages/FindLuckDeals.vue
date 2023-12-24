<script setup>
import AppLayout from '../Layouts/HeadlessAppLayout.vue'
import SneakersList from '../Components/SneakerListV2.vue'

const props = defineProps({
  sneakers: Array
})

</script>

<template>
  <AppLayout title="Luck Deals">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Luck Deals
      </h2>
    </template>

    <div class="py-3">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden p-6">
            <SneakersList :sneakers="sneakers" />
        </div>
      </div>
    </div>
  </AppLayout>
</template>
