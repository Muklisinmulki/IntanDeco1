<!-- resources/js/Components/Dashboard/LogoutModal.vue -->
<template>
  <div
    v-if="show"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/30 backdrop-blur-sm"
  >
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-sm border border-gray-200">
      <div class="flex justify-center mb-4">
        <div class="h-16 w-16 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-500 text-3xl">
          <i class="fas fa-exclamation-circle"></i>
        </div>
      </div>
      <h3 class="text-xl font-semibold text-gray-800 mb-2 text-center">Are you sure?</h3>
      <p class="text-sm text-gray-500 mb-6 text-center">
        You will be logged out from your account.
      </p>
      <div class="flex justify-center gap-4">
        <button
          @click="$emit('cancel')"
          class="px-4 py-2 rounded bg-gray-200 text-gray-800 hover:bg-gray-300 text-sm font-medium"
        >
          Cancel
        </button>
        <button
          @click="$emit('confirm')"
          class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700 text-sm font-medium"
        >
          Yes, logout!
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'LogoutModal',
  props: {
    show: {
      type: Boolean,
      default: false
    }
  }
}
</script>
