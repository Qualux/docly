<?php
/**
 * Template Name: Documentation Page
 * Description: Docly doc page template.
 */
?>

<?php 

$nav = new \Docly\DocNav;

?>

<?php get_header(); ?>

<header class="docly-header">
    <div class="docly-logo">
        DOCLY
    </div>
    <div class="docly-search">
        <input type="text" id="docly-search-input" placeholder="Search docs..."/>
    </div>
    <div class="docly-buttons">
        <button>GITHUB</button>
    </div>
</header>

<main class="doc-main">
    <?php $nav->render(); ?>
    <div id="doc-content">
        <div id="doc-content-heading">DOC HEADING</div>
        <div id="doc-content-title">DOC TITLE</div>
        <div id="doc-content-body">DOC CONTENT</div>   
    </div>
    <div id="doc-content-menu" class="doc-content-menu">
        <div class="doc-content-menu__sticky">
            <h2 class="doc-content-menu__heading">On this page</h2>
            <ul class="doc-content-menu__body doc-content-menu__list"></ul>
        </div>
    </div>
</main>

<template id="docly-search-modal">
    <div class="docly-modal">
        <button id="docly-close-modal">Close</button>
        MODAL
    </div>
</template>

<?php get_footer(); ?>

<script>
    class DoclyModal {
        constructor() {
            this.searchInput = document.getElementById('docly-search-input');
            this.modalTemplate = document.getElementById('docly-search-modal').content.cloneNode(true);
            this.modal = this.modalTemplate.querySelector('.docly-modal');
            this.closeButton = this.modal.querySelector('#docly-close-modal');
            
            this.init();
        }

        init() {
            // Handle opening the modal
            this.searchInput.addEventListener('click', () => this.openModal());
            // Handle closing the modal
            this.closeButton.addEventListener('click', () => this.closeModal());
        }

        openModal() {
            document.body.appendChild(this.modal);
        }

        closeModal() {
            document.body.removeChild(this.modal);
        }
    }

    // Initialize the DoclyModal class
    document.addEventListener('DOMContentLoaded', () => {
        new DoclyModal();
    });
</script>
