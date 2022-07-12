<template>
  <div>
    <div class="mb-10 grid grid-cols-1 sm:grid-cols-4 xl:grid-cols-3 gap-0">
      <div
        class="w-full sm:col-start-2 sm:col-span-2 xl:col-start-2 xl:col-end-3"
      >
        <label class="block text-sm font-medium text-gray-700" for="search"
          >Search</label
        >
        <div class="mt-1 relative rounded-md shadow-sm w-full">
          <input
            id="search"
            v-model="pluginSearch"
            class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 sm:text-sm border-gray-300 rounded-md"
            name="search"
            placeholder="search"
            type="search"
          />
        </div>
      </div>
    </div>

    <ul class="mb-10 columns-1 sm:columns-2 xl:columns-3 gap-3" role="list">
      <li
        v-for="(plugin, index) in records.plugins"
        :key="index"
        class="break-inside-avoid mb-4"
      >
        <div class="flex shadow-sm rounded-md">
          <div
            class="flex-shrink-0 flex items-start justify-center border-t border-l border-gray-200 w-16 text-white text-sm font-medium rounded-tl-md z-10 bg-white p-2"
          >
            <img
              :alt="`${plugin.name} icon`"
              :src="
                plugin.icons.icon_svg ||
                plugin.icons.icon_2x ||
                plugin.icons.icon_1x
              "
            />
          </div>
          <div
            class="flex-1 flex items-start justify-between border-t border-r border-gray-200 bg-white truncate rounded-tr-md"
          >
            <div class="flex-1 px-4 py-2 text-sm truncate">
              <SwitchGroup
                as="div"
                class="flex items-center justify-between mb-2"
              >
                <span class="flex-grow flex flex-col">
                  <SwitchLabel
                    as="span"
                    class="text-sm font-medium text-gray-900"
                    passive
                    ><span
                      class="whitespace-pre-line"
                      v-html="plugin.name"
                    ></span
                  ></SwitchLabel>
                  <SwitchDescription as="span" class="text-sm text-gray-500">
                    <div class="flex items-center">
                      <StarIcon
                        v-for="rating in [0, 1, 2, 3, 4]"
                        :key="rating"
                        :class="[
                          plugin.rating > rating
                            ? 'text-yellow-400'
                            : 'text-gray-200',
                          'h-5 w-5 flex-shrink-0',
                        ]"
                        aria-hidden="true"
                      />
                      <span class="text-gray-500"
                        >({{ plugin.num_ratings }})</span
                      >
                    </div>
                  </SwitchDescription>
                </span>
                <Switch
                  v-model="selectedPlugins[plugin.slug]"
                  :class="[
                    selectedPlugins[plugin.slug]
                      ? 'bg-indigo-600'
                      : 'bg-gray-200',
                    'relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500',
                  ]"
                  @update:modelValue="
                    (plugin) =>
                      $emit('update:selected-plugins', selectedPlugins)
                  "
                >
                  <span
                    :class="[
                      selectedPlugins[plugin.slug]
                        ? 'translate-x-5'
                        : 'translate-x-0',
                      'pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200',
                    ]"
                    aria-hidden="true"
                  />
                </Switch>
              </SwitchGroup>
              <p
                class="w-full whitespace-pre-wrap"
                v-html="plugin.short_description"
              ></p>
            </div>
          </div>
        </div>
        <hr />
        <div
          class="grid grid-cols-1 md:grid-cols-2 text-gray-500 bg-white border-r border-b border-l border-gray-200 p-2 rounded-b-md text-sm"
        >
          <p class="col-span-1 md:col-span-2">
            <UserIcon class="w-4 h-4 inline mr-1" />
            <span v-html="plugin.author"></span>
          </p>
          <p class="md:col-span-1">
            <TrendingUpIcon class="w-4 h-4 inline mr-1" />
            {{ plugin.active_installs }}
          </p>
          <p class="col-span-1">
            <ShieldCheckIcon class="w-4 h-4 inline mr-1" />
            Tested with
            {{ plugin.tested }}
          </p>
        </div>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, watch } from "vue";
import {
  Switch,
  SwitchDescription,
  SwitchGroup,
  SwitchLabel,
} from "@headlessui/vue";
import {
  StarIcon,
  TrendingUpIcon,
  ShieldCheckIcon,
  UserIcon,
} from "@heroicons/vue/solid";
import debounce from "lodash/debounce";
import { Inertia } from "@inertiajs/inertia";

// let rating = 5;

const pluginSearch = ref("");

defineProps({
  records: Object,
  selectedPlugins: Object,
});

watch(
  pluginSearch,
  debounce(function (query) {
    Inertia.get(
      route("slacks.plugins"),
      { search: pluginSearch.value },
      { preserveState: true, replace: true, only: ["records"] }
    );
  }, 300)
);
</script>
