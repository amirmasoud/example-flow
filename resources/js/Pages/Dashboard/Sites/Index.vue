<template>
  <AppHead title="Sites"/>

  <DashboardMain>
    <template #header>Sites</template>
    <template v-if="canCreate" #buttons>
      <Button :href="$route(table.actions.create.link)"> New site</Button>
    </template>
    <template #sub-header></template>
    <template #sub-header-content>
      <Stats :stats="stats"/>
    </template>

    <Table
      :actions="table.actions"
      :can-create="canCreate"
      :fields="table.fields"
      :filters="filters"
      :records="records"
      cannot-create-button="New site"
      cannot-create-description="You need to have at least one stack and server configured to continue."
      cannot-create-title="Need prerequisites"
      endpoint="/dashboard/sites"
    />
  </DashboardMain>
</template>

<script setup>
import AppHead from "@/Components/AppHead.vue";
import Button from "@/Components/Button.vue";
import DashboardMain from "@/Components/DashboardMain.vue";
import Stats from "@/Components/stats.vue";
import Table from "@/Components/Table.vue";

defineProps({
  records: Object,
  filters: Object,
  table: Object,
  stats: Object,
  canCreate: Boolean,
});
</script>
