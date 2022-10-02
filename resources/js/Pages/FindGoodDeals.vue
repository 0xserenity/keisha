<script setup>
import AppLayout from '../Layouts/AppLayout.vue'
import ActionSection from '../Components/ActionSection.vue'
import SectionBorder from '../Components/SectionBorder.vue'
import FormSection from '../Components/FormSection.vue'
import InputLabel from '../Components/InputLabel.vue'
import TextInput from '../Components/TextInput.vue'
import InputError from '../Components/InputError.vue'
import {useForm} from '@inertiajs/inertia-vue3'
import ActionMessage from '../Components/ActionMessage.vue'
import PrimaryButton from '../Components/PrimaryButton.vue'

const props = defineProps({
  sneakers: Array
})

const getNewDealsForm = useForm({
  sessionId: '',
  filter: 1
})

const availableFilters = [
  {
    key: 1,
    name: 'Lv30 Uncommon',
    description: 'Good earner deals. Rushing'
  },
  {
    key: 2,
    name: 'Lv30 Common',
    description: 'Cheapest deals. Rushing'
  },
  {
    key: 3,
    name: 'Lv29 Common',
    description: 'Cheapest deals. No rush'
  },
  {
    key: 4,
    name: 'Lv29 Uncommon',
    description: 'Good earner deals. No rush'
  },
]

const numberFormat = number => new Intl.NumberFormat().format(number)

const getNewDeals = () => {
  getNewDealsForm.post(route('deals.get'), {
    errorBag: 'getNewDeals',
    preserveScroll: true,
    onSuccess: () => getNewDealsForm.reset('filter'),
  })
}

</script>

<template>
  <AppLayout title="Find Good Deals">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Find Good Deals
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden p-6">

          <FormSection @submitted="getNewDeals">
            <template #title>
              Get New Deals
            </template>

            <template #description>
              Fill up the form to get latest deals from market
            </template>

            <template #form>
              <div class="col-span-6 sm:col-span-4">
                <InputLabel for="sessionId" value="Session ID"/>
                <TextInput
                    id="sessionId"
                    type="text"
                    v-model="getNewDealsForm.sessionId"
                    class="mt-1 block w-full"
                />
                <InputError :message="getNewDealsForm.errors.sessionId" class="mt-2"/>
              </div>

              <div v-if="availableFilters.length > 0" class="col-span-6 lg:col-span-4">
                <InputLabel for="roles" value="Filter"/>
                <InputError :message="getNewDealsForm.errors.filter" class="mt-2"/>

                <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer">
                  <button
                      v-for="(filter, i) in availableFilters"
                      :key="filter.key"
                      type="button"
                      class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200"
                      :class="{'border-t border-gray-200 rounded-t-none': i > 0, 'rounded-b-none': i !== Object.keys(availableFilters).length - 1}"
                      @click="getNewDealsForm.filter = filter.key"
                  >
                    <div :class="{'opacity-50': getNewDealsForm.filter && getNewDealsForm.filter !== filter.key}">
                      <!-- Role Name -->
                      <div class="flex items-center">
                        <div class="text-sm text-gray-600"
                             :class="{'font-semibold': getNewDealsForm.filter === filter.key}">
                          {{ filter.name }}
                        </div>

                        <svg
                            v-if="getNewDealsForm.filter === filter.key"
                            class="ml-2 h-5 w-5 text-green-400"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                          <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                      </div>

                      <!-- Role Description -->
                      <div class="mt-2 text-xs text-gray-600 text-left">
                        {{ filter.description }}
                      </div>
                    </div>
                  </button>
                </div>
              </div>
            </template>

            <template #actions>
              <ActionMessage :on="getNewDealsForm.recentlySuccessful" class="mr-3">
                Done.
              </ActionMessage>

              <PrimaryButton :class="{ 'opacity-25': getNewDealsForm.processing }"
                             :disabled="getNewDealsForm.processing">
                Get Deals
              </PrimaryButton>
            </template>
          </FormSection>

          <SectionBorder/>

          <div v-if="sneakers.length > 0">
            <ActionSection class="mt-10 sm:mt-0">
              <template #title>
                Deals
              </template>

              <template #description>
                Here are good deals that we found on market at the moment
              </template>

              <template #content>
                <div class="space-y-6">
                  <div class="flex items-center justify-between">
                    <div class="ml-4">
                      ID
                    </div>
                    <div class="flex items-center">
                      Daily ROI
                    </div>
                    <div class="flex items-center">
                      Level
                    </div>
                    <div class="flex items-center">
                      Comfort
                    </div>
                    <div class="flex items-center">
                      Comfort Max
                    </div>
                    <div class="flex items-center">
                      Price
                    </div>
                    <div class="flex items-center">
                      Price Max
                    </div>
                  </div>
                  <div v-for="sneaker in sneakers" :key="sneaker.id" class="flex items-center justify-between">
                    <div class="flex items-center">
                      <div class="ml-4">
                        {{ sneaker.otd }}
                      </div>
                    </div>

                    <div class="flex items-end">
                      {{ numberFormat(sneaker.daily_roi) }}
                    </div>

                    <div class="flex items-end">
                      {{ sneaker.level }}
                    </div>

                    <div class="flex items-end">
                      {{ numberFormat(sneaker.comfort / 10) }}
                    </div>

                    <div class="flex items-end">
                      {{ numberFormat(sneaker.comfort_max / 10) }}
                    </div>

                    <div class="flex items-end">
                      {{ numberFormat(sneaker.price_sol) }}
                    </div>

                    <div class="flex items-end">
                      {{ numberFormat(sneaker.price_max) }}
                    </div>
                  </div>
                </div>
              </template>
            </ActionSection>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
