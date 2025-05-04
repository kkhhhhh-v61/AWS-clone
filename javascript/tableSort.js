// Table sorting functionality
class TableSort {
    constructor(tableId) {
        this.table = document.getElementById(tableId);
        this.headers = this.table.querySelectorAll('thead th');
        this.rows = Array.from(this.table.querySelectorAll('tbody tr'));
        this.sortStates = {};
        
        // Add click event listeners to headers
        this.headers.forEach(header => {
            header.addEventListener('click', () => this.sortTable(header));
        });
    }

    sortTable(header) {
        const columnIndex = Array.from(header.parentNode.children).indexOf(header);
        const isNumeric = header.classList.contains('numeric');
        let sortDirection = this.sortStates[columnIndex] || 'asc';

        // Toggle sort direction
        if (sortDirection === 'asc') {
            sortDirection = 'desc';
        } else {
            sortDirection = 'asc';
        }
        this.sortStates[columnIndex] = sortDirection;

        // Update sort indicators
        this.updateSortIndicators(columnIndex);

        // Sort the rows
        this.rows.sort((rowA, rowB) => {
            const cellA = rowA.cells[columnIndex].textContent.trim();
            const cellB = rowB.cells[columnIndex].textContent.trim();

            if (isNumeric) {
                return sortDirection === 'asc' 
                    ? Number(cellA) - Number(cellB) 
                    : Number(cellB) - Number(cellA);
            } else {
                return sortDirection === 'asc' 
                    ? cellA.localeCompare(cellB) 
                    : cellB.localeCompare(cellA);
            }
        });

        // Update the table body
        const tbody = this.table.querySelector('tbody');
        this.rows.forEach(row => tbody.appendChild(row));
    }

    updateSortIndicators(activeColumn) {
        this.headers.forEach((header, index) => {
            const sortIndicator = header.querySelector('.sort-indicator');
            if (sortIndicator) {
                sortIndicator.remove();
            }

            if (index === activeColumn) {
                const indicator = document.createElement('span');
                indicator.className = 'sort-indicator';
                indicator.style.marginLeft = '5px';
                
                if (this.sortStates[index] === 'asc') {
                    indicator.textContent = '↑';
                } else {
                    indicator.textContent = '↓';
                }
                
                header.appendChild(indicator);
            }
        });
    }
}

// Initialize table sorting for all tables with class 'sortable'
document.addEventListener('DOMContentLoaded', () => {
    const sortableTables = document.querySelectorAll('table.sortable');
    sortableTables.forEach(table => {
        new TableSort(table.id);
    });
});
