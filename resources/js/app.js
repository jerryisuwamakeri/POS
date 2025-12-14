import './bootstrap';
import './charts';
import './print';

// Initialize charts when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    if (typeof window.initCharts === 'function') {
        window.initCharts();
    }
});

