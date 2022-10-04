<script setup>
import AppLayout from '../Layouts/HeadlessAppLayout.vue'
import SneakersList from '../Components/SneakersList.vue'

const props = defineProps({
  sneakers: Array
})
</script>

<template>
  <AppLayout title="Find Good STEPN Sneakers Deal On Market">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Find Good STEPN Sneakers Deal On Market
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden p-6">
          <div class="bg-indigo-100 rounded-lg">
            <div class="mx-auto max-w-7xl py-3 px-3 sm:px-6 lg:px-8">
              <div class="flex flex-wrap items-center justify-between">
                <div class="w-0 flex-1 items-center">
                  <ul class="list-disc">
                    <li class="ml-3 font-medium text-indigo-600">
                      <span>The data on this page is aiming for cheapest option to earn GMT</span>
                    </li>
                    <li class="ml-3 font-medium text-indigo-600">
                      <span>This page is in progress (WIP)</span>
                    </li>
                    <li class="ml-3 font-medium text-indigo-600">
                      <span>Ping me on <a class="underline" href="https://www.reddit.com/r/StepN/comments/xuc469/sneakers_market_analysis/" target="_blank">Reddit Topic</a> if you would like to contribute ideas to the tool</span>
                    </li>
                    <li class="ml-3 font-medium text-indigo-600">
                      <span>There are only sneakers lv30 with comfort >= 28 on this page</span>
                    </li>
                    <li class="ml-3 font-medium text-indigo-600">
                      <span>The data here might be out-dated due to STEPN authentication problem. I will try to refresh the data as much as I can</span>
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
