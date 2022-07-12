<template>
  <AppHead :title="`Edit ${form.name} site`"/>

  <DashboardMain>
    <template #header>Edit site {{ resource.data.name }}</template>
    <template #buttons></template>
    <template #sub-header></template>
    <template #sub-header-content></template>

    <form
      @submit.prevent="form.post(`/dashboard/sites/${resource.data.id}/update`)"
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
              <Button :form="form" type="submit"> Submit</Button>
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
import { useForm } from "@inertiajs/inertia-vue3";

let props = defineProps({
  resource: Object,
});

let form = useForm(`EditSite: ${props.resource.id}`, props.resource.data);
</script>
