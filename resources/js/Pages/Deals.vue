<script setup>
import AppLayout from '../Layouts/HeadlessAppLayout.vue'
import SneakersList from '../Components/SneakersList.vue'

const props = defineProps({
  sneakers: Array,
  lastSync: String
})

</script>

<template>
  <AppLayout title="GMT Deals">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        GMT Deals
      </h2>
    </template>

    <div class="py-3">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden p-6">
          <div class="bg-indigo-100 rounded-lg">
            <div class="mx-auto max-w-7xl py-3 px-3 sm:px-6 lg:px-8">
              <div class="flex flex-wrap items-center justify-between">
                <div class="w-0 flex-1 items-center">
                  <ul class="list-disc">
                    <li class="ml-3 font-medium text-indigo-600">
                      <span>Last Sync: {{ lastSync }}</span>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <sneakers-list :sneakers="sneakers"/>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
