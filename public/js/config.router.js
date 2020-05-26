'use strict';

/**
 * Config for the router
 */
angular.module('app')
    .run(
        [          '$rootScope', '$state', '$stateParams',
        function ($rootScope,   $state,   $stateParams) {
            $rootScope.$state = $state;
            $rootScope.$stateParams = $stateParams;                                                      
        }
        ]
    )
    .config(
        [          '$stateProvider', '$urlRouterProvider',
        function ($stateProvider,   $urlRouterProvider) {
            
            $urlRouterProvider
                .otherwise('/access/signin');
            $stateProvider
                .state('app', {
                    abstract: true,
                    url: '/app',
                    templateUrl: 'tpl/app.html',                  
                    resolve: {
                        deps: ['$ocLazyLoad',
                            function( $ocLazyLoad){
                            return $ocLazyLoad.load('toaster').then(
                                function(){
                                    return $ocLazyLoad.load('js/controllers/toaster.js');
                                }
                            );
                        }]
                    }
                })
                .state('app.dashboard', {
                    url: '/dashboard',
                    templateUrl: 'tpl/app_dashboard_v1.html',                  
                    authenticate: true,
                    resolve: {
                        deps: ['$ocLazyLoad',
                        function( $ocLazyLoad ){
                            return $ocLazyLoad.load(['js/controllers/dsh/dashboard.js']);
                        }]
                    } 
                })
                // kategori ajaran
                .state('app.ajaran', {
                    url: '/tahun',
                    template: '<div ui-view class="fade-in"></div>',
                    resolve: {
                        deps: ['$ocLazyLoad','uiLoad',
                            function($ocLazyLoad,uiLoad){
                            return uiLoad.load('js/controllers/dsh/tahun_ajaran.js');
                        }]                      
                    }
                }).state('app.ajaran.semua_ajaran', {
                    url: '/semua_tahun',
                    templateUrl: 'tpl/front/tahunAjaran/semua.html'
                }).state('app.ajaran.ajaran_baru', {
                    url: '/ajaran_baru',
                    templateUrl: 'tpl/front/tahunAjaran/baru.html',
                    resolve: {
                        deps: ['$ocLazyLoad',
                            function( $ocLazyLoad, ){
                            return $ocLazyLoad.load(['ui.tinymce']);
                        }]
                    }
                }).state('app.ajaran.ajaran_rubah', {
                    url: '/ajaran_rubah/:id',
                    templateUrl: 'tpl/front/tahunAjaran/rubah.html',
                    resolve: {
                        deps: ['$ocLazyLoad',
                            function( $ocLazyLoad ){                                               
                            return $ocLazyLoad.load(['ui.tinymce']);
                        }]
                    }
                }).state('app.ajaran.lihat_data', {
                    url: '/lihat_data/:id',
                    templateUrl: 'tpl/front/tahunAjaran/semua_mahasiswa.html'
                }).state('app.ajaran.mahasiswa_rubah', {
                    url: '/mahasiswa_rubah/:id',
                    templateUrl: 'tpl/front/tahunAjaran/rubah_mahasiswa.html',
                    resolve: {
                        deps: ['$ocLazyLoad',
                            function( $ocLazyLoad ){                                               
                            return $ocLazyLoad.load(['ui.tinymce']);
                        }]
                    }
                })


                //setting
                .state('app.setting', {
                    url: '/setting',
                    template: '<div ui-view class="fade-in"></div>',
                    resolve: {
                        deps: ['$ocLazyLoad','uiLoad',
                            function($ocLazyLoad,uiLoad){
                            return uiLoad.load('js/controllers/dsh/setting.js');
                        }]                      
                    }
                })
                .state('app.setting.nav', {
                    url: '/nav',
                    templateUrl: 'tpl/front/setting_navigasi.html'
                })
                //Template              
                .state('app.template', {
                    url: '/template',
                    templateUrl: 'tpl/front/setting/template.html',
                    authenticate: true,
                    resolve: {
                        deps: ['$ocLazyLoad',
                        function( $ocLazyLoad ){
                            return $ocLazyLoad.load(['js/controllers/dsh/dashboard.js','colorpicker.module','ngjsColorPicker']);
                        }]
                    } 
                })
                //Hidden Tools
                .state('app.hidden-tool', {
                    url: '/hidden-tool',
                    templateUrl: 'tpl/front/hidden-tool.html',
                    authenticate: true,
                    resolve: {
                    deps: ['$ocLazyLoad',
                        function( $ocLazyLoad ){
                        return $ocLazyLoad.load(['js/controllers/dsh/dashboard.js']);
                    }]
                    } 
                })
                //slider
                .state('app.setting.semua_slider', {
                    url: '/semua_slider',
                    templateUrl: 'tpl/front/setting/slider.html',
                    resolve: {
                        deps: ['$ocLazyLoad',
                            function( $ocLazyLoad){
                            return $ocLazyLoad.load('angularFileUpload');
                        }]
                    }
                })
                .state('app.setting.slider_rubah', {
                    url: '/slider_rubah/:id',
                    templateUrl: 'tpl/front/setting/slider_rubah.html'
                })
                //menu
                .state('app.setting.menu', {
                    url: '/menu',
                    templateUrl: 'tpl/front/setting/menu.html',
                })
                .state('app.setting.menu_tambahan', {
                    url: '/menu_tambahan',
                    templateUrl: 'tpl/front/setting/menu_tambahan.html',
                })
                .state('app.setting.footer', {
                    url: '/footer',
                    templateUrl: 'tpl/front/setting/footer.html',
                })
                //special_offer
                .state('app.setting.special_offer', {
                    url: '/special_offer',
                    templateUrl: 'tpl/front/setting/special_offer.html',
                })
                //Home_setting
                .state('app.setting.home_setting', {
                    url: '/home_setting',
                    templateUrl: 'tpl/front/setting/home_setting.html',
                })
                // admin
                .state('app.setting.admin', {
                    url: '/admin',
                    templateUrl: 'tpl/front/setting/admin.html'
                })
                .state('app.setting.admin_baru', {
                    url: '/admin_baru',
                    templateUrl: 'tpl/front/setting/admin_baru.html'
                })
                .state('app.setting.admin_rubah', {
                    url: '/admin_rubah/:id',
                    templateUrl: 'tpl/front/setting/admin_rubah.html'
                })
                     
                .state('app.setting.logo', {
                    url: '/logo',
                    templateUrl: 'tpl/front/setting/logo.html',                 
                })
                .state('app.setting.gambar', {
                    url: '/gambar',
                    templateUrl: 'tpl/front/setting/gambar.html',
                    resolve: {
                        deps: ['$ocLazyLoad',
                            function( $ocLazyLoad){
                            return $ocLazyLoad.load('ngImgCrop')
                        }]
                    }
                })
                     
                .state('access', {
                    url: '/access',
                    authenticate: true,
                    template: '<div ui-view class="fade-in-right-big smooth"></div>'
                })
                .state('access.signin', {
                    url: '/signin',
                    templateUrl: 'tpl/page_signin.html',                  
                    resolve: {
                        deps: ['uiLoad',
                            function( uiLoad ){
                            return uiLoad.load( ['js/controllers/signin.js'] );
                        }]
                    }
                })
        }
        ]
    );