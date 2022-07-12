<template>
  <label :for="id" class="block text-sm font-semibold text-gray-700">
    {{ label }}
  </label>
  <select
    :id="id"
    :autocomplete="name"
    :class="[
      hasError || !!form.errors[name]
        ? 'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500'
        : 'focus:ring-indigo-500 focus:border-indigo-500 border-gray-300',
    ]"
    :name="name"
    :value="modelValue"
    class="mt-1 block w-full bg-white border rounded-md shadow-sm py-2 px-3 sm:text-sm"
    @input="$emit('update:modelValue', $event.target.value)"
  >
    <option
      v-for="{ label, value } of options"
      :key="value"
      :selected="modelValue === value"
      :value="value"
    >
      {{ label }}
    </option>
  </select>
  <p
    v-if="help !== ''"
    :id="`${name}-description`"
    class="mt-2 text-sm text-gray-500"
  >
    {{ help }}
  </p>
  <TransitionRoot
    :id="`${name}-error`"
    :show="hasError || !!form.errors[name]"
    as="p"
    class="mt-2 text-sm text-red-600"
    enter="transition-opacity duration-300"
    enter-from="opacity-0"
    enter-to="opacity-100"
    leave="transition-opacity duration-300"
    leave-from="opacity-100"
    leave-to="opacity-0"
  >
    {{ hasError ? errorMessage : form.errors[name] }}
  </TransitionRoot>
</template>

<script setup>
import { TransitionRoot } from "@headlessui/vue";

defineEmits(["update:modelValue"]);

defineProps({
  name: String,
  label: String,
  modelValue: String,
  id: {
    type: String,
    default: (props) => props.name,
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
  options: {
    type: Array,
    default: () => [],
  },
});
</script>
