<template>
  <AppHead title="Home"/>

  <DashboardMain>
    <template #header>Home</template>
    <template #sub-header-content>
      <Stats :stats="stats"/>
    </template>
  </DashboardMain>
</template>

<script setup>
import AppHead from "@/Components/AppHead.vue";
import DashboardMain from "@/Components/DashboardMain.vue";
import Stats from "@/Components/stats.vue";

defineProps({
  stats: Object,
});
</script>
