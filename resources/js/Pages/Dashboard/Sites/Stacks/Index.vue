<template>
  <AppHead title="Stacks"/>

  <DashboardMain>
    <template #header>Stacks</template>
    <template #buttons>
      <Button :href="$route(table.actions.create.link)">New stack</Button>
    </template>
    <template #sub-header></template>

    <Table
      :actions="table.actions"
      :endpoint="$route('dashboard.sites.stacks.index')"
      :fields="table.fields"
      :filters="filters"
      :records="records"
    />
  </DashboardMain>
</template>

<script setup>
import AppHead from "@/Components/AppHead.vue";
import Button from "@/Components/Button.vue";
import DashboardMain from "@/Components/DashboardMain.vue";
import Table from "@/Components/Table.vue";

defineProps({records: Object, filters: Object, table: Object});
</script>
