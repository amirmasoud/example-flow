<template>
  <AppHead title="CLI"/>

  <DashboardMain>
    <template #header>Cli - {{ record.data.name }}</template>

    <div class="my-y rounded-xl shadow overflow-hidden">
      <highlightjs :code="output" language="bash"/>
    </div>
  </DashboardMain>
</template>

<script setup>
import AppHead from "@/Components/AppHead.vue";
import DashboardMain from "@/Components/DashboardMain.vue";
import { Inertia } from "@inertiajs/inertia";
import { onMounted } from "vue";

let props = defineProps({record: Object, output: String});

const fetchData = () => {
  Inertia.reload({
    preserveState: true,
    preserveScroll: true,
  });
};

// Fetch data on mount (Lazy loaded)
onMounted(() => {
  fetchData();
});

const reloadInterval = setInterval(() => {
  fetchData();
}, 10000);
</script>
