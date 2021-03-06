<?php

namespace App\Core\Providers;

use App\Core\Models\Parser;
use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoriesServiceProvider.
 */
class RepositoriesServiceProvider extends ServiceProvider
{
    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $models = [
            'Media',
            'Folder',
            'Category',
            'User',
            'Roles',
            'Products',
            'Permission',
            'AttributeGroup',
            'AttributeGroupDescription',
            'NewsLetterList',
            'ProductReview',
            'Subscribers',
            'Campaign',
            'Mail',
            'Orders',
            'Banner',
            'Layout',
            'Promocode',
            'Returns',
            'StaticPages',
            'Cart',
            'Thread',
            'Message',
            'Participant',
            'Settings',
            'Menu',
            'MenuItems',
            'Currency',
            'Parser',
            'EmailLog',
            'EmailLogRecipients',
        ];

        foreach ($models as $repo) {
            $this->app->bind(
                "App\\Core\\Repositories\\{$repo}Repository",
                "App\\Core\\Repositories\\{$repo}RepositoryEloquent"
            );
        }
    }
}
