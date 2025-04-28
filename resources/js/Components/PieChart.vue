<script setup>
import { onMounted, ref, watch } from 'vue'
import { Chart, registerables } from 'chart.js'

Chart.register(...registerables)

const props = defineProps({
  data: {
    type: Array,
    default: () => []
  }
})

const canvasRef = ref(null)

onMounted(() => {
  if (!props.data || props.data.length === 0) return

  new Chart(canvasRef.value, {
    type: 'pie',
    data: {
      labels: props.data.map(d => d.name),
      datasets: [{
        label: 'Jumlah Barang',
        data: props.data.map(d => d.count),
        backgroundColor: [
          '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'
        ]
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'bottom'
        }
      }
    }
  })
})
</script>
