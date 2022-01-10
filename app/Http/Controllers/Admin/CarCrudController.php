<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Model;
use App\Http\Requests\CarRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CarCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CarCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Car::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/car');
        CRUD::setEntityNameStrings('auto', 'autos');

        $this->crud->denyAccess('show');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->setColumns();

        $this->setFilters();
    }

    private function setColumns()
    {
        CRUD::addColumn([
            'name' => 'license_plate',
            'label' => 'Placa',
            'type' => 'text',
        ]);

        CRUD::addColumn([
            'name' => 'owners_uid',
            'label' => 'Cedula',
            'type' => 'text',
        ]);

        CRUD::addColumn([
            'name' => 'owners_name',
            'label' => 'Propietario',
            'type' => 'text',
        ]);

        CRUD::addColumn([
            'name' => 'model.brand.name',
            'label' => 'Marca',
            'type' => 'text',
            'orderable' => true,
            'orderLogic' => function ($query, $column, $columnDirection) {
                return $query->leftJoin('models', 'models.id', '=', 'cars.model_id')
                    ->leftJoin('brands', 'brands.id', '=', 'models.brand_id')
                    ->select('cars.*')
                    ->orderBy('brands.name', $columnDirection);
            },
        ]);

        CRUD::addColumn([
            'name' => 'model.name',
            'label' => 'Modelo',
            'type' => 'text',
            'orderable' => true,
            'orderLogic' => function ($query, $column, $columnDirection) {
                return $query->leftJoin('models', 'models.id', '=', 'cars.model_id')
                    ->select('cars.*')
                    ->orderBy('models.name', $columnDirection);
            },
        ]);

        CRUD::addColumn([
            'name' => 'city_string',
            'label' => 'Ciudad / Municipio',
            'type' => 'text',
        ]);
    }

    private function setFilters()
    {
        CRUD::addFilter(
            [
                'name' => 'brand',
                'label' => 'Marca',
                'type' => 'select2',
            ],
                function () {
                return Brand::orderBy('name')->get()->pluck('name', 'id')->toArray();
            },
                function ($value) {
                $this->crud->addClause('whereHas', 'model', function ($query) use ($value) {
                    return $query->where('brand_id', $value);
                });
            }
        );

        CRUD::addFilter(
            [
                'name' => 'model',
                'label' => 'Modelo',
                'type' => 'select2',
            ],
                function () {
                return Model::orderBy('name')->get()->pluck('name', 'id')->toArray();
            },
                function ($value) {
                $this->crud->addClause('where', 'model_id', $value);
            }
        );
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CarRequest::class);

        CRUD::field('created_at');
        CRUD::field('id');
        CRUD::field('license_plate');
        CRUD::field('model_id');
        CRUD::field('owners_name');
        CRUD::field('owners_uid');
        CRUD::field('updated_at');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
