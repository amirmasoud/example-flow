<template>
  <AppHead title="Sites"/>

  <DashboardMain>
    <template #header>Servers</template>
    <template #buttons>
      <Button :href="$route(table.actions.create.link)">New server</Button>
    </template>

    <Table
      :actions="table.actions"
      :endpoint="$route('dashboard.sites.servers.index')"
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

defineProps({records: Object, filters: Object, table: Object, stats: Object});
</script>
