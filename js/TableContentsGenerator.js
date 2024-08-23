class TableContentsGenerator {

    headingIdsGenerated = []

    constructor() {
        this.initialize();
    }

    initialize() {
        const contentBody = document.querySelector('#doc-content-body');
        if (contentBody) {
            const headingsTree = this.parseHeadings(contentBody);
            const tocEl = document.querySelector('.doc-toc');

            if (headingsTree.length > 0) {
                this.renderContextMenu(headingsTree);
                if (tocEl) {
                    tocEl.style.display = 'block';
                }
                this.trackScrolling();
            } else {
                if (tocEl) {
                    tocEl.style.display = 'none';
                }
            }
        }
    }

    parseHeadings(contentBody) {

        const headings = contentBody.querySelectorAll('h2, h3, h4, h5, h6');
        const tree = [];
        let currentLevel = { children: tree };

        headings.forEach(heading => {
            const level = parseInt(heading.tagName.charAt(1));
            const node = {
                level: level,
                text: heading.textContent,
                element: heading,
                children: []
            };

            if (level === 2) {
                tree.push(node);
                currentLevel = node;
            } else {
                let parentNode = currentLevel;
                while (parentNode.level >= level) {
                    parentNode = parentNode.parent || { children: tree };
                }
                node.parent = parentNode;
                parentNode.children.push(node);
                currentLevel = node;
            }
        });

        return tree;
    }

    renderContextMenu(tree) {

        const contextMenu = document.querySelector('.doc-toc__body');
        contextMenu.innerHTML = ''; // Clear existing content

        const createMenuItem = (node) => {

            if (node.text) {
                const headingId = this.generateIdFromText(node.text);
                node.element.setAttribute('id', headingId);
            }

            const listItem = document.createElement('li');
            listItem.textContent = node.text;
            listItem.classList.add('doc-toc__item');
            listItem.setAttribute('target-heading', node.element.getAttribute('id'));

            if (node.children.length > 0) {
                const subMenu = document.createElement('ul');
                subMenu.classList.add('doc-toc__list');
                node.children.forEach(childNode => {
                    subMenu.appendChild(createMenuItem(childNode));
                });
                listItem.appendChild(subMenu);
            }

            listItem.addEventListener('click', () => {
                node.element.scrollIntoView({ behavior: 'smooth' });
            });

            return listItem;
        };

        tree.forEach(node => {
            contextMenu.appendChild(createMenuItem(node));
        });
    }

    generateIdFromText(text) {

        let baseId = text.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
        let id = baseId;
        let counter = 1;
    
        // If the generated ID is already in use, append a counter until it's unique
        while (this.headingIdsGenerated.includes(id)) {
            id = `${baseId}-${counter}`;
            counter++;
        }
    
        // Store the generated ID to avoid future duplicates
        this.headingIdsGenerated.push(id);
    
        return id;
    }

    highlightActiveLinks() {
        const tocItems = document.querySelectorAll('.doc-toc__item');
        const headings = [...document.querySelectorAll('#doc-content-body h2, h3, h4, h5, h6')];
        let currentHeading = null;
    
        // Find the current heading in view
        for (let i = 0; i < headings.length; i++) {
            const heading = headings[i];
            const bounding = heading.getBoundingClientRect();
    
            if (bounding.top <= window.innerHeight / 2 && bounding.bottom >= 0) {
                currentHeading = heading;
                break;  // Stop once we find the first heading in view
            }
        }
    
        if (currentHeading) {
            // Remove active class from all items
            tocItems.forEach(item => item.classList.remove('doc-toc__item--active'));
    
            // Find and highlight the corresponding TOC item
            tocItems.forEach(item => {
                const targetHeadingId = item.getAttribute('target-heading');
                if (targetHeadingId === currentHeading.id) {
                    item.classList.add('doc-toc__item--active');
    
                    // Highlight only parents of active subheadings
                    let parentItem = item.closest('.doc-toc__list')?.closest('.doc-toc__item');
                    while (parentItem) {
                        parentItem.classList.add('doc-toc__item--active');
                        parentItem = parentItem.closest('.doc-toc__list')?.closest('.doc-toc__item');
                    }
                }
            });
        }
    }
    
    trackScrolling() {
        // Bind highlightActiveLinks to scroll event
        window.addEventListener('scroll', () => {
            this.highlightActiveLinks();
        });
    
        // Initial call to set the highlight state on page load
        this.highlightActiveLinks();
    }                

}

// Initialize the TableContentsGenerator when the content is loaded
document.addEventListener('docly_content_loaded', () => {
    new TableContentsGenerator();
});
