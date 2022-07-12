<template>
  <label :for="filter.name" class="block text-sm font-medium text-gray-700">{{
      filter.label
    }}</label>
  <div class="relative rounded-md shadow-sm">
    <Input
      :id="filter.name"
      v-model="filter.value"
      :placeholder="filter.label"
      class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-2 sm:text-sm border-gray-300 rounded-md"
      name="search"
      type="text"
    />
  </div>
</template>

<script setup>
import Input from "@/Components/Forms/Inputs/Input.vue";

defineProps({
  filter: Object,
});
</script>
