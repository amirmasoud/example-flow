<template>
  <div class="justify-center items-center flex">
    <div class="flex-1 mt-6 mb-8">
      <div class="space-y-2 space-x-2">
        <span
          v-for="(cmd, idx) in sampleCommands"
          :key="idx"
          class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-indigo-100 text-indigo-800"
        >
          <button
            type="button"
            @click.prevent="
              (c) =>
                $emit(
                  'update:entered-commands',
                  enteredCommands + '\n' + cmd.command
                )
            "
          >
            {{ cmd.display }}
          </button>
        </span>
      </div>
      <textarea
        v-model="enteredCommands"
        spellcheck="false"
        data-gramm="false"
        data-gramm_editor="false"
        data-enable-grammarly="false"
        rows="3"
        class="mt-6 shadow-sm block w-full focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border border-gray-300 rounded-md"
        @update:modelValue="
          (commands) => $emit('update:entered-commands', enteredCommands)
        "
      ></textarea>
    </div>
  </div>
</template>

<script setup>
const sampleCommands = [
  {
    display: "10 random posts",
    command:
      "wp post create --post_type=page --post_title='A random post' --post_status=publish --post_author=1 --post_content='This is a sample post'",
  },
  {
    display: "Generate posts with fetched content.",
    command:
      "curl -N https://loripsum.net/api/5 | wp post generate --post_content --count=10",
  },
  {
    display: "Create a new post",
    command: "wp post create --post_type=post --post_title='A sample post'",
  },
  {
    display: "Create a new page",
    command: "wp post create --post_type=page --post_title='A sample page'",
  },
];

let props = defineProps({
  enteredCommands: String,
});
</script>
