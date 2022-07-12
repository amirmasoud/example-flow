<template>
  <component
    :is="href ? 'Link' : 'button'"
    :disabled="disabled || href ? null : processing"
    :href="href ? href : null"
    :type="href ? null : type"
    class="inline-flex items-center py-2 px-3 text-sm font-medium leading-4 text-white bg-indigo-600 hover:bg-indigo-700 rounded-md border border-transparent focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shadow-sm disabled:opacity-50 disabled:cursor-wait focus:outline-none"
  >
    <TransitionRoot
      id="button-spinner"
      :show="processing"
      enter="transition-opacity duration-300"
      enter-from="opacity-0"
      enter-to="opacity-100"
      leave="transition-opacity duration-300"
      leave-from="opacity-100"
      leave-to="opacity-0"
    >
      <Spinner class="w-4 h-4"/>
    </TransitionRoot>
    <slot/>
  </component>
</template>

<script setup>
import Spinner from "@/Components/Icons/Spinner.vue";
import { TransitionRoot } from "@headlessui/vue";

defineProps({
  type: {
    type: String,
    default: "button",
  },
  processing: {
    type: Boolean,
    default: false,
  },
  href: {
    type: String,
    default: null,
  },
});
</script>
