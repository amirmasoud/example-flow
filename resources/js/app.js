// Application
import Dashboard from "@/Shared/Dashboard.vue";
import Empty from "@/Shared/Empty.vue";
import hljsVuePlugin from "@highlightjs/vue-plugin";
import { createInertiaApp, Link } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import hljs from "highlight.js/lib/core";
import bash from "highlight.js/lib/languages/bash";

// Highlight.js Vue plugin
import "highlight.js/styles/stackoverflow-light.css";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { createApp, h } from "vue";
import "../css/app.css";

createInertiaApp({
  //  resolve: async (name) => {
  //    const page = (await import(`./Pages/${name}.vue`)).default;
  //    page.layout = name.startsWith("Auth/") ? Empty : page.layout || Dashboard;
  //    return page;
  //  },

  resolve: async (name) => {
    const page = (
      await resolvePageComponent(
        `./Pages/${name}.vue`,
        import.meta.glob("./Pages/**/*.vue")
      )
    ).default;
    console.log(page);
    page.layout = name.startsWith("Auth/") ? Empty : page.layout || Dashboard;
    return page;
  },

  setup({ el, App, props, plugin }) {
    console.log(el);

    hljs.registerLanguage("bash", bash);

    const app = createApp({ render: () => h(App, props) });

    // eslint-disable-next-line no-undef
    app.config.globalProperties.$route = route;
    app.use(plugin).use(hljsVuePlugin).component("Link", Link).mount(el);
  },
});

InertiaProgress.init({
  color: "blue",
  showSpinner: true,
});
