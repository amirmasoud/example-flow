<template>
  <AppHead title="New WordPress Site"/>

  <DashboardMain>
    <template #header>Install New WordPress Site</template>

    <div class="max-w-screen-xl">
      <form
        class="space-y-4"
        @submit.prevent="form.post($route('dashboard.sites.stacks.store'))"
      >
        <div class="col-span-6 sm:col-span-4">
          <Button type="submit">Deploy</Button>
        </div>

        <div class="col-span-6 sm:col-span-4">
          <Input v-model="form.name" :form="form" label="Name" name="name"/>
        </div>

        <div class="col-span-6 sm:col-span-4">
          <Input v-model="form.price" :form="form" label="Price" name="price"/>
        </div>

        <div class="col-span-6 sm:col-span-4 hidden">
          <Input
            v-model="form.properties"
            :form="form"
            label="Properties"
            name="properties"
          />
        </div>

        <div class="col-span-6 sm:col-span-4 hidden">
          <Input v-model="form.type" :form="form" label="Type" name="type"/>
        </div>

        <RadioGroup v-model="form.type" class="mb-10 max-w-screen-xl">
          <RadioGroupLabel class="sr-only">
            Selected Stack Type
          </RadioGroupLabel>
          <div class="grid grid-cols-2 sm:grid-cols-4 xl:grid-cols-6 gap-4">
            <RadioGroupOption
              v-for="type in types"
              :key="type.value"
              v-slot="{ active, checked }"
              :value="type.value"
              as="template"
            >
              <div
                :class="[
                  active ? 'ring-1 ring-offset-2 ring-indigo-500' : '',
                  'relative block rounded-lg border border-gray-300 bg-white shadow-sm cursor-pointer hover:border-gray-400 sm:flex sm:justify-between focus:outline-none',
                ]"
              >
                <div class="flex items-center flex-col">
                  <img :src="type.icon" class="rounded-t-lg p-4"/>
                  <div class="block w-full px-4 pt-2 pb-4">
                    <RadioGroupLabel as="p" class="font-medium text-gray-900">
                      <span v-html="type.label"/>
                    </RadioGroupLabel>
                    <SwitchDescription as="span" class="text-sm text-gray-500">
                      1 CPU / 1 GB RAM / 5 GB SSD
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

        <TabGroup v-if="form.type === 'wordpress'" as="div">
          <TabList
            class="flex flex-col sm:flex-row flex-wrap relative z-0 justify-center space-y-2 sm:space-y-0 space-x-0 sm:space-x-2 mb-4"
          >
            <Tab v-slot="{ selected }">
              <button
                :class="[
                  selected
                    ? 'text-indigo-600 bg-gray-50 border border-indigo-500 hover:bg-gray-100'
                    : 'text-gray-500 hover:text-gray-700 border border-gray-300 bg-white hover:bg-gray-50',
                  'flex items-center justify-center shadow-sm group relative w-full sm:w-32 overflow-hidden p-2 text-sm font-medium text-center focus:z-10 rounded-lg',
                ]"
                type="button"
              >
                <PuzzleIcon class="w-3 h-3 mr-2"></PuzzleIcon>
                <span>Plugins</span>
              </button>
            </Tab>
            <Tab v-slot="{ selected }">
              <button
                :class="[
                  selected
                    ? 'text-indigo-600 bg-gray-50 border border-indigo-500 hover:bg-gray-100'
                    : 'text-gray-500 hover:text-gray-700 border border-gray-300 bg-white hover:bg-gray-50',
                  'flex items-center justify-center shadow-sm group relative w-full sm:w-32 overflow-hidden p-2 text-sm font-medium text-center focus:z-10 rounded-lg',
                ]"
                type="button"
              >
                <ViewBoardsIcon class="w-3 h-3 mr-2"></ViewBoardsIcon>
                <span>Themes</span>
              </button>
            </Tab>
            <Tab v-slot="{ selected }">
              <button
                :class="[
                  selected
                    ? 'text-indigo-600 bg-gray-50 border border-indigo-500 hover:bg-gray-100'
                    : 'text-gray-500 hover:text-gray-700 border border-gray-300 bg-white hover:bg-gray-50',
                  'flex items-center justify-center shadow-sm group relative w-full sm:w-32 overflow-hidden p-2 text-sm font-medium text-center focus:z-10 rounded-lg',
                ]"
                type="button"
              >
                <TerminalIcon class="w-3 h-3 mr-2"></TerminalIcon>
                <span>Advance</span>
              </button>
            </Tab>
          </TabList>
          <TabPanels>
            <TabPanel>
              <Plugins
                v-model:selected-plugins="selectedPlugins"
                :records="plugins"
              />
            </TabPanel>
            <TabPanel>
              <Themes
                v-model:selected-theme="selectedTheme"
                :records="themes"
              />
            </TabPanel>
            <TabPanel>
              <Advance v-model:entered-commands="enteredCommands"/>
            </TabPanel>
          </TabPanels>
        </TabGroup>
      </form>
    </div>
  </DashboardMain>
</template>

<script setup>
import AppHead from "@/Components/AppHead.vue";
import Button from "@/Components/Button.vue";
import DashboardMain from "@/Components/DashboardMain.vue";
import Input from "@/Components/Forms/Inputs/Input.vue";
import Advance from "@/Components/Stacks/WordPress/Advance.vue";
import Plugins from "@/Components/Stacks/WordPress/Plugins.vue";
import Themes from "@/Components/Stacks/WordPress/Themes.vue";
import {
  RadioGroup,
  RadioGroupLabel,
  RadioGroupOption,
  SwitchDescription,
  Tab,
  TabGroup,
  TabList,
  TabPanel,
  TabPanels
} from "@headlessui/vue";
import { PuzzleIcon, TerminalIcon, ViewBoardsIcon } from "@heroicons/vue/solid";
import { useForm } from "@inertiajs/inertia-vue3";
import { ref, watch } from "vue";

const selectedPlugins = ref({});
const selectedTheme = ref("");
const enteredCommands = ref("");

defineProps({
  plugins: Object,
  themes: Object,
  types: Object,
});

let form = useForm({
  name: null,
  price: null,
  properties: {
    plugins: {},
    theme: "",
    commands: {},
  },
  type: null,
});

watch(selectedPlugins.value, () => {
  /* eslint-disable no-unused-vars */
  form.properties.plugins = Object.entries(selectedPlugins.value)
    .filter(([plugin, enabled]) => enabled)
    .map(([plugin, enabled]) => plugin);
});

watch(selectedTheme, () => {
  form.properties.theme = selectedTheme.value;
});

watch(enteredCommands, () => {
  form.properties.commands = enteredCommands.value;
});
</script>
