<template>
  <AppHead title="New site"/>

  <DashboardMain>
    <template #header> Sites</template>

    <form
      class="max-w-screen-lg"
      @submit.prevent="form.post('/dashboard/sites')"
    >
      <div class="overflow-hidden sm:rounded-md shadow">
        <div class="sm:p-6 py-5 px-4 bg-white">
          <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-4">
              <Input
                v-model="form.name"
                :form="form"
                label="Name"
                name="name"
              />
            </div>

            <div class="col-span-6 sm:col-span-4">
              <Input
                v-model="form.host"
                :form="form"
                label="Host"
                name="host"
              />
            </div>

            <div class="col-span-6 sm:col-span-4">
              <label
                class="block text-sm font-medium text-gray-700 mb-2"
                for="servers"
              >Server</label
              >
              <RadioGroup v-model="form.server_id">
                <RadioGroupLabel class="sr-only"> Server size</RadioGroupLabel>
                <div class="space-y-4">
                  <RadioGroupOption
                    v-for="server in servers.data"
                    :key="server.id"
                    v-slot="{ active, checked }"
                    :value="server.id"
                    as="div"
                  >
                    <div
                      :class="[
                        active ? 'ring-1 ring-offset-2 ring-indigo-500' : '',
                        'relative block rounded-lg border border-gray-300 bg-white shadow-sm px-6 py-4 cursor-pointer hover:border-gray-400 sm:flex sm:justify-between focus:outline-none',
                      ]"
                    >
                      <div class="flex items-center">
                        <div class="text-sm">
                          <RadioGroupLabel
                            as="p"
                            class="font-medium text-gray-900"
                          >
                            {{ server.name }}
                          </RadioGroupLabel>
                          <RadioGroupDescription as="div" class="text-gray-500">
                            <p class="sm:inline">
                              {{ server.ram }}{{ server.ram_unit }} /
                              {{ server.cpu }} Core
                            </p>
                            {{ " " }}
                            <span
                              aria-hidden="true"
                              class="hidden sm:inline sm:mx-1"
                            >&middot;</span
                            >
                            {{ " " }}
                            <p class="sm:inline">
                              {{ server.disk }}{{ server.disk_unit }}
                              {{ server.disk_type }}
                            </p>
                          </RadioGroupDescription>
                        </div>
                      </div>
                      <RadioGroupDescription
                        as="div"
                        class="mt-2 flex text-sm sm:mt-0 sm:block sm:ml-4 sm:text-right"
                      >
                        <div class="font-medium text-gray-900">
                          {{ !server.price ? "Free" : server.price }}
                        </div>
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
              <TransitionRoot
                id="server-id-error"
                :if="form.errors['server_id']"
                as="p"
                class="mt-2 block text-sm text-red-600"
                enter="transition-opacity duration-300"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="transition-opacity duration-300"
                leave-from="opacity-100"
                leave-to="opacity-0"
              >
                {{ form.errors["server_id"] }}
              </TransitionRoot>
            </div>

            <div class="col-span-6 sm:col-span-4">
              <label
                class="block text-sm font-medium text-gray-700 mb-2"
                for="stacks"
              >Stack</label
              >
              <RadioGroup v-model="form.stack_id" class="max-w-screen-xl">
                <RadioGroupLabel class="sr-only">
                  Selected Stack Type
                </RadioGroupLabel>
                <div
                  class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4"
                >
                  <RadioGroupOption
                    v-for="stack in stacks.data"
                    :key="stack.id"
                    v-slot="{ active, checked }"
                    :value="stack.id"
                    as="div"
                    class="overflow-hidden break-all"
                  >
                    <div
                      :class="[
                        active ? 'ring-1 ring-offset-2 ring-indigo-500' : '',
                        'relative block rounded-lg border border-gray-300 bg-white shadow-sm cursor-pointer hover:border-gray-400 sm:flex sm:justify-between focus:outline-none',
                      ]"
                    >
                      <div class="flex items-center flex-col">
                        <img :src="stack.type_icon" class="rounded-t-lg p-4"/>
                        <div class="block w-full px-4 pt-2 pb-4">
                          <RadioGroupLabel
                            as="p"
                            class="font-medium text-gray-900"
                          >
                            <p class="line-clamp-1" v-html="stack.name"/>
                          </RadioGroupLabel>
                          <SwitchDescription
                            as="div"
                            class="text-sm text-gray-500 line-clamp-1"
                          >
                            ${{ stack.price }} / mo
                          </SwitchDescription>
                          <SwitchDescription
                            as="div"
                            class="text-sm text-gray-500 line-clamp-1"
                          >
                            {{ stack.type_name }} Stack
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
              <TransitionRoot
                id="stack-id-error"
                :if="form.errors['stack_id']"
                as="p"
                class="mt-2 block text-sm text-red-600"
                enter="transition-opacity duration-300"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="transition-opacity duration-300"
                leave-from="opacity-100"
                leave-to="opacity-0"
              >
                {{ form.errors["stack_id"] }}
              </TransitionRoot>
            </div>

            <div class="col-span-6 sm:col-span-4">
              <Button color="green" type="submit">
                <PaperAirplaneIcon class="w-4 h-4 mr-2"/>
                Deploy
              </Button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </DashboardMain>
</template>

<script setup>
import AppHead from "@/Components/AppHead.vue";
import Button from "@/Components/Button.vue";
import DashboardMain from "@/Components/DashboardMain.vue";
import Input from "@/Components/Forms/Inputs/Input.vue";
import {
  RadioGroup,
  RadioGroupDescription,
  RadioGroupLabel,
  RadioGroupOption,
  SwitchDescription,
} from "@headlessui/vue";
import { PaperAirplaneIcon } from "@heroicons/vue/solid";
import { useForm } from "@inertiajs/inertia-vue3";
import { defineProps, ref } from "vue";

let props = defineProps({
  servers: Object,
  stacks: Object,
  types: Object,
});

const selectedStack = ref(props.types[0].value);
const selectedServer = ref(props.servers.data[0].id);

let form = useForm({
  name: null,
  host: null,
  server_id: null,
  stack_id: null,
});
</script>
