<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\CitiesMangementController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\CustomersController;
use App\Http\Controllers\Admin\EquipmentsController;
use App\Http\Controllers\Admin\EquipmentCategoriesController;
use App\Http\Controllers\Admin\DocumentNamesController;
use App\Http\Controllers\Admin\EmployeeExpenseNamesController;
use App\Http\Controllers\Admin\EquipmentExpensesController;
use App\Http\Controllers\Admin\EmployeesController;
use App\Http\Controllers\Admin\FleetServicesController;
use App\Http\Controllers\Admin\FleetServiceNamesController;
use App\Http\Controllers\Admin\ExpiredDocumentsController;
use App\Http\Controllers\Admin\EmployeeExpenseController;
use App\Http\Controllers\Admin\OilController;
use App\Http\Controllers\Admin\OilCategoriesController;
use App\Http\Controllers\Admin\QuotationController;
use App\Http\Controllers\Admin\QuotationTermsController;
use App\Http\Controllers\Admin\RentTransactionsController;
use App\Http\Controllers\Admin\EquipmentInvoicesController;
use App\Http\Controllers\Admin\LposController;
use App\Http\Controllers\Admin\LpoItemNamesController;
use App\Http\Controllers\Admin\LpoTermsController;
use App\Http\Controllers\Admin\LowbedsController;
use App\Http\Controllers\Admin\LowbedTransactionsController;
use App\Http\Controllers\Admin\LowbedInvoicesController;
use App\Http\Controllers\Admin\CommonInvoicesController;
use App\Http\Controllers\Admin\EarningsController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

