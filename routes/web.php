<?php

use App\Http\Controllers\ApprovementController;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Backend\BranchController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Customer\CustomerBranchController;
use App\Http\Controllers\Inventory\ProductController;
use App\Http\Controllers\Marketing\ProjectController;
use App\Http\Controllers\Marketing\TaskController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\PersonaliaController;
use App\Http\Controllers\ExportsController;
use App\Http\Controllers\Finance\PaymentController;
use App\Http\Controllers\Marketing\StatController;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\Sales\SalesOrderController;
use App\Http\Controllers\Sales\SalesOrderItemController;
use App\Http\Controllers\Transaction\ItemQuotationController;
use App\Http\Controllers\Transaction\QuotationController;
use App\Http\Controllers\UserManagement\TeamController;
use App\Http\Controllers\UserManagement\UserController;
use Illuminate\Support\Facades\Route;

Route::fallback(function () { return abort(404);});
Route::get     ('login', [AuthenticationController::class, 'login'])->name('login')->middleware('guest');
Route::post    ('authenticate', [AuthenticationController::class, 'authenticate'])->name('authenticate');
//Top Model Priority
Route::middleware(['auth', 'check_user_status'])->group(function () {
    Route::get     ('/', [Controller::class, 'dashboard'])->name('index');
    Route::resource('branch', BranchController::class);
    Route::resource('payment', PaymentController::class);
    Route::resource('user', UserController::class);
    Route::get     ('user/{user}/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::put     ('user/{user}/deativate', [UserController::class, 'deactivate'])->name('user.deactivate');
    Route::put     ('user/{user}/activate', [UserController::class, 'activate'])->name('user.activate');
    Route::put     ('user/{user}/image-profile', [UserController::class, 'image'])->name('user.image');
    Route::get     ('team', TeamController::class)->name('team.index');
    Route::resource('role', RoleController::class);
    Route::post    ('role/{role}/give-permission-to', [RoleController::class, 'permission'])->name('role.permission');
    Route::resource('permission', PermissionController::class);
    Route::resource('product', ProductController::class);
    Route::resource('customer', CustomerController::class);
    Route::get     ('customer/{customer}/detail', [CustomerController::class, 'detail'])->name('customer.detail');
    Route::get     ('customer/{customer}/personalia', [CustomerController::class, 'personalia'])->name('customer.personalia');
    Route::get     ('customer/{customer}/branch', [CustomerController::class, 'branch'])->name('customer.branch');
    Route::resource('personalia', PersonaliaController::class, ['parameters' => ['personalia' => 'personalia']]);
    Route::resource('customer-branch', CustomerBranchController::class);
    Route::get     ('project/card', [ProjectController::class, 'card'])->name('project.card');
    Route::resource('project', ProjectController::class);
    Route::get     ('project/{project}/task', [ProjectController::class, 'task'])->name('project.task');
    Route::get     ('loss-project', [ProjectController::class, 'lossProject'])->name('project.loss');
    Route::post    ('loss-project', [ProjectController::class, 'submitLossProject'])->name('project.loss.submit');
    Route::resource('task', TaskController::class);
    Route::put     ('task/{project}/{task}/checked', [TaskController::class, 'checked'])->name('task.checked');
    Route::get     ('task/{project}/completed', [TaskController::class, 'completed'])->name('task.completed');
    Route::resource('quotation', QuotationController::class);
    Route::get     ('quotation/{quotation}/document', [QuotationController::class, 'document'])->name('quotation.document');
    Route::put     ('quotation/{quotation}/status', [QuotationController::class, 'status'])->name('quotation.status');
    Route::resource('quotation-item', ItemQuotationController::class);
    Route::get     ('approvement/quotation', [ApprovementController::class, 'quotation'])->name('approvement.quotation');
    Route::put     ('approvement/{quotation}/approved', [ApprovementController::class, 'approved'])->name('approvement.quotation.approve');
    Route::put     ('approvement/{quotation}/reject', [ApprovementController::class, 'reject'])->name('approvement.quotation.reject');
    Route::get     ('sales-order/bill', [SalesOrderController::class, 'bill'])->name('sales-order.bill');
    Route::put     ('sales-order/{salesOrder}/paid', [SalesOrderController::class, 'paid'])->name('sales-order.paid');
    Route::resource('sales-order', SalesOrderController::class);
    Route::get     ('sales-order/{salesOrder}/item', [SalesOrderController::class, 'item'])->name('sales-order.item');
    Route::resource('sales-order-item', SalesOrderItemController::class);
    Route::put     ('sales-order/{salesOrder}/status', [SalesOrderController::class, 'status'])->name('sales-order.status');
    Route::get     ('sales-order/{salesOrder}/document', [SalesOrderController::class, 'document'])->name('sales-order.document');
    Route::get     ('stats/{user}', StatController::class)->name('stats.user');
    Route::get     ('report/tasks', [ReportController::class, 'tasks'])->name('report.tasks');
    Route::get     ('report/tasks/result', [ReportController::class, 'resultTask'])->name('report.result.tasks');
    Route::post    ('report/tasks/document', [ReportController::class, 'printResultTask'])->name('report.print.tasks');
    Route::get     ('worklist', [ReportController::class, 'worklists'])->name('worklist');
    Route::post    ('export/tasks', [ExportsController::class, 'export'])->name('export.tasks');
    Route::post    ('logout', [AuthenticationController::class, 'logout'])->name('logout');
});

// Route::view('homepage', 'components.app.home');

Route::view('billing', 'pages.transaction.billing');

Route::view('approval/quotation', 'pages.approval.quotation');

Route::get('export-example', [ExportsController::class, 'export']);


// Add Menu too see All Task done and progress
// Add Menu Tax & Payment for cutomize Tax dan TOP
// Add column perihal on Quotation
// Menu Report Mingguan dan Bulanan Sales & Marketing