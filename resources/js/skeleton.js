export function initSkeletonLoaders() {
  // Find all tables that support skeleton loading
  const skeletonTables = document.querySelectorAll('table[data-skeleton]');

  // Find all filter/search forms
  const forms = document.querySelectorAll('form.filter-form');

  forms.forEach(form => {
    form.addEventListener('submit', () => {
      showTableSkeletons();
    });

    // Also listen for filter input changes (auto-submit via Alpine)
    const inputs = form.querySelectorAll('input, select');
    inputs.forEach(input => {
      input.addEventListener('change', () => {
        showTableSkeletons();
      });
    });
  });

  // Listen for pagination link clicks
  document.addEventListener('click', (e) => {
    if (e.target.tagName === 'A' && e.target.hasAttribute('href')) {
      const href = e.target.getAttribute('href');
      if (href && href.includes('page=')) {
        showTableSkeletons();
      }
    }
  });
}

export function showTableSkeletons() {
  const skeletonTables = document.querySelectorAll('table[data-skeleton]');

  skeletonTables.forEach(table => {
    // Get row count and column count from data attributes
    const rowCount = parseInt(table.getAttribute('data-skeleton')) || 5;
    const columnCount = table.querySelector('thead tr')?.children.length || 6;

    // Create skeleton HTML
    const skeletonHTML = createSkeletonHTML(rowCount, columnCount);

    // Replace table content with skeleton
    const tbody = table.querySelector('tbody');
    if (tbody) {
      const skeletonDiv = document.createElement('div');
      skeletonDiv.className = 'skeleton-loader-wrapper';
      skeletonDiv.innerHTML = skeletonHTML;

      // Hide table, show skeleton
      table.style.display = 'none';
      table.parentNode.insertBefore(skeletonDiv, table);
    }
  });
}

export function hideTableSkeletons() {
  const skeletons = document.querySelectorAll('.skeleton-loader-wrapper');
  const tables = document.querySelectorAll('table[data-skeleton]');

  skeletons.forEach(skeleton => {
    skeleton.remove();
  });

  tables.forEach(table => {
    table.style.display = '';
  });
}

function createSkeletonHTML(rows, columns) {
  let html = '<div class="w-full animate-pulse">';

  for (let i = 0; i < rows; i++) {
    html += `
      <div class="border-b border-gray-200">
        <div class="flex items-center gap-4 px-4 py-3 h-16">
    `;

    for (let j = 0; j < columns; j++) {
      if (j === 0) {
        html += '<div class="flex-1"><div class="h-4 w-16 bg-gray-300 rounded"></div></div>';
      } else if (j === columns - 1) {
        html += '<div class="flex-1"><div class="space-y-2"><div class="h-3 w-8 bg-gray-300 rounded"></div><div class="h-3 w-8 bg-gray-300 rounded"></div></div></div>';
      } else {
        html += '<div class="flex-1"><div class="space-y-2"><div class="h-3 w-full bg-gray-300 rounded"></div><div class="h-3 w-2/3 bg-gray-300 rounded"></div></div></div>';
      }
    }

    html += `
        </div>
      </div>
    `;
  }

  html += '</div>';
  return html;
}

// Add CSS for shimmer animation
const style = document.createElement('style');
style.textContent = `
  @keyframes shimmer {
    0% {
      background-position: -1000px 0;
    }
    100% {
      background-position: 1000px 0;
    }
  }

  .skeleton-loader-wrapper .animate-pulse .bg-gray-300 {
    background: linear-gradient(
      90deg,
      rgba(209, 213, 219, 0.5) 0%,
      rgba(229, 231, 235, 0.8) 50%,
      rgba(209, 213, 219, 0.5) 100%
    );
    background-size: 200% 100%;
    animation: shimmer 2s infinite;
  }
`;
document.head.appendChild(style);
