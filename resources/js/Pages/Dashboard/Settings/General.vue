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

        <!-- Description list with inline editing -->
        <div class="mt-10 divide-y divide-gray-200">
          <div class="space-y-1">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Profile</h3>
            <p class="max-w-2xl text-sm text-gray-500">
              This information will be displayed publicly so be careful what you
              share.
            </p>
          </div>
          <div class="mt-6 rounded-lg bg-white shadow px-4">
            <dl class="divide-y divide-gray-200">
              <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-gray-500">Name</dt>
                <dd
                  class="mt-1 flex text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                >
                  <span class="flex-grow">
                    {{ $page.props.auth.user.name }}
                  </span>
                  <span class="ml-4 flex-shrink-0">
                    <button
                      class="font-semibold text-purple-600 hover:text-purple-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500"
                      type="button"
                    >
                      Update
                    </button>
                  </span>
                </dd>
              </div>
              <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:pt-5">
                <dt class="text-sm font-medium text-gray-500 flex items-center">
                  Photo
                </dt>
                <dd
                  class="mt-1 flex text-sm text-gray-900 sm:mt-0 sm:col-span-2 items-center"
                >
                  <span class="flex-grow">
                    <img
                      :src="
                        $page.props.auth.user.profile ||
                        'https://images.unsplash.com/photo-1607785330196-fdbe6f36c8fa?ixlib=rb-1.2.1&q=80&fm=jpg&cs=tinysrgb&w=256&h=256&fit=facearea'
                      "
                      alt=""
                      class="h-8 w-8 rounded-full"
                    />
                  </span>
                  <span class="ml-4 flex-shrink-0 flex items-start space-x-4">
                    <button
                      class="font-semibold text-purple-600 hover:text-purple-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500"
                      type="button"
                    >
                      Update
                    </button>
                    <span aria-hidden="true" class="text-gray-300">|</span>
                    <button
                      :disabled="!$page.props.auth.user.profile"
                      class="font-semibold text-purple-600 hover:text-purple-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 disabled:opacity-50 disabled:cursor-not-allowed"
                      type="button"
                    >
                      Remove
                    </button>
                  </span>
                </dd>
              </div>
              <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:pt-5">
                <dt class="text-sm font-medium text-gray-500">Email</dt>
                <dd
                  class="mt-1 flex text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                >
                  <span class="flex-grow">
                    {{ $page.props.auth.user.email }}
                  </span>
                  <span class="ml-4 flex-shrink-0">
                    <button
                      class="font-semibold text-purple-600 hover:text-purple-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500"
                      type="button"
                    >
                      Update
                    </button>
                  </span>
                </dd>
              </div>
            </dl>
          </div>
        </div>

        <div class="mt-10 divide-y divide-gray-200">
          <div class="space-y-1">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Account</h3>
            <p class="max-w-2xl text-sm text-gray-500">
              Manage how information is displayed on your account.
            </p>
          </div>
          <div class="mt-6 rounded-lg bg-white shadow px-4">
            <dl class="divide-y divide-gray-200">
              <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-gray-500">Language</dt>
                <dd
                  class="mt-1 flex text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                >
                  <span class="flex-grow">
                    {{ $page.props.auth.user.settings.languageLabel }}
                  </span>
                  <span class="ml-4 flex-shrink-0">
                    <button
                      class="font-semibold text-purple-600 hover:text-purple-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500"
                      type="button"
                    >
                      Update
                    </button>
                  </span>
                </dd>
              </div>
              <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:pt-5">
                <dt class="text-sm font-medium text-gray-500">Date format</dt>
                <dd
                  class="mt-1 flex text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                >
                  <span class="flex-grow">
                    {{ $page.props.auth.user.settings.dateFormatLabel }}
                  </span>
                  <span class="ml-4 flex-shrink-0 flex items-start space-x-4">
                    <button
                      class="font-semibold text-purple-600 hover:text-purple-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500"
                      type="button"
                    >
                      Update
                    </button>
                  </span>
                </dd>
              </div>
              <SwitchGroup
                as="div"
                class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:pt-5"
              >
                <SwitchLabel
                  as="dt"
                  class="text-sm font-medium text-gray-500"
                  passive
                >
                  Swarm mode
                </SwitchLabel>
                <dd
                  class="mt-1 flex text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                >
                  <Switch
                    v-model="automaticTimezoneEnabled"
                    :class="[
                      automaticTimezoneEnabled
                        ? 'bg-purple-600'
                        : 'bg-gray-200',
                      'relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-auto',
                    ]"
                  >
                    <span
                      :class="[
                        automaticTimezoneEnabled
                          ? 'translate-x-5'
                          : 'translate-x-0',
                        'inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200',
                      ]"
                      aria-hidden="true"
                    />
                  </Switch>
                </dd>
              </SwitchGroup>
              <SwitchGroup
                as="div"
                class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-b sm:border-gray-200"
              >
                <SwitchLabel
                  as="dt"
                  class="text-sm font-medium text-gray-500"
                  passive
                >
                  Auto-update application
                </SwitchLabel>
                <dd
                  class="mt-1 flex text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                >
                  <Switch
                    v-model="autoUpdateApplicantDataEnabled"
                    :class="[
                      autoUpdateApplicantDataEnabled
                        ? 'bg-purple-600'
                        : 'bg-gray-200',
                      'relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-auto',
                    ]"
                  >
                    <span
                      :class="[
                        autoUpdateApplicantDataEnabled
                          ? 'translate-x-5'
                          : 'translate-x-0',
                        'inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200',
                      ]"
                      aria-hidden="true"
                    />
                  </Switch>
                </dd>
              </SwitchGroup>
            </dl>
          </div>
        </div>
      </div>
    </div>
  </DashboardMain>
</template>

<script setup>
import AppHead from "@/Components/AppHead.vue";
import DashboardMain from "@/Components/DashboardMain.vue";
import { Switch, SwitchGroup, SwitchLabel } from "@headlessui/vue";
import { ref } from "vue";

const tabs = [
  {
    name: "General",
    href: route("dashboard.settings.general"),
    current: true,
  },
  {name: "Password", href: "#", current: false},
  {name: "Notifications", href: "#", current: false},
  {
    name: "System Status",
    href: route("dashboard.settings.system-status"),
    current: false,
  },
];

const automaticTimezoneEnabled = ref(true);
const autoUpdateApplicantDataEnabled = ref(false);
</script>
