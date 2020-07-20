 <?php

    use Illuminate\Support\Facades\Route;

    Route::get('', 'FlightController@index')->name('flight.admin.index');
    Route::match(['get'], '/create', 'FlightController@create')->name('flight.admin.create');
    Route::match(['get'], '/edit/{id}', 'FlightController@edit')->name('flight.admin.edit');

    Route::post('/store/{id}', 'FlightController@store')->name('flight.admin.store');

    Route::get('/getForSelect2', 'FlightController@getForSelect2')->name('flight.admin.getForSelect2');
    Route::post('/bulkEdit', 'FlightController@bulkEdit')->name('flight.admin.bulkEdit');

    Route::match(['get'], '/category', 'CategoryController@index')->name('flight.admin.category.index');
    Route::match(['get'], '/category/edit/{id}', 'CategoryController@edit')->name('flight.admin.category.edit');
    Route::post('/category/store/{id}', 'CategoryController@store')->name('flight.admin.category.store');

    Route::match(['get'], '/attribute', 'AttributeController@index')->name('flight.admin.attribute.index');
    Route::match(['get'], '/attribute/edit/{id}', 'AttributeController@edit')->name('flight.admin.attribute.edit');
    Route::post('/attribute/store/{id}', 'AttributeController@store')->name('flight.admin.attribute.store');

    Route::match(['get'], '/attribute/term_edit', 'AttributeController@terms')->name('flight.admin.attribute.term.index');
    Route::match(['get'], '/attribute/term_edit/edit/{id}', 'AttributeController@term_edit')->name('flight.admin.attribute.term.edit');
    Route::post('/attribute/term_store/{id}', 'AttributeController@term_store')->name('flight.admin.attribute.term.store');


    Route::group(['prefix' => 'availability'], function () {
        Route::get('/', 'AvailabilityController@index')->name('flight.admin.availability.index');
        Route::get('/loadDates', 'AvailabilityController@loadDates')->name('flight.admin.availability.loadDates');
        Route::get('/store', 'AvailabilityController@store')->name('flight.admin.availability.store');
    });
