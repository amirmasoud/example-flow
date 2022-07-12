<template>
  <div
    class="mb-10 grid grid-cols-1 sm:grid-cols-4 xl:grid-cols-3 gap-0 max-w-screen-xl"
  >
    <div
      class="w-full sm:col-start-2 sm:col-span-2 xl:col-start-2 xl:col-end-3"
    >
      <label class="block text-sm font-medium text-gray-700" for="search"
        >Search</label
      >
      <div class="mt-1 relative rounded-md shadow-sm w-full">
        <input
          id="search"
          v-model="themeSearch"
          class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 sm:text-sm border-gray-300 rounded-md"
          name="search"
          placeholder="search"
          type="search"
        />
      </div>
    </div>
  </div>

  <RadioGroup
    v-model="theme"
    class="mb-10 max-w-screen-xl"
    @update:modelValue="(t) => $emit('update:selected-theme', theme)"
  >
    <RadioGroupLabel class="sr-only"> Selected Theme</RadioGroupLabel>
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
      <RadioGroupOption
        v-for="theme in records.themes"
        :key="theme.slug"
        v-slot="{ active, checked }"
        :value="theme.slug"
        as="template"
      >
        <div
          :class="[
            active ? 'ring-1 ring-offset-2 ring-indigo-500' : '',
            'relative block rounded-lg border border-gray-300 bg-white shadow-sm cursor-pointer hover:border-gray-400 sm:flex sm:justify-between focus:outline-none',
          ]"
        >
          <div class="flex items-center flex-col">
            <img :src="theme.screenshot_url" class="rounded-t-lg" />
            <div class="block w-full px-4 pt-2 pb-4">
              <RadioGroupLabel as="p" class="font-medium text-gray-900">
                <span v-html="theme.name" />
              </RadioGroupLabel>
              <SwitchDescription as="span" class="text-sm text-gray-500">
                <div class="flex items-center">
                  <StarIcon
                    v-for="rating in [0, 1, 2, 3, 4]"
                    :key="rating"
                    :class="[
                      theme.rating > rating
                        ? 'text-yellow-400'
                        : 'text-gray-200',
                      'h-5 w-5 flex-shrink-0',
                    ]"
                    aria-hidden="true"
                  />
                  <span class="text-gray-500">({{ theme.num_ratings }})</span>
                </div>
              </SwitchDescription>
            </div>
          </div>
          <div
            :class="[
              checked ? 'border-indigo-500' : 'border-transparent',
              'absolute -inset-px rounded-lg border-2 pointer-events-none',
            ]"
            aria-hidden="true"
          />
        </div>
      </RadioGroupOption>
    </div>
  </RadioGroup>
</template>

<script setup>
import { ref, watch } from "vue";
import {
  RadioGroup,
  RadioGroupLabel,
  RadioGroupOption,
  SwitchDescription,
} from "@headlessui/vue";
import debounce from "lodash/debounce";
import { Inertia } from "@inertiajs/inertia";
import { StarIcon } from "@heroicons/vue/solid";

const themeSearch = ref("");

let props = defineProps({
  records: Object,
  selectedTheme: String,
});

let theme = ref(props.selectedTheme);

watch(
  themeSearch,
  debounce(function (query) {
    Inertia.get(
      route("dashboard.sites.stacks.create"),
      { search: themeSearch.value },
      {
        preserveState: true,
        replace: true,
        only: ["themes"],
      }
    );
  }, 300)
);
</script>
