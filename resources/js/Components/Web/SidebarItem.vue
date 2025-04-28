<template>
  <div
    @click="$emit('click')"
    :class="[
      'flex items-center gap-3 px-4 py-2 rounded cursor-pointer transition-colors',
      active ? 'bg-gray-800' : 'hover:bg-gray-700'
    ]"
  >
    <i :class="`fas ${icon}`"></i>
    <span class="text-sm">{{ label }}</span>
  </div>
</template>

<script>
export default {
  props: {
    icon: String,
    label: String,
    active: {
      type: Boolean,
      default: false
    }
  }
}
</script>
