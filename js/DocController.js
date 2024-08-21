class DocController {

    constructor() {
        this.initialize();
        this.heightSetter();
    }

    initialize() {

        const docLinks = document.querySelectorAll('.docly-link a');
    
        docLinks.forEach(link => {

            link.addEventListener('click', (event) => {
                event.preventDefault();
    
                const docPostId = link.getAttribute('doc-post-id');
                const docHeading = link.getAttribute('doc-post-parent-title');
                
                this.navSetActiveClass(link);
                this.loadContent(docPostId, docHeading);
                
            });

        });

        this.loadFirst();

    }

    loadFirst() {

        const link = document.querySelector('.docly-link a');
        const docPostId = link.getAttribute('doc-post-id');
        const docHeading = link.getAttribute('doc-post-parent-title');
        this.navSetActiveClass(link);
        this.loadContent(docPostId, docHeading);

    }

    navSetActiveClass( linkEl ) {

        const currentActiveElement = document.querySelector('.docly-link--active');
        if (currentActiveElement) {
            currentActiveElement.classList.remove('docly-link--active');
        }
        linkEl.classList.add('docly-link--active');

    }
    
    async loadContent(docPostId, docHeading) {

        try {
            const response = await fetch(`/wp-json/wp/v2/doc/${docPostId}`);
            const data = await response.json();
    
            if (response.ok) {
    
                const docContentBody = document.querySelector('#doc-content-body');
                const docContentHeadingElement = document.querySelector('#doc-content-heading');
                const docContentTitleElement = document.querySelector('#doc-content-title');
    
                docContentBody.innerHTML = data.content.rendered;
                docContentHeadingElement.innerHTML = docHeading;
                docContentTitleElement.innerHTML = data.title.rendered;
    
                const event = new CustomEvent('docly_content_loaded', {
                    detail: {
                        postId: docPostId,
                        heading: docHeading
                    }
                });
                document.dispatchEvent(event);
    
            } else {
                console.error('Error fetching post:', data);
            }
        } catch (error) {
            console.error('Fetch error:', error);
        }

    }
    
    heightSetter() {

        const headerElement = document.querySelector('.docly-header');
        const navElement = document.querySelector('.docly-nav');
        const tocElement = document.querySelector('.doc-toc');
        const headerHeight = headerElement.clientHeight;
        const viewportHeight = window.innerHeight;
        const navHeight = viewportHeight - headerHeight - this.getAdminBarHeight();
        const navStickyTop = headerHeight + 32;
    
        if (headerElement && navElement) {
            navElement.style.height = `${navHeight}px`;
            navElement.style.top = `${navStickyTop}px`;
        }

        if (headerElement && tocElement) {
            tocElement.style.height = `${navHeight}px`;
            tocElement.style.top = `${navStickyTop}px`;
        }
        

    }

    getAdminBarHeight() {
        const rootStyles = getComputedStyle(document.documentElement);
        const adminBarHeight = rootStyles.getPropertyValue('--wp-admin--admin-bar--height').trim();
        return parseFloat(adminBarHeight) || 0; // Return 0 if the value is not a valid number
    }

}

// Instantiate the controller when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', () => {
    new DocController();
});
