class DocController {
    constructor() {
        this.initialize();
    }

    initialize() {
        // Select all <a> elements within .docly-link
        const docLinks = document.querySelectorAll('.docly-link a');

        // Add a click event listener to each link
        docLinks.forEach(link => {
            link.addEventListener('click', async (event) => {
                event.preventDefault(); // Prevent default navigation

                const docPostId = link.getAttribute('doc-post-id');
                const docHeading = link.getAttribute('doc-post-parent-title');

                try {
                    // Fetch the post content from the WordPress REST API
                    const response = await fetch(`/wp-json/wp/v2/doc/${docPostId}`);
                    const data = await response.json();

                    if (response.ok) {
                        // Render the post content into the .doc-content__body element
                        const docContentBody = document.querySelector('#doc-content-body');
                        const docContentHeadingElement = document.querySelector('#doc-content-heading');
                        const docContentTitleElement = document.querySelector('#doc-content-title');

                        docContentBody.innerHTML = data.content.rendered;
                        docContentHeadingElement.innerHTML = docHeading;
                        docContentTitleElement.innerHTML = data.title.rendered;

                        // Fire the custom event after the content is added
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
            });
        });
    }
}

// Instantiate the controller when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', () => {
    new DocController();
});
