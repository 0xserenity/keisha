<script setup>
import { Head } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Head title="Welcome" />

    <div class="relative flex flex-col items-top justify-center min-h-screen sm:items-center sm:pt-0">
      <div class="text-center bg-gray-50 text-gray-600 py-20 px-6 rounded-lg">
        <p class="text-5xl font-bold mt-0 mb-6">Hello, welcome to Keisha.</p>
        <p class="text-3xl font-bold mb-10">This is a site with a collection of tools that help you make better decisions in the game.</p>

        <h2 class="font-medium leading-tight text-3xl mt-0 mb-10 mt-10">Available Tools</h2>
        <ul>
          <li>
            <a class="inline-block px-6 py-2.5 bg-indigo-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out" href="/hp">HP Restore Cost Calculator</a>
          </li>
          <li>
            <a class="mt-6 inline-block px-6 py-2.5 bg-indigo-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
               href="/deals">Find Good Sneakers Deal</a>
          </li>
        </ul>
      </div>
    </div>
</template>
