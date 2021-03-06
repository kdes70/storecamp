<?php

Auth::routes();

if (env('APP_ENV') !== 'testing') {
    $prefix = \LaravelLocalization::setLocale();
} else {
    $prefix = '/';
}

$this->group(['prefix' => $prefix, 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'checkBannedUser']], function (\Illuminate\Routing\Router $router) {
    /*
     * Client Site routes
     */
    $this->group(['prefix' => '/', 'as' => 'site::'], function (\Illuminate\Routing\Router $router) {
        $router->get('/', [
            'uses' => 'Site\IndexController@home',
        ]);

        $router->get('/searchQuery', [
            'uses' => 'Site\SearchController@search',
            'as'   => 'search',
        ]);

        $router->get('/home', [
            'uses' => 'Site\IndexController@home',
            'as'   => 'home',
        ]);

        $router->group(['prefix' => 'products', 'as' => 'products::'], function (\Illuminate\Routing\Router $router) {
            $router->get('index/{category?}', [
                'uses' => 'Site\ProductController@index',
                'as'   => 'index',
            ]);
            $router->get('show/{product}', [
                'uses' => 'Site\ProductController@show',
                'as'   => 'show',
            ]);
        });

        $router->group(['prefix' => 'cart', 'as' => 'cart::'], function (\Illuminate\Routing\Router $router) {
            $router->get('show', [
                'uses' => 'Site\CartController@show',
                'as'   => 'show',
            ]);

            $router->put('update/{cartId}', [
                'uses' => 'Site\CartController@update',
                'as'   => 'update',
            ]);

            $router->put('add/{cartId}', [
                'uses' => 'Site\CartController@add',
                'as'   => 'add',
            ]);

            $router->put('remove/{itemId}', [
                'uses' => 'Site\CartController@remove',
                'as'   => 'remove',
            ]);

            $router->delete('delete', [
                'uses' => 'Site\CartController@delete',
                'as'   => 'delete',
            ]);

            $router->get('checkout', [
                'uses' => 'Site\CartController@checkout',
                'as'   => 'checkout',
            ]);
        });

        $router->group(['prefix' => 'order', 'as' => 'order::'], function (\Illuminate\Routing\Router $router) {
            $router->get('index/{status?}', [
                'uses' => 'Site\OrdersController@index',
                'as'   => 'index',
            ]);

            $router->post('personal', [
                'uses' => 'Site\OrdersController@createPersonal',
                'as'   => 'personal',
            ]);

            $router->post('address', [
                'uses' => 'Site\OrdersController@createAddress',
                'as'   => 'address',
            ]);

            $router->post('shipment', [
                'uses' => 'Site\OrdersController@createShipping',
                'as'   => 'shipment',
            ]);

            $router->post('payment', [
                'uses' => 'Site\OrdersController@createPayment',
                'as'   => 'payment',
            ]);
        });

        /*
         * site payment callbacks
         */
        $router->get('callback/payment/{status}/{id}/{shoptoken}',
            ['as' => 'callback', 'uses' => 'Site\CallbackController@process']
        );
        $router->post('callback/payment/{status}/{id}/{shoptoken}',
            ['as' => 'callback', 'uses' => 'Site\CallbackController@process']
        );

        $router->get('like_dis/{class_name}/{object_id}',
            ['uses' => 'Site\TogglesController@likeDis', 'as' => 'like_dis'])
            ->where('object_id', '[0-9]+');

        $this->get('/language/{key}', [
            'as'   => 'toggleLanguage',
            'uses' => 'Site\TogglesController@toggleLanguage', ]);
    });

    $this->get('/htmlElements', [
        'uses' => 'Admin\AdminController@htmlElements',
        'as'   => 'htmlElements',
    ]);

    $this->group(['prefix' => 'admin', 'as' => 'admin::', 'middleware' => 'auth'], function () {
        $this->get('dashboard', [
            'uses' => 'Admin\AdminController@show',
            'as'   => 'dashboard', ]);
        $this->get('/', [
            'uses' => 'Admin\AdminController@show',
            'as'   => 'dashboard',
        ]);

        // users
        $this->group(['prefix' => 'users', 'as' => 'users::'], function () {
            $this->get('/', [
                'uses' => 'Admin\UsersController@index',
                'as'   => 'index',
            ]);
            $this->get('data', [
                'uses' => 'Admin\UsersController@data',
                'as'   => 'data',
            ]);
            $this->get('/show/{id}', [
                'uses' => 'Admin\UsersController@show',
                'as'   => 'show',
            ]);
            $this->get('/create', [
                'uses' => 'Admin\UsersController@create',
                'as'   => 'create',
            ]);
            $this->get('/edit/{id}', [
                'uses' => 'Admin\UsersController@edit',
                'as'   => 'edit',
            ]);

            $this->put('update/{id}', [
                'uses' => 'Admin\UsersController@update',
                'as'   => 'update',
            ])->middleware('shouldLeftAdmin');

            $this->delete('{id}', [
                'uses' => 'Admin\UsersController@destroy',
                'as'   => 'delete',
            ])->middleware('notAdmin');

            $this->post('store', [
                'uses' => 'Admin\UsersController@store',
                'as'   => 'store',
            ]);

            $this->get('/delete/{id}', [
                'uses' => 'Admin\UsersController@destroy',
                'as'   => 'get::delete',
            ])->middleware('notAdmin');
        });

        // media
        $this->group(['prefix' => 'media', 'as' => 'media::'], function () {
            $this->get('/index', [
                'uses' => 'Admin\MediaController@index',
                'as'   => 'indexs',
            ]);
            $this->get('/index/{disk}/{path?}', [
                'uses' => 'Admin\MediaController@index',
                'as'   => 'index',
            ]);

            $this->get('getIndex/{disk}/{path?}/', [
                'uses' => 'Admin\MediaController@getIndex',
                'as'   => 'get.index',
            ]);

            $this->post('file_linker/{disk}/{folder?}', [
                'uses' => 'Admin\MediaController@filesLinker',
                'as'   => 'file_linker',
            ]);

            $this->get('/getIndexFolders/{disk}/{folder?}', [
                'uses' => 'Admin\MediaController@getIndexFolders',
                'as'   => 'get.index.folders',
            ]);

            $this->get('download/{disk}/{id}/{folder}', [
                'uses' => 'Admin\MediaController@download',
                'as'   => 'download',
            ]);

            $this->post('/makeDirectory/{disk}', [
                'uses' => 'Admin\MediaController@makeFolder',
                'as'   => 'make.directory',
            ]);

            $this->post('/renameDirectory/{disk}', [
                'uses' => 'Admin\MediaController@renameFolder',
                'as'   => 'rename.directory',
            ])->middleware('folderLocked');

            $this->post('/renameFile/{disk}', [
                'uses' => 'Admin\MediaController@renameFile',
                'as'   => 'rename.file',
            ]);

            $this->delete('{id}', [
                'uses' => 'Admin\MediaController@destroy',
                'as'   => 'delete',
            ]);

            $this->post('upload/{disk}', [
                'uses' => 'Admin\MediaController@upload',
                'as'   => 'upload',
            ]);

            $this->get('delete/{id}', [
                'uses' => 'Admin\MediaController@destroy',
                'as'   => 'get.delete',
            ]);

            $this->get('delete/folder/{disk}/{folder}', [
                'uses' => 'Admin\MediaController@folderDestroy',
                'as'   => 'get.folder.delete',
            ])->middleware('folderLocked');
        });

        // roles
        $this->group(['prefix' => 'roles', 'as' => 'roles::'], function () {
            $this->get('/', [
                'uses' => 'Admin\RolesController@index',
                'as'   => 'index',
            ]);
            $this->get('data', [
                'uses' => 'Admin\RolesController@data',
                'as'   => 'data',
            ]);
            $this->get('create', [
                'uses' => 'Admin\RolesController@create',
                'as'   => 'create',

            ]);
            $this->get('edit/{id}', [
                'uses' => 'Admin\RolesController@edit',
                'as'   => 'edit',
            ]);
            $this->put('update/{id}', [
                'uses' => 'Admin\RolesController@update',
                'as'   => 'update',
            ])->middleware('notDefaultRole');

            $this->delete('{id}', [
                'uses' => 'Admin\RolesController@destroy',
                'as'   => 'delete',
            ])->middleware('notDefaultRole');

            $this->post('store', [
                'uses' => 'Admin\RolesController@store',
                'as'   => 'store',
            ]);

            $this->get('perms/json', [
                'uses' => 'Admin\RolesController@getPermsJson',
                'as'   => 'permissions::json',
            ]);

            $this->get('/delete/{id}', [
                'uses' => 'Admin\RolesController@destroy',
                'as'   => 'get::delete',
            ])->middleware('notDefaultRole');
        });

        // products
        $this->group(['prefix' => 'products', 'as' => 'products::'], function () {
            $this->get('/', [
                'uses' => 'Admin\ProductsController@index',
                'as'   => 'index',

            ]);
            $this->get('data', [
                'uses' => 'Admin\ProductsController@data',
                'as'   => 'data',
            ]);

            $this->get('show/{id}', [
                'uses' => 'Admin\ProductsController@show',
                'as'   => 'show',
            ]);

            $this->get('create', [
                'uses' => 'Admin\ProductsController@create',
                'as'   => 'create',

            ]);

            $this->get('edit/{id}', [
                'uses' => 'Admin\ProductsController@edit',
                'as'   => 'edit',
            ]);

            $this->put('update/{id}', [
                'uses' => 'Admin\ProductsController@update',
                'as'   => 'update',
            ]);

            $this->delete('{id}', [
                'uses' => 'Admin\ProductsController@destroy',
                'as'   => 'delete',
            ]);

            $this->post('store', [
                'uses' => 'Admin\ProductsController@store',
                'as'   => 'store',
            ]);

            $this->get('/delete/{id}', [
                'uses' => 'Admin\ProductsController@destroy',
                'as'   => 'get::delete',
            ]);
            $this->get('/select', [
                'uses' => 'Admin\ProductsController@getSelect',
                'as'   => 'get::select',
            ]);
        });

        //parsers
        $this->group(['prefix' => 'parsers', 'as' => 'parsers::'], function (\Illuminate\Routing\Router $router) {
            $router->get('index', [
                'uses' => 'Admin\ParsersControllerController@index',
                'as'   => 'index',
            ]);
            $router->get('show/{id}', [
                'uses' => 'Admin\ParsersControllerController@show',
                'as'   => 'show',
            ]);
            $router->put('parse/{id}', [
                'uses' => 'Admin\ParsersControllerController@parse',
                'as'   => 'parse',
            ]);
        });

        // reviews
        $this->group(['prefix' => 'reviews', 'as' => 'reviews::'], function () {
            $this->get('index',
                [
                    'uses' => 'Admin\ProductReviewController@index',
                    'as'   => 'index',
                ]);

            $this->get('data', [
                'uses' => 'Admin\ProductReviewController@data',
                'as'   => 'data',
            ]);

            $this->get('show/{id}',
                [
                    'uses' => 'Admin\ProductReviewController@show',
                    'as'   => 'show',
                ]);

            $this->get('delete/{id}', [
                'uses' => 'Admin\ProductReviewController@delete',
                'as'   => 'get.delete',
            ]);

            $this->put('reply/review/{id}', [
                'uses' => 'Admin\ProductReviewController@replyFeedback',
                'as'   => 'reply',
            ]);

            $this->delete('delete/review/{id}', [
                'uses' => 'Admin\ProductReviewController@delete',
                'as'   => 'destroy',
            ]);

            $this->get('create/{productId}', [
                'uses' => 'Admin\ProductReviewController@create',
                'as'   => 'create',
            ]);

            $this->get('edit/{productId}', [
                'uses' => 'Admin\ProductReviewController@edit',
                'as'   => 'edit',
            ]);

            $this->put('update/{productId}', [
                'uses' => 'Admin\ProductReviewController@update',
                'as'   => 'update',
            ]);

            $this->post('store/{productId}', [
                'uses' => 'Admin\ProductReviewController@store',
                'as'   => 'store',
            ]);

            $this->get('toggle_visibility/{id}', [
                'uses' => 'Admin\ProductReviewController@visibility',
                'as'   => 'visibility',
            ]);

            $this->get('markasread/reviews/{feed}', [
                'uses' => 'Admin\ProductReviewController@markAsRead',
                'as'   => 'markasread',
            ]);

            $this->post('editMessage/{messageId}', [
                'uses' => 'Admin\ProductReviewController@editMessage',
                'as'   => 'editMessage',
            ])->middleware('belongsToUserOrAdmin');

            $this->post('deleteMessage/{messageId}', [
                'uses' => 'Admin\ProductReviewController@deleteMessage',
                'as'   => 'deleteMessage',
            ])->middleware('belongsToUserOrAdmin');
        });

        // categories
        $this->group(['prefix' => 'categories', 'as' => 'categories::'], function () {
            $this->get('/', [
                'uses' => 'Admin\CategoriesController@index',
                'as'   => 'index',

            ]);

            $this->get('data', [
                'uses' => 'Admin\CategoriesController@data',
                'as'   => 'data',
            ]);

            $this->get('create', [
                'uses' => 'Admin\CategoriesController@create',
                'as'   => 'create',
            ]);

            $this->get('edit/{id}', [
                'uses' => 'Admin\CategoriesController@edit',
                'as'   => 'edit',
            ]);

            $this->put('update/{id}', [
                'uses' => 'Admin\CategoriesController@update',
                'as'   => 'update',
            ]);

            $this->delete('{id}', [
                'uses' => 'Admin\CategoriesController@destroy',
                'as'   => 'delete',
            ]);

            $this->get('/delete/{id}', [
                'uses' => 'Admin\CategoriesController@destroy',
                'as'   => 'get::delete',
            ]);

            $this->post('store', [
                'uses' => 'Admin\CategoriesController@store',
                'as'   => 'store',
            ]);

            $this->get('description/{id}', [
                'uses' => 'Admin\CategoriesController@getDescription',
                'as'   => 'description',
            ]);
        });

        // attribute groups
        $this->group(['prefix' => 'attribute_groups', 'as' => 'attribute_groups::'], function () {
            $this->get('/', [
                'uses' => 'Admin\AttributeGroupsController@index',
                'as'   => 'index',

            ]);
            $this->get('data', [
                'uses' => 'Admin\AttributeGroupsController@data',
                'as'   => 'data',
            ]);

            $this->get('create', [
                'uses' => 'Admin\AttributeGroupsController@create',
                'as'   => 'create',

            ]);

            $this->get('edit/{id}', [
                'uses' => 'Admin\AttributeGroupsController@edit',
                'as'   => 'edit',
            ]);

            $this->put('update/{id}', [
                'uses' => 'Admin\AttributeGroupsController@update',
                'as'   => 'update',
            ]);

            $this->delete('{id}', [
                'uses' => 'Admin\AttributeGroupsController@destroy',
                'as'   => 'delete',
            ]);

            $this->post('store', [
                'uses' => 'Admin\AttributeGroupsController@store',
                'as'   => 'store',
            ]);

            $this->get('/delete/{id}', [
                'uses' => 'Admin\AttributeGroupsController@destroy',
                'as'   => 'get::delete',
            ]);

            $this->get('/groups/json', [

                'uses' => 'Admin\AttributeGroupsController@getJson',
                'as'   => 'get::json',
            ]);
        });

        // attributes
        $this->group(['prefix' => 'attributes', 'as' => 'attributes::'], function () {
            $this->get('/', [
                'uses' => 'Admin\AttributesController@index',
                'as'   => 'index',

            ]);

            $this->get('data', [
                'uses' => 'Admin\AttributesController@data',
                'as'   => 'data',
            ]);

            $this->get('create', [
                'uses' => 'Admin\AttributesController@create',
                'as'   => 'create',
            ]);

            $this->get('edit/{id}', [
                'uses' => 'Admin\AttributesController@edit',
                'as'   => 'edit',
            ]);

            $this->put('update/{id}', [
                'uses' => 'Admin\AttributesController@update',
                'as'   => 'update',
            ]);

            $this->delete('{id}', [
                'uses' => 'Admin\AttributesController@destroy',
                'as'   => 'delete',
            ]);

            $this->post('store', [
                'uses' => 'Admin\AttributesController@store',
                'as'   => 'store',
            ]);

            $this->get('/delete/{id}', [
                'uses' => 'Admin\AttributesController@destroy',
                'as'   => 'get::delete',
            ]);

            $this->get('/attrs/json', [

                'uses' => 'Admin\AttributesController@getJson',
                'as'   => 'get::json',
            ]);
        });

        // subscribers
        $this->group(['prefix' => 'subscribers', 'as' => 'subscribers::'], function () {
            $this->get('/', ['uses' => 'Admin\SubscriptionController@index', 'as' => 'index']);

            $this->get('/show/{uid}',
                ['uses'  => 'Admin\SubscriptionController@show',
                    'as' => 'show',
                ]);

            $this->get('/show_user/{user}',
                ['uses'  => 'Admin\SubscriptionController@showUser',
                    'as' => 'showUser',
                ]);

            $this->get('/generate/{newsList_id}',
                [
                    'uses' => 'Admin\SubscriptionController@showGenerate',
                    'as'   => 'showGenerate',
                ]);

            $this->get('/tmp_mail/{file}',
                [
                    'uses' => 'Admin\SubscriptionController@getTmpMail',
                    'as'   => 'tmp_mail',
                ]);

            $this->get('/history_mail/{folder}/{filename}',
                [
                    'uses' => 'Admin\SubscriptionController@getHistoryTmpMail',
                    'as'   => 'history_mail',
                ]);

            $this->post('/generate/{uid}/{type}',
                [
                    'uses' => 'Admin\SubscriptionController@generate',
                    'as'   => 'generate',
                ]);
        });

        $this->group(['prefix' => 'search', 'as' => 'search::'], function () {
            $this->get('searchUser', [
                'as'         => 'searchUser',
                'uses'       => 'Admin\SearchController@searchUser',
                'middleware' => ['auth', 'role:Admin'],
            ]);
        });

        $this->group(['prefix' => 'mail', 'as' => 'mail::'], function () {
            $this->get('index', [
                'as'         => 'index',
                'uses'       => 'Admin\MailController@index',
                'middleware' => 'auth',
            ]);
            $this->get('create', [
                'as'         => 'create',
                'uses'       => 'Admin\MailController@create',
                'middleware' => 'auth',
            ]);

            $this->get('showFrame', [
                'as'         => 'showFrame',
                'uses'       => 'Admin\MailController@showFrame',
                'middleware' => 'auth',
            ]);
            $this->get('history', [
                'as'         => 'history',
                'uses'       => 'Admin\MailController@history',
                'middleware' => 'auth',
            ]);

            $this->post('save', [
                'as'         => 'save',
                'uses'       => 'Admin\MailController@save',
                'middleware' => 'auth',
            ]);

            $this->post('saveAndResend', [
                'as'         => 'saveAndResend',
                'uses'       => 'Admin\MailController@saveAndResend',
                'middleware' => 'auth',
            ]);

            $this->post('saveAsNew', [
                'as'         => 'saveAsNew',
                'uses'       => 'Admin\MailController@saveAsNew',
                'middleware' => 'auth',
            ]);
            $this->post('saveAsNewAndResend', [
                'as'         => 'saveAsNewAndResend',
                'uses'       => 'Admin\MailController@saveAsNewAndResend',
                'middleware' => 'auth',
            ]);
            $this->get('{id}', [
                'as'         => 'show',
                'uses'       => 'Admin\MailController@show',
                'middleware' => 'auth',
            ]);
            $this->delete('{id}', [
                'as'         => 'delete',
                'uses'       => 'Admin\MailController@destroy',
                'middleware' => 'auth',
            ]);
        });

        //campaign
        $this->group(['prefix' => 'campaign', 'as' => 'campaign::'], function () {
            $this->get('/', ['uses' => 'Admin\CampaignController@index', 'as' => 'index']);

            $this->get('/show/{uid}',
                ['uses'  => 'Admin\CampaignController@show',
                    'as' => 'show',
                ]);

            $this->get('/subscriber/{user}',
                ['uses'  => 'Admin\CampaignController@subscribers',
                    'as' => 'subscriber',
                ]);

            $this->get('/generate/{Campaign}',
                [
                    'uses' => 'Admin\CampaignController@show',
                    'as'   => 'show',
                ]);

            $this->get('/tmp_mail/{file}',
                [
                    'uses' => 'Admin\CampaignController@getTmpMail',
                    'as'   => 'tmp_mail',
                ]);

            $this->get('/history_mail/{folder}/{filename}',
                [
                    'uses' => 'Admin\CampaignController@getHistoryTmpMail',
                    'as'   => 'history_mail',
                ]);

            $this->post('/generate/{uid}/{type}',
                [
                    'uses' => 'Admin\CampaignController@generate',
                    'as'   => 'generate',
                ]);
            $this->get('/groups/json', [

                'uses' => 'Admin\CampaignController@getJson',
                'as'   => 'get::json',
            ]);
        });

        // design
        $this->group(['prefix' => 'design', 'as' => 'design::'], function () {
            $this->get('/index', ['uses' => 'Admin\DesignController@index', 'as' => 'index']);
            $this->group(['prefix' => 'pages', 'as' => 'pages::'], function () {
                $this->get('/', [
                    'uses' => 'Admin\PagesController@index',
                    'as'   => 'index',

                ]);

                $this->get('create', [
                    'uses' => 'Admin\PagesController@create',
                    'as'   => 'create',

                ]);

                $this->get('edit/{id}', [
                    'uses' => 'Admin\PagesController@edit',
                    'as'   => 'edit',
                ]);

                $this->put('update/{id}', [
                    'uses' => 'Admin\PagesController@update',
                    'as'   => 'update',
                ]);

                $this->delete('{id}', [
                    'uses' => 'Admin\PagesController@destroy',
                    'as'   => 'delete',
                ]);

                $this->post('store', [
                    'uses' => 'Admin\PagesController@store',
                    'as'   => 'store',
                ]);

                $this->get('/delete/{id}', [
                    'uses' => 'Admin\PagesController@destroy',
                    'as'   => 'get::delete',
                ]);

                $this->get('/pages/json', [

                    'uses' => 'Admin\PagesController@getJson',
                    'as'   => 'get::json',
                ]);
            });
            $this->group(['prefix' => 'banners', 'as' => 'banners::'], function () {
                $this->get('/', [
                    'uses' => 'Admin\BannerController@index',
                    'as'   => 'index',
                ]);
                $this->get('create', [
                    'uses' => 'Admin\BannerController@create',
                    'as'   => 'create',
                ]);
                $this->get('edit/{id}', [
                    'uses' => 'Admin\BannerController@edit',
                    'as'   => 'edit',
                ]);
                $this->put('update/{id}', [
                    'uses' => 'Admin\BannerController@update',
                    'as'   => 'update',
                ]);
                $this->delete('{id}', [
                    'uses' => 'Admin\BannerController@destroy',
                    'as'   => 'delete',
                ]);
                $this->post('store', [
                    'uses' => 'Admin\BannerController@store',
                    'as'   => 'store',
                ]);
                $this->get('/delete/{id}', [
                    'uses' => 'Admin\BannerController@destroy',
                    'as'   => 'get::delete',
                ]);
                $this->get('/banners/json', [
                    'uses' => 'Admin\BannerController@getJson',
                    'as'   => 'get::json',
                ]);
            });
            // Menu
            $this->group(['as' => 'menus::', 'prefix' => 'menus'], function () {
                $this->get('/', [
                    'uses' => 'Admin\MenuController@index', 'as' => 'index',
                ]);
                $this->get('data', [
                    'uses' => 'Admin\MenuController@data',
                    'as'   => 'data',
                ]);
                $this->get('/create', [
                    'uses' => 'Admin\MenuController@create',
                    'as'   => 'create',
                ]);
                $this->post('/store', [
                    'uses' => 'Admin\MenuController@store',
                    'as'   => 'store',
                ]);
                $this->get('/edit/{id}', [
                    'uses' => 'Admin\MenuController@edit',
                    'as'   => 'edit',
                ]);
                $this->put('/update/{id}', [
                    'uses' => 'Admin\MenuController@update',
                    'as'   => 'update',
                ]);
                $this->delete('/{id}', [
                    'uses' => 'Admin\MenuController@delete', 'as' => 'delete',
                ]);
                $this->group(['prefix' => '{menu}'], function () {
                    $this->get('builder', [
                        'uses' => 'Admin\MenuController@builder', 'as' => 'builder',
                    ]);
                    $this->post('order', [
                        'uses' => 'Admin\MenuController@order_item', 'as' => 'order',
                    ]);
                    $this->group(['as' => 'item::', 'prefix' => 'item'], function () {
                        $this->delete('{id}', [
                            'uses' => 'Admin\MenuController@delete_menu', 'as' => 'destroy',
                        ]);
                        $this->post('/', [
                            'uses' => 'Admin\MenuController@add_item', 'as' => 'add',
                        ]);
                        $this->put('/', [
                            'uses' => 'Admin\MenuController@update_item', 'as' => 'update',
                        ]);
                    });
                });
            });
        });

        // audits
        $this->group(['prefix' => 'audits', 'as' => 'audits::'], function () {
            $this->get('show/{model}/{id}',
                [
                    'uses' => 'Admin\AuditsController@show',
                    'as'   => 'show',
                ]);
        });
        // Sales
        $this->group(['prefix' => 'sales', 'as' => 'sales::'], function () {
            $this->group(['prefix' => 'orders', 'as' => 'orders::'], function () {
                $this->get('/', [
                    'uses' => 'Admin\OrdersController@index',
                    'as'   => 'index',
                ]);
            });
        });

        // Settings
        $this->group(['as' => 'settings::', 'prefix' => 'settings'], function (\Illuminate\Routing\Router $router) {
            $router->group(['as' => 'default::', 'prefix' => 'default'], function (\Illuminate\Routing\Router $router) {
                $router->get('/', [
                    'uses' => 'Admin\SettingsController@index', 'as' => 'index',
                ]);
                $this->get('data', [
                    'uses' => 'Admin\SettingsController@data',
                    'as'   => 'data',
                ]);
                $router->get('/create', [
                    'uses' => 'Admin\SettingsController@create',
                    'as'   => 'create',
                ]);
                $router->post('/', [
                    'uses' => 'Admin\SettingsController@store', 'as' => 'store',
                ]);
                $router->put('/{id}', [
                    'uses' => 'Admin\SettingsController@update', 'as' => 'update',
                ]);
                $router->delete('{id}', [
                    'uses' => 'Admin\SettingsController@delete', 'as' => 'delete',
                ]);
                $router->get('{id}/move_up', [
                    'uses' => 'Admin\SettingsController@move_up', 'as' => 'move_up',
                ]);
                $router->get('{id}/move_down', [
                    'uses' => 'Admin\SettingsController@move_down', 'as' => 'move_down',
                ]);
                $router->get('{id}/delete_value', [
                    'uses' => 'Admin\SettingsController@delete_value', 'as' => 'delete_value',
                ]);
            });
            $this->group(['as' => 'currency::', 'prefix' => 'currency'], function (\Illuminate\Routing\Router $router) {
                $router->get('/', [
                    'uses' => 'Admin\CurrenciesController@index', 'as' => 'index',
                ]);
                $this->get('data', [
                    'uses' => 'Admin\CurrenciesController@data',
                    'as'   => 'data',
                ]);
                $router->get('/create', [
                    'uses' => 'Admin\CurrenciesController@create',
                    'as'   => 'create',
                ]);
                $router->get('/edit/{id}', [
                    'uses' => 'Admin\CurrenciesController@edit',
                    'as'   => 'edit',
                ]);
                $router->post('/', [
                    'uses' => 'Admin\CurrenciesController@store', 'as' => 'store',
                ]);
                $router->put('/{id}', [
                    'uses' => 'Admin\CurrenciesController@update', 'as' => 'update',
                ]);
                $router->delete('{id}', [
                    'uses' => 'Admin\CurrenciesController@destroy', 'as' => 'delete',
                ]);
            });
        });

        // toggles
        $this->get('toggleBan/{class_name}/{object_id}',
            ['uses' => 'Admin\TogglesController@toggleBan', 'as' => 'toggleBan'])
            ->where('object_id', '[0-9]+');
    });

    $this->group(
        ['prefix' => '/admin/log-viewer'], function () {
            $this->get('/', [
            'as'   => 'log-viewer::dashboard',
            'uses' => 'Admin\LogViewerController@index',
        ]);
            $this->group(['prefix' => '/logs'], function () {
                $this->get('/', [
                'as'   => 'log-viewer::logs.list',
                'uses' => 'Admin\LogViewerController@listLogs',
            ]);
                $this->delete('delete', [
                'as'   => 'log-viewer::logs.delete',
                'uses' => 'Admin\LogViewerController@delete',
            ]);
            });

            $this->group(['prefix' => '/{date}'], function () {
                $this->get('/', [
                'as'   => 'log-viewer::logs.show',
                'uses' => 'Admin\LogViewerController@show',
            ]);

                $this->get('download', [
                'as'   => 'log-viewer::logs.download',
                'uses' => 'Admin\LogViewerController@download',
            ]);
                $this->get('{level}', [
                'as'   => 'log-viewer::logs.filter',
                'uses' => 'Admin\LogViewerController@showByLevel',
            ]);
            });
        });
});

\Route::group(['as' => 'mailbox.', 'prefix' => 'mailbox'], function () {
    \Route::post('notify', ['as' => 'notify', 'uses' => 'Webhooks\MailWebhookController@notify']);
});
