<script setup>
import { cn } from '@/lib/utils';

const props = defineProps({
  class: { type: null, required: false },
});
</script>

<template>
  <tfoot
    :class="
      cn('border-t bg-gray-100/50 font-medium [&>tr]:last:border-b-0 dark:bg-gray-800/50', props.class)
    "
  >
    <slot />
  </tfoot>
</template>
