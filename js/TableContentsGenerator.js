class TableContentsGenerator {
    constructor() {
        this.initialize();
    }

    initialize() {
        const contentBody = document.querySelector('#doc-content-body');
        if (contentBody) {

            const headingsTree = this.parseHeadings(contentBody);

            const tocEl = document.querySelector('.doc-toc');

            if( headingsTree.length > 0 ) {
                this.renderContextMenu(headingsTree);
                if( tocEl ) {
                    tocEl.style.display = 'block';
                }
            } else {
                if( tocEl ) {
                    tocEl.style.display = 'none';
                } 
            }
            
        }
    }

    // Parse the content and create a tree structure for headings
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
                // Push h2 directly into the root tree
                tree.push(node);
                currentLevel = node;
            } else {
                // For h3 and deeper, find the correct parent
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

    // Render the tree structure into a context menu
    renderContextMenu(tree) {
        const contextMenu = document.querySelector('.doc-toc__body');
        contextMenu.innerHTML = ''; // Clear existing content

        const createMenuItem = (node) => {
            const listItem = document.createElement('li');
            listItem.textContent = node.text;
            listItem.classList.add('doc-toc__item');

            if (node.children.length > 0) {
                const subMenu = document.createElement('ul');
                subMenu.classList.add('doc-toc__list');
                node.children.forEach(childNode => {
                    subMenu.appendChild(createMenuItem(childNode));
                });
                listItem.appendChild(subMenu);
            }

            // Scroll to the heading on click
            listItem.addEventListener('click', () => {
                node.element.scrollIntoView({ behavior: 'smooth' });
            });

            return listItem;
        };

        tree.forEach(node => {
            contextMenu.appendChild(createMenuItem(node));
        });
    }
}

// Initialize the DocMenuGenerator when the content is loaded
document.addEventListener('docly_content_loaded', () => {
    new TableContentsGenerator();
});
