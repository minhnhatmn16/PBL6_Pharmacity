<?php

namespace App\Providers;

use App\Models\Import;
use App\Models\ImportDetail;
use App\Repositories\ImportDetailInterface;
use App\Repositories\ImportDetailRepository;
use App\Repositories\ImportInterface;
use App\Repositories\ImportRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductInterface;
use App\Repositories\ProductRepository;
use App\Repositories\ReceiverAddressInterface;
use App\Repositories\ReceiverAddressRepository;
use App\Repositories\SupplierInterface;
use App\Repositories\CategoryInterface;
use App\Repositories\UserInterface;
use App\Repositories\UserRepository;
use App\Repositories\AdminInterface;
use App\Repositories\AdminRepository;
use App\Repositories\BrandInterface;
use App\Repositories\BrandRepository;
use App\Repositories\SupplierRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\OrderInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\CartInterface;
use App\Repositories\CartRepository;
use App\Repositories\PaymentInterface;
use App\Repositories\PaymentRepository;
use App\Repositories\DeliveryInterface;
use App\Repositories\DeliveryMethodInterface;
use App\Repositories\DeliveryMethodRepository;
use App\Repositories\DeliveryRepository;
use App\Repositories\DiseaseInterface;
use App\Repositories\DiseaseRepository;
use App\Repositories\PaymentMethodInterface;
use App\Repositories\PaymentMethodRepository;
use App\Repositories\ReviewInterface;
use App\Repositories\ReviewRepository;
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(AdminInterface::class, AdminRepository::class);

        $this->app->bind(ReceiverAddressInterface::class, ReceiverAddressRepository::class);
        $this->app->bind(BrandInterface::class, BrandRepository::class);
        $this->app->bind(SupplierInterface::class, SupplierRepository::class);
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProductInterface::class, ProductRepository::class);
        $this->app->bind(ImportInterface::class,ImportRepository::class);
        $this->app->bind(ImportDetailInterface::class,ImportDetailRepository::class);
        $this->app->bind(OrderInterface::class, OrderRepository::class);
        $this->app->bind(CartInterface::class, CartRepository::class);
        $this->app->bind(DiseaseInterface::class, DiseaseRepository::class);
        $this->app->bind(PaymentInterface::class, PaymentRepository::class);
        $this->app->bind(DeliveryInterface::class, DeliveryRepository::class);
        $this->app->bind(PaymentMethodInterface::class, PaymentMethodRepository::class);
        $this->app->bind(DeliveryMethodInterface::class, DeliveryMethodRepository::class);
        $this->app->bind(ReviewInterface::class, ReviewRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
