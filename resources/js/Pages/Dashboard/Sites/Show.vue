<template>
  <AppHead title="Sites"/>

  <DashboardMain>
    <template #header>Details - {{ record.data.name }}</template>

    <div class="relative bg-gray-100">
      <main class="py-4">
        <div
          class="mx-auto px-4 sm:px-6 md:flex md:items-center md:justify-between md:space-x-5 lg:px-8"
        >
          <div class="flex items-center space-x-5">
            <div class="flex-shrink-0">
              <div class="relative">
                <img
                  alt=""
                  class="w-16"
                  src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/98/WordPress_blue_logo.svg/1024px-WordPress_blue_logo.svg.png"
                />
              </div>
            </div>
            <div>
              <h1 class="text-2xl font-bold text-gray-900">
                {{ wordpress.name }}
              </h1>
              <p class="text-sm font-medium text-gray-500">
                <span class="capitalize">{{ wordpress.state }}</span> for
                <span class="lowercase">{{ wordpress.status }}</span> from
                {{ wordpress.created }}
              </p>
            </div>
          </div>
          <div
            class="mt-6 flex flex-col-reverse justify-stretch space-y-4 space-y-reverse sm:flex-row-reverse sm:justify-end sm:space-x-reverse sm:space-y-0 sm:space-x-3 md:mt-0 md:flex-row md:space-x-3"
          >
            <Button
              v-if="state !== 'running'"
              :processing="processing"
              color="green"
              @click.prevent="start"
            >
              <PlayIcon class="w-4 h-4"/>
              <span class="pl-2"
              >Start</span
              ></Button
            >
            <Button
              v-if="state === 'running'"
              :processing="processing"
              color="red"
              @click.prevent="stop"
            >
              <StopIcon class="w-4 h-4"/>
              <span class="pl-2"
              >Stop</span
              ></Button
            >
            <Button
              :processing="processing"
              color="orange"
              @click.prevent="restart"
            >
              <RefreshIcon class="w-4 h-4"/>
              <span class="pl-2"
              >Restart</span
              ></Button
            >
            <Link
              :href="`/dashboard/sites/${record.data.id}/cli`"
              as="button"
              class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500"
              type="button"
            >
              <WPTerminalIcon class="w-4 h-4"/>
              <span class="pl-2">WP CLI</span>
            </Link>
            <button
              class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500"
              type="button"
              @click.prevent="backup"
            >
              <DatabaseIcon class="w-4 h-4"/>
              <span class="pl-2">Backup</span>
            </button>
          </div>
        </div>

        <div
          class="mt-8 mx-auto grid grid-cols-1 gap-6 sm:px-6 lg:grid-flow-col-dense lg:grid-cols-3"
        >
          <div class="space-y-6 lg:col-start-1 lg:col-span-2">
            <section aria-labelledby="wordpress-information">
              <div class="bg-white shadow sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                  <h2
                    id="wordpress-information"
                    class="text-lg leading-6 font-medium text-gray-900"
                  >
                    Container Information
                  </h2>
                  <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    This information is provided by the container.
                  </p>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                  <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        Name
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 truncate">
                        {{ wordpress.name }}
                      </dd>
                    </div>
                    <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        ID
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 truncate">
                        {{ wordpress.id }}
                      </dd>
                    </div>
                    <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        Image
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 truncate">
                        {{ wordpress.image }}
                      </dd>
                    </div>
                    <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        Image ID
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 truncate">
                        {{ wordpress.imageId }}
                      </dd>
                    </div>
                    <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        <TerminalIcon
                          class="inline-block h-4 w-4 text-gray-400"
                        />
                        Command
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 truncate">
                        {{ wordpress.command }}
                      </dd>
                    </div>
                    <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        <ClockIcon class="inline-block h-4 w-4 text-gray-400"/>
                        Created
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 truncate">
                        {{ wordpress.created }}
                      </dd>
                    </div>
                    <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        <GlobeIcon class="inline-block h-4 w-4 text-gray-400"/>
                        Public Port
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 truncate">
                        <template v-if="wordpress.publicPort">
                          {{ wordpress.publicPort.port }} ({{
                            wordpress.publicPort.type
                          }})
                        </template>
                        <template v-else>
                          <span class="text-red-500">Not exposed</span>
                        </template>
                      </dd>
                    </div>
                    <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        <EyeOffIcon
                          class="inline-block h-4 w-4 text-gray-400"
                        />
                        Private Port
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 truncate">
                        <template v-if="wordpress.privatePort">
                          {{ wordpress.privatePort.port }} ({{
                            wordpress.publicPort.type
                          }})
                        </template>
                        <template v-else>
                          <span class="text-red-500">Not exposed</span>
                        </template>
                      </dd>
                    </div>
                    <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        State
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 truncate">
                        <StatusOnlineIcon
                          class="inline-block h-4 w-4 text-green-400"
                        />
                        {{ wordpress.state }}
                      </dd>
                    </div>
                    <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        <ClockIcon class="inline-block h-4 w-4 text-gray-400"/>
                        Status
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 truncate">
                        {{ wordpress.status }}
                      </dd>
                    </div>
                  </dl>
                </div>
              </div>
            </section>

            <section aria-labelledby="container-labels">
              <div class="bg-white shadow sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                  <h2
                    id="container-labels"
                    class="text-lg leading-6 font-medium text-gray-900"
                  >
                    Container Information
                  </h2>
                  <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    The labels of the container.
                  </p>
                </div>
                <div
                  v-if="wordpress.labels"
                  class="border-t border-gray-200 px-4 py-5 sm:px-6"
                >
                  <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        Compose Project (com.docker.compose.project)
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 truncate">
                        {{ wordpress.labels["com.docker.compose.project"] }}
                      </dd>
                    </div>
                    <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        Working directory
                        (com.docker.compose.project.working_dir)
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 truncate">
                        {{
                          wordpress.labels[
                            "com.docker.compose.project.working_dir"
                            ]
                        }}
                      </dd>
                    </div>
                    <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        Compose Service (com.docker.compose.service)
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 truncate">
                        {{ wordpress.labels["com.docker.compose.service"] }}
                      </dd>
                    </div>
                    <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        Traefik (traefik.enable)
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 truncate">
                        {{
                          wordpress.labels["traefik.enable"] === "true"
                            ? "Enabled"
                            : "Disabled"
                        }}
                      </dd>
                    </div>
                    <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        Source
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 truncate">
                        {{
                          wordpress.labels["desktop.docker.io/binds/0/Source"]
                        }}
                      </dd>
                    </div>
                    <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        Target
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 truncate">
                        {{
                          wordpress.labels["desktop.docker.io/binds/0/Target"]
                        }}
                      </dd>
                    </div>
                    <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        Secure Entry Point
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 truncate">
                        {{
                          wordpress.labels[
                          "traefik.http.routers." +
                          record.data.name +
                          "-secure.entrypoints"
                            ]
                        }}
                      </dd>
                    </div>
                    <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        TLS enabled
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 truncate">
                        {{
                          wordpress.labels[
                          "traefik.http.routers." +
                          record.data.name +
                          "-secure.tls"
                            ] === "true"
                            ? "Enabled"
                            : "Disabled"
                        }}
                      </dd>
                    </div>
                    <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        Rule
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 truncate">
                        {{
                          wordpress.labels[
                          "traefik.http.routers." + record.data.name + ".rule"
                            ]
                        }}
                      </dd>
                    </div>
                    <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        <ClockIcon class="inline-block h-4 w-4 text-gray-400"/>
                        Load Balancer Port
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 truncate">
                        {{
                          wordpress.labels[
                          "traefik.http.services." +
                          record.data.name +
                          ".loadbalancer.server.port"
                            ]
                        }}
                      </dd>
                    </div>
                  </dl>
                </div>
              </div>
            </section>
          </div>

          <section
            aria-labelledby="database-timeline"
            class="lg:col-start-3 lg:col-span-1"
          >
            <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:px-6">
              <h2
                id="database-timeline"
                class="text-lg font-medium text-gray-900"
              >
                Timeline
              </h2>

              <!-- Activity Feed -->
              <div class="mt-6 flow-root">
                <ul class="-mb-8" role="list">
                  <li v-for="(item, itemIdx) in timeline" :key="item.id">
                    <div class="relative pb-8">
                      <span
                        v-if="itemIdx !== timeline.length - 1"
                        aria-hidden="true"
                        class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"
                      />
                      <div class="relative flex space-x-3">
                        <div>
                          <span
                            :class="[
                              item.type.bgColorClass,
                              'h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white',
                            ]"
                          >
                            <component
                              :is="item.type.icon"
                              aria-hidden="true"
                              class="w-5 h-5 text-white"
                            />
                          </span>
                        </div>
                        <div
                          class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4"
                        >
                          <div>
                            <p class="text-sm text-gray-500">
                              {{ item.content }}
                              <a class="font-medium text-gray-900" href="#">{{
                                  item.target
                                }}</a>
                            </p>
                          </div>
                          <div
                            class="text-right text-sm whitespace-nowrap text-gray-500"
                          >
                            <time :datetime="item.datetime">{{
                                item.date
                              }}
                            </time>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </section>
        </div>
      </main>
    </div>

    <!-- Database -->
    <div class="relative bg-gray-100">
      <main class="py-4">
        <div
          class="mx-auto px-4 sm:px-6 md:flex md:items-center md:justify-between md:space-x-5 lg:px-8"
        >
          <div class="flex items-center space-x-5">
            <div class="flex-shrink-0">
              <div class="relative">
                <img
                  alt=""
                  class="w-16"
                  src="https://www.mysql.com/common/logos/logo-mysql-170x115.png"
                />
              </div>
            </div>
            <div>
              <h1 class="text-2xl font-bold text-gray-900">
                {{ database.name }}
              </h1>
              <p class="text-sm font-medium text-gray-500">
                <span class="capitalize">{{ database.state }}</span> for
                <span class="lowercase">{{ database.status }}</span> from
                {{ database.created }}
              </p>
            </div>
          </div>
        </div>

        <div
          class="mt-8 mx-auto grid grid-cols-1 gap-6 sm:px-6 lg:grid-flow-col-dense lg:grid-cols-3"
        >
          <div class="space-y-6 lg:col-start-1 lg:col-span-2">
            <section aria-labelledby="container-information">
              <div class="bg-white shadow sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                  <h2
                    id="container-information"
                    class="text-lg leading-6 font-medium text-gray-900"
                  >
                    Container Information
                  </h2>
                  <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    This information is provided by the container.
                  </p>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                  <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        Name
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 truncate">
                        {{ database.name }}
                      </dd>
                    </div>
                    <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        ID
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 truncate">
                        {{ database.id }}
                      </dd>
                    </div>
                    <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        Image
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 truncate">
                        {{ database.image }}
                      </dd>
                    </div>
                    <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        Image ID
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 truncate">
                        {{ database.imageId }}
                      </dd>
                    </div>
                    <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        <TerminalIcon
                          class="inline-block h-4 w-4 text-gray-400"
                        />
                        Command
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 truncate">
                        {{ database.command }}
                      </dd>
                    </div>
                    <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        <ClockIcon class="inline-block h-4 w-4 text-gray-400"/>
                        Created
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 truncate">
                        {{ database.created }}
                      </dd>
                    </div>
                    <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        <GlobeIcon class="inline-block h-4 w-4 text-gray-400"/>
                        Public Port
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 truncate">
                        <template v-if="database.publicPort">
                          {{ database.publicPort.port }} ({{
                            database.publicPort.type
                          }})
                        </template>
                        <template v-else>
                          <span class="text-red-500">Not exposed</span>
                        </template>
                      </dd>
                    </div>
                    <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        <EyeOffIcon
                          class="inline-block h-4 w-4 text-gray-400"
                        />
                        Private Port
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 truncate">
                        <template v-if="database.privatePort">
                          {{ database.privatePort.port }} ({{
                            database.publicPort.type
                          }})
                        </template>
                        <template v-else>
                          <span class="text-red-500">Not exposed</span>
                        </template>
                      </dd>
                    </div>
                    <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        State
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 truncate">
                        <StatusOnlineIcon
                          class="inline-block h-4 w-4 text-green-400"
                        />
                        {{ database.state }}
                      </dd>
                    </div>
                    <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        <ClockIcon class="inline-block h-4 w-4 text-gray-400"/>
                        Status
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 truncate">
                        {{ database.status }}
                      </dd>
                    </div>
                  </dl>
                </div>
              </div>
            </section>

            <section aria-labelledby="container-labels">
              <div class="bg-white shadow sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                  <h2
                    id="database-labels"
                    class="text-lg leading-6 font-medium text-gray-900"
                  >
                    Container Labels
                  </h2>
                  <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    The labels of the container.
                  </p>
                </div>
                <div
                  v-if="database.labels"
                  class="border-t border-gray-200 px-4 py-5 sm:px-6"
                >
                  <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        Compose Project (com.docker.compose.project)
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 truncate">
                        {{ database.labels["com.docker.compose.project"] }}
                      </dd>
                    </div>
                    <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        Working directory
                        (com.docker.compose.project.working_dir)
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 truncate">
                        {{
                          database.labels[
                            "com.docker.compose.project.working_dir"
                            ]
                        }}
                      </dd>
                    </div>
                    <div class="sm:col-span-1">
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        Compose Service (com.docker.compose.service)
                      </dt>
                      <dd class="mt-1 text-sm text-gray-900 truncate">
                        {{ database.labels["com.docker.compose.service"] }}
                      </dd>
                    </div>
                  </dl>
                </div>
              </div>
            </section>
          </div>

          <section
            aria-labelledby="timeline-title"
            class="lg:col-start-3 lg:col-span-1"
          >
            <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:px-6">
              <h2 id="timeline-title" class="text-lg font-medium text-gray-900">
                Timeline
              </h2>

              <!-- Activity Feed -->
              <div class="mt-6 flow-root">
                <ul class="-mb-8" role="list">
                  <li v-for="(item, itemIdx) in timeline" :key="item.id">
                    <div class="relative pb-8">
                      <span
                        v-if="itemIdx !== timeline.length - 1"
                        aria-hidden="true"
                        class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"
                      />
                      <div class="relative flex space-x-3">
                        <div>
                          <span
                            :class="[
                              item.type.bgColorClass,
                              'h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white',
                            ]"
                          >
                            <component
                              :is="item.type.icon"
                              aria-hidden="true"
                              class="w-5 h-5 text-white"
                            />
                          </span>
                        </div>
                        <div
                          class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4"
                        >
                          <div>
                            <p class="text-sm text-gray-500">
                              {{ item.content }}
                              <a class="font-medium text-gray-900" href="#">{{
                                  item.target
                                }}</a>
                            </p>
                          </div>
                          <div
                            class="text-right text-sm whitespace-nowrap text-gray-500"
                          >
                            <time :datetime="item.datetime">{{
                                item.date
                              }}
                            </time>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </section>
        </div>
      </main>
    </div>
  </DashboardMain>
