<template>
  <div class="flex">
    <span class="relative inline-flex pl-4 text-sm text-gray-900">
      <slot />
      <span class="absolute h-2 w-2 left-0 top-2">
        <span
          :class="`animate-ping absolute inline-flex h-full w-full rounded-full bg-${color}-400 opacity-75`"
        ></span>
        <span
          :class="`relative inline-flex rounded-full h-2 w-2 bg-${color}-500`"
        ></span>
      </span>
    </span>
  </div>
</template>

<script setup>
defineProps({
  color: {
    type: String,
    default: "green",
    validator(value) {
      return ["green", "red"].includes(value);
    },
  },
});
</script>
