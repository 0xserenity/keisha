<script setup>
import {ref} from 'vue'
import DialogModal from '../Components/DialogModal.vue'
import PrimaryButton from '../Components/PrimaryButton.vue'

const props = defineProps({
  sneakers: Array
})

const sneakerBeingViewed = ref(false)

const isUpgradable = sneaker => {
  return parseFloat(sneaker.daily_roi) < parseFloat(sneaker.daily_roi_max)
}

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
          Comfort Sockets
        </div>
        <div class="flex items-end">
          Comfort
        </div>
        <div class="flex items-end">
          Fresh?
        </div>
        <div class="flex items-end">
          Payback Period
        </div>
        <div class="flex items-end">
          Price SOL
        </div>
      </div>
      <div v-for="sneaker in sneakers" :key="sneaker.id" class="flex flex-col md:flex-row items-center justify-between bg-white rounded-lg p-6 shadow-sm">
        <div class="flex items-center">
          <div class="ml-4">
            {{ sneaker.otd }}
          </div>
        </div>

        <div class="flex items-start">
          {{ sneaker.level }}
        </div>

        <div class="flex items-start">
          {{ ['', 'Common', 'Uncommon', 'Rare', 'Epic', 'Legendary'][sneaker.quality] }}
          {{ ['', 'Walker', 'Jogger', 'Runner', 'Trainer'][sneaker.type] }}
        </div>

        <div class="flex-row items-start">
          <span v-if="sneaker.comfort_socket > 0" class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded">
            {{ sneaker.comfort_socket }} 💎
          </span>
        </div>

        <div class="flex-row items-start">
          <span class="bg-red-100 text-red-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded">
            {{ numberFormat(sneaker.comfort / 10) }}
          </span>
        </div>

        <div class="flex items-start">
          <span v-if="sneaker.is_fresh" class="bg-green-100 text-green-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded">
            Fresh 🥬
          </span>
        </div>

        <div class="flex items-start cursor-pointer" :class="{'bg-green-100': isUpgradable(sneaker)}" @click="sneakerBeingViewed = sneaker">
          <span v-if="isUpgradable(sneaker)">
            {{ sneaker.payback_period_max }}
          </span>

          <span v-else>
            {{ sneaker.daily_roi > 0 ? sneaker.payback_period : 'Not Profitable' }}
          </span>

          <svg class="svg-icon ml-2 mb-1" viewBox="0 0 20 20">
            <path fill="none"
                  d="M8.416,3.943l1.12-1.12v9.031c0,0.257,0.208,0.464,0.464,0.464c0.256,0,0.464-0.207,0.464-0.464V2.823l1.12,1.12c0.182,0.182,0.476,0.182,0.656,0c0.182-0.181,0.182-0.475,0-0.656l-1.744-1.745c-0.018-0.081-0.048-0.16-0.112-0.224C10.279,1.214,10.137,1.177,10,1.194c-0.137-0.017-0.279,0.02-0.384,0.125C9.551,1.384,9.518,1.465,9.499,1.548L7.76,3.288c-0.182,0.181-0.182,0.475,0,0.656C7.941,4.125,8.234,4.125,8.416,3.943z M15.569,6.286h-2.32v0.928h2.32c0.512,0,0.928,0.416,0.928,0.928v8.817c0,0.513-0.416,0.929-0.928,0.929H4.432c-0.513,0-0.928-0.416-0.928-0.929V8.142c0-0.513,0.416-0.928,0.928-0.928h2.32V6.286h-2.32c-1.025,0-1.856,0.831-1.856,1.856v8.817c0,1.025,0.832,1.856,1.856,1.856h11.138c1.024,0,1.855-0.831,1.855-1.856V8.142C17.425,7.117,16.594,6.286,15.569,6.286z"></path>
          </svg>
        </div>

        <div class="flex items-end">
          <span class="bg-purple-100 text-purple-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded">
            {{ numberFormat(sneaker.price_sol) }}
          </span>
        </div>
      </div>
    </div>
  </div>

  <DialogModal :show="sneakerBeingViewed" @close="sneakerBeingViewed = false">
    <template #title>
      #{{ sneakerBeingViewed.otd }}
    </template>

    <template #content>
      <ul class="mt-3">
        <li>
          APY: {{ numberFormat(sneakerBeingViewed.apy) }}%
        </li>
        <li>
          Daily Earning: {{ numberFormat(sneakerBeingViewed.daily_earn_gmt) }} GMT
        </li>
        <li>
          Daily Maintenance Cost: {{ numberFormat(sneakerBeingViewed.daily_expense_gmt) }} GMT (incl. {{ numberFormat(sneakerBeingViewed.daily_repair_gst) }} GST repair cost)
        </li>
        <li>
          Daily Net Profit: {{ numberFormat(sneakerBeingViewed.daily_earn_gmt - sneakerBeingViewed.daily_expense_gmt) }}
          GMT
        </li>
      </ul>

      <ul class="mt-3" v-if="sneakerBeingViewed.daily_roi < sneakerBeingViewed.daily_roi_max">
        <li>
          Potential APY: {{ numberFormat(sneakerBeingViewed.apy_max) }}%
        </li>
        <li>
          Payback Period: {{ sneakerBeingViewed.payback_period_max }}
        </li>
        <li>
          Daily Earning: {{ numberFormat(sneakerBeingViewed.daily_earn_max_gmt) }} GMT
        </li>
        <li>
          Daily Net Profit: {{ numberFormat(sneakerBeingViewed.daily_earn_max_gmt - sneakerBeingViewed.daily_expense_gmt) }}
          GMT
        </li>
      </ul>
      <div class="text-gray-400 mt-3 mb-3 text-sm">
        Numbers based on minimum 2E daily
      </div>
    </template>

    <template #footer>
      <PrimaryButton
          @click="sneakerBeingViewed = false"
      >
        Close
      </PrimaryButton>
    </template>
  </DialogModal>
</template>
