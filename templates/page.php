<?php 

$nav = new \Docly\DocNav;
$template = new \Docly\Template;

?>

<?php $template->render_header(); ?>

<main class="docly-main">
    <div class="docly-main__content">
        <?php $nav->render(); ?>
        <div id="doc-content">
            <div id="doc-content-heading"></div>
            <div id="doc-content-title"></div>
            <div id="doc-content-body"></div>   
        </div>
        <div id="doc-toc" class="doc-toc">
            <h2 class="doc-toc__heading">On this page</h2>
            <ul class="doc-toc__body doc-toc__list"></ul>
        </div>
    </div>
</main>

<template id="docly-search-modal">
    <div class="docly-modal">
        <div class="docly-modal__content">
            <div class="docly-search">
                <span class="docly-search__icon">
                    <svg class="docly-search-button__icon-svg" xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M229.66,218.34l-50.07-50.06a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.32ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z"></path></svg>
                </span>
                <input 
                    id="docly-search-input" 
                    class="docly-search__input" 
                    type="text" 
                    placeholder="Search docs..."
                    autocomplete="off"
                />
            </div>
            <div class="docly-search-results"></div>
        </div>
    </div>
</template>

<?php $template->render_footer(); ?>