<template>
  <AppHead title="Login"/>
  <div
    class="flex flex-col justify-center py-12 sm:px-6 lg:px-8 min-h-screen bg-gray-50 dark:bg-slate-900"
  >
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <h2
        class="mt-6 text-3xl font-extrabold text-center text-gray-900 dark:text-white"
      >
        Sign in to your account
      </h2>
    </div>

    <div class="sm:mx-auto mt-8 sm:w-full sm:max-w-md">
      <div
        class="py-8 px-4 sm:px-10 bg-white dark:bg-slate-800 sm:rounded-lg shadow"
      >
        <form
          action="#"
          class="space-y-6"
          @submit.prevent="form.post('/login')"
        >
          <div>
            <Input
              v-model="form.email"
              :form="form"
              label="Email"
              name="email"
              type="email"
            />
          </div>

          <div>
            <label
              class="block text-sm font-medium text-gray-700 dark:text-slate-300"
              for="password"
            >
              Password
            </label>
            <div class="mt-1">
              <input
                id="password"
                v-model="form.password"
                autocomplete="current-password"
                class="block py-2 px-3 w-full sm:text-sm placeholder-gray-400 rounded-md border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm appearance-none focus:outline-none"
                name="password"
                required=""
                type="password"
              />
            </div>
          </div>

          <div class="flex justify-between items-center">
            <div class="flex items-center">
              <input
                id="remember-me"
                v-model="form.remember"
                class="w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500 dark:bg-slate-800 dark-border-gray-900 dark:focus:ring-indigo-900"
                name="remember-me"
                type="checkbox"
              />
              <label
                class="block ml-2 text-sm text-gray-900 dark:text-slate-300"
                for="remember-me"
              >
                Remember me
              </label>
            </div>

            <div class="text-sm">
              <a
                class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400"
                href="#"
              >
                Forgot your password?
              </a>
            </div>
          </div>

          <div>
            <Button
              :form="form"
              class="flex justify-center py-2 px-4 w-full"
              type="submit"
            >
              Sign in
            </Button>
          </div>
        </form>

        <!--        <div class="mt-6">-->
        <!--          <div class="relative">-->
        <!--            <div class="flex absolute inset-0 items-center">-->
        <!--              <div class="w-full border-t border-gray-300" />-->
        <!--            </div>-->
        <!--            <div class="flex relative justify-center text-sm">-->
        <!--              <span class="px-2 text-gray-500 bg-white">-->
        <!--                Or continue with-->
        <!--              </span>-->
        <!--            </div>-->
        <!--          </div>-->

        <!--          <div class="grid grid-cols-3 gap-3 mt-6">-->
        <!--            <div>-->
        <!--              <a-->
        <!--                href="#"-->
        <!--                class="inline-flex justify-center py-2 px-4 w-full text-sm font-medium text-gray-500 bg-white hover:bg-gray-50 rounded-md border border-gray-300 shadow-sm"-->
        <!--              >-->
        <!--                <span class="sr-only">Sign in with Facebook</span>-->
        <!--                <Facebook class="w-5 h-5" />-->
        <!--              </a>-->
        <!--            </div>-->

        <!--            <div>-->
        <!--              <a-->
        <!--                href="#"-->
        <!--                class="inline-flex justify-center py-2 px-4 w-full text-sm font-medium text-gray-500 bg-white hover:bg-gray-50 rounded-md border border-gray-300 shadow-sm"-->
        <!--              >-->
        <!--                <span class="sr-only">Sign in with Twitter</span>-->
        <!--                <Twitter class="w-5 h-5" />-->
        <!--              </a>-->
        <!--            </div>-->

        <!--            <div>-->
        <!--              <a-->
        <!--                :href="github"-->
        <!--                class="inline-flex justify-center py-2 px-4 w-full text-sm font-medium text-gray-500 bg-white hover:bg-gray-50 rounded-md border border-gray-300 shadow-sm"-->
        <!--              >-->
        <!--                <span class="sr-only">Sign in with GitHub</span>-->
        <!--                <GitHub class="w-5 h-5" />-->
        <!--              </a>-->
        <!--            </div>-->

        <!--            <div>-->
        <!--              <a-->
        <!--                :href="google"-->
        <!--                class="inline-flex justify-center py-2 px-4 w-full text-sm font-medium text-gray-500 bg-white hover:bg-gray-50 rounded-md border border-gray-300 shadow-sm"-->
        <!--              >-->
        <!--                <span class="sr-only">Sign in with Google</span>-->
        <!--                <Google class="w-5 h-5" />-->
        <!--              </a>-->
        <!--            </div>-->
        <!--          </div>-->
        <!--        </div>-->
      </div>
    </div>
  </div>
</template>

<script setup>
import AppHead from "@/Components/AppHead.vue";
import Button from "@/Components/Forms/Buttons/Button.vue";
import Input from "@/Components/Forms/Inputs/Input.vue";
import { useForm } from "@inertiajs/inertia-vue3";

defineProps({
  github: String,
  google: String,
});

let form = useForm({
  email: null,
  password: null,
  remember: false,
});
</script>
