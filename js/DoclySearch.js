class DoclySearch {
    constructor() {
        this.searchButton = document.querySelector('.docly-search');
        this.modalTemplate = document.getElementById('docly-search-modal').content.cloneNode(true);
        this.modal = this.modalTemplate.querySelector('.docly-modal');
        this.closeButton = this.modal.querySelector('#docly-close-modal');

        this.initialized = false; // Ensure events are initialized only once

        this.init();
    }

    init() {
        // Handle opening the modal
        this.searchButton.addEventListener('click', () => this.openModal());
        // Handle closing the modal
        this.closeButton.addEventListener('click', () => this.closeModal());
    }

    openModal() {
        document.body.appendChild(this.modal);

        // Re-select the search input and results container now that the modal is in the DOM
        this.searchInput = document.getElementById('docly-search-input');
        this.resultsContainer = this.modal.querySelector('.docly-search-results');

        // Initialize events if not already done
        if (!this.initialized) {
            this.initEvents();
        }
    }

    initEvents() {
        // Attach event listener for search input
        this.searchInput.addEventListener('input', () => this.performSearch(this.searchInput.value));

        // Set initialized to true to prevent re-initialization
        this.initialized = true;

        this.modal.addEventListener('click', (event) => this.handleClickAway(event));
    }

    closeModal() {
        document.body.removeChild(this.modal);
        this.clearSearchInput();
    }

    async performSearch(query) {
        if (query.length < 3) {
            this.resultsContainer.innerHTML = ''; // Clear results if the query is too short
            return;
        }

        try {
            const response = await fetch(`/wp-json/wp/v2/doc?search=${encodeURIComponent(query)}`);
            const results = await response.json();
            this.displayResults(results);
        } catch (error) {
            console.error('Error fetching search results:', error);
        }
    }

    displayResults(results) {
        this.resultsContainer.innerHTML = '';

        if (results.length === 0) {
            this.resultsContainer.innerHTML = '<p>No results found.</p>';
            return;
        }

        const list = document.createElement('ul');
        results.forEach(doc => {
            const listItem = document.createElement('li');
            listItem.classList.add('docly-link');
            listItem.setAttribute('doc-post-id', doc.id);
            listItem.innerHTML = `<a doc-post-id="${doc.id}" href="${doc.link}">${doc.title.rendered}</a>`;
            list.appendChild(listItem);
        });

        this.resultsContainer.appendChild(list);

        // Re-init links to fetch doc posts. 
        const docController = new DocController();

    }

    clearSearchInput() {
        if (this.searchInput) {
            this.searchInput.value = '';
        }
    }

    handleClickAway(event) {
        // Check if the clicked element is exactly the .docly-modal (not a child element)
        if (event.target === this.modal) {
            this.closeModal();
        }
    }

}

// Initialize the DoclySearch class
document.addEventListener('DOMContentLoaded', () => {
    new DoclySearch();
});
