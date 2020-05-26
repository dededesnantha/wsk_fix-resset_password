<?php
            
    Route::get('folder','protectController@handel');
    Route::get('apps','adminController@angular');    
            
        // sitemap
    Route::get('sitemap.xsl','SitemapsController@layout');
    Route::get('sitemap.xml','SitemapsController@home');
    Route::get('tour-sitemap.xml','SitemapsController@product');
    Route::get('page-sitemap.xml','SitemapsController@page');
    Route::get('category-sitemap.xml','SitemapsController@category');
    Route::get('blog-sitemap.xml','SitemapsController@blog');
    Route::get('tag-sitemap.xml','SitemapsController@tag');
    Route::get('blog-category-sitemap.xml','SitemapsController@blog_category');
    Route::get('amp_tour-sitemap.xml','SitemapsController@amp_product');
    Route::get('amp_page-sitemap.xml','SitemapsController@amp_page');
    Route::get('amp_category-sitemap.xml','SitemapsController@amp_category');
    Route::get('amp_blog-sitemap.xml','SitemapsController@amp_blog');
    Route::get('amp_tag-sitemap.xml','SitemapsController@amp_tag');
    Route::get('amp_blog-category-sitemap.xml','SitemapsController@amp_blog_category');    
