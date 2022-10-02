<script setup>
import AppLayout from '../Layouts/HeadlessAppLayout.vue'
import ActionSection from '../Components/ActionSection.vue'
import SectionBorder from '../Components/SectionBorder.vue'
import FormSection from '../Components/FormSection.vue'
import InputLabel from '../Components/InputLabel.vue'
import TextInput from '../Components/TextInput.vue'
import InputError from '../Components/InputError.vue'
import {useForm} from '@inertiajs/inertia-vue3'
import ActionMessage from '../Components/ActionMessage.vue'
import PrimaryButton from '../Components/PrimaryButton.vue'

const getHpRestoreCostForm = useForm({
  hp: 80,
  quality: 1,
  gem: 1
})

const qualities = [
  {
    key: 1,
    name: 'Common',
  },
  {
    key: 2,
    name: 'Uncommon'
  },
  {
    key: 3,
    name: 'Rare'
  },
  {
    key: 4,
    name: 'Epic'
  },
]

const gems = [
  {
    key: 1,
    name: 'Level 1',
  },
  {
    key: 2,
    name: 'Level 2',
  },
  {
    key: 3,
    name: 'Level 3',
  },
  {
    key: 4,
    name: 'Level 4',
  },
]

const calculate = () => {
  getHpRestoreCostForm.post(route('hp.calculate'), {
    errorBag: 'getHpRestoreCost',
    preserveScroll: true,
  })
}
</script>

<template>
  <AppLayout title="STEPN HP Restore Cost Calculator">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        STEPN HP Restore Cost Calculator
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden p-6">
          <FormSection @submitted="calculate">
            <template #title>
              Guide
            </template>

            <template #description>
              <ul class="mt-3 space-y-1">
                <li>Enter % HP that need to be restored</li>
                <li>Select sneaker's quality</li>
                <li>Select comfort gem level that you want to use</li>
                <li>Hit the "Calculate" button to see the result</li>
              </ul>
            </template>

            <template #form>
              <div class="col-span-6 sm:col-span-4">
                <InputLabel for="hp" value="HP % To Restore"/>
                <TextInput
                    id="hp"
                    type="text"
                    v-model="getHpRestoreCostForm.hp"
                    class="mt-1 block w-full"
                />
                <InputError :message="getHpRestoreCostForm.errors.hp" class="mt-2"/>
              </div>

              <div v-if="qualities.length > 0" class="col-span-6 lg:col-span-4">
                <InputLabel for="quality" value="Sneaker's quality"/>
                <InputError :message="getHpRestoreCostForm.errors.quality" class="mt-2"/>

                <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer">
                  <button
                      v-for="(quality, i) in qualities"
                      :key="quality.key"
                      type="button"
                      class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200"
                      :class="{'border-t border-gray-200 rounded-t-none': i > 0, 'rounded-b-none': i !== Object.keys(qualities).length - 1}"
                      @click="getHpRestoreCostForm.quality = quality.key"
                  >
                    <div :class="{'opacity-50': getHpRestoreCostForm.quality && getHpRestoreCostForm.quality !== quality.key}">
                      <div class="flex items-center">
                        <div class="text-sm text-gray-600"
                             :class="{'font-semibold': getHpRestoreCostForm.quality === quality.key}">
                          {{ quality.name }}
                        </div>

                        <svg
                            v-if="getHpRestoreCostForm.quality === quality.key"
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
                    </div>
                  </button>
                </div>
              </div>

              <div v-if="gems.length > 0" class="col-span-6 lg:col-span-4">
                <InputLabel for="gem" value="Comfort Gem Level"/>
                <InputError :message="getHpRestoreCostForm.errors.gem" class="mt-2"/>

                <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer">
                  <button
                      v-for="(gem, i) in gems"
                      :key="gem.key"
                      type="button"
                      class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200"
                      :class="{'border-t border-gray-200 rounded-t-none': i > 0, 'rounded-b-none': i !== Object.keys(gems).length - 1}"
                      @click="getHpRestoreCostForm.gem = gem.key"
                  >
                    <div :class="{'opacity-50': getHpRestoreCostForm.gem && getHpRestoreCostForm.gem !== gem.key}">
                      <div class="flex items-center">
                        <div class="text-sm text-gray-600"
                             :class="{'font-semibold': getHpRestoreCostForm.gem === gem.key}">
                          {{ gem.name }}
                        </div>

                        <svg
                            v-if="getHpRestoreCostForm.gem === gem.key"
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
                    </div>
                  </button>
                </div>
              </div>
            </template>

            <template #actions>
              <ActionMessage :on="getHpRestoreCostForm.recentlySuccessful" class="mr-3">
                Calculated successfully.
              </ActionMessage>

              <PrimaryButton :class="{ 'opacity-25': getHpRestoreCostForm.processing }"
                             :disabled="getHpRestoreCostForm.processing">
                Calculate
              </PrimaryButton>
            </template>
          </FormSection>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
