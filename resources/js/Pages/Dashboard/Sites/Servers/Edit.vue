<template>
  <AppHead :title="`Edit ${form.name} site`"/>

  <DashboardMain>
    <template #header>Edit site {{ resource.data.name }}</template>

    <form
      @submit.prevent="
        form.put($route('dashboard.sites.servers.update', [resource.data]))
      "
    >
      <div class="overflow-hidden sm:rounded-md shadow">
        <div class="sm:p-6 py-5 px-4 bg-white">
          <div class="">
            <div class="grid grid-cols-6 gap-6">
              <div class="col-span-4">
                <Input
                  v-model="form.name"
                  :form="form"
                  label="Name"
                  name="name"
                />
              </div>

              <div class="col-span-2">
                <Input
                  v-model="form.price"
                  :form="form"
                  :help="'Per month'"
                  label="Price"
                  name="price"
                />
              </div>

              <div class="col-span-4">
                <Input v-model="form.ip" :form="form" label="IP" name="ip"/>
              </div>

              <div class="col-span-2">
                <Input
                  v-model="form.port"
                  :form="form"
                  :help="'Default: 80/443'"
                  label="Port"
                  name="port"
                />
              </div>

              <div class="col-span-4">
                <Input v-model="form.ram" :form="form" label="RAM" name="ram"/>
              </div>

              <div class="col-span-2">
                <Option
                  v-model="form.ram_unit"
                  :form="form"
                  :options="ramUnits"
                  label="Units"
                  name="ram_unit"
                />
              </div>

              <div class="col-span-6">
                <Input v-model="form.cpu" :form="form" label="CPU" name="cpu"/>
              </div>

              <div class="col-span-2">
                <Input
                  v-model="form.disk"
                  :form="form"
                  label="Disk"
                  name="disk"
                />
              </div>

              <div class="col-span-2">
                <Option
                  v-model="form.disk_type"
                  :form="form"
                  :options="diskTypes"
                  label="Disk type"
                  name="disk_type"
                />
              </div>

              <div class="col-span-2">
                <Option
                  v-model="form.disk_unit"
                  :form="form"
                  :options="diskUnits"
                  label="Disk unit"
                  name="disk_unit"
                />
              </div>

              <div class="col-span-4">
                <Option
                  v-model="form.os"
                  :form="form"
                  :options="osFlavors"
                  label="OS"
                  name="os"
                />
              </div>

              <div class="col-span-2">
                <Input
                  v-model="form.os_version"
                  :form="form"
                  label="OS Version"
                  name="os_version"
                />
              </div>

              <div class="col-span-6">
                <Option
                  v-model="form.status"
                  :form="form"
                  :options="serverStatuses"
                  label="Status"
                  name="status"
                />
              </div>

              <div class="col-span-6">
                <Textarea
                  v-model="form.notes"
                  :form="form"
                  label="Notes"
                  name="notes"
                />
              </div>

              <div class="col-span-6">
                <Button :form="form" type="submit">Update</Button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </DashboardMain>
</template>

<script setup>
import AppHead from "@/Components/AppHead.vue";
import DashboardMain from "@/Components/DashboardMain.vue";
import Button from "@/Components/Forms/Buttons/Button.vue";
import Input from "@/Components/Forms/Inputs/Input.vue";
import Option from "@/Components/Forms/Inputs/Option.vue";
import Textarea from "@/Components/Forms/Inputs/Textarea.vue";
import { useForm } from "@inertiajs/inertia-vue3";

let props = defineProps({
  resource: Object,
  ramUnits: Object,
  diskTypes: Object,
  diskUnits: Object,
  osFlavors: Object,
  serverStatuses: Object,
});

let form = useForm(`EditServer: ${props.resource.id}`, props.resource.data);
</script>
