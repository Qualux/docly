<?php 

$nav = new \Docly\DocNav;
$template = new \Docly\Template;

?>

<?php $template->render_header(); ?>

<main class="docly-main">
    <?php $nav->render(); ?>
    <div id="doc-content">
        <div id="doc-content-heading"></div>
        <div id="doc-content-title"></div>
        <div id="doc-content-body"></div>   
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
        <div class="docly-modal__content">
            <div>
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