@props(['type' => 'bar', 'labels' => [], 'datasets' => [], 'title' => '', 'height' => 'h-96'])

<div class="bg-white rounded-lg shadow p-6">
    @if($title)
        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ $title }}</h3>
    @endif

    <div class="{{ $height }} relative">
        <canvas id="chart-{{ uniqid() }}" data-type="{{ $type }}" data-labels="{{ json_encode($labels) }}" data-datasets="{{ json_encode($datasets) }}"></canvas>
    </div>
</div>

@push('scripts')
<script>
function initChart(canvas) {
    const type = canvas.getAttribute('data-type');
    const labels = JSON.parse(canvas.getAttribute('data-labels'));
    const datasets = JSON.parse(canvas.getAttribute('data-datasets'));

    // Chart.js will be available globally after npm install
    if (typeof Chart !== 'undefined') {
        new Chart(canvas, {
            type: type,
            data: {
                labels: labels,
                datasets: datasets,
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                        }
                    }
                }
            }
        });
    }
}

// Wait for DOM to be ready and Chart.js to be loaded
document.addEventListener('DOMContentLoaded', function() {
    const canvases = document.querySelectorAll('canvas[data-type]');

    // If Chart.js is already loaded, initialize immediately
    if (typeof Chart !== 'undefined') {
        canvases.forEach(initChart);
    } else {
        // Wait for Chart.js to be available
        let attempts = 0;
        const checkChart = setInterval(() => {
            if (typeof Chart !== 'undefined') {
                clearInterval(checkChart);
                canvases.forEach(initChart);
            }
            attempts++;
            if (attempts > 50) clearInterval(checkChart); // Stop after 5 seconds
        }, 100);
    }
});
</script>
@endpush
