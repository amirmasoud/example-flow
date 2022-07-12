<template>
  <div class="text-center">
    <svg
      aria-hidden="true"
      class="mx-auto h-12 w-12 text-gray-400"
      fill="none"
      stroke="currentColor"
      viewBox="0 0 24 24"
    >
      <path
        d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        vector-effect="non-scaling-stroke"
      />
    </svg>
    <h3 class="mt-2 text-sm font-medium text-gray-900">{{ title }}</h3>
    <p class="mt-1 text-sm text-gray-500">
      {{ description }}
    </p>
    <div class="mt-6">
      <Component
        :is="link ? 'Link' : 'button'"
        :href="link || '#'"
        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed"
        disabled="disabled"
      >
        <PlusIcon aria-hidden="true" class="-ml-1 mr-2 h-5 w-5" />
        {{ button }}
      </Component>
    </div>
  </div>
</template>

<script setup>
import { PlusIcon } from "@heroicons/vue/solid";

defineProps({
  title: String,
  description: String,
  button: String,
  link: String,
});
</script>
