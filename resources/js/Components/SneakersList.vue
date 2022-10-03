<script setup>
const props = defineProps({
  sneakers: Array
})

const numberFormat = number => parseFloat(number).toFixed(2)
</script>

<template>
  <div v-if="sneakers.length > 0">
    <div class="space-y-6 mt-6">
      <div class="flex flex-col md:flex-row items-center justify-between">
        <div class="ml-4">
          ID
        </div>
        <div class="flex items-end">
          Level
        </div>
        <div class="flex items-end">
          Type
        </div>
        <div class="flex items-end">
          Attributes
        </div>
        <div class="flex items-end">
          Payback Period
        </div>
        <div class="flex items-end">
          Price SOL
        </div>
      </div>
      <div v-for="sneaker in sneakers" :key="sneaker.id" class="flex flex-col md:flex-row items-center justify-between">
        <div class="flex items-center">
          <div class="ml-4">
            {{ sneaker.otd }}
          </div>
        </div>

        <div class="flex items-end">
          {{ sneaker.level }}
        </div>

        <div class="flex items-end">
          {{ ['', 'Common', 'Uncommon', 'Rare', 'Epic', 'Legendary'][sneaker.quality] }}
          {{ ['', 'Walker', 'Jogger', 'Runner', 'Trainer'][sneaker.type] }}
        </div>

        <div class="flex items-end">
          <span class="bg-yellow-100 text-yellow-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded">
            {{ numberFormat(sneaker.efficiency / 10) }}
          </span>
          <span class="bg-cyan-100 text-cyan-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded">
            {{ numberFormat(sneaker.luck / 10) }}
          </span>
          <span class="bg-red-100 text-red-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded">
            {{ numberFormat(sneaker.comfort / 10) }}
          </span>
          <span class="bg-indigo-100 text-indigo-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded">
            {{ numberFormat(sneaker.resilience / 10) }}
          </span>
        </div>

        <div class="flex items-end">
          {{ sneaker.daily_roi > 0 ? sneaker.payback_period : 'Not Profitable' }}
        </div>

        <div class="flex items-end">
          {{ numberFormat(sneaker.price_sol) }}
        </div>
      </div>
    </div>
  </div>
</template>
