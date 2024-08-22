class DocController {

    currentDocPostId  = 0;
    isMobileViewport  = false;
    responsiveNavOpen = false;

    constructor() {

        this.initialize();
        this.heightSetter();

    }

    initialize() {

        const docLinks = document.querySelectorAll('.docly-link');
    
        docLinks.forEach(link => {
            this.addLinkClickEvent(link);
        });

        this.loadFirst();

        this.checkViewport();

        if( this.isMobileViewport ) {
            this.responsiveNavButton();
            this.responsiveNavAutoClose();
        }

    }

    addLinkClickEvent(link) {

        link.addEventListener('click', (event) => {
            event.preventDefault();

            const docPostId = link.getAttribute('doc-post-id');
            const docHeading = link.getAttribute('doc-post-parent-title');
            
            this.navSetActiveClass(link);
            this.loadContent(docPostId, docHeading);
            
        });

    }

    loadFirst() {

        const link = document.querySelector('.docly-link');
        const docPostId = link.getAttribute('doc-post-id');
        const docHeading = link.getAttribute('doc-post-parent-title');
        this.navSetActiveClass(link);
        this.loadContent(docPostId, docHeading);

    }

    responsiveNavButton() {

        const navButtonEl = document.querySelector('.docly-responsive-nav-button');
        navButtonEl.addEventListener('touchstart', () => {
            
            const navEl = document.querySelector('.docly-nav');

            if( ! this.responsiveNavOpen ) {
                navEl.style.display = 'block';
                this.responsiveNavOpen = true;
                const headerHeight = this.getHeaderHeight();

                console.log(headerHeight)

                const navTop = headerHeight + this.getAdminBarHeight();
                navEl.style.top = navTop + 'px';
                return;
            }

            navEl.style.display = 'none';
            this.responsiveNavOpen = false;

        });

    }

    responsiveNavAutoClose() {

        document.addEventListener('docly_content_loaded', () => {
            const navEl = document.querySelector('.docly-nav');
            navEl.style.display = 'none';
            this.responsiveNavOpen = false;
        });

    }

    checkViewport() {
        if (window.innerWidth <= 720) {
            this.isMobileViewport = true;
        } else {
            this.isMobileViewport = false;
        }
    }

    navSetActiveClass(linkEl) {
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

                // Update current doc post ID.
                this.currentDocPostId = docPostId;
    
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

    getHeaderHeight() {
        const headerElement = document.querySelector('.docly-header');
        return headerElement.clientHeight;
    }

    getAdminBarHeight() {
        const rootStyles = getComputedStyle(document.documentElement);
        const adminBarHeight = rootStyles.getPropertyValue('--wp-admin--admin-bar--height').trim();
        return parseFloat(adminBarHeight) || 0; // Return 0 if the value is not a valid number
    }

}

// Instantiate the controller when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', () => {
    window.docly = {
        controller: new DocController()
    };
});
