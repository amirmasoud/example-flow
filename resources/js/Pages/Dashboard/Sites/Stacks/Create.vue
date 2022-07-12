<template>
  <AppHead title="Create new site"/>

  <DashboardMain>
    <template #header> Sites</template>

    <form @submit.prevent="form.post($route('dashboard.sites.stacks.store'))">
      <div class="col-span-6 sm:col-span-4">
        <Input v-model="form.name" :form="form" label="Name" name="name"/>
      </div>

      <div class="col-span-6 sm:col-span-4">
        <Input v-model="form.price" :form="form" label="Price" name="price"/>
      </div>

      <div class="col-span-6 sm:col-span-4">
        <Input
          v-model="form.properties"
          :form="form"
          label="Properties"
          name="properties"
        />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <Input v-model="form.type" :form="form" label="Type" name="type"/>
      </div>
    </form>
  </DashboardMain>
</template>

<script setup>
import AppHead from "@/Components/AppHead.vue";
import DashboardMain from "@/Components/DashboardMain.vue";
import Input from "@/Components/Forms/Inputs/Input.vue";
import { useForm } from "@inertiajs/inertia-vue3";

let form = useForm({
  name: null,
  price: null,
  properties: null,
  type: null,
});
</script>
