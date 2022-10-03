<script setup>
import AppLayout from '../Layouts/HeadlessAppLayout.vue'
import SneakersList from '../Components/SneakersList.vue'

const props = defineProps({
  sneakers: Array
})
</script>

<template>
  <AppLayout title="STEPN Good Deals Finder">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        STEPN Good Deals Finder
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden p-6">

          <div class="bg-indigo-100 rounded-lg">
            <div class="mx-auto max-w-7xl py-3 px-3 sm:px-6 lg:px-8">
              <div class="flex flex-wrap items-center justify-between">
                <div class="flex w-0 flex-1 items-center">

                  <p class="ml-3 truncate font-medium text-indigo-600">
                    <span>This page is in progress (WIP). Ping me on https://www.reddit.com/user/Adam_Kavanagh if you want to contribute something to the tool.</span>
                  </p>
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
