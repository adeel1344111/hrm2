<script>
class TableManager {
    constructor(config) {
        this.tableId = config.tableId;
        this.searchInputId = config.searchInputId || null;
        this.filterInputs = config.filterInputs || [];
        this.rowsPerPage = config.rowsPerPage || 10;
        this.currentPage = 1;
        this.rows = [];
        this.filteredRows = [];
        
        this.init();
    }

    init() {
        const table = document.getElementById(this.tableId);
        if (!table) return;

        // Get all rows from tbody
        this.rows = Array.from(table.querySelector('tbody').querySelectorAll('tr'));
        this.filteredRows = [...this.rows];

        // Setup event listeners
        if (this.searchInputId) {
            const searchInput = document.getElementById(this.searchInputId);
            if (searchInput) {
                searchInput.addEventListener('input', () => this.handleSearch());
                // Remove existing onkeyup if present to avoid conflicts
                searchInput.removeAttribute('onkeyup');
            }
        }

        this.filterInputs.forEach(selector => {
            const input = document.querySelector(selector);
            if (input) {
                input.addEventListener('change', () => this.handleFilter());
                input.removeAttribute('onchange');
            }
        });

        // Add Pagination Controls Container
        this.paginationContainer = document.createElement('div');
        this.paginationContainer.className = 'flex justify-center mt-4 gap-2';
        table.parentElement.parentElement.appendChild(this.paginationContainer);

        // Initial Render
        this.render();
    }

    handleSearch() {
        this.applyFilters();
    }

    handleFilter() {
        this.applyFilters();
    }

    applyFilters() {
        const searchText = this.searchInputId 
            ? document.getElementById(this.searchInputId).value.toLowerCase() 
            : '';

        this.filteredRows = this.rows.filter(row => {
            // Text Search
            let textMatch = true;
            if (searchText) {
                textMatch = row.textContent.toLowerCase().includes(searchText);
            }

            // Dropdown Filters
            let filtersMatch = true;
            this.filterInputs.forEach(selector => {
                const input = document.querySelector(selector);
                const filterValue = input.value.toLowerCase();
                
                if (filterValue) {
                    // Logic: Match specifically against columns or just generic row text? 
                    // Generic row text is safer for a reusable script unless we define mapping
                    // But active/inactive is usually distinct.
                    // Improving logic: Check if row contains the filter value
                    if (!row.textContent.toLowerCase().includes(filterValue)) {
                        filtersMatch = false;
                    }
                }
            });

            return textMatch && filtersMatch;
        });

        this.currentPage = 1;
        this.render();
    }

    render() {
        // Hide all
        this.rows.forEach(row => row.style.display = 'none');

        // Calculate pages
        const totalPages = Math.ceil(this.filteredRows.length / this.rowsPerPage);
        
        // Ensure valid page
        if (this.currentPage > totalPages) this.currentPage = 1;
        
        // Show current page rows
        const start = (this.currentPage - 1) * this.rowsPerPage;
        const end = start + this.rowsPerPage;
        const pageRows = this.filteredRows.slice(start, end);
        
        pageRows.forEach(row => row.style.display = '');

        // Render Pagination Buttons
        this.renderPaginationControls(totalPages);
        
        // Update results counter if exists (optional enhancement for user feedback)
    }

    renderPaginationControls(totalPages) {
        this.paginationContainer.innerHTML = '';
        
        if (totalPages <= 1) return;

        // Previous
        const prevBtn = this.createButton('<', () => {
            if (this.currentPage > 1) {
                this.currentPage--;
                this.render();
            }
        }, this.currentPage === 1);
        this.paginationContainer.appendChild(prevBtn);

        // Pages (Smart range: 1, ... curr-1, curr, curr+1, ... last)
        // Simplified for now: Show all or limited
        let startPage = Math.max(1, this.currentPage - 2);
        let endPage = Math.min(totalPages, this.currentPage + 2);

        if (startPage > 1) {
             this.paginationContainer.appendChild(this.createButton('1', () => { this.currentPage = 1; this.render(); }, false));
             if (startPage > 2) {
                 const dots = document.createElement('span');
                 dots.className = 'px-3 py-1';
                 dots.innerText = '...';
                 this.paginationContainer.appendChild(dots);
             }
        }

        for (let i = startPage; i <= endPage; i++) {
            const btn = this.createButton(i, () => {
                this.currentPage = i;
                this.render();
            }, false, i === this.currentPage);
            this.paginationContainer.appendChild(btn);
        }

        if (endPage < totalPages) {
             if (endPage < totalPages - 1) {
                 const dots = document.createElement('span');
                 dots.className = 'px-3 py-1';
                 dots.innerText = '...';
                 this.paginationContainer.appendChild(dots);
             }
             this.paginationContainer.appendChild(this.createButton(totalPages, () => { this.currentPage = totalPages; this.render(); }, false));
        }

        // Next
        const nextBtn = this.createButton('>', () => {
            if (this.currentPage < totalPages) {
                this.currentPage++;
                this.render();
            }
        }, this.currentPage === totalPages);
        this.paginationContainer.appendChild(nextBtn);
    }

    createButton(text, onClick, disabled, active = false) {
        const btn = document.createElement('button');
        btn.innerHTML = text;
        btn.className = `px-3 py-1 border rounded transition-colors ${active 
            ? 'bg-blue-500 text-white border-blue-500' 
            : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50 dark:bg-zink-700 dark:text-zink-100 dark:border-zink-500 dark:hover:bg-zink-600'}`;
        
        if (disabled) {
            btn.disabled = true;
            btn.className += ' opacity-50 cursor-not-allowed';
        } else {
            btn.onclick = onClick;
        }
        return btn;
    }
}
</script>
<?php /**PATH /var/www/hrm2/resources/views/components/table-manager-script.blade.php ENDPATH**/ ?>