</template>

<script setup>
import AppHead from "@/Components/AppHead.vue";
import Button from "@/Components/Button.vue";
import DashboardMain from "@/Components/DashboardMain.vue";
import { DatabaseIcon, PlayIcon, RefreshIcon, StopIcon, TerminalIcon as WPTerminalIcon, } from "@heroicons/vue/outline";
import {
  CheckIcon,
  ClockIcon,
  EyeOffIcon,
  GlobeIcon,
  StatusOnlineIcon,
  TerminalIcon,
  ThumbUpIcon,
  UserIcon,
} from "@heroicons/vue/solid";
import { Inertia } from "@inertiajs/inertia";
import { onBeforeUnmount, ref } from "vue";

const user = {
  name: "Whitney Francis",
  email: "whitney@example.com",
  imageUrl:
    "https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=256&h=256&q=80",
};
const navigation = [
  {name: "Dashboard", href: "#"},
  {name: "Jobs", href: "#"},
  {name: "Applicants", href: "#"},
  {name: "Company", href: "#"},
];
const breadcrumbs = [
  {name: "Jobs", href: "#", current: false},
  {name: "Front End Developer", href: "#", current: false},
  {name: "Applicants", href: "#", current: true},
];
const userNavigation = [
  {name: "Your Profile", href: "#"},
  {name: "Settings", href: "#"},
  {name: "Sign out", href: "#"},
];
const attachments = [
  {name: "resume_front_end_developer.pdf", href: "#"},
  {name: "coverletter_front_end_developer.pdf", href: "#"},
];
const eventTypes = {
  applied: {icon: UserIcon, bgColorClass: "bg-gray-400"},
  advanced: {icon: ThumbUpIcon, bgColorClass: "bg-blue-500"},
  completed: {icon: CheckIcon, bgColorClass: "bg-green-500"},
};
const timeline = [
  {
    id: 1,
    type: eventTypes.applied,
    content: "Created",
    target: "WordPress Container",
    date: "Sep 20",
    datetime: "2020-09-20",
  },
  {
    id: 2,
    type: eventTypes.advanced,
    content: "Installed themes and plugins",
    target: "WP-CLI",
    date: "Sep 22",
    datetime: "2020-09-22",
  },
  {
    id: 3,
    type: eventTypes.completed,
    content: "Created and up and running",
    target: "Docker",
    date: "Sep 28",
    datetime: "2020-09-28",
  },
];
const comments = [
  {
    id: 1,
    name: "Leslie Alexander",
    date: "4d ago",
    imageId: "1494790108377-be9c29b29330",
    body: "Ducimus quas delectus ad maxime totam doloribus reiciendis ex. Tempore dolorem maiores. Similique voluptatibus tempore non ut.",
  },
  {
    id: 2,
    name: "Michael Foster",
    date: "4d ago",
    imageId: "1519244703995-f4e0f30006d5",
    body: "Et ut autem. Voluptatem eum dolores sint necessitatibus quos. Quis eum qui dolorem accusantium voluptas voluptatem ipsum. Quo facere iusto quia accusamus veniam id explicabo et aut.",
  },
  {
    id: 3,
    name: "Dries Vincent",
    date: "4d ago",
    imageId: "1506794778202-cad84cf45f1d",
    body: "Expedita consequatur sit ea voluptas quo ipsam recusandae. Ab sint et voluptatem repudiandae voluptatem et eveniet. Nihil quas consequatur autem. Perferendis rerum et.",
  },
];

let props = defineProps({
  record: Object,
  wordpress: Object,
  database: Object,
  state: String,
});

let currentState = props.state;
const processing = ref(false);

const fetchData = () => {
  Inertia.reload({
    preserveState: true,
    preserveScroll: true,
    onSuccess: (page) => {
      if (processing.value && page.props.state !== currentState) {
        processing.value = false;
        currentState = page.props.state;
      }
    },
  });
};

const start = () => {
  processing.value = true;
  Inertia.post(`/dashboard/sites/${props.record.data.id}/start`);
};

const stop = () => {
  processing.value = true;
  Inertia.post(`/dashboard/sites/${props.record.data.id}/stop`);
};

const restart = () => {
  processing.value = true;
  Inertia.post(`/dashboard/sites/${props.record.data.id}/restart`);
};

const reloadInterval = setInterval(() => {
  fetchData();
}, 10000);

onBeforeUnmount(() => {
  clearInterval(reloadInterval);
});
</script>
