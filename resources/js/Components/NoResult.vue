<template>
  <div class="text-center">
    <h3 class="mt-2 text-sm font-medium text-gray-900">{{ title }}</h3>
    <p class="mt-1 text-sm text-gray-500">
      {{ description }}
    </p>
    <div class="mt-6">
      <button
        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        @click="$emit('removeFilters')"
      >
        {{ button }}
      </button>
    </div>
  </div>
</template>

<script setup>
let props = defineProps({
  title: String,
  description: String,
  button: String,
});
</script>
