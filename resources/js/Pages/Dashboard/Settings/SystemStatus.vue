<template>
  <AppHead title="Settings"/>

  <DashboardMain>
    <template #header>Settings</template>

    <div class="px-0">
      <div class="py-6">
        <!-- Tabs -->
        <div class="lg:hidden">
          <label class="sr-only" for="selected-tab">Select a tab</label>
          <select
            id="selected-tab"
            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md"
            name="selected-tab"
          >
            <option v-for="tab in tabs" :key="tab.name" :selected="tab.current">
              {{ tab.name }}
            </option>
          </select>
        </div>
        <div class="hidden lg:block">
          <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
              <Link
                v-for="tab in tabs"
                :key="tab.name"
                :class="[
                  tab.current
                    ? 'border-purple-500 text-purple-600'
                    : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700',
                  'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm',
                ]"
                :href="tab.href"
              >
                {{ tab.name }}
              </Link>
            </nav>
          </div>
        </div>

        <div class="mt-10 divide-y divide-gray-200">
          <div class="space-y-1">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Overall</h3>
            <p class="max-w-2xl text-sm text-gray-500">
              The overall status of your system.
            </p>
          </div>
          <div class="mt-6 rounded-lg bg-white shadow p-4">
            <ul class="list-inside space-y-2">
              <li>
                <Pauls :color="dockerStatus ? 'green' : 'red'"
                >Docker is {{ dockerStatus ? "running" : "stopped" }}
                </Pauls>
              </li>
              <li>
                <Pauls :color="traefikStatus ? 'green' : 'red'"
                >Traefik is {{ traefikStatus ? "running" : "stopped" }}
                </Pauls>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </DashboardMain>
</template>

<script setup>
import AppHead from "@/Components/AppHead.vue";
import DashboardMain from "@/Components/DashboardMain.vue";
import Pauls from "@/Components/Paulse.vue";
import { Inertia } from "@inertiajs/inertia";
import { onBeforeUnmount, onMounted } from "vue";

const tabs = [
  {
    name: "General",
    href: route("dashboard.settings.general"),
    current: false,
  },
  {name: "Password", href: "#", current: false},
  {name: "Notifications", href: "#", current: false},
  {
    name: "System Status",
    href: route("dashboard.settings.system-status"),
    current: true,
  },
];

defineProps({
  dockerStatus: Boolean,
  traefikStatus: Boolean,
});

const fetchData = () => {
  Inertia.reload({
    preserveState: true,
    preserveScroll: true,
    only: ["dockerStatus", "traefikStatus"],
  });
};

// Fetch data on mount (Lazy loaded)
onMounted(() => {
  fetchData();
});

const reloadInterval = setInterval(() => {
  fetchData();
}, 10000);

onBeforeUnmount(() => {
  clearInterval(reloadInterval);
});
</script>