// Profile Routes
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::middleware(['auth'])->group(function () {
    
    Route::prefix('/dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/expired_docs_check', [DashboardController::class, 'expired_docs_check']);
    });

    Route::prefix('/manage-cities')->group(function () {
        Route::get('/', [CitiesMangementController::class, 'index'])->name('cities.view');
        Route::get('/add', [CitiesMangementController::class, 'create'])->name('cities.add');
        Route::post('/store', [CitiesMangementController::class, 'store'])->name('cities.store');
        Route::get('/edit/{id}', [CitiesMangementController::class, 'edit'])->name('cities.edit');
        Route::post('/update/{id}', [CitiesMangementController::class, 'update'])->name('cities.update');
        Route::get('/delete/{id}', [CitiesMangementController::class, 'delete'])->name('cities.delete');
    });

    Route::prefix('/manage-apps')->group(function () {
        Route::get('/', [CitiesMangementController::class, 'index'])->name('apps.view');
        Route::get('/add', [CitiesMangementController::class, 'create'])->name('apps.add');
        Route::post('/store', [CitiesMangementController::class, 'store'])->name('apps.store');
        Route::get('/edit/{id}', [CitiesMangementController::class, 'edit'])->name('apps.edit');
        Route::post('/update/{id}', [CitiesMangementController::class, 'update'])->name('apps.update');
        Route::get('/delete/{id}', [CitiesMangementController::class, 'delete'])->name('apps.delete');
    });

    Route::prefix('/drivers')->group(function () {
        Route::get('/', [EmployeesController::class, 'index'])->name('drivers.view');
        Route::get('/add', [EmployeesController::class, 'create'])->name('drivers.add');
        Route::post('/store', [EmployeesController::class, 'store'])->name('drivers.store');
        Route::get('/edit/{id}', [EmployeesController::class, 'edit'])->name('drivers.edit');
        Route::post('/update/{id}', [EmployeesController::class, 'update'])->name('drivers.update');
        Route::get('/delete/{id}', [EmployeesController::class, 'delete'])->name('drivers.delete');

        // Route::get('/expense/view', [EmployeeExpenseController::class, 'index'])->name('drivers.expense.view');
        // Route::get('/expense/add', [EmployeeExpenseController::class, 'create'])->name('drivers.expense.add');
        // Route::post('/expense/store', [EmployeeExpenseController::class, 'store'])->name('drivers.expense.store');
        // Route::get('/expense/edit/{id}', [EmployeeExpenseController::class, 'edit'])->name('drivers.expense.edit');
        // Route::post('/expense/update/{id}', [EmployeeExpenseController::class, 'update'])->name('drivers.expense.update');
        // Route::get('/expense/delete/{id}', [EmployeeExpenseController::class, 'delete'])->name('drivers.expense.delete');

        // Route::get('/names', [EmployeeExpenseNamesController::class, 'index'])->name('employee_expense_names.view');
        // Route::get('/names/add', [EmployeeExpenseNamesController::class, 'create'])->name('employee_expense_names.add');
        // Route::post('/names/store', [EmployeeExpenseNamesController::class, 'store'])->name('employee_expense_names.store');
        // Route::get('/names/edit/{id}', [EmployeeExpenseNamesController::class, 'edit'])->name('employee_expense_names.edit');
        // Route::post('/names/update/{id}', [EmployeeExpenseNamesController::class, 'update'])->name('employee_expense_names.update');
        // Route::get('/names/delete/{id}', [EmployeeExpenseNamesController::class, 'delete'])->name('employee_expense_names.delete');
    });

    Route::prefix('/companies')->group(function () {
        Route::get('/', [DashboardController::class, 'company_index'])->name('companies.view');
        Route::get('/edit/{id}', [DashboardController::class, 'company_edit'])->name('companies.edit');
        Route::post('/update/{id}', [DashboardController::class, 'company_update'])->name('companies.update');
    });

    Route::prefix('/profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile.view');
        Route::post('/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/change-password', [ProfileController::class, 'change_pass'])->name('profile.change_pass');
        Route::post('/update-password', [ProfileController::class, 'update_pass'])->name('profile.update_pass');
    });

    Route::prefix('/rent-transactions')->group(function () {
        Route::get('/', [RentTransactionsController::class, 'index'])->name('rent_transactions.view');
        Route::get('/pending', [RentTransactionsController::class, 'view_pending'])->name('rent_transactions.view.pending');
        Route::get('/completed', [RentTransactionsController::class, 'view_completed'])->name('rent_transactions.view.completed');
        Route::get('/add', [RentTransactionsController::class, 'create'])->name('rent_transactions.add');
        Route::post('/store', [RentTransactionsController::class, 'store'])->name('rent_transactions.store');
        Route::get('/edit/{id}', [RentTransactionsController::class, 'edit'])->name('rent_transactions.edit');
        Route::post('/update/{id}', [RentTransactionsController::class, 'update'])->name('rent_transactions.update');
        Route::get('/delete/{id}', [RentTransactionsController::class, 'delete'])->name('rent_transactions.delete');
        Route::post('/receive-equipments/{id}', [RentTransactionsController::class, 'receive_equipments'])->name('rent_transactions.receive_equipments');
    });

    Route::prefix('/invoices')->group(function () {
        Route::get('/all', [EquipmentInvoicesController::class, 'index'])->name('equip_invoices.view_all');
        Route::get('/{id}', [EquipmentInvoicesController::class, 'view_one'])->name('equip_invoices.view');
        Route::get('/create/{id}', [EquipmentInvoicesController::class, 'create'])->name('equip_invoices.create');
        Route::post('/store/{id}', [EquipmentInvoicesController::class, 'store'])->name('equip_invoices.store');
        Route::get('/edit/{id}', [EquipmentInvoicesController::class, 'edit'])->name('equip_invoices.edit');
        Route::post('/update/{id}', [EquipmentInvoicesController::class, 'update'])->name('equip_invoices.update');
        Route::get('/view/{id}', [EquipmentInvoicesController::class, 'view'])->name('equip_invoices.view_single');
        Route::get('/print/{id}', [EquipmentInvoicesController::class, 'print'])->name('equip_invoices.print');
        Route::get('/pdf/{id}', [EquipmentInvoicesController::class, 'pdf'])->name('equip_invoices.pdf');
    });

    Route::prefix('/lowbed-invoices')->group(function () {
        Route::get('/', [LowbedInvoicesController::class, 'index'])->name('lowbed_invoices.view');
        Route::get('/add/{id}', [LowbedInvoicesController::class, 'create'])->name('lowbed_invoices.add');
        Route::post('/store/{id}', [LowbedInvoicesController::class, 'store'])->name('lowbed_invoices.store');
        Route::get('/edit/{id}', [LowbedInvoicesController::class, 'edit'])->name('lowbed_invoices.edit');
        Route::post('/update/{id}', [LowbedInvoicesController::class, 'update'])->name('lowbed_invoices.update');
        Route::get('/print/{id}', [LowbedInvoicesController::class, 'print'])->name('lowbed_invoices.print');
        Route::get('/pdf/{id}', [LowbedInvoicesController::class, 'pdf'])->name('lowbed_invoices.pdf');
    });

    Route::prefix('/common-invoices')->group(function () {
        Route::get('/', [CommonInvoicesController::class, 'index'])->name('common_invoices.view');
        Route::get('/add', [CommonInvoicesController::class, 'create'])->name('common_invoices.add');
        Route::post('/store', [CommonInvoicesController::class, 'store'])->name('common_invoices.store');
        Route::get('/edit/{id}', [CommonInvoicesController::class, 'edit'])->name('common_invoices.edit');
        Route::post('/update/{id}', [CommonInvoicesController::class, 'update'])->name('common_invoices.update');
        Route::get('/print/{id}', [CommonInvoicesController::class, 'print'])->name('common_invoices.print');
        Route::get('/pdf/{id}', [CommonInvoicesController::class, 'pdf'])->name('common_invoices.pdf');
    });
    
    Route::prefix('/users')->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name('users.view');
        Route::get('/add', [UsersController::class, 'create'])->name('users.add');
        Route::post('/store', [UsersController::class, 'store'])->name('users.store');
        Route::get('/delete/{id}', [UsersController::class, 'delete'])->name('users.delete');
    });

    Route::prefix('/customers')->group(function () {
        Route::get('/', [CustomersController::class, 'index'])->name('customers.view');
        Route::get('/add', [CustomersController::class, 'create'])->name('customers.add');
        Route::post('/store', [CustomersController::class, 'store'])->name('customers.store');
        Route::get('/edit/{id}', [CustomersController::class, 'edit'])->name('customers.edit');
        Route::post('/update/{id}', [CustomersController::class, 'update'])->name('customers.update');
        Route::get('/delete/{id}', [CustomersController::class, 'delete'])->name('customers.delete');
    });

    Route::prefix('/equipments')->group(function () {
        Route::get('/', [EquipmentsController::class, 'index'])->name('equipments.view');
        Route::get('/add', [EquipmentsController::class, 'create'])->name('equipments.add');
        Route::post('/store', [EquipmentsController::class, 'store'])->name('equipments.store');
        Route::get('/edit/{id}', [EquipmentsController::class, 'edit'])->name('equipments.edit');
        Route::post('/update/{id}', [EquipmentsController::class, 'update'])->name('equipments.update');
        Route::get('/delete/{id}', [EquipmentsController::class, 'delete'])->name('equipments.delete');
        Route::get('/status', [EquipmentsController::class, 'status'])->name('equipments.status');
        Route::get('/status/{year}/{month}', [EquipmentsController::class, 'status_filter'])->name('equipments.status_filter');

        Route::get('categories/', [EquipmentCategoriesController::class, 'index'])->name('equipment_categories.view');
        Route::get('categories/add', [EquipmentCategoriesController::class, 'create'])->name('equipment_categories.add');
        Route::post('categories/store', [EquipmentCategoriesController::class, 'store'])->name('equipment_categories.store');
        Route::get('categories/edit/{id}', [EquipmentCategoriesController::class, 'edit'])->name('equipment_categories.edit');
        Route::post('categories/update/{id}', [EquipmentCategoriesController::class, 'update'])->name('equipment_categories.update');
        Route::get('categories/delete/{id}', [EquipmentCategoriesController::class, 'delete'])->name('equipment_categories.delete');
    });

    Route::prefix('/lowbeds')->group(function () {
        Route::get('/', [LowbedsController::class, 'index'])->name('lowbeds.view');
        Route::get('/add', [LowbedsController::class, 'create'])->name('lowbeds.add');
        Route::post('/store', [LowbedsController::class, 'store'])->name('lowbeds.store');
        Route::get('/edit/{id}', [LowbedsController::class, 'edit'])->name('lowbeds.edit');
        Route::post('/update/{id}', [LowbedsController::class, 'update'])->name('lowbeds.update');
        Route::get('/delete/{id}', [LowbedsController::class, 'delete'])->name('lowbeds.delete');
        Route::get('/status', [LowbedsController::class, 'status'])->name('lowbeds.status');
        Route::get('/status/{year}/{month}', [LowbedsController::class, 'status_filter'])->name('lowbeds.status_filter');
    });

    Route::prefix('/lowbed-transactions')->group(function () {
        Route::get('/', [LowbedTransactionsController::class, 'index'])->name('lowbed_transactions.view');
        Route::get('/completed', [LowbedTransactionsController::class, 'view_completed'])->name('lowbed_transactions.view_completed');
        Route::get('/add', [LowbedTransactionsController::class, 'create'])->name('lowbed_transactions.add');
        Route::post('/store', [LowbedTransactionsController::class, 'store'])->name('lowbed_transactions.store');
        Route::get('/edit/{id}', [LowbedTransactionsController::class, 'edit'])->name('lowbed_transactions.edit');
        Route::post('/update/{id}', [LowbedTransactionsController::class, 'update'])->name('lowbed_transactions.update');
        Route::get('/delete/{id}', [LowbedTransactionsController::class, 'delete'])->name('lowbed_transactions.delete');
    });

    Route::prefix('/employees')->group(function () {
        Route::get('/', [EmployeesController::class, 'index'])->name('employees.view');
        Route::get('/add', [EmployeesController::class, 'create'])->name('employees.add');
        Route::post('/store', [EmployeesController::class, 'store'])->name('employees.store');
        Route::get('/edit/{id}', [EmployeesController::class, 'edit'])->name('employees.edit');
        Route::post('/update/{id}', [EmployeesController::class, 'update'])->name('employees.update');
        Route::get('/delete/{id}', [EmployeesController::class, 'delete'])->name('employees.delete');

        Route::get('/expense/view', [EmployeeExpenseController::class, 'index'])->name('employees.expense.view');
        Route::get('/expense/add', [EmployeeExpenseController::class, 'create'])->name('employees.expense.add');
        Route::post('/expense/store', [EmployeeExpenseController::class, 'store'])->name('employees.expense.store');
        Route::get('/expense/edit/{id}', [EmployeeExpenseController::class, 'edit'])->name('employees.expense.edit');
        Route::post('/expense/update/{id}', [EmployeeExpenseController::class, 'update'])->name('employees.expense.update');
        Route::get('/expense/delete/{id}', [EmployeeExpenseController::class, 'delete'])->name('employees.expense.delete');

        Route::get('/names', [EmployeeExpenseNamesController::class, 'index'])->name('employee_expense_names.view');
        Route::get('/names/add', [EmployeeExpenseNamesController::class, 'create'])->name('employee_expense_names.add');
        Route::post('/names/store', [EmployeeExpenseNamesController::class, 'store'])->name('employee_expense_names.store');
        Route::get('/names/edit/{id}', [EmployeeExpenseNamesController::class, 'edit'])->name('employee_expense_names.edit');
        Route::post('/names/update/{id}', [EmployeeExpenseNamesController::class, 'update'])->name('employee_expense_names.update');
        Route::get('/names/delete/{id}', [EmployeeExpenseNamesController::class, 'delete'])->name('employee_expense_names.delete');
    });

    Route::prefix('/fleet-services')->group(function () {
        Route::get('/', [FleetServicesController::class, 'index'])->name('fleet_services.view');
        Route::get('/add', [FleetServicesController::class, 'create'])->name('fleet_services.add');
        Route::post('/store', [FleetServicesController::class, 'store'])->name('fleet_services.store');
        Route::get('/edit/{id}', [FleetServicesController::class, 'edit'])->name('fleet_services.edit');
        Route::post('/update/{id}', [FleetServicesController::class, 'update'])->name('fleet_services.update');
        Route::get('/delete/{id}', [FleetServicesController::class, 'delete'])->name('fleet_services.delete');
        
        Route::get('/names', [FleetServiceNamesController::class, 'index'])->name('fleet_service_names.view');
        Route::get('/names/add', [FleetServiceNamesController::class, 'create'])->name('fleet_service_names.add');
        Route::post('/names/store', [FleetServiceNamesController::class, 'store'])->name('fleet_service_names.store');
        Route::get('/names/edit/{id}', [FleetServiceNamesController::class, 'edit'])->name('fleet_service_names.edit');
        Route::post('/names/update/{id}', [FleetServiceNamesController::class, 'update'])->name('fleet_service_names.update');
        Route::get('/names/delete/{id}', [FleetServiceNamesController::class, 'delete'])->name('fleet_service_names.delete');
    });

    Route::prefix('/expired-documents')->group(function () {
        Route::get('/equipments', [ExpiredDocumentsController::class, 'equipments'])->name('expired_documents.equipments');
        Route::get('/equipments-renew/{id}', [ExpiredDocumentsController::class, 'equipment_doc_renew'])->name('expired_documents.equipment.renew');
        Route::post('/equipments-renew/store/{id}', [ExpiredDocumentsController::class, 'equipment_doc_renew_store'])->name('expired_documents.equipment.renew_store');
        
        Route::get('/employees', [ExpiredDocumentsController::class, 'employees'])->name('expired_documents.employees');
        Route::get('/employee-renew/{id}', [ExpiredDocumentsController::class, 'employee_doc_renew'])->name('expired_documents.employee.renew');
        Route::post('/employee-renew/store/{id}', [ExpiredDocumentsController::class, 'employee_doc_renew_store'])->name('expired_documents.employee.renew_store');
    });

    Route::prefix('/oil')->group(function () {
        Route::get('/view', [OilController::class, 'index'])->name('oil.view');
        Route::get('/add', [OilController::class, 'create'])->name('oil.add');
        Route::post('/store', [OilController::class, 'store'])->name('oil.store');
        Route::get('/edit/{id}', [OilController::class, 'edit'])->name('oil.edit');
        Route::post('/update/{id}', [OilController::class, 'update'])->name('oil.update');
        Route::get('/delete/{id}', [OilController::class, 'delete'])->name('oil.delete');

        Route::get('categories/', [OilCategoriesController::class, 'index'])->name('oil_categories.view');
        Route::get('categories/add', [OilCategoriesController::class, 'create'])->name('oil_categories.add');
        Route::post('categories/store', [OilCategoriesController::class, 'store'])->name('oil_categories.store');
        Route::get('categories/edit/{id}', [OilCategoriesController::class, 'edit'])->name('oil_categories.edit');
        Route::post('categories/update/{id}', [OilCategoriesController::class, 'update'])->name('oil_categories.update');
        Route::get('categories/delete/{id}', [OilCategoriesController::class, 'delete'])->name('oil_categories.delete');
    });

    Route::prefix('/quotations')->group(function () {
        Route::get('/', [QuotationController::class, 'index'])->name('quotations.view');
        Route::get('/add', [QuotationController::class, 'create'])->name('quotations.add');
        Route::post('/store', [QuotationController::class, 'store'])->name('quotations.store');
        Route::get('/edit/{id}', [QuotationController::class, 'edit'])->name('quotations.edit');
        Route::post('/update/{id}', [QuotationController::class, 'update'])->name('quotations.update');
        Route::get('/delete/{id}', [QuotationController::class, 'delete'])->name('quotations.delete');
        Route::get('/view/{id}', [QuotationController::class, 'view'])->name('quotations.single.view');
        Route::get('/print/{id}', [QuotationController::class, 'print'])->name('quotations.print');
        Route::get('/pdf/{id}', [QuotationController::class, 'pdf'])->name('quotations.pdf');

        Route::get('terms/', [QuotationTermsController::class, 'index'])->name('quotation_terms.view');
        Route::get('terms/add', [QuotationTermsController::class, 'create'])->name('quotation_terms.add');
        Route::post('terms/store', [QuotationTermsController::class, 'store'])->name('quotation_terms.store');
        Route::get('terms/edit/{id}', [QuotationTermsController::class, 'edit'])->name('quotation_terms.edit');
        Route::post('terms/update/{id}', [QuotationTermsController::class, 'update'])->name('quotation_terms.update');
        Route::get('terms/delete/{id}', [QuotationTermsController::class, 'delete'])->name('quotation_terms.delete');
    });

    Route::prefix('/lpos')->group(function () {
        Route::get('/', [LposController::class, 'index'])->name('lpos.view');
        Route::get('/add', [LposController::class, 'create'])->name('lpos.add');
        Route::post('/store', [LposController::class, 'store'])->name('lpos.store');
        Route::get('/edit/{id}', [LposController::class, 'edit'])->name('lpos.edit');
        Route::post('/update/{id}', [LposController::class, 'update'])->name('lpos.update');
        Route::get('/delete/{id}', [LposController::class, 'delete'])->name('lpos.delete');
        Route::get('/view/{id}', [LposController::class, 'show'])->name('lpos.single.view');
        Route::get('/print/{id}', [LposController::class, 'print'])->name('lpos.print');
        Route::get('/pdf/{id}', [LposController::class, 'pdf'])->name('lpos.pdf');

        Route::get('/items', [LpoItemNamesController::class, 'index'])->name('lpo_item_names.view');
        Route::get('item/add', [LpoItemNamesController::class, 'create'])->name('lpo_item_names.add');
        Route::post('item/store', [LpoItemNamesController::class, 'store'])->name('lpo_item_names.store');
        Route::get('item/edit/{id}', [LpoItemNamesController::class, 'edit'])->name('lpo_item_names.edit');
        Route::post('item/update/{id}', [LpoItemNamesController::class, 'update'])->name('lpo_item_names.update');
        Route::get('item/delete/{id}', [LpoItemNamesController::class, 'delete'])->name('lpo_item_names.delete');

        Route::get('/terms', [LpoTermsController::class, 'index'])->name('lpo_terms.view');
        Route::get('term/add', [LpoTermsController::class, 'create'])->name('lpo_terms.add');
        Route::post('term/store', [LpoTermsController::class, 'store'])->name('lpo_terms.store');
        Route::get('term/edit/{id}', [LpoTermsController::class, 'edit'])->name('lpo_terms.edit');
        Route::post('term/update/{id}', [LpoTermsController::class, 'update'])->name('lpo_terms.update');
        Route::get('term/delete/{id}', [LpoTermsController::class, 'delete'])->name('lpo_terms.delete');

    });

    Route::prefix('/earnings')->group(function () {
        Route::get('/equipments', [EarningsController::class, 'equipment_earning'])->name('earnings.equipment');
        Route::get('/equipments/invoices/{id}', [EarningsController::class, 'equipment_view_invoices'])->name('earnings.equipment.view_invoice');
        
        Route::get('/customers', [EarningsController::class, 'customer_earning'])->name('earnings.customer');
        Route::get('/customer/invoices/{id}', [EarningsController::class, 'customer_view_invoices'])->name('earnings.customer.view_invoice');
    });

});



require __DIR__.'/auth.php';