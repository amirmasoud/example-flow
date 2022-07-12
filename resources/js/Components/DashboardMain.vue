<template>
  <div
    class="border-b border-gray-200 px-4 py-4 flex items-center justify-between sm:px-6 lg:px-8 max-w-screen-lg"
  >
    <div class="flex-1 min-w-0">
      <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">
        <slot name="header"></slot>
      </h1>
    </div>
    <div class="flex-shrink-0 sm:mt-0 sm:ml-4">
      <slot name="buttons"></slot>
    </div>
  </div>

  <div class="px-4 mt-6 sm:px-6 lg:px-8 max-w-screen-lg">
    <h2 class="text-gray-500 text-xs font-medium uppercase tracking-wide">
      <slot name="sub-header"></slot>
    </h2>
    <slot name="sub-header-content"></slot>
  </div>

  <div class="px-4 my-6 sm:px-6 lg:px-8 max-w-screen-lg">
    <div class="align-middle">
      <slot />
    </div>
  </div>
</template>

<script setup>
defineEmits(["update:modelValue"]);

defineProps({
  name: String,
  label: String,
  modelValue: String,
  id: {
    type: String,
    default: (props) => props.name,
  },
  type: {
    type: String,
    default: "text",
  },
  placeholder: {
    type: String,
    default: "",
  },
  form: {
    type: Object,
    default() {
      return { errors: {} };
    },
  },
  hasError: {
    type: Boolean,
    default: null,
  },
  errorMessage: {
    type: String,
    default: "",
  },
  help: {
    type: String,
    default: "",
  },
});
</script>
