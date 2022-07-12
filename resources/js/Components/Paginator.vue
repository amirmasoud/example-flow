<template>
  <div>
    <nav
      class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
      aria-label="Pagination"
    >
      <template v-for="(link, index) in links" :key="index">
        <!-- First link -->
        <template v-if="index === 0">
          <Component
            :is="link.url ? 'Link' : 'button'"
            :href="link.url"
            :class="{ 'cursor-not-allowed': !link.url }"
            class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-10"
            :disabled="!link.url"
          >
            <span class="sr-only">Previous</span>
            <chevron-left-icon class="h-5 w-5" />
          </Component>
        </template>
        <!-- Last link -->
        <template v-else-if="index === links.length - 1">
          <Component
            :is="link.url ? 'Link' : 'button'"
            :href="link.url"
            :class="{ 'cursor-not-allowed': !link.url }"
            class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-10"
            :disabled="!link.url"
          >
            <span class="sr-only">Next</span>
            <chevron-right-icon class="h-5 w-5" />
          </Component>
        </template>
        <!-- Three dots inner items -->
        <template v-else-if="!link.url">
          <span
            class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700"
          >
            {{ link.label }}
          </span>
        </template>
        <template v-else>
          <Link
            :href="link.url"
            :class="[
              link.active
                ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
            ]"
            class="relative inline-flex items-center px-4 py-2 border text-sm font-medium"
          >
            {{ link.label }}
          </Link>
        </template>
      </template>
    </nav>
  </div>
</template>

<script setup>
import { ChevronLeftIcon, ChevronRightIcon } from "@heroicons/vue/outline";

defineProps({ links: Array });
</script>
