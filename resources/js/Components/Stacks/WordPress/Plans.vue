<template>
  <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">Server Size</h3>
  <RadioGroup
    v-model="selectedPlan"
    @update:modelValue="(plan) => $emit('update:selected-plan', plan)"
  >
    <RadioGroupLabel class="sr-only"> Server size </RadioGroupLabel>
    <div class="space-y-4">
      <RadioGroupOption
        v-for="plan in plans"
        :key="plan.name"
        v-slot="{ active, checked }"
        as="div"
        :value="plan.name"
      >
        <div
          :class="[
            active ? 'ring-1 ring-offset-2 ring-indigo-500' : '',
            'relative block rounded-lg border border-gray-300 bg-white shadow-sm px-6 py-4 cursor-pointer hover:border-gray-400 sm:flex sm:justify-between focus:outline-none',
          ]"
        >
          <div class="flex items-center">
            <div class="text-sm">
              <RadioGroupLabel as="p" class="font-medium text-gray-900">
                {{ plan.name }}
              </RadioGroupLabel>
              <RadioGroupDescription as="div" class="text-gray-500">
                <p class="sm:inline">{{ plan.ram }} / {{ plan.cpus }}</p>
                {{ " " }}
                <span class="hidden sm:inline sm:mx-1" aria-hidden="true"
                  >&middot;</span
                >
                {{ " " }}
                <p class="sm:inline">{{ plan.disk }}</p>
              </RadioGroupDescription>
            </div>
          </div>
          <RadioGroupDescription
            as="div"
            class="mt-2 flex text-sm sm:mt-0 sm:block sm:ml-4 sm:text-right"
          >
            <div class="font-medium text-gray-900">{{ plan.price }}</div>
            <div class="ml-1 text-gray-500 sm:ml-0">/mo</div>
          </RadioGroupDescription>
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

  <h3 class="text-lg leading-6 font-medium text-gray-900 my-6">Configs</h3>
  <RadioGroup
    v-model="selectedConfig"
    @update:modelValue="(config) => $emit('update:selected-config', config)"
  >
    <RadioGroupLabel class="sr-only"> Server Config </RadioGroupLabel>
    <div class="space-y-4">
      <RadioGroupOption
        v-for="config in configs"
        :key="config.name"
        v-slot="{ active, checked }"
        as="template"
        :value="config.name"
      >
        <div
          :class="[
            active ? 'ring-1 ring-offset-2 ring-indigo-500' : '',
            'relative block rounded-lg border border-gray-300 bg-white shadow-sm px-6 py-4 cursor-pointer hover:border-gray-400 sm:flex sm:justify-between focus:outline-none',
          ]"
        >
          <div class="flex items-center">
            <div class="text-sm">
              <RadioGroupLabel as="p" class="font-medium text-gray-900">
                {{ config.name }}
              </RadioGroupLabel>
              <RadioGroupDescription as="div" class="text-gray-500">
                <p class="sm:inline">
                  {{ config.php }} / {{ config.database }}
                </p>
                {{ " " }}
                <span class="hidden sm:inline sm:mx-1" aria-hidden="true"
                  >&middot;</span
                >
                {{ " " }}
                <p class="sm:inline">{{ config.proxy }}</p>
              </RadioGroupDescription>
            </div>
          </div>
          <RadioGroupDescription
            as="div"
            class="mt-2 flex text-sm sm:mt-0 sm:block sm:ml-4 sm:text-right"
          >
            <div class="font-medium text-gray-900">{{ config.price }}</div>
            <div class="ml-1 text-gray-500 sm:ml-0">/mo</div>
          </RadioGroupDescription>
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
import {
  RadioGroup,
  RadioGroupDescription,
  RadioGroupLabel,
  RadioGroupOption,
} from "@headlessui/vue";

const configs = [
  {
    name: "8.1-MariaDB-NGINX",
    php: "PHP 8.1",
    database: "MariaDB",
    proxy: "NGINX",
    price: "Free",
  },
  {
    name: "8.0-MariaDB-NGINX",
    php: "PHP 8.0",
    database: "MariaDB",
    proxy: "NGINX",
    price: "Free",
  },
  {
    name: "7.4-MariaDB-NGINX",
    php: "PHP 7.4",
    database: "MariaDB",
    proxy: "NGINX",
    price: "Free",
  },
  {
    name: "7.3-MariaDB-NGINX",
    php: "PHP 7.3",
    database: "MariaDB",
    proxy: "NGINX",
    price: "Free",
  },
];

const plans = [
  {
    name: "docker.1",
    ram: "512MB",
    cpus: "0.5 CPU",
    disk: "1 GB SSD disk",
    price: "$0.99",
  },
  {
    name: "docker.2",
    ram: "1GB",
    cpus: "1 CPUs",
    disk: "5 GB SSD disk",
    price: "$4.99",
  },
  {
    name: "docker.3",
    ram: "2GB",
    cpus: "2 CPUs",
    disk: "10 GB SSD disk",
    price: "$8.99",
  },
  {
    name: "docker.4",
    ram: "4GB",
    cpus: "4 CPUs",
    disk: "20 GB SSD disk",
    price: "$13.99",
  },
];

defineProps({
  selectedPlan: String,
  selectedConfig: String,
});
</script>
