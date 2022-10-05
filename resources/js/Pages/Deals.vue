<script setup>
import AppLayout from '../Layouts/HeadlessAppLayout.vue'
import SneakersList from '../Components/SneakersList.vue'

const props = defineProps({
  sneakers: Array
})
</script>

<template>
  <AppLayout title="Cheapest STEPN Sneakers To Earn GMT On Market">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Cheapest STEPN Sneakers To Earn GMT On Market
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
                      <span>Only sneakers lv30 with comfort >= 28</span>
                    </li>
                    <li class="ml-3 font-medium text-indigo-600">
                      <span>Estimate earning based on running shares on Twitter and Reddit</span>
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
